import { db } from "~db";

export async function get(id: string) {
  return await db.selectFrom("tokens").selectAll().executeTakeFirst();
}
