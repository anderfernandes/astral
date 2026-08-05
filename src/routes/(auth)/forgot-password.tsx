import { useMutation } from "@tanstack/solid-query";
import { createFileRoute, Link } from "@tanstack/solid-router";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { getRequest } from "@tanstack/solid-start/server";
import { Show } from "solid-js";
import { Alert, Button, Input } from "~components";
import * as UserRepository from "~repositories/UserRepository";

export const Route = createFileRoute("/(auth)/forgot-password")({
  component: RouteComponent,
});

function RouteComponent() {
  const context = Route.useRouteContext();

  const forgotPassword = useServerFn(forgotPasswordFn);

  const mutation = useMutation(() => ({
    mutationFn: (data: string) => forgotPassword({ data }),
  }));

  return (
    <>
      <h2 class="text-center text-xl/9 font-bold tracking-tight text-gray-900">
        Forgot Password
      </h2>
      <span class="mb-8 text-center text-sm/6 text-gray-500">
        {context().settings.name}
      </span>
      <Show
        when={!mutation.data?.success}
        fallback={
          <Alert
            variant="success"
            text="An email with a password recovery link has been sent to your email if you have an account."
          />
        }
      >
        <form
          class="grid w-full max-w-80 gap-3 justify-self-center"
          onSubmit={(e) => {
            e.preventDefault();

            mutation.mutate(
              new FormData(e.currentTarget).get("email") as string,
            );
          }}
        >
          <Input
            placeholder="Email"
            label="Email"
            type="email"
            name="email"
            hint="The email you used when you registered."
            disabled={mutation.isPending}
            required
          />
          <Button text="Recover Password" disabled={mutation.isPending} />
        </form>
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

const forgotPasswordFn = createServerFn({ method: "POST" })
  .validator((data: string) => data)
  .handler(
    async ({ data }) =>
      await UserRepository.forgotPassword(
        data,
        new URL(getRequest().url).origin,
      ),
  );
