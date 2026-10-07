import {
  action,
  RouteDefinition,
  RouteProps,
  useLocation,
  useNavigate,
} from "@solidjs/router";
import {
  createEffect,
  createMemo,
  createSignal,
  createStore,
  For,
  Loading,
  Show,
} from "solid-js";
import { getMembershipTypeFn } from "~lib/membership-types";
import { paths, Router } from "../../../router";
import {
  calculateSaleTotals,
  getOrganizationSettingsFn,
  getSaleTotalsFn,
  getUserFn,
  toCurrencyString,
} from "~lib";
import { Button, Checkbox, Dialog, Input } from "~components";
import * as v from "valibot";
import { respond } from "@solidjs/web";
import db from "~db";
import { EmailSchema, FirstNameSchema, LastNameSchema } from "~lib/schemas";

export const route = {
  preload: ({ params }) => {
    void getMembershipTypeFn(params.id as string);
    void getOrganizationSettingsFn();
  },
} satisfies RouteDefinition;

export default function MembershipSignupPage(
  props: RouteProps<typeof Router.paths.memberships>,
) {
  const navigate = useNavigate();

  const location = useLocation();

  const membershipType = createMemo(() => getMembershipTypeFn(props.params.id));

  const organization = createMemo(() => getOrganizationSettingsFn());

  const user = createMemo(() => getUserFn());

  const [isGift, setIsGift] = createSignal(false);

  const [primary, setPrimary] = createSignal({
    firstName: "",
    lastName: "",
    email: "",
  });

  const [items, setItems] = createStore<SaleItemInsertable[]>([]);

  const cart = createMemo(() => getSaleTotalsFn({ items }));

  const helper = createMemo(() => ({
    canAddFreeSecondaries:
      items.filter((item) => item.type === "MEMBERSHIP (FREE SECONDARY)")
        .length < (membershipType()?.maxFreeSecondaries as number),
    canAddPaidSecondaries:
      items.filter((item) => item.type === "MEMBERSHIP (PAID SECONDARY)")
        .length < (membershipType()?.maxPaidSecondaries as number),
  }));

  createEffect(
    () => user(),
    (value) => {
      setPrimary({
        firstName: value?.firstName as string,
        lastName: value?.lastName as string,
        email: value?.email as string,
      });
    },
  );

  createEffect(
    () => membershipType(),
    (value) => {
      setItems((currentItems) => {
        if (
          currentItems.some(
            (curremtItem) => curremtItem.type === "MEMBERSHIP (PRIMARY)",
          )
        )
          return currentItems;
        return [
          ...currentItems,
          {
            name: value?.name as string,
            description: "",
            price: value?.price as number,
            type: "MEMBERSHIP (PRIMARY)",
            quantity: 1,
          },
        ];
      });
    },
  );

  createEffect(
    () => primary(),
    (value) => {
      setItems((currentItems) =>
        currentItems.map((currentItem) => {
          if (currentItem.type === "MEMBERSHIP (PRIMARY)") {
            currentItem.name = `${value.firstName} ${value.lastName}`;
            currentItem.description = value.email;
          }
          return currentItem;
        }),
      );
    },
  );

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
            <h5 class="text-3xl tracking-tight text-gray-900">
              {toCurrencyString(membershipType()?.price as number, {
                minimumFractionDigits: 0,
              })}
            </h5>
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
                  <span class="text-gray-600">
                    up to {membershipType()?.maxPaidSecondaries} paid
                    secondaries @{" "}
                    {toCurrencyString(
                      membershipType()?.paidSecondaryPrice as number,
                      { minimumFractionDigits: 0 },
                    )}
                    /year each
                  </span>
                </li>
              </Show>
              <li class="text-gray-400">
                <span class="text-gray-600">
                  Discounts on most special events
                </span>
              </li>
            </ul>
          </div>
          <form
            action={checkout}
            method="post"
            class="grid content-start gap-3 lg:col-span-1"
          >
            <div class="grid">
              <Checkbox
                name="isGift"
                label="Buying for someone else as a gift."
                checked={isGift()}
                onChange={(e) => {
                  setIsGift(e.currentTarget.checked);

                  setPrimary({
                    firstName: e.currentTarget.checked
                      ? ""
                      : (user()?.firstName as string),
                    lastName: e.currentTarget.checked
                      ? ""
                      : (user()?.lastName as string),
                    email: e.currentTarget.checked
                      ? ""
                      : (user()?.email as string),
                  });
                }}
              />
              <div class="grid grid-cols-2 gap-2">
                <Input
                  value={primary().firstName}
                  disabled={!isGift()}
                  placeholder="First Name"
                  name="firstName"
                  required={isGift()}
                  onInput={(e) => {
                    setPrimary((currentPrimary) => ({
                      ...currentPrimary,
                      firstName: e.currentTarget.value,
                    }));
                  }}
                />
                <Input
                  value={primary().lastName}
                  disabled={!isGift()}
                  placeholder="Last Name"
                  name="lastName"
                  required={isGift()}
                  onInput={(e) => {
                    setPrimary((currentPrimary) => ({
                      ...currentPrimary,
                      lastName: e.currentTarget.value,
                    }));
                  }}
                />
              </div>
              <Input
                value={primary().email}
                disabled={!isGift()}
                placeholder="Email"
                onInput={(e) => {
                  setPrimary((currentPrimary) => ({
                    ...currentPrimary,
                    email: e.currentTarget.value,
                  }));
                }}
              />
            </div>
            <div class="grid gap-3 lg:grid-cols-2">
              <Show when={(membershipType()?.maxFreeSecondaries as number) > 0}>
                <Button
                  text="Add Free Secondary"
                  variant="secondary"
                  type="button"
                  disabled={!helper().canAddFreeSecondaries}
                  onClick={() => {
                    navigate(
                      paths.memberships(props.params.id, {
                        dialog: "secondary",
                        type: "free",
                      }),
                    );
                  }}
                />
              </Show>
              <Show when={(membershipType()?.maxPaidSecondaries as number) > 0}>
                <Button
                  text="Add Paid Secondary"
                  variant="secondary"
                  type="button"
                  onClick={() => {
                    navigate(
                      paths.memberships(props.params.id, {
                        dialog: "secondary",
                        type: "paid",
                      }),
                    );
                  }}
                  disabled={
                    helper().canAddFreeSecondaries &&
                    helper().canAddPaidSecondaries
                  }
                />
              </Show>
            </div>
            <For each={cart().items}>
              {(item) => (
                <div class="text-sm text-gray-600">
                  <p class="flex gap-1">
                    <span class="grow">{item.name}</span>
                    <span>{toCurrencyString(item.price)}</span>
                  </p>
                  <p>{item.description}</p>
                  <Show when={item.type != "CONVENIENCE FEE"}>
                    <p>{item.type}</p>
                  </Show>
                </div>
              )}
            </For>
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
                <span>{toCurrencyString(cart().tax)}</span>
              </p>
            </div>
            <div class="text-sm text-gray-600">
              <p class="flex gap-1">
                <span class="grow">Subtotal</span>
                <span>{toCurrencyString(cart().subtotal)}</span>
              </p>
            </div>
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
                <span>{toCurrencyString(cart().tax)}</span>
              </p>
            </div>
            <div>
              <p class="flex gap-1">
                <span class="grow">Total</span>
                <span>{toCurrencyString(cart().total)}</span>
              </p>
            </div>
            <p class="mt-10 text-sm text-gray-600">
              You will be redirected to Stripe to pay for your membership and
              redirected back. If the payment is successful, you will be able to
              enjoy the benefits of the membership right away.
            </p>
            <input
              type="hidden"
              name="membershipTypeId"
              value={membershipType()?.id}
            />
            <button
              type="submit"
              class="mt-10 flex w-full cursor-pointer items-center justify-center rounded-md border border-transparent bg-black px-8 py-3 text-base font-medium text-white hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:outline-hidden"
            >
              Pay {toCurrencyString(cart().total)}
            </button>
          </form>
        </div>
        <Show when={location.query.dialog === "secondary"}>
          <Dialog
            title={`Add ${location.query.type} secondary`}
            subtitle={`Adds a ${location.query.type} secondary to the membership`}
          >
            <form
              class="grid gap-3"
              onSubmit={(e) => {
                e.preventDefault();

                const data = new FormData(e.currentTarget);

                const email = String(data.get("email"));

                console.log(email);

                if (
                  cart().items.some((item) => item.description.includes(email))
                ) {
                  alert(`${email} has already been added.`);
                  return;
                }

                if (location.query.type === "free") {
                  setItems((prev) => {
                    prev.splice(1, 0, {
                      name: `${data.get("firstName")} ${data.get("lastName")}`,
                      description: email,
                      price: 0,
                      type: "MEMBERSHIP (FREE SECONDARY)",
                      quantity: 1,
                    });

                    return [...prev];
                  });
                }

                if (location.query.type === "paid") {
                  setItems((prev) => [
                    ...prev,
                    {
                      name: `${data.get("firstName")} ${data.get("lastName")}`,
                      description: email,
                      price: membershipType()?.paidSecondaryPrice as number,
                      type: "MEMBERSHIP (PAID SECONDARY)",
                      quantity: 1,
                    },
                  ]);
                }

                navigate(paths.memberships(props.params.id));
              }}
            >
              <Input
                defaultValue="Sarah"
                label="First Name"
                required
                placeholder="First Name"
                name="firstName"
              />
              <Input
                defaultValue="Fernandes"
                label="Last Name"
                required
                placeholder="Last Name"
                name="lastName"
              />
              <Input
                defaultValue="sarahfernandes@live.com"
                label="Email"
                required
                placeholder="Email"
                name="email"
              />
              <div class="flex justify-end">
                <Button text="Add" type="submit" />
              </div>
            </form>
          </Dialog>
        </Show>
      </Loading>
    </section>
  );
}

