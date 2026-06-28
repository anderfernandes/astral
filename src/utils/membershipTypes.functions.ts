import { createServerFn } from "@tanstack/solid-start";
import { db } from "~db";

export const getMembershipTypesFn = createServerFn().handler(
  async () => await db.selectFrom("membershipTypes").selectAll().execute(),
);

export const getMembershipTypeFn = createServerFn()
  .validator((data: { id: string | number }) => data)
  .handler(
    async ({ data: { id } }) =>
      await await db
        .selectFrom("membershipTypes")
        .selectAll()
        .executeTakeFirst(),
  );

export const saveMembershipTypeFn = createServerFn({ method: "POST" })
  .validator((data: FormData) => {
    // TODO: VALIDATE

    return {
      id: data.has("id") ? Number(data.get("id")) : undefined,
      name: data.get("name") as string,
      description: data.get("description") as string,
      duration: Number(data.get("duration")),
      price: Number(data.get("price")) * 100,
      maxFreeSecondaries: Number(data.get("maxFreeSecondaries")),
      maxPaidSecondaries: Number(data.get("maxPaidSecondaries")),
      paidSecondaryPrice: Number(data.get("paidSecondaryPrice")) * 100,
      isActive: Number(data.has("isActive")) as 0 | 1,
      isPublic: Number(data.has("isPublic")) as 0 | 1,
    };
  })
  .handler(async ({ data }) => {
    if (data.id) {
      await db
        .updateTable("membershipTypes")
        .set(data)
        .where("id", "=", data.id)
        .execute();

      return;
    }

    await db
      .insertInto("membershipTypes")
      .values(data)
      .returningAll()
      .execute();
  });
