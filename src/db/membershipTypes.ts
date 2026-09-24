import { Temporal } from "@js-temporal/polyfill";
import { db } from "~db";

async function create(
  data: Omit<MembershipTypeInsertable, "isActive" | "isPublic"> & {
    isActive: boolean;
    isPublic: boolean;
  },
) {
  try {
    await db
      .insertInto("membershipTypes")
      .values({
        name: data.name,
        description: data.description,
        cover: data.description,
        duration: data.duration,
        price: data.price * 100,
        maxFreeSecondaries: data.maxFreeSecondaries,
        paidSecondaryPrice: data.paidSecondaryPrice * 100,
        maxPaidSecondaries: data.maxPaidSecondaries,
        isActive: data.isActive ? 1 : 0,
        isPublic: data.isPublic ? 1 : 0,
        creatorId: data.creatorId,
      })
      .executeTakeFirstOrThrow();

    console.log("Membership type created!");
  } catch (e) {
    console.error((e as Error).message);
  }
}

async function update(
  id: number,
  data: Omit<
    Required<MembershipTypeUpdateable>,
    "isActive" | "isPublic" | "updatedAt" | "cover"
  > & {
    isActive: boolean;
    isPublic: boolean;
  },
) {
  await db
    .updateTable("membershipTypes")
    .set({
      name: data.name,
      description: data.description,
      cover: data.description,
      duration: data.duration,
      price: data.price * 100,
      maxFreeSecondaries: data.maxFreeSecondaries,
      paidSecondaryPrice: data.paidSecondaryPrice * 100,
      maxPaidSecondaries: data.maxPaidSecondaries,
      isActive: data.isActive ? 1 : 0,
      isPublic: data.isPublic ? 1 : 0,
      updatedAt: Temporal.Now.instant().epochMilliseconds,
    })
    .where("id", "=", id)
    .execute();
}

async function find(id: number) {
  const data = await db
    .selectFrom("membershipTypes")
    .where("id", "=", id)
    .selectAll()
    .executeTakeFirstOrThrow();

  return {
    ...data,
    isActive: Boolean(data.isActive),
    isPublic: Boolean(data.isPublic),
  };
}

async function findBy(q: { isActive?: boolean; isPublic?: boolean }) {
  let result = await findAll();

  if (q.isActive != undefined)
    result = result.filter((item) => item.isActive == q.isActive);

  if (q.isPublic != undefined)
    result = result.filter((item) => item.isPublic == q.isPublic);

  return result;
}

async function findAll() {
  const data = await db.selectFrom("membershipTypes").selectAll().execute();

  return data.map((item) => ({
    ...item,
    isActive: Boolean(item.isActive),
    isPublic: Boolean(item.isPublic),
  }));
}

export default { create, find, findAll, findBy, update };
