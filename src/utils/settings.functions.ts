import { createServerFn } from "@tanstack/solid-start";
import { MembershipType } from "~db";

export const getSettingsFn = createServerFn().handler(async () => {
  const membershipTypes = await MembershipType.findAll({
    raw: true,
    where: { isPublic: true, isActive: true },
  });

  return {
    name: process.env["NAME"],
    taxRate: Number(process.env["SALE_TAX_RATE"]),
    convenienceFee: Number(process.env["CONVENIENCE_FEE"]),
    hasMembershipTypes: membershipTypes.length > 0,
    locale: process.env["LOCALE"],
    currency: process.env["USD"],
  };
});
