import { db } from "~db";
import * as saleItems from "./saleItems";

export async function create(
  sale: SaleInsertable & {
    items: SaleItemInsertable[];
    payments: PaymentInsertable[];
  },
) {
  let saleId: number;

  const query = db.insertInto("sales").values({
    status: "OPEN",
    source: sale.source,
    isTaxable: sale.isTaxable,
    checkoutId: sale.checkoutId,
    creatorId: sale.creatorId,
    customerId: sale.customerId,
  });

  if (["mysql", "mariadb"].includes(process.env.DB_DRIVER)) {
    const result = await query.executeTakeFirst();
    saleId = Number(result.insertId);
  } else if (process.env.DB_DRIVER === "mssql") {
    const result = await query.output("inserted.id").executeTakeFirst();

    if (!result || !result.id) throw new Error("Error inserting sale.");

    saleId = result.id;
  } else {
    const result = await query.returning("id").executeTakeFirst();

    if (!result || !result.id) throw new Error("Error inserting sale.");

    saleId = result?.id;
  }

  await saleItems.create(saleId, sale.items);
}

export async function find(id: number) {
  const sale = await db
    .selectFrom("sales")
    .where("id", "=", id)
    .selectAll()
    .executeTakeFirst();

  const items = await saleItems.findBy({ saleId: id });

  return { ...sale, items };
}

export async function findBy(data: { customerId: number }) {
  let query = db.selectFrom("sales");

  query = query.where("customerId", "=", data.customerId);

  const sales = await query.selectAll().execute();

  const ids = sales.map((sale) => sale.id);

  const items = await db
    .selectFrom("saleItems")
    .where("saleId", "in", ids)
    .selectAll()
    .execute();

  return sales.map((sale) => ({
    ...sale,
    items: items.filter((item) => item.saleId === sale.id),
  }));
}
