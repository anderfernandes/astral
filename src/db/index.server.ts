import SQLite from "better-sqlite3";
import { Kysely, SqliteDialect } from "kysely";

export const db = new Kysely<IDatabase>({
  dialect: new SqliteDialect({
    database: new SQLite(process.env["DB_DATABASE"]),
  }),
});
