import { createServerFn } from "@tanstack/solid-start";
import { PaymentMethod } from "~db";

export const getPaymentMethodsFn = createServerFn().handler(
  async () => await PaymentMethod.findAll({ raw: true }),
);

export const savePaymentMethodFn = createServerFn({ method: "POST" })
  .inputValidator((data: FormData) => {
    return {
      id: data.has("id") ? Number(data.get("id")) : undefined,
      name: data.get("name") as string,
      description: data.get("description") as string,
      type: data.get("type") as PaymentMethod["type"],
      isActive: data.has("isActive"),
      isPublic: data.has("isPublic"),
    };
  })
  .handler(async ({ data }) => {
    if (data.id) {
      const item = await PaymentMethod.findByPk(data.id);

      await item?.update({ ...data, updatedAt: new Date() });

      return;
    }

    await PaymentMethod.create({
      ...data,
      createdAt: new Date(),
    });
  });
