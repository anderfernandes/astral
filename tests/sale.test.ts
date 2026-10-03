import { expect, test } from "vitest";
import db from "~db";

test("create", async () => {
  await db.sales.create({
    status: "OPEN",
    source: "ADMIN",
    isTaxable: true,
    creatorId: 0,
    customerId: 0,
    items: [
      {
        type: "PRODUCT",
        name: "test product",
        description: "a test product",
        price: 10,
        quantity: 1,
      },
    ],
  });

  const sale = await db.sales.find(1);

  expect(sale?.id).toBe(1);
  expect(sale?.createdAt).toBeTruthy();
  expect(sale?.updatedAt).toBeFalsy();
  expect(sale?.items.length).toBe(1);
  expect(sale?.items[0].createdAt).toBeTruthy();
  expect(sale?.items[0].updatedAt).toBeFalsy();
});

test("update", async () => {
  let sale = await db.sales.find(1);

  if (!sale) throw new Error("sale does not exist");

  await db.sales.update(sale.id, { ...sale, isTaxable: false });

  sale = await db.sales.find(1);

  console.log(sale);

  expect(sale?.updatedAt).toBeTruthy();
  expect(sale?.items[0].updatedAt).toBeTruthy();
});
