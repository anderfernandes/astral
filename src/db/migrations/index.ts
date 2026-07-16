import { db } from "~db";
import * as PostgresMigrator from "./postgres";
import * as SqliteMigrator from "./sqlite";
import * as MssqlMigrator from "./mssql";

switch (process.env["DB_DRIVER"]) {
  case "postgres":
    PostgresMigrator.up(db);
    break;
  case "sqlite":
    SqliteMigrator.up(db);
    break;
  case "mssql":
    MssqlMigrator.up(db);
    break;
  default:
    throw new Error("Invalid DB_DRIVER.");
}
