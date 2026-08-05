import { createFileRoute, Link } from "@tanstack/solid-router";
import { createServerOnlyFn } from "@tanstack/solid-start";
import { Show } from "solid-js";
import { Alert } from "~components";
import * as UserRepository from "~repositories/UserRepository";

export const Route = createFileRoute("/(auth)/recover")({
  component: RouteComponent,
  validateSearch: (search: { token: string }) => search,
  loaderDeps: ({ search: { token } }) => ({ token }),
  loader: async ({ deps }) => {
    const token = await recoverFn(deps.token);

    if (!token) return { success: false };

    return { success: true };
  },
});

function RouteComponent() {
  const loaderData = Route.useLoaderData();

  const context = Route.useRouteContext();

  return (
    <>
      <h2 class="my-3 text-center text-xl/9 font-bold tracking-tight text-gray-900">
        Recover
      </h2>
      <span class="mb-8 text-center text-sm/6 text-gray-500">
        {context().settings.name}
      </span>
      <Show
        when={loaderData().success === true}
        fallback={
          <Alert variant="error" text="Activation expired or already used." />
        }
      >
        <Alert variant="success" text="Account activated!" />
      </Show>
      <p class="mt-10 text-center text-sm/6 text-gray-500">
        Already have an account?{" "}
        <Link
          to="/sign-in"
          class="font-semibold text-black hover:text-black/75"
        >
          Sign In
        </Link>
        .
      </p>
    </>
  );
}

const recoverFn = createServerOnlyFn(UserRepository.recover);
