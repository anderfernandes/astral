import { expect, test } from "vitest";
import { User } from "~db";

test("1: save new user", async () => {
  await User.create({
    email: "user@astralcloud.org",
    firstName: "Test",
    lastName: "User",
    password: "123456",
    roles: [],
    createdAt: new Date(),
  });

  const user = await User.findByPk(1);

  expect(user?.firstName).toBe("Test");
});

test("2: assing ROLE_USER to user", async () => {
  const user = await User.findByPk(1);

  await user?.update({
    roles: ["ROLE_USER"],
  });

  expect(user?.roles[0], "ROLE_USER");
});
