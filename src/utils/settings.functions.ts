import { createServerFn } from "@tanstack/solid-start";

export const getSettingsFn = createServerFn().handler(async () => ({
  name: process.env["NAME"],
  taxRate: Number(process.env["SALE_TAX_RATE"]),
  convenienceFee: Number(process.env["CONVENIENCE_FEE"]),
}));
