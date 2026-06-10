import { createServerFn } from "@tanstack/solid-start";
import { MembershipType } from "~db";

export const getMembershipTypesFn = createServerFn().handler(
  async () => await MembershipType.findAll({ raw: true }),
);

export const saveMembershipTypeFn = createServerFn({ method: "POST" })
  .inputValidator((data: FormData) => {
    // TODO: VALIDATE

    const item = {
      id: data.has("id") ? Number(data.get("id")) : undefined,
      name: data.get("name") as string,
      description: data.get("description") as string,
      duration: Number(data.get("duration")),
      price: Number(data.get("price")) * 100,
      maxFreeSecondaries: Number(data.get("maxFreeSecondaries")),
      maxPaidSecondaries: Number(data.get("maxPaidSecondaries")),
      paidSecondaryPrice: Number(data.get("paidSecondaryPrice")),
      isActive: data.has("isActive"),
      isPublic: data.has("isPublic"),
    };

    return item;
  })
  .handler(async ({ data }) => {
    if (data.id) {
      const item = await MembershipType.findByPk(data.id);

      await item?.update({ ...data, updatedAt: new Date() });

      return;
    }

    await MembershipType.create({
      ...data,
      createdAt: new Date(),
    });
  });
