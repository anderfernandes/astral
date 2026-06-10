import { useMutation, useQuery } from "@tanstack/solid-query";
import { createFileRoute, Link } from "@tanstack/solid-router";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { createMemo, For, Loading, Show } from "solid-js";
import { Button, Checkbox, Dialog, Input, Radio, Select } from "~components";
import { PaymentMethod } from "~db";
import {
  getPaymentMethodsFn,
  savePaymentMethodFn,
} from "~utils/paymentMethods.functions";

export const Route = createFileRoute("/admin/settings/payment")({
  validateSearch: (search: { dialog?: "create" | "edit"; id?: number }) =>
    search,
  loaderDeps: ({ search: { dialog, id } }) => ({ dialog, id }),
  component: PaymentSettingsPage,
});

function PaymentSettingsPage() {
  const query = useQuery(() => ({
    queryKey: ["payment-methods"],
    queryFn: useServerFn(getPaymentMethodsFn),
  }));

  const search = Route.useSearch();

  const navigate = Route.useNavigate();

  const mutation = useMutation(() => ({
    mutationFn: useServerFn(savePaymentMethodFn),
    onSuccess: () => {
      navigate({ to: "." });
    },
    onError: (e) => {
      console.log(e.stack);
      alert(e.message);
    },
  }));

  const selected = createMemo(() =>
    query.data?.find((item) => item.id == search().id),
  );

  return (
    <div>
      <Button
        text="New Payment Method..."
        to="."
        search={{ dialog: "create" }}
      />
      <Show when={search().dialog === "create" || search().dialog === "edit"}>
        <Dialog
          title={selected() ? "Update Payment Method" : "New Payment Method"}
          subtitle={
            selected()
              ? "Update an existing payment method"
              : "Create a brand new payment method"
          }
          footer={
            <>
              <Button to="." text="Close" variant="secondary" />
              <Button text="Save" />
            </>
          }
        >
          <form
            class="grid gap-3"
            method="post"
            onSubmit={(e) => {
              e.preventDefault();

              mutation.mutate({ data: new FormData(e.currentTarget) });
            }}
          >
            <Show when={search().id}>
              <input type="hidden" name="id" value={search().id} />
            </Show>
            <Input
              value={selected()?.name}
              name="name"
              placeholder="Name"
              label="Name"
            />
            <Input
              value={selected()?.description}
              name="description"
              placeholder="Description"
              label="Description"
            />
            <Select label="Type" name="type" value={selected()?.type}>
              <option value="CASH">CASH</option>
              <option value="CARD">CARD</option>
              <option value="OTHER">OTHER</option>
            </Select>
            <Checkbox
              checked={selected()?.isActive}
              name="isActive"
              label="Active"
              hint="Check if you want to make this payment type usable."
            />
            <Checkbox
              checked={selected()?.isPublic}
              name="isPublic"
              label="Public"
              hint="Check to make method available in public portal."
            />
            <div class="mt-3 flex justify-end gap-3">
              <Button to="." text="Cancel" variant="secondary" />
              <Button text="Save" type="submit" disabled={mutation.isPending} />
            </div>
          </form>
        </Dialog>
      </Show>
      <Loading fallback={<span class="text-sm">Loading...</span>}>
        <For each={query.data}>
          {(item) => (
            <Link
              to="."
              search={{ dialog: "edit", id: item.id }}
              class="flex max-w-sm"
            >
              {/* <img class="size-16 rounded-full" src="/img/profile.jpg" /> */}
              <div class="wrap-anywhere">
                <p class="font-medium">{item.name}</p>
                <p>{item.type}</p>
              </div>
            </Link>
          )}
        </For>
      </Loading>
    </div>
  );
}
