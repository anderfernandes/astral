import { expect, test } from "vitest";
import { db } from "~db";
import * as UserRepository from "~repositories/UserRepository";

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
    .where("email", "=", "user@astralcloud.org")
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
      .executeTakeFirstOrThrow(),
  ).rejects.toThrow();
});

test("4: register and activate user", async () => {
  await UserRepository.register({
    firstName: "John",
    lastName: "Doe",
    email: "john.doe@astralcloud.org",
    password: "1234",
  });

  const user = await db
    .selectFrom("tokens")
    .leftJoin("users", "users.id", "tokens.userId")
    .select([
      "users.id as id",
      "users.email as email",
      "tokens.id as token",
      "tokens.purpose as tokenPurpose",
    ])
    .where("email", "=", "john.doe@astralcloud.org")
    .where("tokens.purpose", "=", "activation")
    .executeTakeFirst();

  const token = await UserRepository.activate(user?.token as string);

  expect(token).toEqual(user?.token);

  const activatedUser = await db
    .selectFrom("users")
    .leftJoin("tokens", "tokens.userId", "users.id")
    .select([
      "users.id as id",
      "users.email as email",
      "users.activatedAt as activatedAt",
      "tokens.id as token",
      "tokens.updatedAt as tokenUpdatedAt",
    ])
    .where("tokens.id", "=", user?.token as string)
    .where("tokens.purpose", "=", "activation")
    .executeTakeFirst();

  expect(activatedUser?.activatedAt).toBeDefined();
  expect(activatedUser?.tokenUpdatedAt).toBeTruthy();
});
