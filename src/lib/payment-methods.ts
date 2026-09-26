import { query } from "@solidjs/router";
import db from "~db";

export const getPaymentMethodsFn = query(async () => {
  "use server";
  return await db.paymentMethods.findAll();
}, "payment-methods");
