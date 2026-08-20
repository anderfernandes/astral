import { Temporal } from "@js-temporal/polyfill";

export function toCurrencyString(
  n: number,
  options: Intl.NumberFormatOptions = { maximumFractionDigits: 2 },
) {
  return (n / 100).toLocaleString("en-US", {
    style: "currency",
    currency: "USD",
    maximumFractionDigits: 2,
    ...options,
  });
}

export function getCurrentDateTimeString() {
  return Temporal.Now.instant()
    .toZonedDateTimeISO("UTC")
    .toPlainDateTime()
    .toString({ smallestUnit: "second" })
    .replace("T", " ");
}

export function toDateTimeString(datetime: string) {
  return Temporal.PlainDateTime.from(datetime)
    .toZonedDateTime("UTC")
    .toPlainDateTime()
    .toString({ smallestUnit: "second" })
    .replace("T", " ");
}

export function toDate(d: string | Date | undefined) {
  if (d === undefined) throw new Error("toDate is returning undefined");
  else if (typeof d === "string") return new Date(d + "+00:00");
  return d as Date;
}

export function calculateSaleTotals(
  items: { price: number; quantity: number }[],
  taxRate: number,
) {
  const subtotal = items.reduce(
    (total, item) => item.price * item.quantity + total,
    0,
  );

  const tax = (taxRate / 100) * subtotal;

  return {
    subtotal,
    tax,
    total: subtotal + tax,
  };
}
