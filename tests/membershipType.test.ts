import { expect, test } from "vitest";
import db from "~db";

const data = {
  name: "Test",
  description: "A test membership type",
  duration: 365,
  price: 60,
  maxFreeSecondaries: 0,
  paidSecondaryPrice: 0,
  maxPaidSecondaries: 0,
  isActive: true,
  isPublic: true,
  creatorId: 0,
};

test("create", async () => {
  await db.membershipTypes.create(data);

  const membershipType = await db.membershipTypes.find(1);

  expect(membershipType.name).toBe(data.name);
});

test("update", async () => {
  let membershipType = await db.membershipTypes.find(1);

  await db.membershipTypes.update(membershipType.id, {
    ...membershipType,
    name: "Updated test membership type",
  });

  membershipType = await db.membershipTypes.find(1);

  expect(membershipType.name).toBe("Updated test membership type");
});

test("findBy", async () => {
  const membershipTypes = await db.membershipTypes.findAll();

  expect(membershipTypes.length).toBe(1);
});
