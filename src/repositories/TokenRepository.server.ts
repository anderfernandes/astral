import { db } from "~db";
import { toDate } from "~utils/index";

export async function get(data: Partial<Token>) {
  let query = db.selectFrom("tokens");

  if (data.userId) query = query.where("userId", "=", data.userId);

  if (data.purpose) query = query.where("purpose", "=", data.purpose);

  const token = await query.selectAll().executeTakeFirstOrThrow();

  return {
    ...token,
    createdAt: toDate(token.createdAt),
    updatedAt: toDate(token.updatedAt),
    expiresAt: toDate(token.expiresAt),
  };
}

export async function save(data: TokenInsertable | TokenUpdateable) {
  if (data.id && data.updatedAt) {
    await db
      .updateTable("tokens")
      .set(data)
      .where("id", "=", data.id)
      .executeTakeFirstOrThrow();

    return;
  }

  await db
    .insertInto("tokens")
    .values(data as TokenInsertable)
    .executeTakeFirstOrThrow();
}
