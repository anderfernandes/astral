import { db } from "~db";

export async function create(memo: SaleMemoInsertable) {
  await db
    .insertInto("saleMemos")
    .values({
      saleId: memo.saleId,
      message: memo.message,
      creatorId: memo.creatorId,
    })
    .execute();
}

export async function update(memo: SaleMemoUpdateable) {
  await db
    .updateTable("saleMemos")
    .set({
      saleId: memo.saleId,
      message: memo.message,
      creatorId: memo.creatorId,
    })
    .execute();
}

export async function findBy(data: { saleId: number }) {
  return await db
    .selectFrom("saleMemos")
    .where("saleId", "=", data.saleId)
    .orderBy("id", "desc")
    .execute();
}
