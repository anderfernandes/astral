import { Temporal } from "@js-temporal/polyfill";
import { db } from "~db";

interface IPaymentMethodDto {
  name: string;
  description: string;
  type: PaymentMethodInsertable["type"];
  isActive: boolean;
  isPublic: boolean;
  creatorId: number;
}

async function create(item: IPaymentMethodDto) {
  await db
    .insertInto("paymentMethods")
    .values({
      name: item.name,
      description: item.description,
      type: item.type,
      isActive: item.isActive ? 1 : 0,
      isPublic: item.isPublic ? 1 : 0,
      creatorId: item.creatorId,
    })
    .execute();
}

async function update(id: number, item: IPaymentMethodDto & { id: number }) {
  await db
    .updateTable("paymentMethods")
    .set({
      name: item.name,
      description: item.description,
      type: item.type,
      isActive: item.isActive ? 1 : 0,
      isPublic: item.isPublic ? 1 : 0,
      creatorId: item.creatorId,
      updatedAt: Temporal.Now.instant().epochMilliseconds,
    })
    .where("id", "=", id)
    .execute();
}

async function findAll() {
  const items = await db.selectFrom("paymentMethods").selectAll().execute();

  return items.map((item) => ({
    ...item,
    createdAt: item.createdAt ? Number(item.createdAt) : undefined,
    updatedAt: item.updatedAt ? Number(item.updatedAt) : undefined,
  }));
}

export default { create, update, findAll };
