import { Temporal } from "@js-temporal/polyfill";
import { useQuery } from "@tanstack/solid-query";
import { createFileRoute } from "@tanstack/solid-router";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { Show } from "solid-js";
import { db } from "~db";

export const Route = createFileRoute("/admin/users/$id/")({
  component: RouteComponent,
});

function RouteComponent() {
  const params = Route.useParams();

  const query = useQuery(() => ({
    queryKey: ["users", params().id],
    queryFn: useServerFn(() => getUserFn({ data: { id: params().id } })),
  }));

  return (
    <div>
      <div class="px-4 sm:px-0">
        <h3 class="text-base/7 font-semibold text-gray-900">User Details</h3>
        <p class="mt-1 max-w-2xl text-sm/6 text-gray-500">User details</p>
      </div>
      <div class="mt-6 border-t border-gray-100">
        <dl class="divide-y divide-gray-100">
          <div class="grid grid-cols-2">
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm/6 font-medium text-gray-900">First Name</dt>
              <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                {query.data?.firstName}
              </dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm/6 font-medium text-gray-900">Last Name</dt>
              <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                {query.data?.lastName}
              </dd>
            </div>
          </div>
          {/* <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm/6 font-medium text-gray-900">Application for</dt>
            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
              Backend Developer
            </dd>
          </div> */}
          <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm/6 font-medium text-gray-900">Email address</dt>
            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
              {query.data?.email}
            </dd>
          </div>
          <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm/6 font-medium text-gray-900">Roles</dt>
            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
              {(JSON.parse(query.data?.roles as string) as []).join(", ")}
            </dd>
          </div>
          <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm/6 font-medium text-gray-900">Created on</dt>
            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
              {Temporal.Instant.from(
                query.data?.createdAt + "-00:00",
              ).toLocaleString("en-US", {
                dateStyle: "full",
                timeStyle: "short",
              })}
            </dd>
          </div>
          <Show when={query.data?.updatedAt}>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm/6 font-medium text-gray-900">
                Last Updated on
              </dt>
              <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                {Temporal.Instant.from(
                  query.data?.updatedAt + "-00:00",
                ).toLocaleString("en-US", {
                  dateStyle: "full",
                  timeStyle: "short",
                })}
              </dd>
            </div>
          </Show>
          <Show when={query.data?.updatedAt}>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm/6 font-medium text-gray-900">Activated on</dt>
              <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                {Temporal.Instant.from(
                  query.data?.activatedAt + "-00:00",
                ).toLocaleString("en-US", {
                  dateStyle: "full",
                  timeStyle: "short",
                })}
              </dd>
            </div>
          </Show>
          {/* <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm/6 font-medium text-gray-900">Attachments</dt>
            <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
              <ul
                role="list"
                class="divide-y divide-gray-100 rounded-md border border-gray-200"
              >
                <li class="flex items-center justify-between py-4 pr-5 pl-4 text-sm/6">
                  <div class="flex w-0 flex-1 items-center">
                    <svg
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      data-slot="icon"
                      aria-hidden="true"
                      class="size-5 shrink-0 text-gray-400"
                    >
                      <path
                        d="M15.621 4.379a3 3 0 0 0-4.242 0l-7 7a3 3 0 0 0 4.241 4.243h.001l.497-.5a.75.75 0 0 1 1.064 1.057l-.498.501-.002.002a4.5 4.5 0 0 1-6.364-6.364l7-7a4.5 4.5 0 0 1 6.368 6.36l-3.455 3.553A2.625 2.625 0 1 1 9.52 9.52l3.45-3.451a.75.75 0 1 1 1.061 1.06l-3.45 3.451a1.125 1.125 0 0 0 1.587 1.595l3.454-3.553a3 3 0 0 0 0-4.242Z"
                        clip-rule="evenodd"
                        fill-rule="evenodd"
                      />
                    </svg>
                    <div class="ml-4 flex min-w-0 flex-1 gap-2">
                      <span class="truncate font-medium text-gray-900">
                        resume_back_end_developer.pdf
                      </span>
                      <span class="shrink-0 text-gray-400">2.4mb</span>
                    </div>
                  </div>
                  <div class="ml-4 shrink-0">
                    <a
                      href="#"
                      class="font-medium text-indigo-600 hover:text-indigo-500"
                    >
                      Download
                    </a>
                  </div>
                </li>
                <li class="flex items-center justify-between py-4 pr-5 pl-4 text-sm/6">
                  <div class="flex w-0 flex-1 items-center">
                    <svg
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      data-slot="icon"
                      aria-hidden="true"
                      class="size-5 shrink-0 text-gray-400"
                    >
                      <path
                        d="M15.621 4.379a3 3 0 0 0-4.242 0l-7 7a3 3 0 0 0 4.241 4.243h.001l.497-.5a.75.75 0 0 1 1.064 1.057l-.498.501-.002.002a4.5 4.5 0 0 1-6.364-6.364l7-7a4.5 4.5 0 0 1 6.368 6.36l-3.455 3.553A2.625 2.625 0 1 1 9.52 9.52l3.45-3.451a.75.75 0 1 1 1.061 1.06l-3.45 3.451a1.125 1.125 0 0 0 1.587 1.595l3.454-3.553a3 3 0 0 0 0-4.242Z"
                        clip-rule="evenodd"
                        fill-rule="evenodd"
                      />
                    </svg>
                    <div class="ml-4 flex min-w-0 flex-1 gap-2">
                      <span class="truncate font-medium text-gray-900">
                        coverletter_back_end_developer.pdf
                      </span>
                      <span class="shrink-0 text-gray-400">4.5mb</span>
                    </div>
                  </div>
                  <div class="ml-4 shrink-0">
                    <a
                      href="#"
                      class="font-medium text-indigo-600 hover:text-indigo-500"
                    >
                      Download
                    </a>
                  </div>
                </li>
              </ul>
            </dd>
          </div> */}
        </dl>
      </div>
    </div>
  );
}

const getUserFn = createServerFn()
  .validator((data: { id: string | number }) => data)
  .handler(
    async ({ data: { id } }) =>
      await db
        .selectFrom("users")
        .where("id", "=", Number(id))
        .selectAll()
        .executeTakeFirstOrThrow(),
  );
