import { createFileRoute, Link } from "@tanstack/solid-router";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { useMutation } from "@tanstack/solid-query";
import { Input, Button, Alert } from "~components";
import { createSignal, Show } from "solid-js";
import { db } from "~db";
import { verifyHash } from "~utils/index.server";

export const Route = createFileRoute("/(auth)/sign-in")({
  component: SignInPage,
});

function SignInPage() {
  const getUser = useServerFn(getUserFn);

  const getUserMutation = useMutation(() => ({
    mutationFn: (email: string) => getUser({ data: { email } }),
    onSuccess: (data) => {
      setEmail(data.email);
    },
  }));

  const signIn = useServerFn(signInFn);

  const signInMutation = useMutation(() => ({
    mutationFn: (password: string) =>
      signIn({ data: { email: email() as string, password } }),
    onSuccess: (data) => {
      console.log(data);
      console.log("signed in!");
    },
    onError: (error) => {
      console.log(error.message);
      setErrors([error.message]);
    },
  }));

  const loaderData = Route.parentRoute.useLoaderData();

  const [email, setEmail] = createSignal<string>();

  const [errors, setErrors] = createSignal<string[]>([]);

  return (
    <>
      <h2 class="text-center text-2xl/9 font-bold tracking-tight text-gray-900">
        Sign in to your account
      </h2>
      <span class="mb-8 text-center text-sm/6 text-gray-500">
        {loaderData().name}
      </span>

      <form
        class="grid w-full max-w-80 gap-3 justify-self-center"
        onSubmit={(e) => {
          e.preventDefault();

          const formData = new FormData(e.currentTarget);

          if (!email()) {
            getUserMutation.mutate(formData.get("email") as string);
            return;
          }

          signInMutation.mutate(formData.get("password") as string);
        }}
      >
        <Show
          when={errors().length > 0}
          fallback={<Alert text="Enter your credentials." />}
        >
          <Alert text={errors()[0]} variant="error" />
        </Show>
        <Input
          disabled={signInMutation.isPending || email()?.length! > 0}
          placeholder="Email"
          label="Email"
          type="email"
          name="email"

          required
        />
        <Show when={email()}>
          <Input
            placeholder="Password"
            disabled={signInMutation.isPending}
            label="Password"
            type="password"
            name="password"
            required
          />
        </Show>
        <Button disabled={signInMutation.isPending} text="Sign in" />
      </form>
      <p class="mt-10 text-center text-sm/6 text-gray-500">
        New?{" "}
        <Link
          to="/register"
          class="font-semibold text-black hover:text-black/75"
        >
          Register
        </Link>
        .
      </p>
    </>
  );
}

const getUserFn = createServerFn({ method: "POST" })
  .validator((data: { id?: number; email: string }) => data)
  .handler(
    async ({ data: { email } }) =>
      await db
        .selectFrom("users")
        .where("email", "=", email)
        .select("email")
        .executeTakeFirstOrThrow(),
  );

const signInFn = createServerFn({ method: "POST" })
  .validator((data: { email: string; password: string }) => data)
  .handler(async ({ data: { email, password } }) => {
    const user = await db
      .selectFrom("users")
      .where("email", "=", email)
      .select(["id", "email", "password", "activatedAt"])
      .executeTakeFirstOrThrow();

    console.log(user);

    if (!(await verifyHash(password, user.password))) {
      throw new Error("Invalid credentials.");
    }

    return { success: true };
  });
