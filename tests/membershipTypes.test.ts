import { expect, test } from "vitest";
import { MembershipType } from "~db";

test("1: save new membership type", async () => {
  const item = await MembershipType.create({
    name: "New Membership Type",
    description: "New Membership Type",
    duration: 365,
    price: 60,
    maxFreeSecondaries: 0,
    maxPaidSecondaries: 0,
    paidSecondaryPrice: 0,
    isActive: true,
    isPublic: true,
    createdAt: new Date(),
  });

  expect(item.updatedAt).toBeNull();
});

test("2: fetches all membership types", async () => {
  const items = await MembershipType.findAll({ raw: true });

  expect(items).length(1);
});

test("3: update membership type", async () => {
  const item = (await MembershipType.findByPk(1)) as MembershipType;

  await item.update({
    name: "Updated Membership Type",
    updatedAt: new Date(),
  });

  expect(item.name).toBe("Updated Membership Type");
  expect(item.updatedAt).toBeDefined();
});
