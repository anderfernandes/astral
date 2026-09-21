import SQLite from "better-sqlite3";
import {
  Kysely,
  MssqlDialect,
  MysqlDialect,
  PostgresDialect,
  SqliteDialect,
} from "kysely";
import * as pg from "pg";
import * as tedious from "tedious";
import * as tarn from "tarn";
import users from "./users";
import tokens from "./tokens";
import { createPool } from "mysql2";

function getDialect() {
  switch (process.env["DB_DRIVER"]) {
    case "mariadb":
      return new MysqlDialect({
        pool: createPool({
          database: process.env["DB_DATABASE"],
          host: process.env["DB_HOST"],
          user: process.env["DB_USER"],
          password: process.env["DB_PASSWORD"],
          port: Number(process.env["DB_PORT"]),
          connectionLimit: 10,
        }),
      });

    case "mssql":
      return new MssqlDialect({
        tarn: { ...tarn, options: { min: 0, max: 10 } },
        tedious: {
          ...tedious,
          connectionFactory: () =>
            new tedious.Connection({
              authentication: {
                options: {
                  password: process.env["DB_PASSWORD"],
                  userName: process.env["DB_USER"],
                },
                type: "default",
              },
              options: {
                database: process.env["DB_DATABASE"],
                port: Number(process.env["DB_PORT"]),
                trustServerCertificate: Boolean(
                  process.env["DB_TRUST_SERVER_CERTIFICATE"],
                ),
              },
              server: process.env["DB_SERVER"] as string,
            }),
        },
      });

    case "mysql":
      return new MysqlDialect({
        pool: createPool({
          database: process.env["DB_DATABASE"],
          host: process.env["DB_HOST"],
          user: process.env["DB_USER"],
          password: process.env["DB_PASSWORD"],
          port: Number(process.env["DB_PORT"]),
          connectionLimit: 10,
        }),
      });

    case "postgres":
      return new PostgresDialect({
        pool: new pg.Pool({
          database: process.env["DB_DATABASE"],
          host: process.env["DB_HOST"],
          user: process.env["DB_USER"],
          password: process.env["DB_PASSWORD"],
          port: Number(process.env["DB_PORT"]),
          max: 10,
        }),
      });

    case "sqlite":
      return new SqliteDialect({
        database: new SQLite(process.env["DB_DATABASE"]),
      });

    case "mssql":
      return new MssqlDialect({
        tarn: { ...tarn, options: { min: 0, max: 10 } },
        tedious: {
          ...tedious,
          connectionFactory: () =>
            new tedious.Connection({
              authentication: {
                options: {
                  password: process.env["DB_PASSWORD"],
                  userName: process.env["DB_USER"],
                },
                type: "default",
              },
              options: {
                database: process.env["DB_DATABASE"],
                port: Number(process.env["DB_PORT"]),
                trustServerCertificate: Boolean(
                  process.env["DB_TRUST_SERVER_CERTIFICATE"],
                ),
              },
              server: process.env["DB_SERVER"] as string,
            }),
        },
      });

    default:
      throw new Error("Invalid dialect.");
  }
}

export const db = new Kysely<IDatabase>({ dialect: getDialect() });

export default {
  users,
  tokens,
};
