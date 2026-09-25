import { action, query, RouteProps } from "@solidjs/router";
import { createMemo } from "solid-js";
import db from "~db";
import { Router } from "../../../../router";
import { Button } from "~components";
import { respond } from "@solidjs/web";

type UserDetailsPageProps = RouteProps<typeof Router.paths.admin.users>;

export default function UserDetailsPage(props: UserDetailsPageProps) {
  const user = createMemo(() => getUserFn(Number(props.params.id)));

  return (
    <section class="grid gap-3">
      <form method="post" action={updateUserFn}>
        <input type="hidden" name="id" value={user().id} />
        <input
          type="hidden"
          name="isAdmin"
          value={user().roles.includes("ROLE_STAFF") ? 1 : 0}
        />
        <Button
          type="submit"
          text={
            user().roles.includes("ROLE_STAFF")
              ? "Remove staff role"
              : "Add staff role"
          }
        />
      </form>
      <p>
        #{user().id} {user().firstName} {user().lastName}
      </p>
      <p>{user().email}</p>
    </section>
  );
}

const updateUserFn = action(async (form: FormData) => {
  "use server";

  // TODO: ENSURE ONLY ROLE_ADMIN CAN CHANGE ROLES.

  const user = {
    id: Number(form.get("id")),
    roles:
      Number(form.get("isAdmin")) == 1
        ? ["ROLE_USER"]
        : ["ROLE_USER", "ROLE_STAFF"],
  };

  await db.users.update(user.id, { roles: user.roles as Role[] });
});

const getUserFn = query(async (id: number) => {
  "use server";
  return await db.users.find(id);
}, "user");
