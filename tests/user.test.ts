import { expect, test } from "vitest";
import { db } from "~db";

test("1: save new user", async () => {
  await db
    .insertInto("users")
    .values({
      email: "user@astralcloud.org",
      firstName: "Test",
      lastName: "User",
      password: "123456",
      roles: "[]",
    })
    //.returningAll()
    .execute();

  const user = await db
    .selectFrom("users")
    .selectAll()
    .executeTakeFirstOrThrow();

  expect(user?.firstName).toBe("Test");
});

test("2: assing ROLE_USER to user", async () => {
  await db
    .updateTable("users")
    .set({
      roles: JSON.stringify(["ROLE_USER"]),
    })
    .where("id", "=", 1)
    //.returningAll()
    .executeTakeFirstOrThrow();

  const user = await db
    .selectFrom("users")
    .selectAll()
    .executeTakeFirstOrThrow();

  expect(JSON.parse(user?.roles as string)[0], "ROLE_USER");
});

test("3: throw if email already registered", async () => {
  expect(
    await db
      .insertInto("users")
      .values({
        email: "user@astralcloud.org",
        firstName: "Test",
        lastName: "User",
        password: "123456",
        roles: "[]",
      })
      .executeTakeFirstOrThrow(),
  ).toThrow();
});
