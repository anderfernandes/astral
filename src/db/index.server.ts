import SQLite from "better-sqlite3";
import { Kysely, PostgresDialect, SqliteDialect } from "kysely";
import { Pool } from "pg";

function getDialect() {
  switch (process.env["DB_DRIVER"]) {
    case "postgres":
      return new PostgresDialect({
        pool: new Pool({
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

    default:
      throw new Error("Invalid dialect.");
  }
}

export const db = new Kysely<IDatabase>({
  dialect: getDialect(),
});
