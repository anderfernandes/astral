import { expect, test } from "vitest";
import * as UserRepository from "~repositories/UserRepository";
import * as TokenRepository from "~repositories/TokenRepository";
import { verifyHash } from "~utils/index.server";

test("1: register", async () => {
  const data = {
    firstName: "John",
    firstNameConfirmation: "John",
    lastName: "Doe",
    lastNameConfirmation: "Doe",
    email: "john.doe@astralcloud.org",
    emailConfirmation: "john.doe@astralcloud.org",
    password: "1234",
    passwordConfirmation: "1234",
  };

  await UserRepository.register(data);

  const token = await TokenRepository.get({ purpose: "activation" });

  expect(token.id).toBeDefined();

  const user = await UserRepository.get({ email: data.email });

  expect(user.createdAt).toBeDefined();
  expect(user.activatedAt).toBeFalsy();
  expect(token.updatedAt).toBeFalsy();
});

test("2: activate", async () => {
  const token = await TokenRepository.get({ purpose: "activation" });

  expect(token.id).toBeDefined();

  await UserRepository.activate(token.id);

  const user = await UserRepository.get({ email: "john.doe@astralcloud.org" });

  expect(user?.activatedAt.getTime()).toBeLessThan(new Date().getTime());
  expect(token.expiresAt.toString() == token.createdAt.toString()).toBe(false);
  expect(token?.updatedAt).toBeDefined();
});

test("3: reset password", async () => {
  await UserRepository.generateAccountRecoveryToken("john.doe@astralcloud.org");

  const user = await UserRepository.get({ email: "john.doe@astralcloud.org" });

  const { id } = await TokenRepository.get({
    userId: user.id,
    purpose: "password recovery",
  });

  const token = await UserRepository.getAccountRecoveryToken(id);

  expect(token.id).toBe(id);

  await UserRepository.save({
    id: token.userId,
    password: "change me 1234",
  });

  const updatedUser = await UserRepository.get({
    email: "john.doe@astralcloud.org",
  });

  expect(
    await verifyHash("change me 1234", updatedUser.password as string),
  ).toBe(true);
});
