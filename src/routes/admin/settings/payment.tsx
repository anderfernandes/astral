import { useMutation, useQuery } from "@tanstack/solid-query";
import { createFileRoute } from "@tanstack/solid-router";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { For, Loading, Show } from "solid-js";
import { Button, Checkbox, Dialog, Input, Radio, Select } from "~components";

export const Route = createFileRoute("/admin/settings/payment")({
  validateSearch: (search: { dialog: "create" | "edit"; id?: number }) =>
    search,
  loaderDeps: ({ search: { dialog, id } }) => ({ dialog, id }),
  component: PaymentSettingsPage,
});

function PaymentSettingsPage() {
  const query = useQuery(() => ({
    queryKey: ["payment-methods"],
    queryFn: useServerFn(getPaymentMethods),
  }));

  const search = Route.useSearch();

  const mutation = useMutation(() => ({
    mutationFn: useServerFn(savePaymentMethod),
  }));

  return (
    <div>
      <Button
        text="New Payment Method..."
        to="."
        search={{ dialog: "create" }}
      />
      <Show when={search().dialog === "create"}>
        <Dialog
          title="New Payment Method"
          subtitle="Create a brand new payment method."
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
            onChange={(e) => {
              e.preventDefault();

              var data = new FormData(e.currentTarget);

              mutation.mutate({
                data: {
                  name: data.get("name") as string,
                  description: data.get("description") as string,
                  type: data.get("type") as IPaymentMethod["type"],
                  isActive: true,
                  isPublic: true,
                },
              });
            }}
          >
            <Input name="name" placeholder="Name" label="Name" />
            <Input
              name="description"
              placeholder="Description"
              label="Description"
            />
            <Select label="Type" name="type">
              <option value="CASH">CASH</option>
              <option value="CARD">CARD</option>
              <option value="OTHER">OTHER</option>
            </Select>
            <Checkbox
              name="isActive"
              label="Active"
              hint="Check if you want to make this payment type usable."
            />
            <Checkbox
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
            <div class="flex max-w-sm">
              <img class="size-16 rounded-full" src="/img/profile.jpg" />
              <div class="wrap-anywhere">
                <p class="font-medium">Jay Riemenschneider</p>
                <p>jason.riemenschneider@vandelayindustries.com</p>
              </div>
            </div>
          )}
        </For>
      </Loading>
    </div>
  );
}

const savePaymentMethod = createServerFn({ method: "POST" })
  .inputValidator((data: IPaymentMethod) => data)
  .handler(async ({ data }) => {
    const req = await fetch("http://localhost:8000/payment-methods", {
      method: "POST",
      body: JSON.stringify(data),
    });

    console.log("POST " + req.status, req.url);

    const res = await req.json();

    console.log(res);

    return { sucess: true };
  });

const getPaymentMethods = createServerFn().handler(async () => {
  // const req = await fetch("http://localhost:8000/payment-methods");

  // console.log(req.status, req.url);

  // const { data } = await req.json();

  // console.log(data);

  return [] as IPaymentMethod[];
});

interface IPaymentMethod {
  name: string;
  description: string;
  type: "CASH" | "CHECK" | "OTHER";
  isActive: boolean;
  isPublic: boolean;
}