const checkout = action(async (form: FormData) => {
  "use server";

  let primary;

  if (form.has("isGift")) {
    const primaryValidator = v.safeParse(
      v.object({
        firstName: FirstNameSchema,
        lastName: LastNameSchema,
        email: EmailSchema,
      }),
      {
        firstName: String(form.get("firstName")),
        lastName: String(form.get("lastName")),
        email: String(form.get("email")),
      },
    );

    if (!primaryValidator.success) {
      throw respond(
        {
          message: "Fix the errors below.",
          issues: primaryValidator.issues.map(({ message }) => message),
        },
        { status: 400 },
      );
    }

    primary = await db.users.find((await getUserFn())?.userId as number);

    if (!primary) {
      await db.users.create({
        firstName: primaryValidator.output.firstName,
        lastName: primaryValidator.output.lastName,
        email: primaryValidator.output.lastName,
        password: crypto
          .getRandomValues(new Uint8Array(8))
          .toBase64({ alphabet: "base64url" }),
      });
    }
  }

  const membershipTypeValidator = v.safeParse(
    v.number(),
    Number(form.get("membershipTypeId")),
  );

  if (!membershipTypeValidator.success) {
    throw respond(
      {
        message: "Fix the errors below.",
        issues: membershipTypeValidator.issues.map(({ message }) => message),
      },
      { status: 400 },
    );
  }

  // CHECK IF A PRIMARY ALREADY EXISTS, IF NOT CURRENT USER IS PRIMARY

  const membershipType = await db.membershipTypes.find(
    membershipTypeValidator.output,
  );

  // CREATE SALE

  // REDIRECT TO ONLINE PAYMENT PROCESSOR

  console.log(membershipType);
});
