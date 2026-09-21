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
      expiresAt: Temporal.Now.instant().add({ minutes: 5 }).epochMilliseconds,
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
    .where("tokens.expiresAt", ">=", Temporal.Now.instant().epochMilliseconds)
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
  const t = await db
    .selectFrom("tokens")
    .leftJoin("users", "users.id", "tokens.userId")
    .where("tokens.data", "=", userToken.data)
    .where("tokens.purpose", "=", userToken.purpose)
    .where("tokens.updatedAt", "is", null)
    .where("tokens.expiresAt", ">=", Temporal.Now.instant().epochMilliseconds)
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

  if (!t && userToken.purpose === "account activation") {
    console.error("Invalid, expired or already used activation code.");
    throw new Error("Invalid, expired or already used activation code.");
  }

  return t;
}

async function update(id: number, token: TokenUpdateable) {
  let query = db.updateTable("tokens");

  if (token.data) query = query.set({ data: token.data });

  query = query.set({
    updatedAt: Temporal.Now.instant().epochMilliseconds,
  });

  await query.where("id", "=", id).execute();
}

export default { create, find, findBy, update };
