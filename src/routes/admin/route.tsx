import {
  createFileRoute,
  Link,
  LinkProps,
  Outlet,
  redirect,
} from "@tanstack/solid-router";
import { Badge, Button, Dialog } from "~components";
import { useServerFn } from "@tanstack/solid-start";
import { createMemo, For, Show } from "solid-js";
import { getSignedInUserFn, signoutFn } from "~utils/account.functions";
import { useMutation } from "@tanstack/solid-query";
import { JSX } from "@solidjs/web";
import { getSettingsFn } from "~utils/settings.functions";

export const Route = createFileRoute("/admin")({
  component: RouteComponent,
  validateSearch: (search: { dialog?: "more" }) => search,
  loaderDeps: ({ search: { dialog } }) => ({ dialog }),
  beforeLoad: async () => {
    const user = await getSignedInUserFn();

    if (!user) {
      console.log("no user");
      throw redirect({ to: "/sign-in" });
    }

    return { user, settings: await getSettingsFn() };
  },
});

function RouteComponent() {
  const context = Route.useRouteContext();

  const search = Route.useSearch();

  const user = createMemo(() => context().user);

  const signout = useServerFn(signoutFn);

  const mutation = useMutation(() => ({
    mutationFn: () => signout(),
  }));

  return (
    <section class="mx-auto w-full lg:max-w-540">
      <div class="fixed top-0 hidden h-screen w-64 flex-col bg-black lg:flex">
        <Link to="/" class="flex h-16 items-center px-4">
          <svg
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            stroke="currentColor"
            stroke-width="1.75"
            class="size-8 text-white"
          >
            <circle cx="12" cy="12" r="4" fill="white" />
            <path
              stroke="currentColor"
              fill="transparent"
              d="M 3.3357286,6.9976809 6.3405211,6.3405212 6.9976805,3.3357289 9.9284869,4.2690082 12,1.9953613 14.071513,4.2690081 17.002319,3.3357286 17.659479,6.3405211 20.664271,6.9976805 19.730992,9.9284869 22.004639,12 l -2.273647,2.071513 0.933279,2.930806 -3.004792,0.65716 L 17.00232,20.664271 14.071513,19.730992 12,22.004639 9.9284871,19.730992 6.9976809,20.664271 6.3405212,17.659479 3.3357289,17.00232 4.2690082,14.071513 1.9953613,12 4.2690081,9.9284871 Z"
            />
          </svg>
          {/* <img
          class="h-8 w-auto"
          src="https://tailwindui.com/plus/img/logos/mark.svg?color=white"
          alt="Your Company"
        /> */}
        </Link>
        <div class="flex flex-1 flex-col overflow-y-auto">
          <aside class="flex-1 space-y-1 px-2 py-4">
            <SidebarItem
              to="/admin"
              text="Dashboard"
              icon={
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="size-6"
                >
                  <rect width="7" height="9" x="3" y="3" rx="1" />
                  <rect width="7" height="5" x="14" y="3" rx="1" />
                  <rect width="7" height="9" x="14" y="12" rx="1" />
                  <rect width="7" height="5" x="3" y="16" rx="1" />
                </svg>
              }
            />
            <SidebarItem
              to="/admin/users"
              text="Users"
              icon={
                <svg viewBox="0 0 24 24" class="size-6">
                  <path
                    fill="currentColor"
                    d="M16 17V19H2V17S2 13 9 13 16 17 16 17M12.5 7.5A3.5 3.5 0 1 0 9 11A3.5 3.5 0 0 0 12.5 7.5M15.94 13A5.32 5.32 0 0 1 18 17V19H22V17S22 13.37 15.94 13M15 4A3.39 3.39 0 0 0 13.07 4.59A5 5 0 0 1 13.07 10.41A3.39 3.39 0 0 0 15 11A3.5 3.5 0 0 0 15 4Z"
                  />
                </svg>
              }
            />
            <SidebarItem
              to="/admin/settings"
              text="Settings"
              icon={
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="size-6"
                >
                  <path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
                  <circle cx="12" cy="12" r="3" />
                </svg>
              }
            />
          </aside>
        </div>
        <div class="grid gap-4 p-4">
          <form
            class="grid"
            onSubmit={async (e) => {
              e.preventDefault();

              if (confirm("Are you sure you want to sign out?")) {
                mutation.mutate();
              }
            }}
          >
            <Button text="Sign out" variant="secondary" />
          </form>
          <Link to="/account" class="group block w-full">
            <div class="flex items-center">
              <svg viewBox="0 0 24 24" class="size-9 text-white">
                <Show
                  when={user().roles.includes("ROLE_STAFF")}
                  fallback={
                    <path
                      fill="currentColor"
                      d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"
                    />
                  }
                >
                  <path
                    fill="currentColor"
                    d="M17,3H14V6H10V3H7A2,2 0 0,0 5,5V21A2,2 0 0,0 7,23H17A2,2 0 0,0 19,21V5A2,2 0 0,0 17,3M12,8A2,2 0 0,1 14,10A2,2 0 0,1 12,12A2,2 0 0,1 10,10A2,2 0 0,1 12,8M16,16H8V15C8,13.67 10.67,13 12,13C13.33,13 16,13.67 16,15V16M13,5H11V1H13V5M16,19H8V18H16V19M12,21H8V20H12V21Z"
                  />
                </Show>
              </svg>
              <div class="ml-3">
                <p class="text-sm font-medium text-white">
                  {user().firstName} {user().lastName}
                </p>
                <div class="flex gap-1 text-xs font-medium text-gray-400 group-hover:text-white">
                  {user().roles.toString()}
                </div>
              </div>
            </div>
          </Link>
        </div>
      </div>
      <div class="mb-16 p-4 lg:mx-64 lg:mb-0">
        <Outlet />
      </div>
      <nav class="fixed bottom-0 flex h-[calc(4rem+env(safe-area-inset-bottom))] w-full bg-black lg:hidden">
        <NavbarItem
          text="Dashboard"
          to="/admin"
          icon={
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="size-6"
            >
              <rect width="7" height="9" x="3" y="3" rx="1" />
              <rect width="7" height="5" x="14" y="3" rx="1" />
              <rect width="7" height="9" x="14" y="12" rx="1" />
              <rect width="7" height="5" x="3" y="16" rx="1" />
            </svg>
          }
        />
        <NavbarItem
          text="Users"
          to="/admin/users"
          icon={
            <svg viewBox="0 0 24 24" class="size-6">
              <path
                fill="currentColor"
                d="M16 17V19H2V17S2 13 9 13 16 17 16 17M12.5 7.5A3.5 3.5 0 1 0 9 11A3.5 3.5 0 0 0 12.5 7.5M15.94 13A5.32 5.32 0 0 1 18 17V19H22V17S22 13.37 15.94 13M15 4A3.39 3.39 0 0 0 13.07 4.59A5 5 0 0 1 13.07 10.41A3.39 3.39 0 0 0 15 11A3.5 3.5 0 0 0 15 4Z"
              />
            </svg>
          }
        />
        <NavbarItem
          text="Settings"
          to="/admin/settings"
          icon={
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="size-6"
            >
              <path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
              <circle cx="12" cy="12" r="3" />
            </svg>
          }
        />
        <NavbarItem
          text="More"
          to="."
          search={{ dialog: "more" }}
          activeOptions={{ exact: false }}
          icon={
            <svg viewBox="0 0 24 24" class="size-6">
              <path
                fill="currentColor"
                d="M16,12A2,2 0 0,1 18,10A2,2 0 0,1 20,12A2,2 0 0,1 18,14A2,2 0 0,1 16,12M10,12A2,2 0 0,1 12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12M4,12A2,2 0 0,1 6,10A2,2 0 0,1 8,12A2,2 0 0,1 6,14A2,2 0 0,1 4,12Z"
              />
            </svg>
          }
        />
      </nav>
      <Show when={search().dialog === "more"}>
        <Dialog title="More">
          <div class="grid gap-3">
            <Link to="/account" class="group block w-full">
              <div class="flex items-center">
                <svg viewBox="0 0 24 24" class="size-9">
                  <Show
                    when={user().roles.includes("ROLE_STAFF")}
                    fallback={
                      <path
                        fill="currentColor"
                        d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"
                      />
                    }
                  >
                    <path
                      fill="currentColor"
                      d="M17,3H14V6H10V3H7A2,2 0 0,0 5,5V21A2,2 0 0,0 7,23H17A2,2 0 0,0 19,21V5A2,2 0 0,0 17,3M12,8A2,2 0 0,1 14,10A2,2 0 0,1 12,12A2,2 0 0,1 10,10A2,2 0 0,1 12,8M16,16H8V15C8,13.67 10.67,13 12,13C13.33,13 16,13.67 16,15V16M13,5H11V1H13V5M16,19H8V18H16V19M12,21H8V20H12V21Z"
                    />
                  </Show>
                </svg>
                <div class="ml-3">
                  <p class="text-sm font-medium">
                    {user().firstName} {user().lastName}
                  </p>
                  <p class="text-xs font-medium text-gray-500">
                    {user().roles.toString()}
                  </p>
                </div>
              </div>
            </Link>
            <form
              class="flex justify-end"
              onSubmit={async (e) => {
                e.preventDefault();

                if (confirm("Are you sure you want to sign out?")) {
                  signout();
                }
              }}
            >
              <Button type="submit" text="Sign Out" />
            </form>
          </div>
        </Dialog>
      </Show>
    </section>
  );
}

