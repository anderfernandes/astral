import { createServerFn } from "@tanstack/solid-start";
import { execSync } from "node:child_process";
import { db } from "~db";
import pkg from "../../package.json";

export const getSettingsFn = createServerFn().handler(async () => {
  const commit = execSync("git rev-parse --short HEAD").toString().trim();
  const version = pkg.version;

  const membershipTypes = await db
    .selectFrom("membershipTypes")
    .selectAll()
    .execute();

  return {
    name: process.env["NAME"],
    taxRate: Number(process.env["SALE_TAX_RATE"]),
    convenienceFee: Number(process.env["CONVENIENCE_FEE"]),
    hasMembershipTypes: membershipTypes.length > 0,
    locale: process.env["LOCALE"],
    currency: process.env["CURRENCY"],
    database: process.env["DB_DRIVER"],
    version: `${version} (${commit})`,
  };
});
