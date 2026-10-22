import { db } from "~db";
import * as members from "./members";

export async function create(
  membership: MembershipInsertable & {
    members: Omit<MemberInsertable, "membershipId">[];
  },
) {
  let membershipId: number;

  const query = db.insertInto("memberships").values({
    typeId: membership.typeId,
    creatorId: membership.creatorId,
  });

  if (["mysql", "mariadb"].includes(process.env.DB_DRIVER)) {
    const result = await query.executeTakeFirst();

    membershipId = Number(result.insertId);
  } else if (process.env.DB_DRIVER === "mssql") {
    const result = await query.output("inserted.id").executeTakeFirst();

    if (!result || !result.id) throw new Error("Error creating membership.");

    membershipId = result.id;
  } else {
    const result = await query.returning("id").executeTakeFirst();

    if (!result || !result.id) throw new Error("Error creating membership.");

    membershipId = result?.id;
  }

  await members.create(
    membershipId,
    membership.members.map((member) => ({
      userId: member.userId,
      type: member.type,
      membershipId,
      saleId: member.saleId,
      startsAt: member.startsAt,
      endsAt: member.endsAt,
      creatorId: member.creatorId,
    })),
  );

  return membershipId;
}

export async function find(id: number) {
  const membership = await db
    .selectFrom("memberships")
    .where("id", "=", id)
    .selectAll()
    .executeTakeFirst();

  if (!membership) return null;

  const _members = await members.findBy({ membershipId: membership.id });

  return { ...membership, members: _members };
}
