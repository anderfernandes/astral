import { db } from "~db";
import { Temporal } from "@js-temporal/polyfill";

async function create(purpose: ITokensTable["purpose"], email: string) {
  const user = await db
    .selectFrom("users")
    .where("email", "=", email)
    .selectAll()
    .executeTakeFirst();

  if (!user) throw new Error("User doesn't exist");

  //const data = randomBytes(32).toString("base64url");
  const data = Buffer.from(crypto.getRandomValues(new Uint8Array(32))).toString(
    "base64url",
  );

  await db
    .insertInto("tokens")
    .values({
      userId: user.id,
      purpose,
      data,
      expiresAt: Temporal.Now.instant().add({
        minutes: purpose === "account activation" ? 5 : 60,
      }).epochMilliseconds,
    })
    .execute();

  return data;
}

async function find(id: number) {
  return await db
    .selectFrom("tokens")
    .leftJoin("users", "users.id", "tokens.userId")
    .where("tokens.id", "=", id)
    .where("tokens.updatedAt", "is", null)
    .where(
      "tokens.expiresAt",
      ">=",
      Math.floor(Temporal.Now.instant().epochMilliseconds / 1000),
    )
    .select([
      "users.id as userId",
      "users.email",
      "tokens.id as tokenId",
      "tokens.expiresAt",
    ])
    .executeTakeFirst();
}

async function findBy(userToken: {
  data: string;
  purpose: TokenInsertable["purpose"];
}) {
  const token = await db
    .selectFrom("tokens")
    .leftJoin("users", "users.id", "tokens.userId")
    .where("tokens.data", "=", userToken.data)
    .where("tokens.purpose", "=", userToken.purpose)
    .where("tokens.updatedAt", "is", null)
    .where(
      "tokens.expiresAt",
      ">=",
      Math.floor(Temporal.Now.instant().epochMilliseconds / 1000),
    )
    .select([
      "users.id as userId",
      "users.email",
      "users.firstName",
      "users.lastName",
      "users.roles",
      "tokens.id as tokenId",
      "tokens.expiresAt",
    ])
    .executeTakeFirst();

  // if (!token && userToken.purpose === "account activation") {
  //   console.error("Invalid, expired or already used activation code.");
  //   throw new Error("Invalid, expired or already used activation code.");
  // }

  if (!token) return undefined;

  return {
    ...token,
    createdAt: token.expiresAt ? Number(token.expiresAt) : undefined,
    roles: JSON.parse(token.roles as string) as Role[],
  };
}

async function update(id: number, token: TokenUpdateable) {
  let query = db.updateTable("tokens");

  if (token.data) query = query.set({ data: token.data });

  query = query.set({
    updatedAt: Math.floor(Temporal.Now.instant().epochMilliseconds / 1000),
  });

  await query.where("id", "=", id).execute();
}

export default { create, find, findBy, update };
