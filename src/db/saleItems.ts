import { db } from "~db";

export async function findBy(item: { saleId: number }) {
  await db
    .selectFrom("saleItems")
    .where("saleId", "=", item.saleId)
    .selectAll()
    .execute();
}

export async function create(saleId: number, items: SaleItemInsertable[]) {
  let query = db.insertInto("saleItems");

  for (const item of items) {
    query = query.values({
      saleId: item.saleId,
      type: item.type,
      name: item.name,
      description: item.description,
      price: item.price,
      quantity: item.quantity,
      creatorId: item.creatorId,
      customerId: item.customerId,
    });
  }

  await query.execute();
}

export async function update(saleId: number, items: SaleItemUpdatable[]) {
  let query = db.updateTable("saleItems");

  for (const item of items) {
    query = query.set({
      saleId: item.saleId,
      type: item.type,
      name: item.name,
      description: item.description,
      price: item.price,
      quantity: item.quantity,
      creatorId: item.creatorId,
      customerId: item.customerId,
    });
  }

  await query.execute();
}
