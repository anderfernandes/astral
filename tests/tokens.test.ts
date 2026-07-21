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

  let expiresAt = (process.env["DB_DRIVER"] === "sqlite"
    ? sql`DATETIME(${new Date().toISOString()})`
    : new Date()) as unknown as string;

  await db
    .insertInto("tokens")
    .values({
      id: randomBytes(32).toString("hex"),
      userId: user.id,
      purpose: "activation",
      expiresAt,
    })
    //.returningAll()
    .executeTakeFirstOrThrow();

  const session = await db
    .selectFrom("tokens")
    .selectAll()
    .executeTakeFirstOrThrow();

  expect(session).toBeDefined();
});
