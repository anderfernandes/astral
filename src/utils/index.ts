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
