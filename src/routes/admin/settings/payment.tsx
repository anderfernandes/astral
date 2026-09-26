import { action, useLocation } from "@solidjs/router";
import { createMemo, For, Loading, Show } from "solid-js";
import { Alert, Button, Checkbox, Dialog, Input, Select } from "~components";
import { getPaymentMethodsFn } from "~lib/payment-methods";
import * as v from "valibot";
import { redirect, respond } from "@solidjs/web";
import { getUserFn } from "~lib";
import db from "~db";

export default function PaymentSettingsPage() {
  const location = useLocation();

  const paymentMethods = createMemo(() => getPaymentMethodsFn());

  const selected = createMemo(() =>
    paymentMethods().find((item) => String(item.id) == location?.query?.id),
  );

  return (
    <section class="grid gap-3">
      <div>
        <Button href="?dialog=create" text="New Payment Method..." />
      </div>
      <Show when={paymentMethods().length <= 0}>
        <Alert text="No payment methods have been setup yet." />
      </Show>
      <Loading fallback={<span class="text-sm">Loading...</span>}>
        <div class="mt-3 grid gap-3 lg:grid-cols-3">
          <For each={paymentMethods()}>
            {(item) => (
              <a
                href={`?dialog=edit&id=${item.id}`}
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
              </a>
            )}
          </For>
        </div>
      </Loading>
      <Show
        when={
          location.query.dialog === "create" || location.query.dialog === "edit"
        }
      >
        <Dialog
          title={selected() ? "Update Payment Method" : "New Payment Method"}
          subtitle={
            selected()
              ? "Update an existing payment method"
              : "Create a brand new payment method"
          }
          footer={
            <>
              <Button
                href="/admin/settings/payment"
                text="Close"
                variant="secondary"
              />
              <Button text="Save" />
            </>
          }
        >
          <form class="grid gap-3" method="post" action={save}>
            <Show when={selected()?.id}>
              <input type="hidden" name="id" value={selected()?.id} />
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
              <Button
                href="/admin/settings/payment"
                text="Cancel"
                variant="secondary"
              />
              <Button text="Save" type="submit" />
            </div>
          </form>
        </Dialog>
      </Show>
    </section>
  );
}

const PaymentMethodSchema = v.object({
  name: v.pipe(v.string(), v.minLength(3), v.maxLength(255)),
  description: v.pipe(v.string(), v.minLength(3), v.maxLength(255)),
  type: v.pipe(v.string(), v.picklist(["CASH", "CARD", "OTHER"])),
  isActive: v.boolean(),
  isPublic: v.boolean(),
});

const save = action(async (form: FormData) => {
  "use server";

  const { output, success, issues } = v.safeParse(PaymentMethodSchema, {
    name: form.get("name"),
    description: form.get("description"),
    type: form.get("type"),
    isActive: Boolean(form.has("isActive")),
    isPublic: Boolean(form.has("isPublic")),
  });

  if (!success) {
    console.log("success: ", issues);

    throw respond(
      { issues: issues?.map(({ message }) => message) },
      { status: 400 },
    );
  }

  const user = await getUserFn();

  if (!user) throw respond({ message: "An error has occurred." });

  console.log("creator: ", user);

  if (form.has("id")) {
    const result = v.safeParse(v.number(), Number(form.get("id")));

    if (!result.success)
      throw respond({ message: "An error has occurred." }, { status: 400 });

    await db.paymentMethods.update(result.output, {
      ...output,
      id: result.output,
      creatorId: user.userId as number,
    });
  } else {
    await db.paymentMethods.create({
      ...output,
      creatorId: user.userId as number,
    });
  }

  return redirect("/admin/settings/payment");
});
