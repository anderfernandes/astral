import { Kysely, sql } from "kysely";

export async function up(db: Kysely<any>): Promise<void> {
  await db.schema
    .createTable("users")
    //.ifNotExists()
    .addColumn("id", "integer", (c) => c.primaryKey().modifyEnd(sql`identity`))
    .addColumn("firstName", "varchar(255)", (c) => c.notNull())
    .addColumn("lastName", "varchar(255)", (c) => c.notNull())
    .addColumn("email", "varchar(255)", (c) => c.notNull().unique())
    .addColumn("password", "varchar(255)", (c) => c.notNull())
    .addColumn("roles", "varchar(255)", (c) => c.notNull())
    .addColumn("createdAt", "datetime", (c) =>
      c.notNull().defaultTo(sql`GETDATE()`),
    )
    .addColumn("updatedAt", "datetime")
    .addColumn("activatedAt", "datetime")
    .execute();

  await db.schema
    .createTable("sessions")
    //.ifNotExists()
    .addColumn("id", "varchar(255)", (c) => c.notNull())
    .addColumn("userId", "integer", (c) => c.notNull())
    .addColumn("createdAt", "datetime", (c) =>
      c.notNull().defaultTo(sql`GETDATE()`),
    )
    .addColumn("expiresAt", "datetime", (c) => c.notNull())
    .execute();

  await db.schema
    .createTable("membershipTypes")
    // .ifNotExists()
    .addColumn("id", "integer", (c) => c.primaryKey().modifyEnd(sql`IDENTITY`))
    .addColumn("name", "varchar(255)", (c) => c.notNull())
    .addColumn("description", "varchar(255)", (c) => c.notNull())
    .addColumn("cover", "varchar(255)")
    .addColumn("duration", "integer", (c) => c.notNull())
    .addColumn("price", "integer", (c) => c.notNull())
    .addColumn("maxFreeSecondaries", "integer", (c) => c.notNull())
    .addColumn("paidSecondaryPrice", "integer", (c) => c.notNull())
    .addColumn("maxPaidSecondaries", "integer", (c) => c.notNull())
    .addColumn("isActive", sql`TINYINT`, (c) => c.notNull())
    .addColumn("isPublic", sql`TINYINT`, (c) => c.notNull())
    .addColumn("createdAt", "datetime", (c) =>
      c.notNull().defaultTo(sql`GETDATE()`),
    )
    .addColumn("updatedAt", "datetime")
    .execute();

  await db.schema
    .createTable("paymentMethods")
    //.ifNotExists()
    .addColumn("id", "integer", (c) => c.primaryKey().modifyEnd(sql`IDENTITY`))
    .addColumn("name", "varchar(255)", (c) => c.notNull())
    .addColumn("description", "varchar(255)", (c) => c.notNull())
    .addColumn("type", "varchar(255)", (c) => c.notNull())
    .addColumn("isActive", sql`TINYINT`, (c) => c.notNull())
    .addColumn("isPublic", sql`TINYINT`, (c) => c.notNull())
    .addColumn("createdAt", "datetime", (c) =>
      c.notNull().defaultTo(sql`GETDATE()`),
    )
    .addColumn("updatedAt", "datetime")
    .execute();

  await db.schema
    .createTable("payments")
    //.ifNotExists()
    .addColumn("id", "integer", (c) => c.primaryKey().modifyEnd(sql`IDENTITY`))
    .addColumn("methodId", "integer", (c) => c.notNull())
    .addColumn("tendered", "integer", (c) => c.notNull())
    .addColumn("saleId", "integer", (c) => c.notNull())
    .addColumn("processorSessionId", "varchar(255)", (c) => c.notNull())
    .addColumn("createdAt", "datetime", (c) =>
      c.notNull().defaultTo(sql`GETDATE()`),
    )
    .addColumn("updatedAt", "datetime")
    .execute();

  await db.schema
    .createTable("saleItems")
    //.ifNotExists()
    .addColumn("id", "integer", (c) => c.primaryKey().modifyEnd(sql`IDENTITY`))
    .addColumn("saleId", "integer", (c) => c.notNull())
    .addColumn("type", "varchar(255)", (c) => c.notNull())
    .addColumn("name", "varchar(255)", (c) => c.notNull())
    .addColumn("description", "varchar(255)", (c) => c.notNull())
    .addColumn("price", "integer", (c) => c.notNull())
    .addColumn("quantity", "integer", (c) => c.notNull())
    .addColumn("createdAt", "datetime", (c) =>
      c.notNull().defaultTo(sql`GETDATE()`),
    )
    .addColumn("updatedAt", "datetime")
    .execute();

  await db.schema
    .createTable("sales")
    //.ifNotExists()
    .addColumn("id", "integer", (c) => c.primaryKey().modifyEnd(sql`IDENTITY`))
    .addColumn("status", "varchar(255)", (c) => c.notNull())
    .addColumn("source", "varchar(255)", (c) => c.notNull())
    .addColumn("isTaxable", sql`TINYINT`, (c) => c.notNull())
    .addColumn("createdAt", "datetime", (c) =>
      c.notNull().defaultTo(sql`GETDATE()`),
    )
    .addColumn("updatedAt", "datetime")
    .execute();

  console.info(`${process.env["DB_DRIVER"]} migrations executed succesfully!`);
}
