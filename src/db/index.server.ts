import {
  type CreationOptional,
  type InferAttributes,
  type InferCreationAttributes,
  DataTypes,
  Model,
  Sequelize,
} from "@sequelize/core";
import { SqliteDialect } from "@sequelize/sqlite3";
import { PostgresDialect } from "@sequelize/postgres";
import { MsSqlDialect } from "@sequelize/mssql";
import { MySqlDialect } from "@sequelize/mysql";
import { MariaDbDialect } from "@sequelize/mariadb";
import {
  Attribute,
  PrimaryKey,
  AutoIncrement,
  NotNull,
  Table,
} from "@sequelize/core/decorators-legacy";

export class MembershipType extends Model<
  InferAttributes<MembershipType>,
  InferCreationAttributes<MembershipType>
> {
  @Attribute(DataTypes.INTEGER)
  @PrimaryKey
  @AutoIncrement
  declare id: CreationOptional<number>;

  @Attribute(DataTypes.STRING)
  @NotNull
  declare name: string;

  @Attribute(DataTypes.STRING)
  @NotNull
  declare description: string;

  @Attribute(DataTypes.INTEGER)
  @NotNull
  declare duration: number;

  @Attribute(DataTypes.INTEGER)
  @NotNull
  declare price: number;

  @Attribute(DataTypes.INTEGER)
  @NotNull
  declare maxFreeSecondaries: number;

  @Attribute(DataTypes.INTEGER)
  @NotNull
  declare maxPaidSecondaries: number;

  @Attribute(DataTypes.INTEGER)
  @NotNull
  declare paidSecondaryPrice: number;

  @Attribute(DataTypes.BOOLEAN)
  @NotNull
  declare isActive: boolean;

  @Attribute(DataTypes.BOOLEAN)
  @NotNull
  declare isPublic: boolean;

  @Attribute(DataTypes.DATE)
  @NotNull
  declare createdAt: Date;

  @Attribute(DataTypes.DATE)
  declare updateAt: CreationOptional<Date>;
}

const models = [MembershipType];

if (process.env["DB_DRIVER"] === "sqlite") {
  const db = new Sequelize({
    dialect: SqliteDialect,
    storage: process.env["DB_DATABASE"],
    models,
    define: {
      underscored: true,
    },
  });

  await db.sync();
} else if (process.env["DB_DRIVER"] === "postgres") {
  const db = new Sequelize({
    dialect: PostgresDialect,
    database: process.env["DB_DATABASE"],
    user: process.env["DB_USER"],
    password: process.env["DB_PASSWORD"],
    host: process.env["DB_HOST"],
    port: Number(process.env["DB_PORT"]) ?? 5432,
    models,
    define: {
      underscored: true,
    },
    ssl: Boolean(process.env["DB_SSL"]) ?? false,
    clientMinMessages: "notice",
  });

  await db.sync();
} else if (process.env["DB_DRIVER"] === "mssql") {
  const db = new Sequelize({
    dialect: MsSqlDialect,
    server: process.env["DB_SERVER"],
    port: Number(process.env["DB_PORT"]) ?? 1433,
    database: process.env["DB_DATABASE"],
    models,
    define: {
      underscored: true,
    },
    trustServerCertificate:
      Boolean(process.env["DB_TRUST_SERVER_CERTIFICATE"]) ?? true,
    authentication: {
      type: "default",
      options: {
        userName: process.env["DB_USER"],
        password: process.env["DB_PASSWORD"],
      },
    },
  });

  await db.sync();
} else if (process.env["DB_DRIVER"] === "mysql") {
  const db = new Sequelize({
    dialect: MySqlDialect,
    database: process.env["DB_DATABASE"],
    user: process.env["DB_USER"],
    password: process.env["DB_PASSWORD"],
    host: process.env["DB_HOST"],
    port: Number(process.env["DB_PORT"]) ?? 3306,
    models,
    define: {
      underscored: true,
    },
  });

  await db.sync();
} else if (process.env["DB_DRIVER"] === "mariadb") {
  const db = new Sequelize({
    dialect: MariaDbDialect,
    database: process.env["DB_DATABASE"],
    user: process.env["DB_USER"],
    password: process.env["DB_PASSWORD"],
    host: process.env["DB_HOST"],
    port: Number(process.env["DB_PORT"]) ?? 3306,
    models,
    define: {
      underscored: true,
    },
    showWarnings: true,
    connectTimeout: 1000,
  });

  await db.sync();
} else throw new Error("Invalid database driver");
