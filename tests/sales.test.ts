import { expect, test } from "vitest";
import * as SaleRepository from "~repositories/SaleRepository";

test("1: save new sale", async () => {
  const id = await SaleRepository.save({
    customerId: 1,
    creatorId: 0,
    items: [
      {
        type: "MEMBERSHIP (PRIMARY)",
        name: "test sale item name",
        description: "test sale item description",
        price: 500,
        quantity: 1,
      },
    ],
  });

  expect(id).toBeDefined();
});

test("2: update sale", async () => {
  await SaleRepository.save({ id: 1, status: "CANCELED", customerId: 1 });

  const sale = await SaleRepository.get({ id: 1 });

  expect(sale).toBeDefined();
});
