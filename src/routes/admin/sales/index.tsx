import { query, RouteDefinition } from "@solidjs/router";
import { createMemo, For, Loading, Show } from "solid-js";
import { Badge, Header } from "~components";
import db from "~db";
import { formatDateTime, toCurrencyString } from "~lib";

export const route = {
  preload: () => {
    void getSalesFn();
  },
} satisfies RouteDefinition;

export default function SalesIndexPage() {
  const sales = createMemo(() => getSalesFn());
  return (
    <>
      <Header title="Sales" />
      <section class="grid content-start divide-y divide-gray-300 pt-16">
        <Loading fallback={<p>Loading...</p>}>
          <For each={sales()}>
            {(sale) => {
              return (
                <a
                  href={`/admin/sales/${sale.id}`}
                  class="grid p-3 hover:bg-gray-100"
                >
                  <div class="flex items-center gap-3">
                    <div class="text-sm/6 font-semibold">#{sale.id}</div>
                    <Badge text={sale.status} />
                    <div class="flex items-center text-sm">
                      <svg viewBox="0 0 24 24" class="size-4">
                        <path
                          fill="currentColor"
                          d="M17,3H14V6H10V3H7A2,2 0 0,0 5,5V21A2,2 0 0,0 7,23H17A2,2 0 0,0 19,21V5A2,2 0 0,0 17,3M12,8A2,2 0 0,1 14,10A2,2 0 0,1 12,12A2,2 0 0,1 10,10A2,2 0 0,1 12,8M16,16H8V15C8,13.67 10.67,13 12,13C13.33,13 16,13.67 16,15V16M13,5H11V1H13V5M16,19H8V18H16V19M12,21H8V20H12V21Z"
                        />
                      </svg>
                      <Show
                        when={sale.creator.id > 0}
                        fallback={<span>system</span>}
                      >
                        {sale.creator.firstName}
                      </Show>
                    </div>
                    <div class="flex items-center gap-1 text-sm/6">
                      <svg viewBox="0 0 24 24" class="size-4">
                        <path
                          fill="currentColor"
                          d="M17 9H8V7H17V9M7 7H5V9H7V7M7 4H5V6H7V4M10 4H8V6H10V4M13 17V19H14C14.55 19 15 19.45 15 20H22V22H15C15 22.55 14.55 23 14 23H10C9.45 23 9 22.55 9 22H2V20H9C9 19.45 9.45 19 10 19H11V17H4C2.89 17 2 16.11 2 15L2 3C2 1.89 2.9 1 4 1H20C21.11 1 22 1.89 22 3L22 15C22 16.11 21.11 17 20 17H13M20 15V3H4V15L20 15M11 6H19V4H11V6M5 12H11V10H5V12M13 14H19V12H13V14Z"
                        />
                      </svg>
                      <span>{sale.source}</span>
                    </div>
                    <div class="flex items-center gap-1 text-sm">
                      <svg viewBox="0 0 24 24" class="size-4">
                        <path
                          fill="currentColor"
                          d="M21,16.5C21,16.88 20.79,17.21 20.47,17.38L12.57,21.82C12.41,21.94 12.21,22 12,22C11.79,22 11.59,21.94 11.43,21.82L3.53,17.38C3.21,17.21 3,16.88 3,16.5V7.5C3,7.12 3.21,6.79 3.53,6.62L11.43,2.18C11.59,2.06 11.79,2 12,2C12.21,2 12.41,2.06 12.57,2.18L20.47,6.62C20.79,6.79 21,7.12 21,7.5V16.5M12,4.15L10.11,5.22L16,8.61L17.96,7.5L12,4.15M6.04,7.5L12,10.85L13.96,9.75L8.08,6.35L6.04,7.5M5,15.91L11,19.29V12.58L5,9.21V15.91M19,15.91V9.21L13,12.58V19.29L19,15.91Z"
                        />
                      </svg>
                      <span class="text-sm">{sale.items.length}</span>
                    </div>
                    <span class="text-sm">
                      {toCurrencyString(sale.paid)} paid
                    </span>
                    <span class="text-sm">
                      {toCurrencyString(sale.total)} total
                    </span>
                  </div>
                  <p class="text-sm text-gray-500">
                    {sale.customer.firstName} {sale.customer.lastName} &middot;{" "}
                    {formatDateTime(sale.createdAt)}
                  </p>
                </a>
              );
            }}
          </For>
        </Loading>
      </section>
    </>
  );
}

const getSalesFn = query(async () => {
  "use server";
  return await db.sales.findBy();
}, "sales");
