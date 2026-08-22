import { createServerOnlyFn } from "@tanstack/solid-start";
import Stripe from "stripe";
import * as UserRepository from "~repositories/UserRepository";

const stripe = new Stripe(process.env["STRIPE_SECRET_KEY"]);

export const createStripeCheckoutSession = createServerOnlyFn(
  async (sale: Sale) => {
    if (sale.items.length === 0) return;

    const user = await UserRepository.get({ id: sale.customerId });

    const taxRate = await getStripeTaxRate();

    const line_items: Stripe.Checkout.SessionCreateParams.LineItem[] = [];

    const currency = process.env["CURRENCY"] ?? "USD";

    for (const item of sale.items) {
      let line_item: Stripe.Checkout.SessionCreateParams.LineItem = {
        quantity: item.quantity,
        price_data: {
          tax_behavior: "exclusive",
          currency,
          unit_amount: item.price,
          product_data: {
            name: `${item.name} ${item.type}`,
            description: item.description,
            images: ["http://localhost:3000/cover.jpg"],
          },
        },
      };

      if (taxRate) line_item.tax_rates = [taxRate.id];

      line_items.push(line_item);
    }

    const session = await stripe.checkout.sessions.create({
      line_items,
      mode: "payment",
      //integration_identifier: "{{INTEGRATION_ID}}",
      customer_email: user.email,
      success_url:
        "http://localhost:3000/account/checkout/sessions/{CHECKOUT_SESSION_ID}",
      cancel_url: "http://localhost:3000/account/checkout/canceled",
    });

    if (!session) throw new Error("Failed to create checkout session.");

    return session;
  },
);

export const getStripeCheckoutSession = createServerOnlyFn(
  async (id: string) => {
    try {
      return await stripe.checkout.sessions.retrieve(id);
    } catch (e) {
      return null;
    }
  },
);

const getStripeTaxRate = createServerOnlyFn(async () => {
  if (!process.env["STRIPE_TAX_RATE_ID"]) {
    console.warn("STRIPE_TAX_RATE_ID not set");
    return null;
  }

  try {
    return await stripe.taxRates.retrieve(process.env["STRIPE_TAX_RATE_ID"]);
  } catch (e) {
    console.warn("STRIPE_TAX_RATE_ID not set up");
    return null;
  }
});
