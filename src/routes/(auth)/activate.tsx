import { createFileRoute, Link } from "@tanstack/solid-router";
import { createServerFn, createServerOnlyFn } from "@tanstack/solid-start";
import { sql } from "kysely";
import { db } from "~db";
import { Temporal } from "@js-temporal/polyfill";
import { getCurrentDateTimeString, toDateTimeString } from "~utils/index";
import { Alert, Button } from "~components";
import { Match, Show, Switch } from "solid-js";

export const Route = createFileRoute("/(auth)/activate")({
  component: ActivatePage,
  validateSearch: (search: { token: string }) => search,
  loaderDeps: ({ search }) => ({
    token: search.token,
  }),
  loader: async ({ deps }) => {
    const user = await activateAccountFn(deps.token);

    if (!user) return { success: false };

    return { success: true };
  },
});

function ActivatePage() {
  const loaderData = Route.useLoaderData();

  return (
    <>
      <h2 class="my-3 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
        Activate
      </h2>
      <Show
        when={loaderData().success === true}
        fallback={
          <Alert variant="error" text="Activation expired or already used." />
        }
      >
        <Alert variant="success" text="Account activated!" />
      </Show>
      <Link
        to="/sign-in"
        class="text-center font-semibold text-black hover:text-black/75"
      >
        Sign In
      </Link>
    </>
  );
}

const activateAccountFn = createServerOnlyFn(async (tokenId: string) => {
  const token = await db
    .selectFrom("tokens")
    .where("id", "=", tokenId)
    .where("expiresAt", "<=", getCurrentDateTimeString() as any)
    .where("updatedAt", "=", null)
    .selectAll()
    .executeTakeFirst();

  if (!token) return undefined;

  await db
    .updateTable("tokens")
    .set({
      updatedAt: getCurrentDateTimeString() as any,
      expiresAt: getCurrentDateTimeString() as any,
    })
    .where("id", "=", tokenId)
    .where("expiresAt", "<=", getCurrentDateTimeString() as any)
    .executeTakeFirst();

  db.updateTable("users")
    .set({
      activatedAt: getCurrentDateTimeString() as any,
    })
    .where("id", "=", token?.userId)
    .executeTakeFirstOrThrow();

  return token;
});
