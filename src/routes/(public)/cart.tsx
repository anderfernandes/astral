import { createMutation } from "@tanstack/solid-query";
import { createFileRoute, redirect } from "@tanstack/solid-router";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { createMemo, For, Show } from "solid-js";
import { Alert, Badge, Button } from "~components";
import { getSignedInUserFn } from "~utils/account.functions";
import { getCurrentDateTimeString, toCurrencyString } from "~utils/index";
import { getStripeCheckoutSession } from "~utils/stripe.functions";
import * as SaleRepository from "~repositories/SaleRepository";

export const Route = createFileRoute("/(public)/cart")({
  component: RouteComponent,
});

function RouteComponent() {
  const context = Route.useRouteContext();

  const sale = createMemo(() => context().user?.sale);

  const checkout = useServerFn(checkoutFn);

  const mutation = createMutation(() => ({
    mutationFn: () => checkout(),
    onError: (e) => {
      console.log(e.message);
      alert("An error occurred.");
    },
  }));

  const removeItem = useServerFn(removeItemFn);

  const removeItemMutation = createMutation(() => ({
    mutationFn: (data: { saleId: number; saleItemId: number }) =>
      removeItem({ data }),
  }));

  return (
    <section class="mx-auto my-24 grid w-full gap-6 px-8 lg:w-2xl lg:px-0">
      <h1 class="mb-12 text-center text-4xl font-bold">Shopping Cart</h1>
      <For
        each={context().user?.sale?.items.filter(
          (item) => item.type != "CONVENIENCE FEE",
        )}
      >
        {(item) => (
          <div class="grid gap-3 border-y border-gray-200 py-3 text-sm">
            <div class="flex items-center">
              <p class="grow">{item.name}</p>
              <p>{toCurrencyString(item.price as number)}</p>
            </div>
            <div class="flex">
              <Badge text={item.type} />
            </div>
            <p class="text-gray-600">{item.description}</p>
            <form
              onSubmit={(e) => {
                e.preventDefault();

                if (
                  !confirm(
                    "Are you sure you want to remove this item from your cart?",
                  )
                )
                  return;

                removeItemMutation.mutate({
                  saleId: sale()?.id as number,
                  saleItemId: item.id as number,
                });
              }}
            >
              <Button
                variant="secondary"
                text={removeItemMutation.isPending ? "Removing..." : "Remove"}
                disabled={removeItemMutation.isPending}
              />
            </form>
          </div>
        )}
      </For>
      <Show
        when={context().user?.sale?.items.length! > 0}
        fallback={<Alert text="Nothing on your cart yet." />}
      >
        <div class="text-sm text-gray-600">
          <p class="flex gap-1">
            <span class="grow">Subtotal</span>
            <span>
              {toCurrencyString(context().user?.sale?.subtotal as number)}
            </span>
          </p>
        </div>
        <Show
          when={context().user?.sale?.items.some(
            (item) => item.type === "CONVENIENCE FEE",
          )}
        >
          <div class="text-sm text-gray-600">
            <p class="flex gap-1">
              <span class="grow">Convenience Fee</span>
              <span>{toCurrencyString(context().settings.convenienceFee)}</span>
            </p>
          </div>
        </Show>
        <div class="text-sm text-gray-600">
          <p class="flex gap-1">
            <span class="grow">
              Tax (
              {(context().settings.taxRate / 100).toLocaleString("en-US", {
                style: "percent",
                minimumSignificantDigits: 1,
              })}
              )
            </span>
            <span>{toCurrencyString(context().user?.sale?.tax as number)}</span>
          </p>
        </div>
        <div>
          <p class="flex gap-1">
            <span class="grow">Total</span>
            <span>
              {toCurrencyString(context().user?.sale?.total as number)}
            </span>
          </p>
        </div>
        <Show
          when={context().user?.sale?.items.some((item) =>
            item?.type?.includes("MEMBERSHIP"),
          )}
          fallback={
            <p class="mt-10 text-sm text-gray-600">
              You will be redirected to Stripe to pay for the items in your
              cart.
            </p>
          }
        >
          <p class="mt-10 text-sm text-gray-600">
            You will be redirected to Stripe to pay for your membership and
            redirected back with and given the benefits once we receive the
            payment.
          </p>
        </Show>
        <form
          class="grid"
          onClick={(e) => {
            e.preventDefault();

            if (!confirm("You will be redirected to Stripe to pay.")) return;

            mutation.mutate();
          }}
        >
          <Button type="submit" text="Checkout" disabled={mutation.isPending} />
        </form>
      </Show>
    </section>
  );
}

const checkoutFn = createServerFn({ method: "POST" }).handler(async () => {
  const user = await getSignedInUserFn();

  if (!user) throw redirect({ to: "/sign-in" });

  if (!user.sale) throw new Error("Sign in user has no open sales.");

  if (!user.sale.checkoutSessionId)
    throw new Error("Checkout session of signed in user sale not found.");

  const checkoutSession = await getStripeCheckoutSession(
    user.sale.checkoutSessionId,
  );

  if (!checkoutSession) throw new Error("Checkout session not found");

  console.log("checkout URL: ", checkoutSession.url);

  if (!checkoutSession.url) return;

  throw redirect({ href: checkoutSession.url });
});

const removeItemFn = createServerFn({ method: "POST" })
  .validator((data: { saleId: number; saleItemId: number }) => data)
  .handler(async ({ data: { saleId, saleItemId } }) => {
    const user = await getSignedInUserFn();

    if (!user) throw new Error("Unable to delete item from cart.");

    let sale = await SaleRepository.get({
      id: saleId,
      customerId: user.id,
      source: "PORTAL",
      status: "OPEN",
    });

    const item = sale?.items.find(
      (x) => x.id === saleId && x.saleId === saleId,
    );

    if (!item) return;

    item.deletedAt = getCurrentDateTimeString();

    await SaleRepository.save({ id: saleId, items: sale?.items });

    console.log(sale?.id, saleItemId);
  });
