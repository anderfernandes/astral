import { createQuery } from "@tanstack/solid-query";
import { createFileRoute, Link } from "@tanstack/solid-router";
import { useServerFn } from "@tanstack/solid-start";
import { For, Loading, Show } from "solid-js";
import { getMembershipTypesFn } from "~utils/membershipTypes.functions";

export const Route = createFileRoute("/(public)/memberships/")({
  component: RouteComponent,
  loader: async () => getMembershipTypesFn(),
});

function RouteComponent() {
  const membershipTypes = Route.useLoaderData();

  return (
    <section class="bg-white py-24">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
          <h2 class="text-base font-semibold text-black">Pricing</h2>
          <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900">
            Simple pricing for all family sizes
          </p>
          <p class="mt-6 text-lg text-gray-600">
            Choose the plan that fits your needs...
          </p>
        </div>
        <div class="mx-auto mt-16 max-w-6xl overflow-hidden rounded-3xl">
          <div class="grid lg:flex lg:justify-center">
            <For
              each={membershipTypes()
                ?.filter((item) => item.isActive && item.isPublic)
                .sort((a, b) => a.price - b.price)}
            >
              {(item) => (
                <div class="w-full border-b border-gray-300 p-8 lg:w-1/3 lg:border-b-0 lg:p-10 not-first:lg:border-l">
                  <h3 class="text-sm font-semibold text-gray-900">
                    {item.name}
                  </h3>

                  <div class="mt-4 flex items-baseline gap-x-2">
                    <span class="text-5xl font-bold tracking-tight">
                      {(item.price / 100).toLocaleString("en-US", {
                        style: "currency",
                        currency: "USD",
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 2,
                      })}
                    </span>
                    <span class="text-sm text-gray-500">/year</span>
                  </div>

                  <p class="mt-4 text-sm text-gray-600">{item.description}</p>

                  <Link
                    to="/memberships/$typeId"
                    params={{ typeId: String(item.id) }}
                    class="black black mt-8 block rounded-md border px-4 py-2 text-center text-sm font-semibold hover:bg-gray-50"
                  >
                    Sign up
                  </Link>

                  <ul class="mt-8 space-y-3 text-sm text-gray-600">
                    <li class="flex gap-1">
                      <svg
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        data-slot="icon"
                        aria-hidden="true"
                        class="size-5 text-black"
                      >
                        <path
                          d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                          clip-rule="evenodd"
                          fill-rule="evenodd"
                        />
                      </svg>{" "}
                      Special benefits for {item.duration} days
                    </li>
                    <Show when={item.maxFreeSecondaries === 0}>
                      <li class="flex gap-1">
                        <svg
                          viewBox="0 0 20 20"
                          fill="currentColor"
                          data-slot="icon"
                          aria-hidden="true"
                          class="size-5 text-black"
                        >
                          <path
                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                            clip-rule="evenodd"
                            fill-rule="evenodd"
                          />
                        </svg>{" "}
                        1 FREE ticket per event for most events
                      </li>
                    </Show>

                    <li class="flex gap-1">
                      <svg
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        data-slot="icon"
                        aria-hidden="true"
                        class="size-5 text-black"
                      >
                        <path
                          d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                          clip-rule="evenodd"
                          fill-rule="evenodd"
                        />
                      </svg>{" "}
                      Discounts on most special events
                    </li>
                    <Show when={item.maxFreeSecondaries > 0}>
                      <li class="flex gap-1">
                        <svg
                          viewBox="0 0 20 20"
                          fill="currentColor"
                          data-slot="icon"
                          aria-hidden="true"
                          class="size-5 text-black"
                        >
                          <path
                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                            clip-rule="evenodd"
                            fill-rule="evenodd"
                          />
                        </svg>{" "}
                        {item.maxFreeSecondaries + 1} FREE tickets for most
                        events
                      </li>
                    </Show>
                    <Show when={item.maxPaidSecondaries > 0}>
                      <li class="flex gap-1">
                        <svg
                          viewBox="0 0 20 20"
                          fill="currentColor"
                          data-slot="icon"
                          aria-hidden="true"
                          class="size-5 text-black"
                        >
                          <path
                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                            clip-rule="evenodd"
                            fill-rule="evenodd"
                          />
                        </svg>{" "}
                        up to {item.maxPaidSecondaries} paid secondaries @{" "}
                        {(item.paidSecondaryPrice / 100).toLocaleString(
                          "en-US",
                          {
                            style: "currency",
                            currency: "USD",
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 2,
                          },
                        )}
                        /year each
                      </li>
                    </Show>
                  </ul>
                </div>
              )}
            </For>

            {/* <div class="border-t border-gray-200 lg:border-t-0 lg:border-l">
              <div class="p-8 lg:p-10">
                <h3 class="text-sm font-semibold text-gray-900">Pro</h3>

                <div class="mt-4 flex items-baseline gap-x-2">
                  <span class="text-5xl font-bold tracking-tight">$29</span>
                  <span class="text-sm text-gray-500">/month</span>
                </div>

                <p class="mt-4 text-sm text-gray-600">
                  Everything you need for growing teams.
                </p>

                <a
                  href="#"
                  class="mt-8 block rounded-md bg-indigo-600 px-4 py-2 text-center text-sm font-semibold text-white hover:bg-indigo-500"
                >
                  Start free trial
                </a>

                <ul class="mt-8 space-y-3 text-sm text-gray-600">
                  <li>Unlimited projects</li>
                  <li>Advanced analytics</li>
                  <li>Priority support</li>
                  <li>Team collaboration</li>
                </ul>
              </div>
            </div>

            <div class="border-t border-gray-200 lg:border-t-0 lg:border-l">
              <div class="p-8 lg:p-10">
                <h3 class="text-sm font-semibold text-gray-900">Enterprise</h3>

                <div class="mt-4 flex items-baseline gap-x-2">
                  <span class="text-5xl font-bold tracking-tight">$99</span>
                  <span class="text-sm text-gray-500">/month</span>
                </div>

                <p class="mt-4 text-sm text-gray-600">
                  Advanced security and dedicated support.
                </p>

                <a
                  href="#"
                  class="mt-8 block rounded-md border border-indigo-600 px-4 py-2 text-center text-sm font-semibold text-indigo-600 hover:bg-indigo-50"
                >
                  Contact sales
                </a>

                <ul class="mt-8 space-y-3 text-sm text-gray-600">
                  <li>Custom integrations</li>
                  <li>SSO & security</li>
                  <li>Dedicated manager</li>
                  <li>SLA guarantees</li>
                </ul>
              </div>
            </div> */}
          </div>
        </div>
      </div>
    </section>
  );
}
