import { useMutation } from "@tanstack/solid-query";
import { createFileRoute, Link } from "@tanstack/solid-router";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { getRequest } from "@tanstack/solid-start/server";
import { sql } from "kysely";
import { randomBytes } from "node:crypto";
import { createSignal, Match, Show, Switch } from "solid-js";
import { Alert, Button, Input } from "~components";
import { db } from "~db";
import { createHash, encrypt } from "~utils/index.server";
import mailer from "~utils/mailer.server";

export const Route = createFileRoute("/(auth)/register")({
  component: RegisterPage,
});

function RegisterPage() {
  const [errors, setErrors] = createSignal<string[]>([]);

  const mutation = useMutation(() => ({
    mutationFn: useServerFn(registerFn),
    onError: (error) => {
      console.log(error.message);

      setErrors([error.message]);
    },
  }));

  return (
    <>
      <h2 class="my-3 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
        Register
      </h2>
      <Show
        when={!mutation.data?.success}
        fallback={
          <Alert
            variant="success"
            title="Account created!"
            text="We've sent you an account confirmation email."
          />
        }
      >
        <form
          class="grid gap-3"
          onSubmit={(e) => {
            e.preventDefault();

            mutation.mutate({ data: new FormData(e.currentTarget) });
          }}
        >
          <Switch
            fallback={
              <Alert title="Fill out the form below to create an account if you don't have one." />
            }
          >
            <Match when={mutation.error}>
              <Alert
                variant="error"
                text="Fix the errors show below and try again."
              />
            </Match>
          </Switch>
          <div class="grid gap-3 lg:grid-cols-2">
            <Input
              placeholder="First Name"
              label="First Name"
              name="firstName"
              hint="First Name"
              disabled={mutation.isPending}
              required
            />
            <Input
              placeholder="Last Name"
              hint="Last Name"
              label="Last Name"
              name="lastName"
              disabled={mutation.isPending}
              required
            />
          </div>
          <Input
            type="email"
            label="Email"
            name="email"
            placeholder="Email"
            hint="Email"
            required
            errors={errors().filter((e) => e.toLowerCase().includes("email"))}
            disabled={mutation.isPending}
          />
          <Input
            type="email"
            name="emailConfirmation"
            label="Confirm Email"
            placeholder="Confirm Email"
            hint="Confirm Email"
            required
            errors={errors().filter((e) => e.toLowerCase().includes("email"))}
            disabled={mutation.isPending}
          />
          <Input
            name="password"
            type="password"
            label="Password"
            placeholder="Password"
            hint="At least 8 characters, mixed."
            minlength="8"
            required
            errors={errors().filter((e) =>
              e.toLowerCase().includes("password"),
            )}
            disabled={mutation.isPending}
          />
          <Input
            name="passwordConfirmation"
            type="password"
            label="Confirm Password"
            placeholder="Confirm Password"
            hint="At least 8 mixed characters."
            required
            errors={errors().filter((e) =>
              e.toLowerCase().includes("password"),
            )}
            disabled={mutation.isPending}
          />
          <Button text="Register" type="submit" disabled={mutation.isPending} />
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

const registerFn = createServerFn({ method: "POST" })
  .validator((data: FormData) => {
    const email = String(data.get("email"));
    const emailConfirmation = String(data.get("emailConfirmation"));

    if (email !== emailConfirmation) {
      throw new Error("Email confirmation does not match.");
    }

    const password = String(data.get("password"));
    const passwordConfirmation = String(data.get("passwordConfirmation"));

    if (password !== passwordConfirmation) {
      throw new Error("Password confirmation doesn't match.");
    }

    return {
      firstName: String(data.get("firstName")),
      lastName: String(data.get("lastName")),
      email: String(data.get("email")),
      password: String(data.get("password")),
    };
  })
  .handler(async ({ data }) => {
    try {
      await db
        .insertInto("users")
        .values({
          email: data.email,
          firstName: data.firstName,
          lastName: data.lastName,
          password: await createHash(data.password),
          roles: JSON.stringify(["ROLE_USER"]),
        })
        .execute();

      const user = await db
        .selectFrom("users")
        .where("email", "=", data.email)
        .selectAll()
        .executeTakeFirstOrThrow();

      const token = randomBytes(32).toString("base64url");

      const expiresAt = new Date();
      expiresAt.setMinutes(expiresAt.getMinutes() + 15);

      await db
        .insertInto("tokens")
        .values({
          id: token,
          userId: user?.id,
          purpose: "activation",
          expiresAt: (process.env["DB_DRIVER"] === "sqlite"
            ? sql`DATETIME(${expiresAt.toISOString()})`
            : expiresAt) as unknown as string,
        })
        .execute();

      const url = new URL(getRequest().url);

      const res = await mailer.sendMail({
        from: process.env["MAIL_FROM"],
        to: data.email,
        subject: `Activate your ${process.env["NAME"]} account`,
        html: `<h1>Welcome to ${process.env["NAME"]}!</h1><p>Click <a target="_blank" href="${url.origin}/activate?token=${token}">here</a> to activate your account.</p>`,
      });

      console.log(res);

      return { success: true };
    } catch (error) {
      if ((error as Error).message.includes("email"))
        throw new Error("Email already in use.");

      throw new Error(
        "Unable to create an account. Please try again in a few.",
      );
    }
  });
