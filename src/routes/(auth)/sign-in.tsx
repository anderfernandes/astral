import { createFileRoute, Link, redirect } from "@tanstack/solid-router";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { useMutation } from "@tanstack/solid-query";
import { Input, Button, Alert } from "~components";
import { createSignal, Show } from "solid-js";
import { db } from "~db";
import { verifyHash } from "~utils/index.server";
import { randomBytes } from "node:crypto";
import { setResponseHeader } from "@tanstack/solid-start/server";
import { Temporal } from "@js-temporal/polyfill";

export const Route = createFileRoute("/(auth)/sign-in")({
  component: SignInPage,
});

function SignInPage() {
  const getUser = useServerFn(getUserFn);

  const getUserMutation = useMutation(() => ({
    mutationFn: (email: string) => getUser({ data: { email } }),
    onSuccess: (data) => {
      setErrors([]);
      setUser(data);
    },
    onError: (data) => {
      setErrors(["Invalid credentials."]);
    },
  }));

  const signIn = useServerFn(signInFn);

  const signInMutation = useMutation(() => ({
    mutationFn: (password: string) =>
      signIn({ data: { email: user()?.email as string, password } }),
    onSuccess: (data) => {
      console.log(data);
      console.log("signed in!");
    },
    onError: (error) => {
      console.log(error.message);
      setErrors([error.message]);
    },
  }));

  const context = Route.useRouteContext();

  const [user, setUser] =
    createSignal<Pick<User, "id" | "email" | "firstName">>();

  const [errors, setErrors] = createSignal<string[]>([]);

  return (
    <>
      <h2 class="text-center text-2xl/9 font-bold tracking-tight text-gray-900">
        <Show when={user()} fallback={<>Sign in to your account</>}>
          Welcome back, {user()?.firstName}!
        </Show>
      </h2>
      <span class="mb-8 text-center text-sm/6 text-gray-500">
        {context().settings.name}
      </span>
      <form
        class="grid w-full max-w-80 gap-3 justify-self-center"
        onSubmit={(e) => {
          e.preventDefault();

          const formData = new FormData(e.currentTarget);

          if (!user()) {
            getUserMutation.mutate(formData.get("email") as string);
            return;
          }

          signInMutation.mutate(formData.get("password") as string);
        }}
      >
        <Show
          when={errors().length > 0}
          fallback={
            <Alert
              text={user() ? "Enter your password." : "Enter your credentials."}
            />
          }
        >
          <Alert text={errors()[0]} variant="error" />
        </Show>
        <Input
          disabled={signInMutation.isPending || user()?.email.length! > 0}
          placeholder="Email"
          label="Email"
          type="email"
          name="email"

          required
        />
        <Show when={user()}>
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
        .select(["id", "email", "firstName"])
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

    //console.log(user);

    if (!(await verifyHash(password, user.password))) {
      throw new Error("Invalid credentials.");
    }

    const token = randomBytes(32).toString("base64url");

    const maxAge = 60 * 60 * 1;

    const expiresAt = Temporal.Now.zonedDateTimeISO("UTC")
      .add({ minutes: maxAge / 60 })
      .toPlainDateTime()
      .toString({ smallestUnit: "seconds" })
      .replace("T", " ");

    //console.log(expiresAt);

    await db
      .insertInto("tokens")
      .values({
        id: token,
        userId: user.id,
        purpose: "authentication",
        expiresAt,
      })
      .executeTakeFirstOrThrow();

    console.log(import.meta.env.PROD ? "PROD" : "NOT PROD");

    setResponseHeader(
      "Set-Cookie",
      import.meta.env.PROD
        ? `__Host-ASTRALSESSID=${token}; HttpOnly; Secure; SameSite=Lax; Path=/; MaxAge=${maxAge}`
        : `ASTRALSESSID=${token}; HttpOnly; Path=/; MaxAge=${maxAge}`,
    );

    throw redirect({ to: "/admin" });
  });
