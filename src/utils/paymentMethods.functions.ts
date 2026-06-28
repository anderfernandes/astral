import { createServerFn } from "@tanstack/solid-start";
import { db } from "~db";

export const getPaymentMethodsFn = createServerFn().handler(
  async () => await db.selectFrom("paymentMethods").selectAll().execute(),
);

export const savePaymentMethodFn = createServerFn({ method: "POST" })
  .validator((data: FormData) => {
    // TODO: VALIDATE

    return {
      id: data.has("id") ? Number(data.get("id")) : undefined,
      name: data.get("name") as string,
      description: data.get("description") as string,
      type: data.get("type") as PaymentMethod["type"],
      isActive: Number(data.has("isActive")) as 0 | 1,
      isPublic: Number(data.has("isPublic")) as 0 | 1,
    };
  })
  .handler(async ({ data }) => {
    if (data.id) {
      await db
        .updateTable("paymentMethods")
        .set(data)
        .where("id", "=", data.id)
        .execute();

      return;
    }

    await db.insertInto("paymentMethods").values(data).returningAll().execute();
  });
