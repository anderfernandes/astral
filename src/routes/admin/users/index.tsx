import { useQuery } from "@tanstack/solid-query";
import { createFileRoute, Link } from "@tanstack/solid-router";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { For } from "solid-js";
import { db } from "~db";

export const Route = createFileRoute("/admin/users/")({
  component: RouteComponent,
});

function RouteComponent() {
  const query = useQuery(() => ({
    queryKey: ["users"],
    queryFn: useServerFn(getUsersFn),
  }));

  return (
    <section class="grid content-start gap-3">
      <h1 class="text-base/7 font-semibold">Users</h1>
      <ul role="list" class="divide-y divide-gray-100">
        <For each={query.data}>
          {(user) => (
            <li class="flex justify-between gap-x-6 py-5">
              <Link
                to="/admin/users/$id"
                params={{ id: String(user.id) }}
                class="flex min-w-0 gap-x-4"
              >
                <svg viewBox="0 0 24 24" class="size-12">
                  <path
                    fill="currentColor"
                    d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"
                  />
                </svg>
                <div class="min-w-0 flex-auto">
                  <p class="text-sm/6 font-semibold text-gray-900">
                    {user.firstName} {user.lastName}
                  </p>
                  <p class="mt-1 truncate text-xs/5 text-gray-500">
                    {user.email}
                  </p>
                </div>
              </Link>
              {/* <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                <p class="text-sm/6 text-gray-900">Co-Founder / CEO</p>
                <p class="mt-1 text-xs/5 text-gray-500">
                  Last seen <time datetime="2023-01-23T13:23Z">3h ago</time>
                </p>
              </div> */}
            </li>
          )}
        </For>
      </ul>
    </section>
  );
}

const getUsersFn = createServerFn().handler(async () =>
  db.selectFrom("users").selectAll().orderBy("id", "desc").execute(),
);
