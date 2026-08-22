import { db } from "~db";
import { toDate } from "~utils/index";

export async function find(data: Partial<Payment>) {
  let query = db.selectFrom("payments");

  if (data.saleId) query = query.where("saleId", "=", data.saleId);

  const payments = await query.selectAll().execute();

  return payments.map((item) => ({
    ...item,
    createdAt: toDate(item.createdAt),
    updatedAt: item.updatedAt ? toDate(item.updatedAt) : null,
  }));
}
