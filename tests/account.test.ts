import { expect, test } from "vitest";
import db from "~db";

const account = {
  firstName: "John",
  lastName: "Doe",
  email: "john.doe@astralcloud.org",
  password: "MyStrongPassword!",
};

test("create", async () => {
  await db.users.create(account);

  const user = await db.users.findOneBy({ email: account.email });

  expect(user?.firstName).toBe(user?.firstName);
  expect(user?.lastName).toBe(user?.lastName);
  expect(user?.email).toBe(user?.email);
  expect(user?.createdAt).toBeDefined();
  expect(user?.updatedAt).toBeFalsy();
  expect(user?.roles?.length).toBe(0);
});

test("activate", async () => {
  let user = await db.users.findOneBy({ email: account.email });

  const token = await db.tokens.create(
    "account activation",
    user?.email as string,
  );

  const userToken = await db.tokens.findBy({
    data: token,
    purpose: "account activation",
  });

  await db.users.activate({
    tokenId: userToken?.tokenId as number,
    email: userToken?.email as string,
  });

  user = await db.users.findOneBy({ email: user?.email as string });

  expect(user?.roles).toContain("ROLE_USER");
  expect(user?.activatedAt).toBeLessThanOrEqual(
    Temporal.Now.instant().epochMilliseconds,
  );
  expect(user?.updatedAt).toBeDefined();
});

test("update", async () => {
  let user = await db.users.findOneBy({ email: account.email });

  await db.users.update(user?.id as number, {
    roles: ["ROLE_USER"],
    activatedAt: Temporal.Now.instant().epochMilliseconds,
  });

  user = await db.users.findOneBy({ email: user?.email as string });

  expect(user?.roles).toContain("ROLE_USER");
  expect(user?.activatedAt).toBeLessThanOrEqual(
    Temporal.Now.instant().epochMilliseconds,
  );
  expect(user?.updatedAt).toBeDefined();
});

test("sign in", async () => {
  const token = await db.users.signin({
    email: account.email,
    password: account.password,
  });

  expect(token).toHaveLength(43);
});

test("sigin in with wrong password", async () => {
  await expect(() =>
    db.users.signin({ email: account.email, password: "123456" }),
  ).rejects.toThrow("Invalid credentials.");
});

test("sign out", async () => {
  const token = await db.users.signin({
    email: account.email,
    password: account.password,
  });

  await db.users.signout(token);

  const userToken = await db.tokens.findBy({
    data: token,
    purpose: "authentication",
  });

  expect(userToken).toBe(undefined);
});
