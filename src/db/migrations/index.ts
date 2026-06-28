import { db } from "~db";
import * as PostgresMigrator from "./postgres";
import * as SqliteMigrator from "./sqlite";

switch (process.env["DB_DRIVER"]) {
  case "postgres":
    PostgresMigrator.up(db);
    break;
  case "sqlite":
    SqliteMigrator.up(db);
    break;
  default:
    throw new Error("Invalid DB_DRIVER.");
}
