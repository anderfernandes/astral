import "server-only";

import Stripe from "stripe";

const stripe = new Stripe(process.env["STRIPE_SECRET_KEY"]);

export default stripe;

export async function createStripeCheckout(
  sale: {
    id: number;
    status: Sale["status"];
    isTaxable: boolean;
    items: SaleItemInsertable[];
  },
  customer: { id: number; firstName: string; lastName: string; email: string },
) {
  if (!customer.id) throw new Error("Sale doesn't have a customer.");

  if (!sale.id) throw new Error("Sale doesn't have an id.");

  if (sale.items.length <= 0) throw new Error("Sale has no items.");

  if (sale.status !== "OPEN") throw new Error("Sale is not open.");

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
    customer_email: customer.email,
    success_url:
      "http://localhost:3000/account/checkout/sessions/{CHECKOUT_SESSION_ID}",
    cancel_url: "http://localhost:3000/account/checkout/canceled",
  });

  if (!session) throw new Error("Failed to create checkout session.");

  return session;
}

export async function getStripeTaxRate() {
  if (!process.env["STRIPE_TAX_RATE_ID"]) {
    console.warn("STRIPE_TAX_RATE_ID not set");
    return null;
  }

  try {
    return await stripe.taxRates.retrieve(process.env["STRIPE_TAX_RATE_ID"]);
  } catch {
    console.warn("STRIPE_TAX_RATE_ID not set up");
    return null;
  }
}
