import { db } from "~db";
import { calculateSaleTotals, toDate } from "~utils/index";
import * as PaymentRepository from "./PaymentRepository.server";

export async function get(data: Partial<Sale>) {
  let query = db.selectFrom("sales");

  if (data.id) query = query.where("id", "=", data.id);

  const sale = await query.selectAll().executeTakeFirst();

  if (!sale) return undefined;

  const items = await findItems(sale.id);

  const taxRate = Number(process.env["SALE_TAX_RATE"]) ?? 0;

  return {
    ...sale,
    ...calculateSaleTotals(items, taxRate),
    items,
    payments: await PaymentRepository.find({ saleId: sale.id }),
    createdAt: toDate(sale.createdAt),
    updatedAt: sale.updatedAt ? toDate(sale.updatedAt) : null,
  } as Sale;
}

export async function save(data: Partial<Sale>) {
  if (data.id) {
    let query = db.updateTable("sales");

    if (data.status) query = query.set("status", data.status);

    if (data.source) query = query.set("source", data.source);

    if (data.isTaxable)
      query = query.set("isTaxable", Boolean(data.isTaxable) ? 1 : 0);

    if (data.checkoutSessionId)
      query = query.set("checkoutSessionId", data.checkoutSessionId);

    await query.execute();

    return data.id;
  }

  if (!data.items || data.items.length <= 0)
    throw new Error("No items in sale.");

  if (data.customerId == undefined || data.customerId < 0)
    throw new Error("Invalid customer.");

  if (data.creatorId == undefined || data.creatorId < 0)
    throw new Error("Invalid creator.");

  const values: SaleInsertable = {
    status: data.status || "OPEN",
    source: data.source || "PORTAL",
    isTaxable: Boolean(data.isTaxable) ? 1 : 0,
    checkoutSessionId: data.checkoutSessionId,
    creatorId: data.customerId,
    customerId: data.creatorId,
  };

  let saleId: number;

  if (process.env.DB_DRIVER === "postgres") {
    const result = await db
      .insertInto("sales")
      .values(values)
      .returning("id")
      .executeTakeFirstOrThrow();

    saleId = result.id;
  } else if (process.env.DB_DRIVER === "mssql") {
    const result = await db
      .insertInto("sales")
      .values(values)
      .output("inserted.id")
      .executeTakeFirstOrThrow();

    saleId = result.id;
  } else {
    const result = await db
      .insertInto("sales")
      .values(values)
      .executeTakeFirstOrThrow();

    saleId = Number(result.insertId);
  }

  if (saleId == undefined) throw new Error("No insertId");

  if (data.source === "PORTAL")
    data.items.push({
      type: "CONVENIENCE FEE",
      name: "Convenience Fee",
      description: "Convenience Fee",
      price: Number(process.env["CONVENIENCE_FEE"]),
      quantity: 1,
    });

  await saveItems(
    saleId,
    data.items.map((item) => ({ ...item, creatorId: data.creatorId })),
  );

  return saleId;
}

export async function find(data: Partial<Sale>) {
  let query = db.selectFrom("sales");

  if (data.status) query = query.where("status", "=", data.status);

  if (data.customerId) query = query.where("customerId", "=", data.customerId);

  const sale = await query.selectAll().execute();

  return { ...sale };
}

async function findItems(saleId: number) {
  const items = await db
    .selectFrom("saleItems")
    .where("saleId", "=", saleId)
    .selectAll()
    .execute();

  return items.map((item) => ({
    ...item,
    createdAt: toDate(item.createdAt),
    updatedAt: item.updatedAt ? toDate(item.updatedAt) : null,
  })) satisfies SaleItem[];
}

async function saveItems(saleId: number, items: Partial<SaleItem>[]) {
  // TODO: ADD IS_DELETED FOR SALE ITEMS
  for (const item of items) {
    if (item.id) break;

    await db
      .insertInto("saleItems")
      .values({
        saleId,
        type: item.type as SaleItem["type"],
        name: item.name as string,
        description: item.description as string,
        price: item.price as number,
        quantity: item.quantity as number,
        creatorId: item.creatorId as number,
      })
      .execute();
  }
}
