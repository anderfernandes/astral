import { createFileRoute } from "@tanstack/solid-router";
import { createServerFn } from "@tanstack/solid-start";
import { For, Loading } from "solid-js";
import { Badge } from "~components";
import { db } from "~db";
import { toDate, toDateTimeString } from "~utils/index";

export const Route = createFileRoute("/admin/sales/")({
  component: RouteComponent,
  loader: () => getSalesFn(),
});

function RouteComponent() {
  const loaderData = Route.useLoaderData();
  return (
    <section class="grid gap-3">
      <ul role="list" class="divide-y divide-gray-100">
        <Loading fallback={<span>Loading...</span>}>
          <For each={loaderData()}>
            {(item) => (
              <li class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                  <svg class="size-12" viewBox="0 0 24 24">
                    <path
                      fill="currentColor"
                      d="M17 7V9H7V7H17M15 11V13H7V11H15M18 20L21 22V3H3V22L6 20L9 22L12 20L15 22L18 20M19 5V18.26L18 17.6L15 19.6L12 17.6L9 19.6L6 17.6L5 18.26V5H19Z"
                    />
                  </svg>
                  <div class="min-w-0 flex-auto">
                    <p class="flex items-center gap-2 text-sm/6 font-semibold text-gray-900">
                      #{item.id} <Badge text={item.source} />
                    </p>
                    <p class="mt-1 truncate text-xs/5 text-gray-500">
                      {item.customerEmail}
                    </p>
                  </div>
                </div>
                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                  <p class="text-sm/6 text-gray-900">{item.status}</p>
                  <p class="mt-1 text-xs/5 text-gray-500">
                    Created on{" "}
                    <time datetime="2023-01-23T13:23Z">
                      {toDate(item.createdAt).toLocaleString("en-US", {
                        dateStyle: "medium",
                        timeStyle: "short",
                      })}
                    </time>
                  </p>
                </div>
              </li>
            )}
          </For>
        </Loading>
      </ul>
    </section>
  );
}

const getSalesFn = createServerFn().handler(() =>
  db
    .selectFrom("sales")
    .innerJoin("users", "sales.customerId", "users.id")
    .select([
      "sales.id",
      "sales.createdAt",
      "sales.isTaxable",
      "sales.source",
      "sales.status",
      "sales.updatedAt",
      "users.firstName as customerFirstName",
      "users.lastName as customerLastName",
      "users.email as customerEmail",
    ])
    .orderBy("sales.id", "desc")
    .execute(),
);
