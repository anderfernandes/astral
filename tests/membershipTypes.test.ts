import { sql } from "kysely";
import { expect, test } from "vitest";
import { db } from "~db";

test("1: save new membership type", async () => {
  await db
    .insertInto("membershipTypes")
    .values({
      name: "New Membership Type",
      description: "New Membership Type",
      duration: 365,
      price: 60,
      maxFreeSecondaries: 0,
      maxPaidSecondaries: 0,
      paidSecondaryPrice: 0,
      isActive: 1,
      isPublic: 1,
    })
    //.returningAll()
    .executeTakeFirstOrThrow();

  const item = await db
    .selectFrom("membershipTypes")
    .where("id", "=", 1)
    .selectAll()
    .executeTakeFirstOrThrow();

  expect(item).toBeDefined();
  expect(item?.updatedAt).toBeNull();
});

test("2: get all membership types", async () => {
  const items = await db.selectFrom("membershipTypes").selectAll().execute();

  expect(items).length(1);
});

test("3: update membership type", async () => {
  db.updateTable("membershipTypes")
    .set({
      name: "Updated Membership Type",
      updatedAt: sql`CURRENT_TIMESTAMP`,
    })
    .where("id", "=", 1)
    .execute();

  const item = await db
    .selectFrom("membershipTypes")
    .where("id", "=", 1)
    .selectAll()
    .executeTakeFirstOrThrow();

  expect(item?.name).toBe("Updated Membership Type");
  expect(item?.updatedAt).toBeDefined();
});
