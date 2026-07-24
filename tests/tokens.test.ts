import { sql } from "kysely";
import { randomBytes } from "node:crypto";
import { expect, test } from "vitest";
import { db } from "~db";
import { getCurrentDateTimeString } from "~utils/index";

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

  await db
    .insertInto("tokens")
    .values({
      id: randomBytes(32).toString("base64url"),
      userId: user.id,
      purpose: "activation",
      expiresAt: getCurrentDateTimeString(),
    })
    //.returningAll()
    .executeTakeFirstOrThrow();

  const token = await db
    .selectFrom("tokens")
    .selectAll()
    .executeTakeFirstOrThrow();

  expect(token).toBeDefined();
});
