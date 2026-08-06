import { useMutation } from "@tanstack/solid-query";
import { createFileRoute, Link } from "@tanstack/solid-router";
import { createServerFn, createServerOnlyFn } from "@tanstack/solid-start";
import { createSignal, Match, Show, Switch } from "solid-js";
import { Alert, Button, Input } from "~components";
import * as UserRepository from "~repositories/UserRepository";
import * as TokenRepository from "~repositories/TokenRepository";
import { toDate } from "~utils/index";

export const Route = createFileRoute("/(auth)/reset")({
  component: RouteComponent,
  validateSearch: (search: { token: string }) => search,
  loaderDeps: ({ search: { token } }) => ({ token }),
  loader: async ({ deps }) => {
    const token = await getAccountRecoveryTokenFn(deps.token);

    if (!token) return { success: false };

    return { success: true };
  },
});

function RouteComponent() {
  const loaderData = Route.useLoaderData();

  const search = Route.useSearch();

  const context = Route.useRouteContext();

  const [errors, setErrors] = createSignal<string[]>([]);

  const mutation = useMutation(() => ({
    mutationFn: (data: AccountResetData) => saveUserFn({ data }),
    onSuccess: () => {
      console.log("success");
    },
    onError: (error) => {
      console.log(error.message);
      setErrors([error.message]);
    },
  }));

  return (
    <>
      <h2 class="my-3 text-center text-xl/9 font-bold tracking-tight text-gray-900">
        Recover
      </h2>
      <span class="mb-8 text-center text-sm/6 text-gray-500">
        {context().settings.name}
      </span>
      <Switch>
        <Match when={!loaderData().success}>
          <Alert variant="error" text="Activation expired or already used." />
        </Match>
        <Match when={loaderData().success === true}>
          <Show
            when={!mutation.data?.success}
            fallback={
              <Alert variant="success" text="Password reset succesfully!" />
            }
          >
            <Show
              when={mutation.error}
              fallback={<Alert text="Enter your new password." />}
            >
              <Alert variant="error" text={mutation.error?.message} />
            </Show>
            <form
              class="grid gap-3"
              onSubmit={(e) => {
                e.preventDefault();

                const formData = new FormData(e.currentTarget);

                mutation.mutate({
                  password: String(formData.get("password")),
                  passwordConfirmation: String(
                    formData.get("passwordConfirmation"),
                  ),
                  token: search().token,
                });
              }}
            >
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
              <Button
                type="submit"
                text="Submit"
                disabled={mutation.isPending}
              />
            </form>
          </Show>
        </Match>
      </Switch>
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

const saveUserFn = createServerFn({ method: "POST" })
  .validator((data: AccountResetData) => {
    if (data.password !== data.passwordConfirmation)
      throw new Error("Password confirmation does not match.");

    return data;
  })
  .handler(async ({ data }) => {
    const token = await TokenRepository.get(data.token);

    if (token === undefined) throw new Error("An error ocurred.");

    if (toDate(token.expiresAt) > new Date())
      throw new Error("Request expired.");

    const user = await UserRepository.get(token.id);

    if (user === undefined)
      throw new Error("Unable to recover account at this moment.");

    await UserRepository.save({ id: user.id, password: user.password });

    return { success: true };
  });

const getAccountRecoveryTokenFn = createServerOnlyFn(
  UserRepository.getAccountRecoveryToken,
);

type AccountResetData = Pick<User, "password"> & {
  token: string;
  passwordConfirmation: string;
};
