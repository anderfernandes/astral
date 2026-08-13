import { db } from "~db";
import { toDate } from "~utils/index";

export async function get(data: Partial<MembershipType>) {
  let query = db.selectFrom("membershipTypes");

  if (data.id) query = query.where("id", "=", data.id);

  const membershipType = await query.selectAll().executeTakeFirst();

  return {
    ...membershipType,
    createdAt: toDate(membershipType?.createdAt),
    updatedAt: toDate(membershipType?.updatedAt),
  };
}
