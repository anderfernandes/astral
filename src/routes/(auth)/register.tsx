import { useMutation } from "@tanstack/solid-query";
import { createFileRoute, Link } from "@tanstack/solid-router";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { createSignal, Match, Switch } from "solid-js";
import { Alert, Button, Input } from "~components";

export const Route = createFileRoute("/(auth)/register")({
  component: RegisterPage,
});

function RegisterPage() {
  const mutation = useMutation(() => ({
    mutationFn: useServerFn(registerFn),
  }));

  return (
    <>
      <h2 class="my-3 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
        Register
      </h2>
      <form
        class="grid w-full max-w-xs gap-3"
        onSubmit={(e) => {
          e.preventDefault();

          mutation.mutate({ data: new FormData(e.currentTarget) });
        }}
      >
        <Switch
          fallback={
            <Alert text="Fill out the form below to create an account if you don't have one." />
          }
        >
          <Match when={mutation.data?.errors}>
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
            required
            value="Anderson"
          />
          <Input
            placeholder="Last Name"
            hint="Last Name"
            label="Last Name"
            name="lastName"
          />
        </div>
        <Input
          type="email"
          label="Email"
          name="email"
          placeholder="Email"
          required

          errors={mutation.data?.errors?.email}
        />
        <Input
          type="email"
          name="emailConfirmation"
          label="Confirm Email"
          placeholder="Confirm Email"
          required

          errors={mutation.data?.errors?.email}
        />
        <Input
          type="password"
          label="Password"
          placeholder="Password"
          required
        />
        <Input
          name="passwordConfirmation"
          type="password"
          label="Confirm Password"
          placeholder="Password"
          required
        />
        <Button text="Register" type="submit" />
      </form>
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
      return {
        errors: {
          email: ["Email confirmation does not match."],
        },
      };
    }

    const password = String(data.get("password"));
    const passwordConfirmation = String(data.get("passwordConfirmation"));

    if (password !== passwordConfirmation) {
      return {
        errors: {
          password: ["Password confirmation doesn't match."],
        },
      };
    }
    return {
      firstName: String(data.get("firstName")),
      lastName: String(data.get("lastName")),
      email: String(data.get("email")),
      password: String(data.get("password")),
    };
  })
  .handler(({ data }) => data);
