import { query } from "@solidjs/router";
import { createMemo, For } from "solid-js";
import db from "~db";
import { paths } from "../../../router";

export default function UsersIndexPage() {
  const users = createMemo(() => getUsersFn());

  return (
    <section class="grid gap-3">
      <For each={users()}>
        {(user) => (
          <a href={paths.admin.users(user.id)}>
            #{user.id} {user.firstName} {user.lastName} &middot; {user.email}
          </a>
        )}
      </For>
    </section>
  );
}

const getUsersFn = query(async () => {
  "use server";
  return await db.users.findAll();
}, "users");
