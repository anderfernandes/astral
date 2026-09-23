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
        price: data.price,
        maxFreeSecondaries: data.maxFreeSecondaries,
        paidSecondaryPrice: data.paidSecondaryPrice,
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
  data: Omit<MembershipTypeUpdateable, "isActive" | "isPublic"> & {
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
      price: data.price,
      maxFreeSecondaries: data.maxFreeSecondaries,
      paidSecondaryPrice: data.paidSecondaryPrice,
      maxPaidSecondaries: data.maxPaidSecondaries,
      isActive: data.isActive ? 1 : 0,
      isPublic: data.isPublic ? 1 : 0,
    })
    .where("id", "=", id)
    .execute();
}

async function findAll() {
  const data = await db.selectFrom("membershipTypes").selectAll().execute();

  return data.map((item) => ({
    ...item,
    isActive: Boolean(item.isActive),
    isPublic: Boolean(item.isPublic),
  }));
}

export default { create, findAll, update };
