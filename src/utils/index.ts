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
  return console.log(
    Temporal.Now.instant()
      .toZonedDateTimeISO("UTC")
      .toPlainDateTime()
      .toString({ smallestUnit: "second" })
      .replace("T", " "),
  );
}

export function toDateTimeString(datetime: string) {
  return Temporal.PlainDateTime.from(datetime)
    .toZonedDateTime("UTC")
    .toPlainDateTime()
    .toString({ smallestUnit: "second" })
    .replace("T", " ");
}
