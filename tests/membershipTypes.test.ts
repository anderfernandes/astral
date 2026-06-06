import { afterAll, beforeAll, expect, test } from "vitest";
import { execSync } from "node:child_process";
import { MembershipType } from "~db";
import { where } from "@sequelize/core";

// beforeAll(() => {
//   execSync("npm run db:migrate");
// }, 50_000);

// afterAll(() => {});

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

  expect(item.updateAt).toBeNull();
});

test("2: fetches all membership types", async () => {
  const items = await MembershipType.findAll({ raw: true });

  expect(items).length(1);
});

test("3: update membership type", async () => {
  const item = (await MembershipType.findByPk(1)) as MembershipType;

  item.name = "Updated Membership Type";
  item.updateAt = new Date();

  await item.save();

  expect(item.name).toBe("Updated Membership Type");
  expect(item.updateAt).toBeTruthy();
});
