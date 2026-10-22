import { Temporal } from "@js-temporal/polyfill";
import { db } from "~db";

export async function create(
  membershipId: number,
  members: MemberInsertable[],
) {
  await db
    .insertInto("members")
    .values(
      members.map((member) => ({
        userId: member.userId,
        type: member.type,
        membershipId,
        saleId: member.saleId,
        startsAt: member.startsAt,
        endsAt: member.endsAt,
        creatorId: member.creatorId,
      })),
    )
    .execute();
}

export async function update(
  membershipId: number,
  members: MemberUpdateable[],
) {
  let query = db.updateTable("members");

  for (const member of members) {
    query = query.set({
      // MEMBER ID?
      userId: member.userId,
      type: member.type,
      membershipId,
      saleId: member.saleId,
      startsAt: member.startsAt,
      endsAt: member.startsAt,
      creatorId: member.creatorId,
      updatedAt: Math.floor(Temporal.Now.instant().epochMilliseconds / 1000),
    });
  }

  await query.execute();
}

export async function findBy(member: { membershipId: number }) {
  return await db
    .selectFrom("members")
    .where("membershipId", "=", member.membershipId)
    .selectAll()
    .execute();
}
