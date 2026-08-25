import { expect, test } from "vitest";
import * as UserRepository from "~repositories/UserRepository";

test("1: save new user", async () => {
  const data = {
    email: "user@astralcloud.org",
    firstName: "Test",
    lastName: "User",
    password: "123456",
    roles: [],
    creatorId: 0,
  };

  await UserRepository.save(data);

  const user = await UserRepository.get({ email: data.email });

  expect(user?.firstName).toBe("Test");
  expect(user?.createdAt).toBeDefined();
  expect(user?.updatedAt).toBeNull();
  expect(user.roles.length).toBe(0);
});

test("2: assing ROLE_USER to user", async () => {
  await UserRepository.save({ id: 1, roles: ["ROLE_USER"] });

  const user = await UserRepository.get({ id: 1 });

  expect(user?.roles[0]).toBe("ROLE_USER");
});

test("3: throw if email already registered", async () => {
  await expect(
    UserRepository.save({
      email: "user@astralcloud.org",
      firstName: "Test",
      lastName: "User",
      password: "654321",
      roles: [],
      creatorId: 0,
    }),
  ).rejects.toThrow();
});
