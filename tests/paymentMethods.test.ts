import { expect, test } from "vitest";
import { db } from "~db";

test("1: save new payment method", async () => {
  // const item = await PaymentMethod.create({
  //   name: "Test Payment Method",
  //   description: "A test payment method",
  //   type: "CASH",
  //   isActive: true,
  //   isPublic: true,
  //   createdAt: new Date(),
  // });

  await db
    .insertInto("paymentMethods")
    .values({
      name: "Test Payment Method",
      description: "A test payment method",
      type: "CASH",
      isActive: 1,
      isPublic: 1,
      creatorId: 0,
    })
    //.returningAll()
    .executeTakeFirstOrThrow();

  const item = await db
    .selectFrom("paymentMethods")
    .where("id", "=", 1)
    .selectAll()
    .executeTakeFirstOrThrow();

  expect(item?.updatedAt).toBeNull();
});

test("2: update payment method", async () => {
  db.updateTable("paymentMethods")
    .set({ name: "Updated Test Payment Method", type: "OTHER" })
    .where("id", "=", 1)
    .execute();

  const item = await db
    .selectFrom("paymentMethods")
    .where("id", "=", 1)
    .selectAll()
    .executeTakeFirstOrThrow();

  expect(item?.name).toBe("Updated Test Payment Method");
});

test("3: get all payment methods", async () => {
  const items = await db.selectFrom("paymentMethods").selectAll().execute();

  expect(items.length).toBe(1);
});
