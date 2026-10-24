import { query, RouteDefinition, RouteProps } from "@solidjs/router";
import { Router } from "../../../../router";
import { Alert, Badge, Button, Header, Table } from "~components";
import db from "~db";
import { createMemo, For, Loading, Show } from "solid-js";
import {
  formatCurrency,
  formatDateTime,
  getOrganizationSettingsFn,
} from "~lib";
import { respond } from "@solidjs/web";
import { Temporal } from "@js-temporal/polyfill";

type SaleDetailsPageProps = RouteProps<typeof Router.paths.admin.sales>;

export const route = {
  preload: ({ params }) => {
    void getSaleFn(Number(params.id));
    void getOrganizationSettingsFn();
  },
} satisfies RouteDefinition;

export default function SaleDetailsPage(props: SaleDetailsPageProps) {
  const sale = createMemo(() => getSaleFn(Number(props.params.id)));
  const organization = createMemo(() => getOrganizationSettingsFn());
  return (
    <>
      <Header>
        <h5 class="flex items-center gap-3">
          <span class="font-semibold">Sale #{props.params.id}</span>
          <Loading fallback="">
            <Badge text={sale().status} />
            <div class="flex items-center text-sm">
              <svg viewBox="0 0 24 24" class="size-4">
                <path
                  fill="currentColor"
                  d="M17,3H14V6H10V3H7A2,2 0 0,0 5,5V21A2,2 0 0,0 7,23H17A2,2 0 0,0 19,21V5A2,2 0 0,0 17,3M12,8A2,2 0 0,1 14,10A2,2 0 0,1 12,12A2,2 0 0,1 10,10A2,2 0 0,1 12,8M16,16H8V15C8,13.67 10.67,13 12,13C13.33,13 16,13.67 16,15V16M13,5H11V1H13V5M16,19H8V18H16V19M12,21H8V20H12V21Z"
                />
              </svg>
              <Show when={sale().creator.id > 0} fallback={<span>system</span>}>
                {sale().creator.firstName}
              </Show>
            </div>
            <div class="flex items-center gap-1 text-sm/6">
              <svg viewBox="0 0 24 24" class="size-4">
                <path
                  fill="currentColor"
                  d="M17 9H8V7H17V9M7 7H5V9H7V7M7 4H5V6H7V4M10 4H8V6H10V4M13 17V19H14C14.55 19 15 19.45 15 20H22V22H15C15 22.55 14.55 23 14 23H10C9.45 23 9 22.55 9 22H2V20H9C9 19.45 9.45 19 10 19H11V17H4C2.89 17 2 16.11 2 15L2 3C2 1.89 2.9 1 4 1H20C21.11 1 22 1.89 22 3L22 15C22 16.11 21.11 17 20 17H13M20 15V3H4V15L20 15M11 6H19V4H11V6M5 12H11V10H5V12M13 14H19V12H13V14Z"
                />
              </svg>
              <span>{sale().source}</span>
            </div>
            <div class="flex items-center gap-1">
              <svg viewBox="0 0 24 24" class="size-4">
                <path
                  fill="currentColor"
                  d="M21,16.5C21,16.88 20.79,17.21 20.47,17.38L12.57,21.82C12.41,21.94 12.21,22 12,22C11.79,22 11.59,21.94 11.43,21.82L3.53,17.38C3.21,17.21 3,16.88 3,16.5V7.5C3,7.12 3.21,6.79 3.53,6.62L11.43,2.18C11.59,2.06 11.79,2 12,2C12.21,2 12.41,2.06 12.57,2.18L20.47,6.62C20.79,6.79 21,7.12 21,7.5V16.5M12,4.15L10.11,5.22L16,8.61L17.96,7.5L12,4.15M6.04,7.5L12,10.85L13.96,9.75L8.08,6.35L6.04,7.5M5,15.91L11,19.29V12.58L5,9.21V15.91M19,15.91V9.21L13,12.58V19.29L19,15.91Z"
                />
              </svg>
              <span class="text-sm">{sale().items.length}</span>
            </div>
          </Loading>
        </h5>
      </Header>
      <section class="mt-16 grid gap-3">
        <Loading fallback={<p>Loading...</p>}>
          <div class="grid lg:grid-cols-2">
            <p class="text-sm text-gray-500">
              Created on {formatDateTime(sale().createdAt)}
            </p>
            <Show when={sale().updatedAt}>
              <p class="text-sm text-gray-500">
                Last Updated on {formatDateTime(sale().updatedAt as number)}
              </p>
            </Show>
          </div>
          <div class="grid rounded border border-gray-300 p-3 text-sm">
            <div class="flex items-center gap-3">
              <svg viewBox="0 0 24 24" class="size-12">
                <path
                  fill="currentColor"
                  d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"
                />
              </svg>
              <div class="grid grow">
                <p>
                  {sale().customer.firstName} {sale().customer.lastName}
                </p>
                <p class="text-gray-500">{sale().customer.email}</p>
              </div>
            </div>
          </div>
          <div class="grid grid-cols-3 text-center">
            <div class="grid">
              <span class="text-sm">Paid</span>
              <span class="text-lg font-semibold">
                {formatCurrency(sale().paid)}
              </span>
            </div>
            <div class="grid">
              <span class="text-sm">Total</span>
              <span class="text-lg font-semibold">
                {formatCurrency(sale().total)}
              </span>
            </div>
            <div class="grid">
              <span class="text-sm">Balance</span>
              <span class="text-lg font-semibold">
                {formatCurrency(sale().balance)}
              </span>
            </div>
          </div>
          <h5 class="text-sm/6 font-medium">Items ({sale().items.length})</h5>
          <Table>
            <Table.Head>
              <Table.Header text="Name" />
              <Table.Header text="Type" />
              <Table.Header text="Quantity" />
              <Table.Header text="Created On" />
              <Table.Header text="Last Updated On" />
              <Table.Header text="Price" />
            </Table.Head>
            <Table.Body>
              <For each={sale()?.items} keyed={(item) => item.id}>
                {(item) => (
                  <Table.Row>
                    <Table.DataCell>
                      <p>{item().name}</p>
                      <p class="text-gray-500">{item().description}</p>
                    </Table.DataCell>
                    <Table.DataCell text={<Badge text={item().type} />} />
                    <Table.DataCell text={item().quantity} />
                    <Table.DataCell>
                      {formatDateTime(item().createdAt)}
                    </Table.DataCell>
                    <Table.DataCell>
                      <Show when={item().updatedAt} fallback="N/A">
                        {formatDateTime(item().updatedAt as number)}
                      </Show>
                    </Table.DataCell>
                    <Table.DataCell text={formatCurrency(item().price)} />
                  </Table.Row>
                )}
              </For>
            </Table.Body>
          </Table>
          <div class="grid gap-3 text-right text-sm">
            <div class="grid grid-cols-4">
              <span class="col-span-3 text-right">Subtotal </span>
              <span>{formatCurrency(sale().subtotal)}</span>
            </div>
            <div class="grid grid-cols-4">
              <span class="col-span-3 text-right">
                Tax ({organization().saleTaxRate}%){" "}
              </span>
              <span>{formatCurrency(sale().tax)}</span>
            </div>
            <div class="grid grid-cols-4 font-semibold">
              <span class="col-span-3 text-right">Total</span>
              <span>{formatCurrency(sale().total)}</span>
            </div>
          </div>
          <h5 class="text-sm/6 font-medium">
            Payments ({sale().payments.length})
          </h5>
          <Show
            when={sale().payments.length > 0}
            fallback={<Alert text="No payments so far." />}
          >
            <Table>
              <Table.Head>
                <Table.Header text="#" />
                <Table.Header text="Created On" />
                <Table.Header text="Last Updated On" />
                <Table.Header text="Method" />
                <Table.Header text="Cashier" />
                <Table.Header text="Customer" />
                <Table.Header text="Tendered" />
              </Table.Head>
              <Table.Body>
                <For each={sale().payments} keyed={(payment) => payment.id}>
                  {(payment) => (
                    <Table.Row>
                      <Table.DataCell text={payment().id} />
                      <Table.DataCell>
                        {formatDateTime(payment().createdAt)}
                      </Table.DataCell>
                      <Table.DataCell>
                        <Show when={payment().updatedAt} fallback="N/A">
                          {payment().updatedAt}
                        </Show>
                      </Table.DataCell>
                      <Table.DataCell text={payment().method.name} />
                      <Table.DataCell>
                        {payment().cashier.firstName}{" "}
                        {payment().cashier.lastName?.at(0)}.
                      </Table.DataCell>
                      <Table.DataCell>
                        {payment().customer.firstName}{" "}
                        {payment().customer.lastName}
                      </Table.DataCell>
                      <Table.DataCell>
                        {formatCurrency(payment().tendered)}
                      </Table.DataCell>
                    </Table.Row>
                  )}
                </For>
              </Table.Body>
            </Table>
          </Show>
          <h5 class="flex w-full items-center">
            <div class="grow text-sm/6 font-medium">
              Memos ({sale().memos.length})
            </div>
            <Button text="New Memo..." />
          </h5>
          <Show
            when={sale().memos.length > 0}
            fallback={<Alert text="No payments so far." />}
          >
            <For each={sale().memos} keyed={(memo) => memo.id}>
              {(memo) => (
                <div class="flex w-full items-center gap-3">
                  <svg viewBox="0 0 24 24" class="size-10">
                    <path
                      fill="currentColor"
                      d="M20,2A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H6L2,22V4C2,2.89 2.9,2 4,2H20M4,4V17.17L5.17,16H20V4H4M6,7H18V9H6V7M6,11H15V13H6V11Z"
                    />
                  </svg>
                  <div class="grid grow text-sm">
                    <div class="flex items-center gap-3">
                      <span class="font-medium">{memo().creatorId}</span>
                      <span class="text-gray-500">
                        {formatDateTime(memo().createdAt)}
                      </span>
                    </div>
                    <p>{memo().message}</p>
                  </div>
                </div>
              )}
            </For>
          </Show>
        </Loading>
      </section>
    </>
  );
}

const getSaleFn = query(async (id: number) => {
  "use server";
  const sale = await db.sales.find(id);

  if (!sale) throw respond("Not Found", { status: 404 });

  return sale;
}, "sale-details");
