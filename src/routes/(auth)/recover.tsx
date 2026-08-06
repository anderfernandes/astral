import { useMutation } from "@tanstack/solid-query";
import { createFileRoute, Link } from "@tanstack/solid-router";
import {
  createServerFn,
  createServerOnlyFn,
  useServerFn,
} from "@tanstack/solid-start";
import { getRequest } from "@tanstack/solid-start/server";
import { Show } from "solid-js";
import { Alert, Button, Input } from "~components";
import * as UserRepository from "~repositories/UserRepository";

export const Route = createFileRoute("/(auth)/recover")({
  component: RouteComponent,
});

function RouteComponent() {
  const context = Route.useRouteContext();

  const generateAccountRecoveryToken = useServerFn(
    generateAccountRecoveryTokenFn,
  );

  const mutation = useMutation(() => ({
    mutationFn: (data: string) => generateAccountRecoveryToken({ data }),
    onSuccess: () => {
      console.log("success");
    },
    onError: (error) => {
      console.log(error.message);
    },
  }));

  return (
    <>
      <h2 class="text-center text-xl/9 font-bold tracking-tight text-gray-900">
        Account Recovery
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

            mutation.mutate(String(new FormData(e.currentTarget).get("email")));
          }}
        >
          <Alert text="We will send to the email below an account recovery link." />
          <Input
            placeholder="Email"
            label="Email"
            type="email"
            name="email"
            hint="The email you used when you registered."
            disabled={mutation.isPending}
            required
          />
          <Button
            type="submit"
            text="Recover Account"
            disabled={mutation.isPending}
          />
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

const generateAccountRecoveryTokenFn = createServerFn({ method: "POST" })
  .validator((data: string) => {
    if (data.length <= 0 || data.length > 255 || !data.includes("@"))
      throw new Error("Invalid email.");
    return data;
  })
  .handler(
    async ({ data }) =>
      await UserRepository.generateAccountRecoveryToken(
        data,
        new URL(getRequest().url).origin,
      ),
  );
