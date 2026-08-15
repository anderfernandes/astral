import {
  createFileRoute,
  Link,
  Outlet,
  redirect,
} from "@tanstack/solid-router";
import { Show } from "solid-js";
import { Button } from "~components";
import { getSignedInUserFn } from "~utils/account.functions";
import { getSettingsFn } from "~utils/settings.functions";

export const Route = createFileRoute("/account")({
  component: RouteComponent,
  beforeLoad: async () => {
    const user = await getSignedInUserFn();

    if (!user) {
      console.log("no user");
      throw redirect({ to: "/sign-in" });
    }

    return { user, settings: await getSettingsFn() };
  },
});

function RouteComponent() {
  const context = Route.useRouteContext();

  return (
    <>
      <header class="flex h-16 max-w-540 items-center justify-end px-4">
        <h5 class="grid grow text-sm">
          <span>Account Details</span>
          <span>
            {context().user.firstName} {context().user.lastName}
          </span>
        </h5>
        <nav class="flex gap-3 text-sm">
          <Link to="/">Home</Link>
          <Show when={context().user.roles.includes("ROLE_STAFF")}>
            <Link to="/admin">Admin</Link>
          </Show>
        </nav>
      </header>
      <section class="grid gap-3 p-4">
        <Outlet />
      </section>
    </>
  );
}
