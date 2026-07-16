import { sql } from "kysely";
import { randomBytes } from "node:crypto";
import { expect, test } from "vitest";
import { db } from "~db";

test("1: save new session", async () => {
  await db
    .insertInto("users")
    .values({
      email: "session.user@astralcloud.org",
      firstName: "Test",
      lastName: "User",
      password: "123456",
      roles: "[]",
    })
    //.returningAll()
    .executeTakeFirstOrThrow();

  const user = await db
    .selectFrom("users")
    .where("email", "=", "session.user@astralcloud.org")
    .selectAll()
    .executeTakeFirstOrThrow();

  let expiresAt: any;

  switch (process.env["DB_DRIVER"]) {
    case "postgres":
      expiresAt = new Date();
      break;
    case "sqlite":
      expiresAt = sql`datetime(${new Date().toISOString()})`;
      break;
    case "mssql":
      expiresAt = new Date();
      break;
  }

  await db
    .insertInto("sessions")
    .values({
      id: randomBytes(32).toString("hex"),
      userId: user.id,
      expiresAt,
    })
    //.returningAll()
    .executeTakeFirstOrThrow();

  const session = await db
    .selectFrom("sessions")
    .selectAll()
    .executeTakeFirstOrThrow();

  expect(session).toBeDefined();
});
