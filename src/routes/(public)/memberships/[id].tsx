import { RouteProps } from "@solidjs/router";
import { createMemo, Loading, Show } from "solid-js";
import { getMembershipTypeFn } from "~lib/membership-types";
import { Router } from "../../../router";
import { getOrganizationSettingsFn } from "~lib";

export default function MembershipSignupPage(
  props: RouteProps<typeof Router.paths.memberships>,
) {
  const membershipType = createMemo(() => getMembershipTypeFn(props.params.id));

  const organization = createMemo(() => getOrganizationSettingsFn());

  return (
    <section class="mx-auto max-w-7xl bg-white py-24">
      <div class="pt-6">
        {/* <nav aria-label="Breadcrumb">
          <ol
            role="list"
            class="mx-auto flex max-w-2xl items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8"
          >
            <li>
              <div class="flex items-center">
                <a href="#" class="mr-2 text-sm font-medium text-gray-900">
                  Men
                </a>
                <svg
                  viewBox="0 0 16 20"
                  width="16"
                  height="20"
                  fill="currentColor"
                  aria-hidden="true"
                  class="h-5 w-4 text-gray-300"
                >
                  <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                </svg>
              </div>
            </li>
            <li>
              <div class="flex items-center">
                <a href="#" class="mr-2 text-sm font-medium text-gray-900">
                  Clothing
                </a>
                <svg
                  viewBox="0 0 16 20"
                  width="16"
                  height="20"
                  fill="currentColor"
                  aria-hidden="true"
                  class="h-5 w-4 text-gray-300"
                >
                  <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                </svg>
              </div>
            </li>

            <li class="text-sm">
              <a
                href="#"
                aria-current="page"
                class="font-medium text-gray-500 hover:text-gray-600"
              >
                Basic Tee 6-Pack
              </a>
            </li>
          </ol>
        </nav> */}

        {/* <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-8 lg:px-8">
          <img
            src="https://tailwindcss.com/plus-assets/img/ecommerce-images/product-page-02-secondary-product-shot.jpg"
            alt="Two each of gray, white, and black shirts laying flat."
            class="row-span-2 aspect-3/4 size-full rounded-lg object-cover max-lg:hidden"
          />
          <img
            src="https://tailwindcss.com/plus-assets/img/ecommerce-images/product-page-02-tertiary-product-shot-01.jpg"
            alt="Model wearing plain black basic tee."
            class="col-start-2 aspect-3/2 size-full rounded-lg object-cover max-lg:hidden"
          />
          <img
            src="https://tailwindcss.com/plus-assets/img/ecommerce-images/product-page-02-tertiary-product-shot-02.jpg"
            alt="Model wearing plain gray basic tee."
            class="col-start-2 row-start-2 aspect-3/2 size-full rounded-lg object-cover max-lg:hidden"
          />
          <img
            src="https://tailwindcss.com/plus-assets/img/ecommerce-images/product-page-02-featured-product-shot.jpg"
            alt="Model wearing plain white basic tee."
            class="row-span-2 aspect-4/5 size-full object-cover sm:rounded-lg lg:aspect-3/4"
          />
        </div> */}
      </div>
      <Loading fallback={<span class="m-6 text-sm">Loading...</span>}>
        <div class="m-6 grid gap-3 lg:grid-cols-3">
          <div class="grid content-start gap-3 lg:col-span-2 lg:border-r lg:border-gray-200">
            <h2 class="sr-only">Membership Type Information</h2>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
              {membershipType()?.name}
            </h1>
            {/* <h5 class="text-3xl tracking-tight text-gray-900">
                {toCurrencyString(membershipType()?.price as number, {
                  minimumFractionDigits: 0,
                })}
              </h5> */}
            <p class="text-base text-gray-900">
              {membershipType()?.description}
            </p>
            <h3 class="my-4 text-sm font-medium text-gray-900">Highlights</h3>
            <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
              <li class="text-gray-400">
                <span class="text-gray-600">
                  Special benefits for {membershipType()?.duration} days
                </span>
              </li>
              <Show when={membershipType()?.maxFreeSecondaries === 0}>
                <li class="text-gray-400">
                  <span class="text-gray-600">
                    1 FREE ticket per event for most event
                  </span>
                </li>
              </Show>
              <Show when={(membershipType()?.maxFreeSecondaries as number) > 0}>
                <li class="text-gray-400">
                  <span class="text-gray-600">
                    {(membershipType()?.maxFreeSecondaries as number) + 1} FREE
                    tickets for most events
                  </span>
                </li>
              </Show>
              <Show when={(membershipType()?.maxPaidSecondaries as number) > 0}>
                <li class="text-gray-400">
                  {/* <span class="text-gray-600">
                      up to {membershipType()?.maxPaidSecondaries} paid
                      secondaries @{" "}
                      {toCurrencyString(
                        membershipType()?.paidSecondaryPrice as number,
                        { minimumFractionDigits: 0 },
                      )}
                      /year each
                    </span> */}
                </li>
              </Show>
              <li class="text-gray-400">
                <span class="text-gray-600">
                  Discounts on most special events
                </span>
              </li>
            </ul>
          </div>
          <form class="grid content-start gap-3 lg:col-span-1">
            <div class="text-sm text-gray-600">
              <p class="flex gap-1">
                <span class="grow">
                  Tax (
                  {(organization().saleTaxRate / 100).toLocaleString("en-US", {
                    style: "percent",
                    minimumSignificantDigits: 1,
                  })}
                  )
                </span>
                {/* <span>{toCurrencyString(totals().tax)}</span> */}
              </p>
            </div>
          </form>
        </div>
      </Loading>
    </section>
  );
}
