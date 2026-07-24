import { sql, type Kysely } from "kysely";

export async function up(db: Kysely<any>): Promise<void> {
  await db.schema
    .createTable("users")
    .ifNotExists()
    .addColumn("id", "serial", (c) => c.primaryKey())
    .addColumn("firstName", "varchar(255)", (c) => c.notNull())
    .addColumn("lastName", "varchar(255)", (c) => c.notNull())
    .addColumn("email", "varchar(255)", (c) => c.notNull().unique())
    .addColumn("password", "varchar(255)", (c) => c.notNull())
    .addColumn("roles", "varchar(255)", (c) => c.notNull())
    .addColumn("createdAt", "timestamp", (c) =>
      c.notNull().defaultTo(sql`now()`),
    )
    .addColumn("updatedAt", "timestamp")
    .addColumn("activatedAt", "timestamp")
    .execute();

  await db.schema
    .createTable("tokens")
    .ifNotExists()
    .addColumn("id", "varchar(255)", (c) => c.notNull())
    .addColumn("userId", "integer", (c) => c.notNull())
    .addColumn("purpose", "varchar(255)", (c) => c.notNull())
    .addColumn("createdAt", "timestamp", (c) =>
      c.notNull().defaultTo(sql`now()`),
    )
    .addColumn("updatedAt", "timestamp")
    .addColumn("expiresAt", "timestamp", (c) => c.notNull())
    .execute();

  await db.schema
    .createTable("membershipTypes")
    .ifNotExists()
    .addColumn("id", "serial", (c) => c.primaryKey())
    .addColumn("name", "varchar(255)", (c) => c.notNull())
    .addColumn("description", "varchar(255)", (c) => c.notNull())
    .addColumn("cover", "varchar(255)")
    .addColumn("duration", "integer", (c) => c.notNull())
    .addColumn("price", "integer", (c) => c.notNull())
    .addColumn("maxFreeSecondaries", "integer", (c) => c.notNull())
    .addColumn("paidSecondaryPrice", "integer", (c) => c.notNull())
    .addColumn("maxPaidSecondaries", "integer", (c) => c.notNull())
    .addColumn("isActive", "integer", (c) => c.notNull())
    .addColumn("isPublic", "integer", (c) => c.notNull())
    .addColumn("createdAt", "timestamp", (c) =>
      c.notNull().defaultTo(sql`now()`),
    )
    .addColumn("updatedAt", "timestamp")
    .execute();

  await db.schema
    .createTable("paymentMethods")
    .ifNotExists()
    .addColumn("id", "serial", (c) => c.primaryKey())
    .addColumn("name", "varchar(255)", (c) => c.notNull())
    .addColumn("description", "varchar(255)", (c) => c.notNull())
    .addColumn("type", "varchar(255)", (c) => c.notNull())
    .addColumn("isActive", "integer", (c) => c.notNull())
    .addColumn("isPublic", "integer", (c) => c.notNull())
    .addColumn("createdAt", "timestamp", (c) =>
      c.notNull().defaultTo(sql`current_timestamp`),
    )
    .addColumn("updatedAt", "timestamp")
    .execute();

  await db.schema
    .createTable("payments")
    .ifNotExists()
    .addColumn("id", "serial", (c) => c.primaryKey())
    .addColumn("methodId", "serial", (c) => c.notNull())
    .addColumn("tendered", "integer", (c) => c.notNull())
    .addColumn("saleId", "serial", (c) => c.notNull())
    .addColumn("processorSessionId", "varchar(255)", (c) => c.notNull())
    .addColumn("createdAt", "timestamp", (c) =>
      c.notNull().defaultTo(sql`current_timestamp`),
    )
    .addColumn("updatedAt", "timestamp")
    .execute();

  await db.schema
    .createTable("saleItems")
    .ifNotExists()
    .addColumn("id", "serial", (c) => c.primaryKey())
    .addColumn("saleId", "serial", (c) => c.notNull())
    .addColumn("type", "varchar(255)", (c) => c.notNull())
    .addColumn("name", "varchar(255)", (c) => c.notNull())
    .addColumn("description", "varchar(255)", (c) => c.notNull())
    .addColumn("price", "integer", (c) => c.notNull())
    .addColumn("quantity", "integer", (c) => c.notNull())
    .addColumn("createdAt", "timestamp", (c) =>
      c.notNull().defaultTo(sql`current_timestamp`),
    )
    .addColumn("updatedAt", "timestamp")
    .execute();

  await db.schema
    .createTable("sales")
    .ifNotExists()
    .addColumn("id", "serial", (c) => c.primaryKey())
    .addColumn("status", "varchar(255)", (c) => c.notNull())
    .addColumn("source", "varchar(255)", (c) => c.notNull())
    .addColumn("isTaxable", "integer", (c) => c.notNull())
    .addColumn("createdAt", "timestamp", (c) =>
      c.notNull().defaultTo(sql`current_timestamp`),
    )
    .addColumn("updatedAt", "timestamp")
    .execute();

  console.info(`${process.env["DB_DRIVER"]} migrations executed succesfully!`);
}
