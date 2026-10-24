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
  const results = await db
    .selectFrom("saleMemos")
    .where("saleId", "=", data.saleId)
    .orderBy("id", "desc")
    .selectAll()
    .execute();

  const memos = results.map((memo) => ({
    id: memo.id,
    creatorId: 1, //memo.creatorId,
    saleId: memo.saleId,
    message: memo.message,
    createdAt: memo.createdAt * 1000,
    updatedAt: memo.updatedAt ? memo.updatedAt * 1000 : null,
  }));

  return memos;
}
