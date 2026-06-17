import { createFileRoute, Link, Outlet } from "@tanstack/solid-router";
import { Button } from "~components";
import { getSettingsFn } from "~utils/settings.functions";

export const Route = createFileRoute("/(public)")({
  component: RouteComponent,
  loader: () => getSettingsFn(),
});

function RouteComponent() {
  const loaderData = Route.useLoaderData();
  return (
    <>
      <div class="bg-white">
        <header class="absolute inset-x-0 top-0 z-50">
          <nav
            aria-label="Global"
            class="flex items-center justify-between p-6 lg:px-8"
          >
            <div class="flex lg:flex-1">
              <a href="#" class="-m-1.5 p-1.5">
                <span class="sr-only">{loaderData().name}</span>
                <svg
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                  stroke="currentColor"
                  stroke-width="1.75"
                  class="h-8 w-auto"
                >
                  <circle cx="12" cy="12" r="5" fill="black" />
                  <path
                    stroke="currentColor"
                    fill="transparent"
                    d="M 3.3357286,6.9976809 6.3405211,6.3405212 6.9976805,3.3357289 9.9284869,4.2690082 12,1.9953613 14.071513,4.2690081 17.002319,3.3357286 17.659479,6.3405211 20.664271,6.9976805 19.730992,9.9284869 22.004639,12 l -2.273647,2.071513 0.933279,2.930806 -3.004792,0.65716 L 17.00232,20.664271 14.071513,19.730992 12,22.004639 9.9284871,19.730992 6.9976809,20.664271 6.3405212,17.659479 3.3357289,17.00232 4.2690082,14.071513 1.9953613,12 4.2690081,9.9284871 Z"
                  />
                </svg>
                {/* <img
                  src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600"
                  alt=""
                  class="h-8 w-auto"
                /> */}
              </a>
            </div>
            <div class="flex lg:hidden">
              <button
                type="button"
                command="show-modal"
                commandfor="mobile-menu"
                class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700"
              >
                <span class="sr-only">Open main menu</span>
                <svg
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.5"
                  data-slot="icon"
                  aria-hidden="true"
                  class="size-6"
                >
                  <path
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
              <Link to="/" class="text-sm/6 font-semibold text-gray-900">
                Home
              </Link>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
              <Button to="/sign-in" text="Sign In &rarr;" />
            </div>
          </nav>
          <div>
            <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
              <div tabindex="0" class="fixed inset-0 focus:outline-none">
                <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                  <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                      <span class="sr-only">{loaderData().name}</span>
                      <svg
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                        stroke="currentColor"
                        stroke-width="1.75"
                        class="h-8 w-auto"
                      >
                        <circle cx="12" cy="12" r="5" fill="black" />
                        <path
                          stroke="currentColor"
                          fill="transparent"
                          d="M 3.3357286,6.9976809 6.3405211,6.3405212 6.9976805,3.3357289 9.9284869,4.2690082 12,1.9953613 14.071513,4.2690081 17.002319,3.3357286 17.659479,6.3405211 20.664271,6.9976805 19.730992,9.9284869 22.004639,12 l -2.273647,2.071513 0.933279,2.930806 -3.004792,0.65716 L 17.00232,20.664271 14.071513,19.730992 12,22.004639 9.9284871,19.730992 6.9976809,20.664271 6.3405212,17.659479 3.3357289,17.00232 4.2690082,14.071513 1.9953613,12 4.2690081,9.9284871 Z"
                        />
                      </svg>
                    </a>
                    <button
                      type="button"
                      command="close"
                      commandfor="mobile-menu"
                      class="-m-2.5 rounded-md p-2.5 text-gray-700"
                    >
                      <span class="sr-only">Close menu</span>
                      <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        data-slot="icon"
                        aria-hidden="true"
                        class="size-6"
                      >
                        <path
                          d="M6 18 18 6M6 6l12 12"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                      </svg>
                    </button>
                  </div>
                  <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                      <div class="space-y-2 py-6">
                        <Link
                          to="/"
                          class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50"
                        >
                          Home
                        </Link>
                      </div>
                      <div class="py-6">
                        <Button to="/sign-in" text="Sign In &rarr;" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </dialog>
          </div>
        </header>
        <Outlet />
      </div>
      <footer class="bg-white">
        <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
          <div class="xl:grid xl:grid-cols-3 xl:gap-8">
            <div class="space-y-4">
              <div class="flex items-center gap-2">
                <svg
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                  stroke="currentColor"
                  stroke-width="1.75"
                  class="h-8 w-auto"
                >
                  <circle cx="12" cy="12" r="5" fill="black" />
                  <path
                    stroke="currentColor"
                    fill="transparent"
                    d="M 3.3357286,6.9976809 6.3405211,6.3405212 6.9976805,3.3357289 9.9284869,4.2690082 12,1.9953613 14.071513,4.2690081 17.002319,3.3357286 17.659479,6.3405211 20.664271,6.9976805 19.730992,9.9284869 22.004639,12 l -2.273647,2.071513 0.933279,2.930806 -3.004792,0.65716 L 17.00232,20.664271 14.071513,19.730992 12,22.004639 9.9284871,19.730992 6.9976809,20.664271 6.3405212,17.659479 3.3357289,17.00232 4.2690082,14.071513 1.9953613,12 4.2690081,9.9284871 Z"
                  />
                </svg>
                <span class="text-lg font-semibold text-gray-900">
                  {loaderData().name}
                </span>
              </div>

              <p class="max-w-md text-sm text-gray-600">
                We connecting our community to the wonders of science, space,
                and discovery through experiences that educate, entertain, and
                inspire.
              </p>
            </div>

            <div class="mt-12 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
              <div class="md:grid md:grid-cols-2 md:gap-8">
                <div>
                  <h3 class="text-sm font-semibold text-gray-900">
                    For the General Public
                  </h3>
                  <ul class="mt-4 space-y-3">
                    <li>
                      <Link
                        to="/"
                        class="text-sm text-gray-600 hover:text-gray-900"
                      >
                        Upcoming Events
                      </Link>
                    </li>
                    <li>
                      <Link
                        to="/"
                        class="text-sm text-gray-600 hover:text-gray-900"
                      >
                        Memberships
                      </Link>
                    </li>
                  </ul>
                </div>

                <div class="mt-10 md:mt-0">
                  <h3 class="text-sm font-semibold text-gray-900">
                    For Groups
                  </h3>
                  <ul class="mt-4 space-y-3">
                    <li>
                      <a
                        href="#"
                        class="text-sm text-gray-600 hover:text-gray-900"
                      >
                        School Groups
                      </a>
                    </li>
                    <li>
                      <a
                        href="#"
                        class="text-sm text-gray-600 hover:text-gray-900"
                      >
                        Civic Groups
                      </a>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="md:grid md:grid-cols-2 md:gap-8">
                <div>
                  <h3 class="text-sm font-semibold text-gray-900">Other</h3>
                  <ul class="mt-4 space-y-3">
                    <li>
                      <a
                        href="#"
                        class="text-sm text-gray-600 hover:text-gray-900"
                      >
                        Events Calendar
                      </a>
                    </li>
                  </ul>
                </div>

                <div class="mt-10 md:mt-0">
                  <h3 class="text-sm font-semibold text-gray-900">About</h3>
                  <ul class="mt-4 space-y-3">
                    <li>
                      <a
                        href="#"
                        class="text-sm text-gray-600 hover:text-gray-900"
                      >
                        Privacy
                      </a>
                    </li>
                    <li>
                      <a
                        href="#"
                        class="text-sm text-gray-600 hover:text-gray-900"
                      >
                        Terms
                      </a>
                    </li>
                    <li>
                      <a
                        href="#"
                        class="text-sm text-gray-600 hover:text-gray-900"
                      >
                        Cookies
                      </a>
                    </li>
                    <li>
                      <a
                        href="#"
                        class="text-sm text-gray-600 hover:text-gray-900"
                      >
                        Licenses
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-16 border-t border-gray-200 pt-8">
            <p class="text-sm text-gray-500">
              &copy; {new Date().getFullYear()} {loaderData().name}. All rights
              reserved.
            </p>
          </div>
        </div>
      </footer>
    </>
  );
}
