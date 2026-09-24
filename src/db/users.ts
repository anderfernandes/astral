import { db } from "~db";
import { createHash, verifyHash } from "~lib";
import tokens from "./tokens";
import { Temporal } from "@js-temporal/polyfill";

async function create(user: UserInsertable) {
  try {
    await db
      .insertInto("users")
      .values({
        ...user,
        password: await createHash(user.password),
        roles: user.roles ?? JSON.stringify([]),
        creatorId: user.creatorId ?? 0,
      })
      .executeTakeFirstOrThrow();
  } catch (e) {
    const message = (e as Error).message;

    if (message.includes("UNIQUE constraint failed: users.email"))
      throw new Error("Email already registered.");

    console.error(message);
  }
}

async function update(
  id: number,
  user: Partial<Pick<UserSelectable, "activatedAt" | "roles">>,
) {
  let query = db.updateTable("users");

  if (user.activatedAt) query = query.set({ activatedAt: user.activatedAt });
  if (user.roles) query = query.set({ roles: JSON.stringify(user.roles) });

  query = query.set({
    updatedAt: Temporal.Now.instant().epochMilliseconds,
  });

  await query.where("id", "=", id).execute();

  console.log("user updated");
}

async function findOneBy(data: { email: string }) {
  const user = await db
    .selectFrom("users")
    .where("email", "=", data.email)
    .select([
      "id",
      "firstName",
      "lastName",
      "email",
      "createdAt",
      "updatedAt",
      "activatedAt",
      "roles",
    ])
    .executeTakeFirstOrThrow();

  return { ...user, roles: JSON.parse(user.roles.toString()) as Role[] };
}

async function activate(userToken: { tokenId: number; email: string }) {
  const token = await tokens.find(userToken.tokenId);

  if (!token) throw new Error("Unable to activate account.");

  if (token.email !== userToken.email)
    throw new Error("Cannot activate account.");

  await update(token.userId as number, {
    roles: ["ROLE_USER"],
    activatedAt: Temporal.Now.instant().epochMilliseconds,
  });
}

async function signin(data: { email: string; password: string }) {
  const user = await db
    .selectFrom("users")
    .where("email", "=", data.email)
    .select(["email", "password"])
    .executeTakeFirst();

  if (!user) throw new Error("Invalid credentials.");

  if (!(await verifyHash(data.password, user.password)))
    throw new Error("Invalid credentials.");

  return await tokens.create("authentication", user.email);
}

async function signout(data: string) {
  const token = await tokens.findBy({ data, purpose: "authentication" });

  await tokens.update(token?.tokenId as number, {
    expiresAt: Temporal.Now.instant().epochMilliseconds,
  });
}

export default { activate, create, findOneBy, signin, signout, update };
