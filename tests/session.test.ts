import { randomBytes } from "node:crypto";
import { test } from "vitest";
import { Session, User } from "~db";

test("1: save new session", async () => {
  const user = await User.create({
    email: "userwithsession@astralcloud.org",
    firstName: "Test",
    lastName: "User",
    password: "123456",
    roles: [],
    createdAt: new Date(),
  });

  await Session.create({
    id: randomBytes(32).toString("hex"),
    userId: user.id,
    createdAt: new Date(),
    expiresAt: new Date(),
  });
});
