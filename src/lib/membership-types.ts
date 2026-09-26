import { query } from "@solidjs/router";
import { redirect } from "@solidjs/web";
import db from "~db";

export const getMembershipTypesFn = query(async () => {
  "use server";
  return await db.membershipTypes.findAll();
}, "membership-types");

export const getMembershipTypeFn = query(async (id: string) => {
  "use server";
  try {
    return await db.membershipTypes.find(Number(id));
  } catch (e) {
    console.log((e as Error).message);
    throw redirect("/");
  }
}, "membership-type");