function NavbarItem(props: ISidebarItemProps) {
  return (
    <Link
      class="group flex basis-1/3 flex-col items-center justify-center gap-1 px-2 text-xs text-white"
      to={props.to}
      search={props.search}
      activeOptions={props.activeOptions || { exact: true }}
    >
      <div class="flex w-12 justify-center rounded-full py-0.5 group-[.active]:bg-white group-[.active]:text-black">
        {props.icon}
      </div>
      {props.text}
    </Link>
  );
}

interface ISidebarItemProps {
  text: JSX.Element;
  icon: JSX.Element;
  label?: JSX.Element;
  to: LinkProps["to"];
  search?: LinkProps["search"];
  activeOptions?: LinkProps["activeOptions"];
}

function SidebarItem(props: ISidebarItemProps) {
  return (
    <Link
      to={props.to}
      search={props.search}
      activeOptions={props.activeOptions || { exact: true }}
      class="flex items-center gap-3 rounded-md px-2 py-2 text-sm font-medium text-white hover:bg-neutral-950 data-[status=active]:bg-white data-[status=active]:text-black data-[status=active]:hover:bg-white/90"
    >
      {props.icon}
      {/* <svg
        class="mr-3 h-6 w-6 text-white group-hover:text-white"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"
        />
      </svg> */}
      <span class="flex-1">{props.text}</span>
      {/* <Show when={icon}>
        <span class="ml-3 inline-block rounded-full bg-white px-3 py-0.5 text-xs font-medium text-black">
          {label}
        </span>
      </Show> */}
    </Link>
  );
}
