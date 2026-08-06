import { useMutation } from "@tanstack/solid-query";
import { createFileRoute, Link } from "@tanstack/solid-router";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { getRequest } from "@tanstack/solid-start/server";
import { createSignal, Match, Show, Switch } from "solid-js";
import { Alert, Button, Input } from "~components";
import * as UserRepository from "~repositories/UserRepository";

export const Route = createFileRoute("/(auth)/register")({
  component: RegisterPage,
});

function RegisterPage() {
  const [errors, setErrors] = createSignal<string[]>([]);

  const register = useServerFn(registerFn);

  const mutation = useMutation(() => ({
    mutationFn: (data: IRegistrationData) => register({ data }),
    onError: (error) => {
      setErrors([error.message]);
    },
  }));

  const context = Route.useRouteContext();

  return (
    <>
      <h2 class="text-center text-xl/9 font-bold tracking-tight text-gray-900">
        Register
      </h2>
      <span class="mb-8 text-center text-sm/6 text-gray-500">
        {context().settings.name}
      </span>
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

            const formData = new FormData(e.currentTarget);

            mutation.mutate({
              firstName: String(formData.get("firstName")),
              firstNameConfirmation: String(
                formData.get("firstNameConfirmation"),
              ),
              lastName: String(formData.get("lastName")),
              lastNameConfirmation: String(
                formData.get("lastNameConfirmation"),
              ),
              email: String(formData.get("email")),
              emailConfirmation: String(formData.get("emailConfirmation")),
              password: String(formData.get("password")),
              passwordConfirmation: String(
                formData.get("passwordConfirmation"),
              ),
            });
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
            <div class="grid grid-cols-2 gap-3 lg:col-span-2">
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
  .validator((data: IRegistrationData) => {
    if (data.email !== data.emailConfirmation) {
      throw new Error("Email confirmation does not match.");
    }

    if (data.password !== data.passwordConfirmation) {
      throw new Error("Password confirmation doesn't match.");
    }

    return data;
  })
  .handler(
    async ({ data }) =>
      await UserRepository.register(data, new URL(getRequest().url).origin),
  );
