import { Temporal } from "@js-temporal/polyfill";
import { query } from "@solidjs/router";
import { createMemo, For } from "solid-js";
import { Badge } from "~components";
import db from "~db";
import { toCurrencyString } from "~lib";

export default function SalesIndexPage() {
  const sales = createMemo(() => getSalesFn());
  return (
    <>
      <header class="fixed top-0 left-64 flex h-16 w-[calc(100vw-18rem)] items-center bg-white/50 p-4">
        <span class="text-base/6 font-bold">Sales</span>
      </header>
      <section class="grid content-start divide-y divide-gray-300 pt-16">
        <For each={sales()}>
          {(sale) => {
            return (
              <a
                href={`/admin/sales/${sale.id}`}
                class="grid py-3 hover:bg-gray-100"
              >
                <p class="flex items-center gap-3">
                  <span class="text-sm/6 font-semibold">#{sale.id}</span>
                  <Badge text={sale.status} />
                  <span class="text-sm/6">
                    {sale.source} &middot; {toCurrencyString(sale.total)} total
                  </span>
                </p>
                <p class="text-sm text-gray-500">
                  {sale.customer.firstName} {sale.customer.lastName} &middot;{" "}
                  {Temporal.Instant.fromEpochMilliseconds(
                    sale.createdAt,
                  ).toLocaleString("en-US")}
                </p>
              </a>
            );
          }}
        </For>
      </section>
    </>
  );
}

const getSalesFn = query(async () => {
  "use server";
  return await db.sales.findBy();
}, "sales");
