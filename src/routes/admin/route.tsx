import {
  createFileRoute,
  Link,
  LinkProps,
  Outlet,
} from "@tanstack/solid-router";
import { JSX } from "@solidjs/web";
import { Button } from "~components";

export const Route = createFileRoute("/admin")({
  component: RouteComponent,
});

function RouteComponent() {
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
          <nav class="flex-1 space-y-1 px-2 py-4">
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
          </nav>
        </div>
        <div class="grid gap-4 p-4">
          <Button to="/sign-in" text="Logout" variant="secondary" />
          <a href="#" class="group block w-full">
            <div class="flex items-center">
              <div>
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
                  class="size-9 text-white"
                >
                  <path d="M17.925 20.056a6 6 0 0 0-11.851.001" />
                  <circle cx="12" cy="11" r="4" />
                  <circle cx="12" cy="12" r="10" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-white">Anderson Fernandes</p>
                <p class="text-xs font-medium text-gray-400 group-hover:text-white">
                  Planetarium Assistant
                </p>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="mb-16 p-4 lg:mx-64 lg:mb-0">
        <Outlet />
      </div>
      <div class="fixed bottom-0 flex h-16 w-full bg-black lg:hidden">
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
        <form class="flex basis-1/3 items-center justify-center">
          <button class="flex flex-col items-center justify-center gap-1 px-2 text-xs text-white">
            <svg viewBox="0 0 24 24" class="size-6">
              <path
                fill="currentColor"
                d="M14.08,15.59L16.67,13H7V11H16.67L14.08,8.41L15.5,7L20.5,12L15.5,17L14.08,15.59M19,3A2,2 0 0,1 21,5V9.67L19,7.67V5H5V19H19V16.33L21,14.33V19A2,2 0 0,1 19,21H5C3.89,21 3,20.1 3,19V5C3,3.89 3.89,3 5,3H19Z"
              />
            </svg>
            Logout
          </button>
        </form>
      </div>
    </section>
  );
}

function NavbarItem(props: ISidebarItemProps) {
  const { text, icon, to } = props;
  return (
    <Link
      class="group flex basis-1/3 flex-col items-center justify-center gap-1 px-2 text-xs text-white"
      to={to}
      activeOptions={{ exact: true }}
    >
      <div class="flex w-12 justify-center rounded-full py-0.5 group-[.active]:bg-white group-[.active]:text-black">
        {icon}
      </div>
      {text}
    </Link>
  );
}

interface ISidebarItemProps {
  text: JSX.Element;
  icon: JSX.Element;
  label?: JSX.Element;
  to: LinkProps["to"];
}

function SidebarItem(props: ISidebarItemProps) {
  const { text, icon, label, to } = props;
  return (
    <Link
      to={to}
      activeOptions={{ exact: true }}
      class="flex items-center gap-3 rounded-md px-2 py-2 text-sm font-medium text-white hover:bg-gray-900 data-[status=active]:bg-white data-[status=active]:text-black data-[status=active]:hover:bg-white/90"
    >
      {icon}
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
      <span class="flex-1">{text}</span>
      {/* <Show when={icon}>
        <span class="ml-3 inline-block rounded-full bg-white px-3 py-0.5 text-xs font-medium text-black">
          {label}
        </span>
      </Show> */}
    </Link>
  );
}
