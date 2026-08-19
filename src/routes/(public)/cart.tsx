import { createFileRoute } from "@tanstack/solid-router";
import { For } from "solid-js";
import { Badge, Button } from "~components";
import { toCurrencyString } from "~utils/index";

export const Route = createFileRoute("/(public)/cart")({
  component: RouteComponent,
});

function RouteComponent() {
  const context = Route.useRouteContext();
  return (
    <section class="mx-auto my-24 grid w-full gap-6 lg:w-2xl">
      <h1 class="mb-12 text-center text-4xl font-bold">Shopping Cart</h1>
      <For each={context().user?.cart}>
        {(item) => (
          <div class="grid border-y border-gray-200 py-3 text-sm">
            <div class="flex items-center">
              <Badge text={item.type} />
              <p class="grow">{item.name}</p>
              <p>{toCurrencyString(item.price)}</p>
            </div>
            <p class="text-gray-600">{item.description}</p>
          </div>
        )}
      </For>
      <Button text="Checkout" />
    </section>
  );
}
