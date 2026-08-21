import { createMutation } from "@tanstack/solid-query";
import { createFileRoute, redirect } from "@tanstack/solid-router";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { createMemo, For, Show } from "solid-js";
import Stripe from "stripe";
import { Alert, Badge, Button } from "~components";
import { getSignedInUserFn } from "~utils/account.functions";
import { calculateSaleTotals, toCurrencyString } from "~utils/index";
import { stripe } from "~utils/index.server";

export const Route = createFileRoute("/(public)/cart")({
  component: RouteComponent,
});

function RouteComponent() {
  const context = Route.useRouteContext();

  const checkout = useServerFn(checkoutFn);

  const mutation = createMutation(() => ({
    mutationFn: () => checkout(),
    onError: (e) => {
      console.log(e.message);
      alert("An error occurred.");
    },
  }));

  const totals = createMemo(() =>
    calculateSaleTotals(context().user?.cart ?? [], context().settings.taxRate),
  );

  return (
    <section class="mx-auto my-24 grid w-full gap-6 px-8 lg:w-2xl lg:px-0">
      <h1 class="mb-12 text-center text-4xl font-bold">Shopping Cart</h1>
      <For
        each={context().user?.cart.filter(
          (item) => item.type != "CONVENIENCE FEE",
        )}
      >
        {(item) => (
          <div class="grid gap-3 border-y border-gray-200 py-3 text-sm">
            <div class="flex items-center">
              <p class="grow">{item.name}</p>
              <p>{toCurrencyString(item.price)}</p>
            </div>
            <div class="flex">
              <Badge text={item.type} />
            </div>
            <p class="text-gray-600">{item.description}</p>
            <div>
              <Button variant="secondary" text="Remove" />
            </div>
          </div>
        )}
      </For>
      <Show
        when={context().user?.cart.length! > 0}
        fallback={<Alert text="Nothing on your cart yet." />}
      >
        <div class="text-sm text-gray-600">
          <p class="flex gap-1">
            <span class="grow">Subtotal</span>
            <span>{toCurrencyString(totals().subtotal)}</span>
          </p>
        </div>
        <Show
          when={context().user?.cart.some(
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
            <span>{toCurrencyString(totals().tax)}</span>
          </p>
        </div>
        <div>
          <p class="flex gap-1">
            <span class="grow">Total</span>
            <span>{toCurrencyString(totals().total)}</span>
          </p>
        </div>
        <Show
          when={context().user?.cart.some((item) =>
            item.type.includes("MEMBERSHIP"),
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

  const line_items: Stripe.Checkout.SessionCreateParams.LineItem[] = [];

  if (!user?.cart || user.cart.length <= 0) return;

  // TODO: MAKE SURE CURRENCY IS SET

  const taxRate = await stripe.taxRates.retrieve(
    process.env["STRIPE_TAX_RATE_ID"] as string,
  );

  // TODO: CHECK IF TAX RATE EXISTS

  for (const item of user?.cart) {
    line_items.push({
      tax_rates: [taxRate.id],
      quantity: item.quantity,
      price_data: {
        tax_behavior: "exclusive",
        currency: process.env["CURRENCY"] as string,
        unit_amount: item.price,
        product_data: {
          name: item.name,
          description: item.description,
          images: ["http://localhost:3000/cover.jpg"],
        },
      },
    });
  }

  const checkoutSession = await stripe.checkout.sessions.create({
    line_items,
    mode: "payment",
    //integration_identifier: "{{INTEGRATION_ID}}",
    customer_email: user.email,
    success_url:
      "http://localhost:3000/account/checkout/sessions/{CHECKOUT_SESSION_ID}",
    cancel_url: "http://localhost:3000/account/checkout/canceled",
  });

  console.log("checkout URL: ", checkoutSession.url);

  if (!checkoutSession.url) return;

  throw redirect({ href: checkoutSession.url });
});
