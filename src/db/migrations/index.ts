import Database from "better-sqlite3";
import { readFileSync } from "node:fs";
import path from "node:path";
import { fileURLToPath } from "node:url";
import { Client as Postgres } from "pg";
import { Connection as Mssql, Request } from "tedious";
import mysql from "mysql2/promise";

const filePath = path.dirname(fileURLToPath(import.meta.url));

switch (process.env["DB_DRIVER"]) {
  case "mariadb":
    migrateMariadb();
    break;
  case "mssql":
    migrateMssql();
    break;
  case "mysql":
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

async function migrateMariadb() {
  const migration = readFileSync(`${filePath}/mysql.sql`, "utf-8");

  await using Mariadb = await mysql.createConnection({
    host: process.env["DB_HOST"],
    user: process.env["DB_USER"],
    database: process.env["DB_DATABASE"],
    password: process.env["DB_PASSWORD"],
    port: Number(process.env["DB_PORT"]),
    multipleStatements: true,
  });

  await Mariadb.query(migration);
}

async function migrateMssql() {
  const migration = readFileSync(`${filePath}/mssql.sql`, "utf-8");

  const mssql = new Mssql({
    server: String(process.env["DB_SERVER"]),
    authentication: {
      type: "default",
      options: {
        userName: process.env["DB_USER"],
        password: process.env["DB_PASSWORD"],
      },
    },
    options: {
      database: process.env["DB_DATABASE"],
      port: Number(process.env["DB_PORT"]),
      trustServerCertificate: Boolean(
        process.env["DB_TRUST_SERVER_CERTIFICATE"],
      ),
    },
  });

  mssql.connect((error) => {
    if (error) throw new Error("MSSQL connection failed.");

    const request = new Request(migration, (err, rowCount) => {
      if (err) throw err;

      mssql.close();
    });

    mssql.execSql(request);
  });
}

async function migrateMysql() {
  const migration = readFileSync(
    `${filePath}/${process.env["DB_DRIVER"]}.sql`,
    "utf-8",
  );

  await using Mysql = await mysql.createConnection({
    host: process.env["DB_HOST"],
    user: process.env["DB_USER"],
    database: process.env["DB_DATABASE"],
    password: process.env["DB_PASSWORD"],
    port: Number(process.env["DB_PORT"]),
    multipleStatements: true,
  });

  await Mysql.query(migration);
}

async function migratePostgres() {
  const migration = readFileSync(
    `${filePath}/${process.env["DB_DRIVER"]}.sql`,
    "utf-8",
  );

  const postgres = await new Postgres({
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
