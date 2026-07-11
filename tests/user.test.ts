import { expect, test } from "vitest";
import { db } from "~db";

test("1: save new user", async () => {
  const user = await db
    .insertInto("users")
    .values({
      email: "user@astralcloud.org",
      firstName: "Test",
      lastName: "User",
      password: "123456",
      roles: "[]",
    })
    .returningAll()
    .executeTakeFirstOrThrow();

  expect(user?.firstName).toBe("Test");
});

test("2: assing ROLE_USER to user", async () => {
  const user = await db
    .updateTable("users")
    .set({
      roles: JSON.stringify(["ROLE_USER"]),
    })
    .where("id", "=", 1)
    .returningAll()
    .executeTakeFirst();

  expect(JSON.parse(user?.roles as string)[0], "ROLE_USER");
});

test("3: throw if email already registered", async () => {
  await expect(
    db
      .insertInto("users")
      .values({
        email: "user@astralcloud.org",
        firstName: "Test",
        lastName: "User",
        password: "123456",
        roles: "[]",
      })
      .execute(),
  ).rejects.toThrow();
});
