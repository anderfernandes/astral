import * as v from "valibot";

export const FirstNameSchema = v.pipe(
  v.string(),
  v.minLength(2),
  v.maxLength(255),
);

export const LastNameSchema = v.pipe(
  v.string(),
  v.minLength(2),
  v.maxLength(255),
);

export const EmailSchema = v.pipe(
  v.pipe(v.string(), v.email(), v.maxLength(255)),
);

export const SaleStatus = [
  "ROLE_USER",
  "ROLE_STAFF",
  "ROLE_ADMIN",
  "ROLE_MEMBER",
];

export const SaleSource = ["CASHIER", "ADMIN", "PORTAL"];

export const SaleSchema = v.object({
  status: v.picklist(SaleStatus),
  source: v.picklist(SaleSource),
  isTaxable: v.boolean(),
  creatorId: v.pipe(v.number(), v.minValue(0)),
  customerId: v.pipe(v.number(), v.minValue(0)),
});

export const SaleItemType = [
  "TICKET",
  "PRODUCT",
  "MEMBERSHIP (PRIMARY)",
  "MEMBERSHIP (FREE SECONDARY)",
  "MEMBERSHIP (PAID SECONDARY)",
  "CONVENIENCE FEE",
  "SURCHARGE",
  "DISCOUNT",
] as const;

export const SaleItemSchema = v.object({
  type: v.picklist(SaleItemType),
  name: v.pipe(v.string(), v.minLength(0), v.maxLength(255)),
  description: v.pipe(v.string(), v.minLength(0), v.maxLength(255)),
  price: v.pipe(v.number(), v.minValue(0)),
  quantity: v.pipe(v.number(), v.minValue(0)),
});

export const SaleItemsSchema = v.array(SaleItemSchema);
