import { createFileRoute, useNavigate } from "@tanstack/solid-router";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { createEffect, createMemo, createSignal, For, Show } from "solid-js";
import { Button, Dialog, Input } from "~components";
import { toCurrencyString } from "~utils/index";
import { getMembershipTypeFn } from "~utils/membershipTypes.functions";
import * as MembershipTypeRepository from "~repositories/MembershipTypeRepository";
import { useMutation } from "@tanstack/solid-query";
import * as SaleRepository from "~repositories/SaleRepository";

export const Route = createFileRoute("/(public)/memberships/$typeId")({
  validateSearch: (search: {
    dialog?: "secondary" | "secondary";
    type?: "free" | "paid";
    email?: string;
  }) => search,
  component: RouteComponent,
  loader: ({ params: { typeId } }) =>
    getMembershipTypeFn({ data: { id: typeId } }),
});

function RouteComponent() {
  const search = Route.useSearch();

  const params = Route.useParams();

  const navigate = useNavigate();

  const context = Route.useRouteContext();

  const settings = createMemo(() => context().settings);
  const user = createMemo(() => context().user);

  const membershipType = Route.useLoaderData();

  const processOnlineMembershipSale = useServerFn(
    processOnlineMembershipSaleFn,
  );

  const mutation = useMutation(() => ({
    mutationFn: (data: IOnlineMembershipSaleData) =>
      processOnlineMembershipSale({ data }),
    onError: (e) => {
      console.log(e.message);
    },
    onSuccess: () => {
      alert("success");
    },
  }));

  const [items, setItems] = createSignal<
    Pick<SaleItem, "name" | "description" | "price" | "quantity" | "type">[]
  >([]);

  const helpers = createMemo(() => {
    return {
      canAddFreeSecondaries:
        items().filter((item) => item.type === "MEMBERSHIP (FREE SECONDARY)")
          .length < membershipType()?.maxFreeSecondaries!,
      canAddPaidSecondaries:
        items().filter((item) => item.type === "MEMBERSHIP (PAID SECONDARY)")
          .length < membershipType()?.maxPaidSecondaries!,
    };
  });

  createEffect(
    () => membershipType(),
    (value, prev) => {
      setItems((current) => [
        ...current,
        {
          name: value?.name as string,
          description: "",
          price: value?.price as number,
          type: "MEMBERSHIP (PRIMARY)",
          quantity: 1,
        },
      ]);
    },
  );

  createEffect(
    () => settings(),
    (value, prev) => {
      setItems((current) => [
        ...current,
        {
          name: "Convenience Fee",
          description: "",
          price: value.convenienceFee,
          type: "CONVENIENCE FEE",
          quantity: 1,
        },
      ]);
    },
  );

  const totals = createMemo(() => {
    const subtotal = items().reduce(
      (total, item) => item.price * item.quantity + total,
      0,
    );

    const tax = (settings().taxRate / 100) * subtotal;

    return {
      subtotal,
      tax,
      total: subtotal + tax,
    };
  });

  return (
    <section class="bg-white py-24">
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

        <Show
          when={membershipType() != undefined}
          fallback={<span class="m-6 text-sm">Loading...</span>}
        >
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
                <Show
                  when={(membershipType()?.maxFreeSecondaries as number) > 0}
                >
                  <li class="text-gray-400">
                    <span class="text-gray-600">
                      {(membershipType()?.maxFreeSecondaries as number) + 1}{" "}
                      FREE tickets for most events
                    </span>
                  </li>
                </Show>
                <Show
                  when={(membershipType()?.maxPaidSecondaries as number) > 0}
                >
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
              class="grid content-start gap-3 lg:col-span-1"
              onSubmit={(e) => {
                e.preventDefault();

                mutation.mutate({
                  typeId: Number(params().typeId),
                  freeSecondariesIds: [],
                  paidSecondariesIds: [],
                });
              }}
            >
              <div class="my-6 grid gap-3 lg:grid-cols-2">
                <Show
                  when={(membershipType()?.maxFreeSecondaries as number) > 0}
                >
                  <Button
                    text="Add Free Secondary"
                    variant="secondary"
                    type="button"
                    disabled={!helpers().canAddFreeSecondaries}
                    onClick={() => {
                      navigate({
                        to: ".",
                        search: { dialog: "secondary", type: "free" },
                      });
                    }}
                  />
                </Show>
                <Show
                  when={(membershipType()?.maxPaidSecondaries as number) > 0}
                >
                  <Button
                    text="Add Paid Secondary"
                    variant="secondary"
                    type="button"
                    onClick={() => {
                      navigate({
                        to: ".",
                        search: { dialog: "secondary", type: "paid" },
                      });
                    }}
                    disabled={
                      helpers().canAddFreeSecondaries &&
                      helpers().canAddPaidSecondaries
                    }
                  />
                </Show>
              </div>
              <For each={items()}>
                {(item, i) => (
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
                  <span class="grow">Subtotal</span>
                  <span>{toCurrencyString(totals().subtotal)}</span>
                </p>
              </div>
              <div class="text-sm text-gray-600">
                <p class="flex gap-1">
                  <span class="grow">
                    Tax (
                    {(settings().taxRate / 100).toLocaleString("en-US", {
                      style: "percent",
                      minimumSignificantDigits: 1,
                    })}
                    )
                  </span>
                  <span>{toCurrencyString(totals().tax)}</span>
                </p>
              </div>
              <div>
                <p class="flex gap-1">
                  <span class="grow">Total</span>
                  <span>{toCurrencyString(totals().total)}</span>
                </p>
              </div>
              <p class="mt-10 text-sm text-gray-600">
                You will be redirected to Stripe to pay for your membership and
                redirected back with and given the benefits once we receive the
                payment.
              </p>
              <button
                type="submit"
                class="mt-10 flex w-full cursor-pointer items-center justify-center rounded-md border border-transparent bg-black px-8 py-3 text-base font-medium text-white hover:bg-gray-700 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:outline-hidden"
              >
                Pay {toCurrencyString(totals().total)}
              </button>
            </form>
          </div>
          <Show when={search().dialog === "secondary"}>
            <Dialog
              title={`Add ${search().type} secondary`}
              subtitle={`Adds a ${search().type} secondary to the membership`}
            >
              <form
                class="grid gap-3"
                onSubmit={(e) => {
                  e.preventDefault();

                  const data = new FormData(e.currentTarget);

                  const email = String(data.get("email"));

                  if (
                    items().some((item) => item.description.includes(email))
                  ) {
                    alert(`${email} has already been added.`);
                    return;
                  }

                  if (search().type === "free") {
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

                  if (search().type === "paid") {
                    setItems((prev) => {
                      prev.splice(prev.length - 1, 0, {
                        name: `${data.get("firstName")} ${data.get("lastName")}`,
                        description: email,
                        price: membershipType()?.paidSecondaryPrice as number,
                        type: "MEMBERSHIP (PAID SECONDARY)",
                        quantity: 1,
                      });

                      return [...prev];
                    });
                  }

                  navigate({ to: "." });
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
        </Show>
      </div>
    </section>
  );
}

interface IOnlineMembershipSaleData {
  typeId: number;
  freeSecondariesIds: number[];
  paidSecondariesIds: number[];
}

const processOnlineMembershipSaleFn = createServerFn({ method: "POST" })
  .validator((data: IOnlineMembershipSaleData) => data)
  .handler(async ({ data }) => {
    const membershipType = await MembershipTypeRepository.get({
      id: data.typeId,
    });

    if (membershipType == undefined)
      throw new Error("Invalid membership type.");

    if (
      (membershipType.maxFreeSecondaries as number) >
      data.freeSecondariesIds.length
    )
      throw new Error(
        "Selected number of free secondaries is greater than what the membership type allows.",
      );

    console.log(membershipType);

    await SaleRepository.save({
      status: "OPEN",
      source: "PORTAL",
      items: [
        {
          type: "MEMBERSHIP (PRIMARY)",
          name: membershipType.name as string,
          description: "primary",
          price: membershipType.price as number,
          quantity: 1,
        },
      ],
    });
  });
