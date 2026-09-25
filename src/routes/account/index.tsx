import { createMemo, Show } from "solid-js";
import { Button } from "~components";
import { getUserFn } from "~lib";

export default function AccountPage() {
  const user = createMemo(() => getUserFn());

  return (
    <section class="grid gap-3 p-4">
      <p>Account Page</p>
      <div class="flex gap-3">
        <Show when={user()?.roles?.includes("ROLE_STAFF")}>
          <Button href="/admin" text="Admin" />
        </Show>
        <Button href="/" text="Home" />
      </div>
    </section>
  );
}
