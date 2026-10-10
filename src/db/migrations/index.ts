import Database from "better-sqlite3";
import { readFileSync } from "node:fs";
import path from "node:path";
import { fileURLToPath } from "node:url";
import { Client as Postgres } from "pg";
import {
  type ConnectionConfiguration,
  Connection as Mssql,
  Request,
} from "tedious";
import * as Mysql from "mysql2/promise";

const filePath = path.dirname(fileURLToPath(import.meta.url));

switch (process.env["DB_DRIVER"]) {
  case "mssql":
    migrateMssql();
    break;
  case "mysql":
    migrateMysql();
    break;
  case "mariadb":
    migrateMysql();
    break;
  case "postgres":
    migratePostgres();
    break;
  case "sqlite":
    migrateSqlite();
    break;
  default:
    throw new Error("Invalid DB_DRIVER");
}

async function migrateMssql() {
  const migration = readFileSync(`${filePath}/mssql.sql`, "utf-8");

  function query(connection: Mssql, sqlText: string) {
    return new Promise<void>((resolve, reject) => {
      const request = new Request(sqlText, (err) => {
        if (err) reject(err);
        else resolve();
      });
      connection.execSql(request);
    });
  }

  function connect(config: ConnectionConfiguration) {
    return new Promise<Mssql>((resolve, reject) => {
      const connection = new Mssql(config);
      connection.on("connect", (err) => {
        if (err) reject(err);
        else resolve(connection);
      });
      connection.connect();
    });
  }

  const config = {
    server: String(process.env["DB_SERVER"]),
    authentication: {
      type: "default",
      options: {
        userName: process.env["DB_USER"],
        password: process.env["DB_PASSWORD"],
      },
    },
    options: {
      port: Number(process.env["DB_PORT"]),
      trustServerCertificate: Boolean(
        process.env["DB_TRUST_SERVER_CERTIFICATE"],
      ),
    },
  } satisfies ConnectionConfiguration;

  if (process.env["DB_DATABASE"] != "master") {
    const mssql = await connect(config);

    await query(
      mssql,
      `
      IF DB_ID(N'${process.env["DB_DATABASE"]}') IS NULL
      BEGIN
        CREATE DATABASE [${process.env["DB_DATABASE"]}];
      END;
    `,
    );

    if (process.env["DB_USER"] != "sa") {
      await query(
        mssql,
        `
        USE [${process.env["DB_DATABASE"]}];
        
        IF IS_ROLEMEMBER(N'db_owner', N'${process.env["DB_USER"]}') <> 1
        BEGIN
          ALTER ROLE [db_owner] ADD MEMBER [${process.env["DB_USER"]}];
        END;
      `,
      );
    }

    mssql.close();
  }

  const mssql = await connect({
    server: config.server,
    authentication: config.authentication,
    options: { ...config.options, database: process.env["DB_DATABASE"] },
  });

  await query(mssql, migration);

  mssql.close();
}

async function migrateMysql() {
  const migration = readFileSync(`${filePath}/mysql.sql`, "utf-8");

  let mysql = await Mysql.createConnection({
    host: process.env["DB_HOST"],
    user: process.env["DB_USER"],
    password: process.env["DB_PASSWORD"],
    port: Number(process.env["DB_PORT"]),
    multipleStatements: true,
  });

  if (process.env["DB_DATABASE"] != "sys") {
    await mysql.query(
      `CREATE DATABASE IF NOT EXISTS ${process.env["DB_DATABASE"]}`,
    );

    await mysql.query(`
      GRANT ALL PRIVILEGES ON ${process.env["DB_DATABASE"]}.*
      TO '${process.env["DB_USER"]}'@'${process.env["DB_HOST"]}'
    `);
  }

  if (mysql) await mysql.end();

  mysql = await Mysql.createConnection({
    host: process.env["DB_HOST"],
    user: process.env["DB_USER"],
    database: process.env["DB_DATABASE"],
    password: process.env["DB_PASSWORD"],
    port: Number(process.env["DB_PORT"]),
    multipleStatements: true,
  });

  await mysql.query(migration);

  await mysql.end();
}

async function migratePostgres() {
  const migration = readFileSync(
    `${filePath}/${process.env["DB_DRIVER"]}.sql`,
    "utf-8",
  );

  let postgres = new Postgres({
    user: process.env["DB_USER"],
    password: process.env["DB_PASSWORD"],
    host: process.env["DB_HOST"],
    port: Number(process.env["DB_PORT"]),
  });

  if (process.env["DB_DATABASE"] != "postgres") {
    postgres = await postgres.connect();

    await postgres.query(
      `CREATE DATABASE ${process.env["DB_DATABASE"]} OWNER ${process.env["DB_USER"]}`,
    );

    await postgres.end();
  }

  postgres = await new Postgres({
    user: process.env["DB_USER"],
    password: process.env["DB_PASSWORD"],
    host: process.env["DB_HOST"],
    port: Number(process.env["DB_PORT"]),
    database: process.env["DB_DATABASE"],
  }).connect();

  await postgres.query(migration);

  await postgres.end();
}

async function migrateSqlite() {
  const migration = readFileSync(
    `${filePath}/${process.env["DB_DRIVER"]}.sql`,
    "utf-8",
  );

  new Database(process.env["DB_DATABASE"]).exec(migration);
}
