import { createFileRoute, Link } from "@tanstack/solid-router";
import { createServerOnlyFn } from "@tanstack/solid-start";
import { Alert } from "~components";
import { Show } from "solid-js";
import * as UserRepository from "~repositories/UserRepository";

export const Route = createFileRoute("/(auth)/activate")({
  component: ActivatePage,
  validateSearch: (search: { token: string }) => search,
  loaderDeps: ({ search }) => ({
    token: search.token,
  }),
  loader: async ({ deps }) => {
    const token = await activateAccountFn(deps.token);

    if (!token) return { success: false };

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

const activateAccountFn = createServerOnlyFn(UserRepository.activate);
