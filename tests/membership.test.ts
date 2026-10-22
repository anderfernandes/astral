import { expect, test } from "vitest";
import db from "~db";

test("create", async () => {
  // await db.membershipTypes.create({
  //   name: "test basic membership",
  //   description: "for membership tests",
  //   duration: 365,
  //   price: 50,
  //   maxFreeSecondaries: 2,
  //   paidSecondaryPrice: 0,
  //   maxPaidSecondaries: 0,
  //   isActive: true,
  //   isPublic: true,
  //   creatorId: 0,
  // });

  const membershipId = await db.memberships.create({
    creatorId: 0,
    typeId: 1,
    members: [
      {
        creatorId: 0,
        userId: 1,
        type: "PRIMARY",
        saleId: 0,
        startsAt: Math.floor(Temporal.Now.instant().epochMilliseconds / 1000),
        endsAt: Math.floor(
          Temporal.Now.instant().add({ hours: 365 * 24 }).epochMilliseconds /
            1000,
        ),
      },
    ],
  });

  expect(membershipId).toBe(1);
});

test("find", async () => {
  const membership = await db.memberships.find(1);

  console.log(membership);

  expect(membership?.updatedAt).toBeFalsy();
  expect(membership?.members.length).toBe(1);
});
