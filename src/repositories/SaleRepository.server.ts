import { db } from "~db";
import { getSignedInUserFn } from "~utils/account.functions";
import { toDate } from "~utils/index";
import * as PaymentRepository from "./PaymentRepository.server";

export async function get(data: Partial<Sale>) {
  let query = db.selectFrom("sales");

  if (data.id) query = query.where("id", "=", data.id);

  const sale = await query.selectAll().executeTakeFirst();

  if (!sale) return undefined;

  return {
    ...sale,
    items: await findItems(sale.id),
    payments: PaymentRepository.find({ saleId: sale.id }),
    updatedAt: toDate(sale.updatedAt),
  };
}

export async function save(data: {
  id?: number;
  status: Sale["status"];
  source: Sale["source"];
  isTaxable?: boolean;
  items: Pick<
    SaleItem,
    "type" | "name" | "description" | "price" | "quantity"
  >[];
}) {
  if (data.id) return;

  if (!data.items || data.items.length <= 0) return;

  const user = await getSignedInUserFn();

  if (!user) return;

  const { insertId } = await db
    .insertInto("sales")
    .values({
      status: data.status || "OPEN",
      source: data.source || "PORTAL",
      isTaxable: data.isTaxable === false ? 0 : 1,
      creatorId: 0,
      customerId: user.id,
    })
    .executeTakeFirstOrThrow();

  if (insertId == undefined) throw new Error("No insertId");

  if (data.source === "PORTAL")
    data.items.push({
      type: "CONVENIENCE FEE",
      name: "Convenience Fee",
      description: "Convenience Fee",
      price: Number(process.env["CONVENIENCE_FEE"]),
      quantity: 1,
    });

  await saveItems(
    insertId,
    data.items.map((item) => ({ ...item, creatorId: user.id })),
  );
}

export async function find(data: Partial<Sale>) {
  let query = db.selectFrom("sales");

  if (data.status) query = query.where("status", "=", data.status);

  if (data.customerId) query = query.where("customerId", "=", data.customerId);

  const sale = await query.selectAll().execute();

  return { ...sale };
}

async function findItems(saleId: bigint) {
  const items = await db
    .selectFrom("saleItems")
    .where("saleId", "=", saleId)
    .selectAll()
    .execute();

  return items.map((item) => ({
    ...item,
    createdAt: toDate(item.createdAt),
    updatedAt: toDate(item.updatedAt),
  }));
}

async function saveItems(
  saleId: bigint,
  items: {
    id?: number;
    type: SaleItem["type"];
    name: string;
    description: string;
    price: number;
    quantity: number;
    creatorId: number;
  }[],
) {
  for (const item of items) {
    if (item.id) break;

    await db
      .insertInto("saleItems")
      .values({
        saleId,
        type: item.type,
        name: item.name,
        description: item.description,
        price: item.price,
        quantity: item.quantity,
        creatorId: item.creatorId,
      })
      .execute();
  }
}
