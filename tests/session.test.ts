import { sql } from "kysely";
import { randomBytes } from "node:crypto";
import { expect, test } from "vitest";
import { db } from "~db";

test("1: save new session", async () => {
  // const user = await User.create({
  //   email: "userwithsession@astralcloud.org",
  //   firstName: "Test",
  //   lastName: "User",
  //   password: "123456",
  //   roles: [],
  //   createdAt: new Date(),
  // });
  // await Session.create({
  //   id: randomBytes(32).toString("hex"),
  //   userId: user.id,
  //   createdAt: new Date(),
  //   expiresAt: new Date(),
  // });

  const user = await db
    .insertInto("users")
    .values({
      email: "session.user@astralcloud.org",
      firstName: "Test",
      lastName: "User",
      password: "123456",
      roles: "[]",
    })
    .returningAll()
    .executeTakeFirstOrThrow();

  let expiresAt: any;

  switch (process.env["DB_DRIVER"]) {
    case "postgres":
      expiresAt = new Date();
      break;
    case "sqlite":
      expiresAt = sql`datetime(${new Date().toISOString()})`;
  }

  const session = await db
    .insertInto("sessions")
    .values({
      id: randomBytes(32).toString("hex"),
      userId: user.id,
      expiresAt,
    })
    .returningAll()
    .executeTakeFirstOrThrow();

  expect(session).toBeDefined();
});
