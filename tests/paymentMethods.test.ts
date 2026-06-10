import { expect, test } from "vitest";
import { PaymentMethod } from "~db";

test("1: save new payment method", async () => {
  const item = await PaymentMethod.create({
    name: "Test Payment Method",
    description: "A test payment method",
    type: "CASH",
    isActive: true,
    isPublic: true,
    createdAt: new Date(),
  });

  expect(item.updatedAt).toBeNull();
});

test("2: update payment method", async () => {
  const item = await PaymentMethod.findByPk(1);

  await item?.update({
    name: "Updated Test Payment Method",
    updatedAt: new Date(),
  });

  expect(item?.name).toBe("Updated Test Payment Method");
});

test("3: get all payment methods", async () => {
  expect(await PaymentMethod.findAll({ raw: true })).length(1);
});
