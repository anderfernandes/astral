import { Temporal } from "@js-temporal/polyfill";
import { useQuery } from "@tanstack/solid-query";
import { createFileRoute, useRouter } from "@tanstack/solid-router";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { createMemo, isPending, Loading, Show } from "solid-js";
import { Button } from "~components";
import { db } from "~db";
import { toDateTimeString } from "~utils/index";

function toDate(d: string | Date | undefined) {
  if (typeof d === "string") return new Date(d + "+00:00");
  return d;
}

export const Route = createFileRoute("/admin/users/$id/")({
  component: RouteComponent,
  loader: async ({ params }) => {
    const user = await getUserFn({ data: { id: params.id } });

    return {
      user: {
        ...user,
        createdAt: toDate(user.createdAt),
        updatedAt: toDate(user.updatedAt),
        activatedAt: toDate(user.activatedAt),
      },
    };
  },
});

function RouteComponent() {
  const loaderData = Route.useLoaderData();

  const user = createMemo(() => loaderData().user);

  const router = useRouter();

  const saveUser = useServerFn(saveUserFn);

  const context = Route.useRouteContext();

  return (
    <div>
      <div class="px-4 sm:px-0">
        <h3 class="text-base/7 font-semibold text-gray-900">User Details</h3>
        <p class="mt-1 max-w-2xl text-sm/6 text-gray-500">User details</p>
      </div>
      <Loading fallback={<p>loading...</p>}>
        <Show
          when={
            !import.meta.env.PROD || context().user.roles.includes("ROLE_STAFF")
          }
        >
          <form
            class="mt-4"
            onSubmit={async (e) => {
              e.preventDefault();

              if (
                !confirm(
                  `Are you sure you want to make ${user()?.firstName} staff?`,
                )
              )
                return;

              await saveUser({
                data: {
                  id: user().id,
                  roles: JSON.stringify(
                    user().roles.includes("ROLE_STAFF")
                      ? ["ROLE_USER"]
                      : ["ROLE_USER", "ROLE_STAFF"],
                  ),
                },
              });

              router.invalidate();
            }}
          >
            <Button
              text={
                user().roles.includes("ROLE_STAFF")
                  ? "Remove Staff Role..."
                  : "Add Staff Role"
              }
              type="submit"
            />
          </form>
        </Show>
        <div class="mt-6 border-t border-gray-100">
          <dl class="divide-y divide-gray-100">
            <div class="grid">
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">First Name</dt>
                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                  {user().firstName}
                </dd>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">Last Name</dt>
                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                  {user().lastName}
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
                {user().email}
              </dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm/6 font-medium text-gray-900">Roles</dt>
              <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                {(JSON.parse(user().roles as string) as []).join(", ")}
              </dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm/6 font-medium text-gray-900">Created on</dt>
              <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                {user()?.createdAt?.toLocaleString("en-US", {
                  dateStyle: "medium",
                  timeStyle: "short",
                })}
              </dd>
            </div>
            <Show when={user().updatedAt}>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">
                  Last Updated on
                </dt>
                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                  {user()?.updatedAt?.toLocaleString("en-US", {
                    dateStyle: "medium",
                    timeStyle: "short",
                  })}
                </dd>
              </div>
            </Show>
            <Show when={user().updatedAt}>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm/6 font-medium text-gray-900">
                  Activated on
                </dt>
                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                  {user()?.activatedAt?.toLocaleString("en-US", {
                    dateStyle: "medium",
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
      </Loading>
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

const saveUserFn = createServerFn()
  .validator((data: Partial<User>) => data)
  .handler(async ({ data }) => {
    console.log(data);
    if (data.id) {
      let query = db.updateTable("users");

      if (data.roles) {
        query = query.set({ roles: data.roles });
      }

      await query.where("id", "=", data.id).execute();
    }
  });
