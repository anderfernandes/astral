import { Sequelize } from "@sequelize/core";
import { SqliteDialect } from "@sequelize/sqlite3";
import { PostgresDialect } from "@sequelize/postgres";
import { MsSqlDialect } from "@sequelize/mssql";
import { MySqlDialect } from "@sequelize/mysql";
import { MariaDbDialect } from "@sequelize/mariadb";
import { MembershipType, PaymentMethod, User, Session } from "../models";

const options = {
  models: [MembershipType, PaymentMethod, User, Session],
  define: {
    underscored: true,
  },
};

if (process.env["DB_DRIVER"] === "sqlite") {
  const db = new Sequelize({
    dialect: SqliteDialect,
    storage: String(process.env["DB_DATABASE"]),
    ...options,
  });

  await db.sync();
} else if (process.env["DB_DRIVER"] === "postgres") {
  const db = new Sequelize({
    dialect: PostgresDialect,
    database: String(process.env["DB_DATABASE"]),
    user: process.env["DB_USER"],
    password: process.env["DB_PASSWORD"],
    host: process.env["DB_HOST"],
    port: Number(process.env["DB_PORT"]) ?? 5432,
    ssl: Boolean(process.env["DB_SSL"]) ?? false,
    clientMinMessages: "notice",
    ...options,
  });

  await db.sync();
} else if (process.env["DB_DRIVER"] === "mssql") {
  const db = new Sequelize({
    dialect: MsSqlDialect,
    server: String(process.env["DB_SERVER"]),
    port: Number(process.env["DB_PORT"]) ?? 1433,
    database: String(process.env["DB_DATABASE"]),
    trustServerCertificate:
      Boolean(process.env["DB_TRUST_SERVER_CERTIFICATE"]) ?? true,
    authentication: {
      type: "default",
      options: {
        userName: String(process.env["DB_USER"]),
        password: String(process.env["DB_PASSWORD"]),
      },
    },
    ...options,
  });

  await db.sync();
} else if (process.env["DB_DRIVER"] === "mysql") {
  const db = new Sequelize({
    dialect: MySqlDialect,
    database: String(process.env["DB_DATABASE"]),
    user: String(process.env["DB_USER"]),
    password: String(process.env["DB_PASSWORD"]),
    host: String(process.env["DB_HOST"]),
    port: Number(process.env["DB_PORT"]) ?? 3306,
    ...options,
  });

  await db.sync();
} else if (process.env["DB_DRIVER"] === "mariadb") {
  const db = new Sequelize({
    dialect: MariaDbDialect,
    database: String(process.env["DB_DATABASE"]),
    user: String(process.env["DB_USER"]),
    password: String(process.env["DB_PASSWORD"]),
    host: String(process.env["DB_HOST"]),
    port: Number(process.env["DB_PORT"]) ?? 3306,
    showWarnings: true,
    connectTimeout: 1000,
    ...options,
  });

  await db.sync();
} else throw new Error("Invalid database driver");

export { MembershipType, PaymentMethod, User, Session };
