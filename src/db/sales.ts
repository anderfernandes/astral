import { db } from "~db";
import { calculateSaleTotals } from "~lib";
import * as saleItemRepository from "./saleItems";
import * as paymentRepository from "./payments";
import * as saleMemoRepository from "./saleMemo";

export async function create(
  sale: Omit<SaleInsertable, "isTaxable"> & {
    isTaxable?: boolean;
    items: Omit<SaleItemInsertable, "saleId" | "creatorId">[];
    payments?: PaymentInsertable[];
  },
) {
  let saleId: number;

  const query = db.insertInto("sales").values({
    status: "OPEN",
    source: sale.source,
    isTaxable: sale.isTaxable ? 1 : 0,
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

  await saleItemRepository.create(
    sale.items.map((item) => ({
      ...item,
      saleId,
      creatorId: sale.creatorId,
      customerId:
        item.customerId != undefined ? item.customerId : sale.customerId,
    })),
  );

  // TODO: CALCULATE TOTALS AND UPDATE IF NECESSARY

  return saleId;
}

export async function update(
  saleId: number,
  sale: Omit<SaleUpdateable, "isTaxable"> & {
    isTaxable: boolean;
    items: Omit<SaleItemUpdatable, "saleId">[];
    payments?: PaymentUpdateable[];
  },
) {
  let query = db.updateTable("sales").set({
    status: sale.status,
    source: sale.source,
    isTaxable: sale.isTaxable ? 1 : 0,
    checkoutId: sale.checkoutId,
    creatorId: sale.creatorId,
    customerId: sale.customerId,
    updatedAt: Math.floor(Temporal.Now.instant().epochMilliseconds / 1000),
  });

  if (sale.checkoutId) query = query.set({ checkoutId: sale.checkoutId });

  if (sale.checkoutProcessor)
    query = query.set({ checkoutProcessor: sale.checkoutProcessor });

  await query.where("id", "=", saleId).execute();

  await saleItemRepository.update(
    saleId,
    sale.items
      .filter((item) => item.id)
      .map((item) => ({
        ...item,
        saleId,
        creatorId: sale.creatorId,
        customerId:
          item?.customerId != undefined ? item.customerId : sale.customerId,
      })),
  );

  const newItems = sale.items.filter((item) => !item.id) as Omit<
    SaleItemInsertable,
    "saleId" | "creatorId"
  >[];

  if (newItems.length > 0) {
    await saleItemRepository.create(
      newItems.map((item) => ({
        ...item,
        saleId,
        creatorId: sale.creatorId,
        customerId:
          item.customerId != undefined ? item.customerId : sale.customerId,
      })),
    );
  }
}

export async function find(id: number) {
  const sale = await db
    .selectFrom("sales")
    .innerJoin("users as customer", "customer.id", "sales.customerId")
    .leftJoin("users as creator", "creator.id", "sales.creatorId")
    .where("sales.id", "=", id)
    .select([
      "sales.id",
      "sales.status",
      "sales.source",
      "sales.isTaxable",
      "sales.createdAt",
      "sales.updatedAt",
      "sales.customerId",
      "customer.firstName as customerFirstName",
      "customer.lastName as customerLastName",
      "customer.email as customerEmail",
      "sales.creatorId",
      "creator.firstName as creatorFirstName",
      "creator.lastName as creatorLastName",
    ])
    .executeTakeFirst();

  if (!sale) return undefined;

  const items = await saleItemRepository.findBy({ saleId: id });

  const payments = await paymentRepository.findBy({ saleId: id });

  const memos = await saleMemoRepository.findBy({ saleId: id });

  const totals = calculateSaleTotals({ ...sale, items, payments });

  const data = {
    ...totals,
    id: sale.id,
    status: sale.status,
    source: sale.source,
    isTaxable: Boolean(sale.isTaxable),
    createdAt: sale.createdAt * 1000,
    updatedAt: sale.updatedAt ? sale.updatedAt * 1000 : null,
    items,
    payments,
    memos,
    customer: {
      id: sale.customerId,
      email: sale.customerEmail,
      firstName: sale.customerFirstName,
      lastName: sale.customerLastName,
    },
    creator: {
      id: sale.creatorId,
      firstName: sale.creatorFirstName,
      lastName: sale.creatorLastName,
    },
  };

  return data;
}

export async function findBy(
  data: { customerId?: number } | undefined = undefined,
) {
  let query = db
    .selectFrom("sales")
    .innerJoin("users as customer", "customer.id", "sales.customerId")
    .leftJoin("users as creator", "creator.id", "sales.creatorId");

  if (data?.customerId) query = query.where("customerId", "=", data.customerId);

  const sales = await query
    .select([
      "sales.id",
      "sales.status",
      "sales.source",
      "sales.isTaxable",
      "sales.createdAt",
      "sales.updatedAt",
      "sales.customerId",
      "customer.firstName as customerFirstName",
      "customer.lastName as customerLastName",
      "customer.email as customerEmail",
      "sales.creatorId",
      "creator.firstName as creatorFirstName",
      "creator.lastName as creatorLastName",
    ])
    .orderBy("sales.id", "desc")
    .execute();

  const ids = sales.map((sale) => sale.id);

  const _items = await db
    .selectFrom("saleItems")
    .where("saleId", "in", ids)
    .selectAll()
    .execute();

  const _payments = await db
    .selectFrom("payments")
    .where("saleId", "in", ids)
    .selectAll()
    .execute();

  const _memos = await db
    .selectFrom("saleMemos")
    .where("saleId", "in", ids)
    .selectAll()
    .execute();

  return sales.map((sale) => {
    const items = _items.filter((item) => item.saleId === sale.id);
    const payments = _payments.filter((p) => p.saleId === sale.id);
    const memos = _memos.filter((m) => m.saleId === sale.id);

    const totals = calculateSaleTotals({ ...sale, items, payments });

    const data = {
      ...totals,
      id: sale.id,
      status: sale.status,
      source: sale.source,
      isTaxable: Boolean(sale.isTaxable),
      createdAt: sale.createdAt * 1000,
      updatedAt: sale.updatedAt ? sale.updatedAt * 1000 : null,
      items,
      payments,
      memos,
      customer: {
        id: sale.customerId,
        email: sale.customerEmail,
        firstName: sale.customerFirstName,
        lastName: sale.customerLastName,
      },
      creator: {
        id: sale.creatorId,
        firstName: sale.creatorFirstName,
        lastName: sale.creatorLastName,
      },
    };

    return data;
  });
}
