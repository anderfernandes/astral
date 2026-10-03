import { expect, test } from "vitest";
import db from "~db";

let data = {
  name: "test payment method",
  description: "a test payment method",
  type: "CASH" as PaymentMethodInsertable["type"],
  isActive: true,
  isPublic: true,
  creatorId: 0,
};

test("create", async () => {
  await db.paymentMethods.create(data);

  const method = (await db.paymentMethods.findAll())[0];

  expect(method.name).toBe(data.name);
});
