import { Temporal } from "@js-temporal/polyfill";
import { db } from "~db";

export async function findBy(item: { saleId: number }) {
  const saleItems = await db
    .selectFrom("saleItems")
    .where("saleId", "=", item.saleId)
    .selectAll()
    .execute();
  return saleItems.map((item) => ({
    ...item,
    createdAt: item.createdAt * 1000,
    updatedAt: item.updatedAt ? item.updatedAt * 1000 : null,
  }));
}

export async function create(items: SaleItemInsertable[]) {
  await db
    .insertInto("saleItems")
    .values(
      items.map((item) => ({
        saleId: item.saleId,
        type: item.type,
        name: item.name,
        description: item.description,
        price: item.price,
        quantity: item.quantity,
        creatorId: item.creatorId,
        customerId: item.customerId,
      })),
    )
    .execute();
}

export async function update(saleId: number, items: SaleItemUpdatable[]) {
  let query = db.updateTable("saleItems");

  for (const item of items) {
    // SALE ITEM ID?
    query = query.set({
      saleId: saleId,
      type: item.type,
      name: item.name,
      description: item.description,
      price: item.price,
      quantity: item.quantity,
      creatorId: item.creatorId,
      customerId: item.customerId,
      updatedAt: Math.floor(Temporal.Now.instant().epochMilliseconds / 1000),
    });
  }

  await query.execute();
}
