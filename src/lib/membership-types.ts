import { query } from "@solidjs/router";
import db from "~db";

export const getMembershipTypesFn = query(async () => {
  "use server";
  return await db.membershipTypes.findAll();
}, "membership-types");

export const getMembershipTypeFn = query(async (id: string) => {
  "use server";
  return await db.membershipTypes.find(Number(id));
}, "membership-type");
