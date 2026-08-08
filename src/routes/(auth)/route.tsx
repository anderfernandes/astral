import {
  createFileRoute,
  Link,
  Outlet,
  redirect,
} from "@tanstack/solid-router";
import { Badge } from "~components";
import { getSignedInUserFn } from "~utils/account.functions";
import { getSettingsFn } from "~utils/settings.functions";

export const Route = createFileRoute("/(auth)")({
  beforeLoad: async () => {
    const user = await getSignedInUserFn();

    if (user) {
      console.log("already logged in");
      throw redirect({ to: "/account" });
    }

    return { settings: await getSettingsFn() };
  },
  component: RouteComponent,
});

function RouteComponent() {
  const context = Route.useRouteContext();

  return (
    <section class="mx-auto grid h-svh max-w-[2160px] grid-cols-12">
      <div class="hidden bg-[url('/sky-5114501_1280.jpg')] bg-cover bg-center lg:col-span-8 lg:block">
        left
      </div>
      <div class="col-span-12 grid content-evenly overflow-y-auto p-4 lg:col-span-4">
        <div class="grid w-full max-w-sm justify-self-center">
          <svg
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            stroke="currentColor"
            stroke-width="1.75"
            class="mx-auto mb-4 size-16"
          >
            <circle cx="12" cy="12" r="5" fill="black" />
            <path
              stroke="currentColor"
              fill="transparent"
              d="M 3.3357286,6.9976809 6.3405211,6.3405212 6.9976805,3.3357289 9.9284869,4.2690082 12,1.9953613 14.071513,4.2690081 17.002319,3.3357286 17.659479,6.3405211 20.664271,6.9976805 19.730992,9.9284869 22.004639,12 l -2.273647,2.071513 0.933279,2.930806 -3.004792,0.65716 L 17.00232,20.664271 14.071513,19.730992 12,22.004639 9.9284871,19.730992 6.9976809,20.664271 6.3405212,17.659479 3.3357289,17.00232 4.2690082,14.071513 1.9953613,12 4.2690081,9.9284871 Z"
            />
          </svg>
          <Outlet />
          <hr class="my-8 border-gray-200" />
          <div class="flex items-center justify-center">
            <Badge text={context().settings.version} />
          </div>
          <a
            href="https://github.com/anderfernandes"
            target="_blank"
            class="mt-4 text-center text-sm/6 text-gray-500 hover:underline hover:underline-offset-2"
          >
            2017-{new Date().getFullYear()} Astral
          </a>
        </div>
      </div>
    </section>
  );
}
