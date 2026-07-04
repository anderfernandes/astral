import { useMutation } from "@tanstack/solid-query";
import { createFileRoute, Link } from "@tanstack/solid-router";
import { useServerFn } from "@tanstack/solid-start";
import { createMemo, For, Loading, Show } from "solid-js";
import { Button, Checkbox, Dialog, Input, Radio, Select } from "~components";
import {
  getPaymentMethodsFn,
  savePaymentMethodFn,
} from "~utils/paymentMethods.functions";

interface ISearchParams {
  dialog?: "create" | "edit";
  id?: number;
}

export const Route = createFileRoute("/admin/settings/payment")({
  validateSearch: (search: ISearchParams) => search,
  loaderDeps: ({ search: { dialog, id } }) => ({ dialog, id }),
  component: PaymentSettingsPage,
  loader: async () => getPaymentMethodsFn(),
});

function PaymentSettingsPage() {
  const search = Route.useSearch();

  const navigate = Route.useNavigate();

  const paymentMethods = Route.useLoaderData();

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
    paymentMethods()?.find((item) => item.id == search().id),
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
              checked={selected()?.isActive === 1}
              name="isActive"
              label="Active"
              hint="Check if you want to make this payment type usable."
            />
            <Checkbox
              checked={selected()?.isPublic === 1}
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
        <div class="mt-3 grid gap-3 lg:grid-cols-3">
          <For each={paymentMethods()}>
            {(item) => (
              <Link
                to="."
                search={{ dialog: "edit", id: item.id }}
                class="flex w-full rounded-xl border border-gray-300 p-6"
              >
                <div class="grid grow">
                  <p class="font-medium">{item.name}</p>
                  <p class="text-gray-500">{item.type}</p>
                </div>
                <svg viewBox="0 0 24 24" class="size-10">
                  <path
                    fill="currentColor"
                    d="M15.58,16.8L12,14.5L8.42,16.8L9.5,12.68L6.21,10L10.46,9.74L12,5.8L13.54,9.74L17.79,10L14.5,12.68M20,12C20,10.89 20.9,10 22,10V6C22,4.89 21.1,4 20,4H4A2,2 0 0,0 2,6V10C3.11,10 4,10.9 4,12A2,2 0 0,1 2,14V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V14A2,2 0 0,1 20,12Z"
                  />
                </svg>
              </Link>
            )}
          </For>
        </div>
      </Loading>
    </div>
  );
}
