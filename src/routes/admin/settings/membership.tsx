import { useMutation, useQuery } from "@tanstack/solid-query";
import { createFileRoute, useSearch } from "@tanstack/solid-router";
import { useServerFn } from "@tanstack/solid-start";
import { createMemo, For, Loading, Match, Show, Switch } from "solid-js";
import { Badge, Button, Checkbox, Dialog, Input, Textarea } from "~components";
import {
  getMembershipTypesFn,
  saveMembershipTypeFn,
} from "~utils/membershipTypes.functions";

export const Route = createFileRoute("/admin/settings/membership")({
  validateSearch: (search: { dialog?: "create" | "edit"; id?: number }) =>
    search,
  component: MembershipSettingsPage,
});

function MembershipSettingsPage() {
  const search = Route.useSearch();

  const query = useQuery(() => ({
    queryKey: ["membership-types", search().id, search().dialog],
    queryFn: useServerFn(getMembershipTypesFn),
  }));

  const navigate = Route.useNavigate();

  const mutation = useMutation(() => ({
    mutationFn: useServerFn(saveMembershipTypeFn),
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
    <div class="grid gap-3">
      <div class="flex gap-3">
        <Button
          text="New Membership Type..."
          to="."
          search={{ dialog: "create" }}
        />
      </div>
      <Show when={search().dialog === "create" || search().dialog === "edit"}>
        <Dialog
          title="New Membership Type"
          subtitle="Creates a membership type."
        >
          <form
            class="grid max-h-96 gap-3 overflow-y-auto"
            onSubmit={(e) => {
              e.preventDefault();

              if (confirm("Save Membership Type?")) {
                mutation.mutate({ data: new FormData(e.currentTarget) });
              }
            }}
          >
            <Show when={search().id}>
              <input type="hidden" name="id" value={search().id} />
            </Show>
            <Input
              value={selected()?.name}
              name="name"
              required
              label="Name"
              placeholder="Name"
            />
            <Textarea
              value={selected()?.description}
              name="description"
              label="Description"
              required
              placeholder="Description"
            />
            <Input
              value={selected()?.duration}
              name="duration"
              type="number"
              label="Duration"
              required
              placeholder="Duration in days"
              min="1"
            />
            <Input
              value={(selected()?.price as number) / 100}
              name="price"
              type="number"
              label="Price"
              required
              placeholder="Price"
              min="0"
            />
            <Input
              value={selected()?.maxFreeSecondaries}
              name="maxFreeSecondaries"
              type="number"
              label="Max Free Secondaries"
              required
              placeholder="Max Free Secondaries"
              min="0"
            />
            <Input
              value={selected()?.maxPaidSecondaries}
              name="maxPaidSecondaries"
              type="number"
              label="Max Paid Secondaries"
              required
              placeholder="Max Paid Secondaries"
              min="0"
            />
            <Input
              value={(selected()?.paidSecondaryPrice as number) / 100}
              name="paidSecondaryPrice"
              type="number"
              label="Paid Secondary Price"
              required
              placeholder="Paid Secondary Price"
              min="0"
            />
            <Checkbox
              checked={selected()?.isActive as boolean}
              name="isActive"
              label="Active"
              hint="Check to make it available everywhere."
            />
            <Checkbox
              checked={selected()?.isPublic as boolean}
              name="isPublic"
              label="Public"
              hint="Check to make it available in the public portal."
            />
            <div class="mt-3 flex justify-end gap-3">
              <Button to="." text="Cancel" variant="secondary" />
              <Button text="Save" type="submit" disabled={mutation.isPending} />
            </div>
          </form>
        </Dialog>
      </Show>
      <ul role="list" class="divide-y divide-gray-100">
        <Show when={query.isLoading}>Loading Membership Types...</Show>
        <Loading fallback={<span class="text-sm">Loading...</span>}>
          <For each={query.data}>
            {(item) => (
              <li class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 grow gap-x-4">
                  <svg viewBox="0 0 24 24" class="size-12">
                    <path
                      fill="currentColor"
                      d="M20 22.09L22.45 23.58L21.8 20.77L24 18.89L21.11 18.64L20 16L18.87 18.64L16 18.89L18.18 20.77L17.5 23.58L20 22.09M14.08 21H2C.95 21 0 20.05 0 19V5C0 3.95 .95 3 2 3H22C23.05 3 24 3.95 24 5V15.53C22.94 14.58 21.54 14 20 14C16.69 14 14 16.69 14 20C14 20.34 14.03 20.68 14.08 21M8 13.91C6 13.91 2 15 2 17V18H14V17C14 15 10 13.91 8 13.91M8 6C6.35 6 5 7.35 5 9C5 10.65 6.35 12 8 12C9.65 12 11 10.65 11 9C11 7.35 9.65 6 8 6M21 10H14V11H21V10M22 8H14V9H22V8M22 6H14V7H22V6Z"
                    />
                  </svg>
                  <div class="min-w-0 flex-auto">
                    <p class="flex gap-1 text-sm/6 font-semibold text-gray-900">
                      {item.name}
                      <Show when={item.isPublic}>
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 24 24"
                          fill="currentColor"
                          class="size-6"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM6.262 6.072a8.25 8.25 0 1 0 10.562-.766 4.5 4.5 0 0 1-1.318 1.357L14.25 7.5l.165.33a.809.809 0 0 1-1.086 1.085l-.604-.302a1.125 1.125 0 0 0-1.298.21l-.132.131c-.439.44-.439 1.152 0 1.591l.296.296c.256.257.622.374.98.314l1.17-.195c.323-.054.654.036.905.245l1.33 1.108c.32.267.46.694.358 1.1a8.7 8.7 0 0 1-2.288 4.04l-.723.724a1.125 1.125 0 0 1-1.298.21l-.153-.076a1.125 1.125 0 0 1-.622-1.006v-1.089c0-.298-.119-.585-.33-.796l-1.347-1.347a1.125 1.125 0 0 1-.21-1.298L9.75 12l-1.64-1.64a6 6 0 0 1-1.676-3.257l-.172-1.03Z"
                            clip-rule="evenodd"
                          />
                        </svg>
                      </Show>
                      <Show when={item.isActive}>
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="size-6"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                          />
                        </svg>
                      </Show>
                    </p>
                    <div class="mt-1 flex flex-wrap gap-1">
                      <Badge
                        text={(item.price / 100).toLocaleString("en-US", {
                          style: "currency",
                          currency: "USD",
                          maximumSignificantDigits: 2,
                        })}
                      />
                      <Badge>
                        <span class="flex items-center gap-1">
                          <svg viewBox="0 0 24 24" class="size-4">
                            <path
                              fill="currentColor"
                              d="M13.09 20H4C2.9 20 2 19.11 2 18V6C2 4.89 2.9 4 4 4H20C21.11 4 22 4.89 22 6V13.81C21.12 13.3 20.09 13 19 13C15.69 13 13 15.69 13 19C13 19.34 13.04 19.67 13.09 20M18 15V18H15V20H18V23H20V20H23V18H20V15H18Z"
                            />
                          </svg>
                          {item.maxFreeSecondaries}
                        </span>
                      </Badge>
                      <Badge>
                        <span class="flex items-center gap-1">
                          <svg viewBox="0 0 24 24" class="size-4">
                            <path
                              fill="currentColor"
                              d="M21 15V18H24V20H21V23H19V20H16V18H19V15H21M14 18H3V6H19V13H21V6C21 4.89 20.11 4 19 4H3C1.9 4 1 4.89 1 6V18C1 19.11 1.9 20 3 20H14V18Z"
                            />
                          </svg>
                          {item.maxPaidSecondaries} @{" "}
                          {(item.price / 100).toLocaleString("en-US", {
                            style: "currency",
                            currency: "USD",
                            maximumSignificantDigits: 2,
                          })}{" "}
                          each
                        </span>
                      </Badge>
                    </div>
                    <p class="mt-1 truncate text-xs/5 text-gray-500">
                      {item.description}
                    </p>
                  </div>
                </div>
                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                  <p class="text-sm/6 text-gray-900">{item.duration} days</p>
                  {/* <p class="mt-1 text-xs/5 text-gray-500">
                    {(item.price / 100).toLocaleString("en-US", {
                      style: "currency",
                      currency: "USD",
                    })}
                  </p> */}
                </div>
                <div class="flex items-center">
                  <Button
                    text="Edit"
                    to="."
                    search={{ dialog: "edit", id: item.id }}
                  />
                </div>
              </li>
            )}
          </For>
        </Loading>
      </ul>
    </div>
  );
}
