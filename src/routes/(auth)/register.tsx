import {
  action,
  query,
  RouteDefinition,
  useSubmissions,
} from "@solidjs/router";
import { createMemo, Show } from "solid-js";
import { Alert, Button, Input } from "~components";
import { getOrganizationSettingsFn } from "~lib";
import db from "~db";
import * as v from "valibot";
import { respond } from "@solidjs/web";

export const route = {
  preload: () => {
    void getOrganizationSettings();
  },
} satisfies RouteDefinition;

const getOrganizationSettings = query(
  getOrganizationSettingsFn,
  "organization-settings",
);

export default function RegisterPage() {
  const organization = createMemo(() => getOrganizationSettings());

  const submissions = useSubmissions(register);

  const submission = () => submissions.at(-1);

  const errors = (k = "") => {
    const issues = submission()?.error?.issues as string[] | undefined;

    console.log(issues);

    if (!issues) return [];

    if (k)
      return issues.filter((issue) =>
        issue.toLowerCase().includes(k.toLowerCase()),
      );

    return issues;
  };

  return (
    <>
      <h2 class="text-center text-xl/9 font-bold tracking-tight text-gray-900">
        Register
      </h2>
      <span class="mb-8 text-center text-sm/6 text-gray-500">
        {organization().name}
      </span>
      <Show
        when={!submission()?.result?.success}
        fallback={
          <Alert
            variant="success"
            title="Account created successfully!"
            text="We've emailed you an account activation link."
          />
        }
      >
        <Show
          when={submission()?.error.message}
          fallback={
            <Alert text="Fill out the form below to create an account if you don't have one." />
          }
        >
          <Alert variant="error" text={submission()?.error.message} />
        </Show>
        <form action={register} method="post" class="grid gap-3">
          <div class="grid grid-cols-2 gap-3">
            <Input
              placeholder="First Name"
              label="First Name"
              name="firstName"
              hint="First Name"
              required
              errors={errors("first name")}
            />
            <Input
              placeholder="Last Name"
              hint="Last Name"
              label="Last Name"
              name="lastName"
              required
              errors={errors("last name")}
            />
          </div>
          <Input
            type="email"
            label="Email"
            name="email"
            placeholder="Email"
            hint="Email"
            required
            errors={errors("email")}
          />
          <Input
            type="email"
            name="emailConfirmation"
            label="Confirm Email"
            placeholder="Confirm Email"
            hint="Confirm Email"
            required
            errors={errors("email")}
          />
          <Input
            name="password"
            type="password"
            label="Password"
            placeholder="Password"
            hint="At least 8 characters, mixed."
            minlength="8"
            required
            errors={errors("password")}
          />
          <Input
            name="passwordConfirmation"
            type="password"
            label="Confirm Password"
            placeholder="Confirm Password"
            hint="At least 8 mixed characters."
            required
            errors={errors("password")}
          />
          <div class="my-4 grid">
            <Button text="Register" type="submit" />
          </div>
        </form>
      </Show>
      <p class="mt-10 text-center text-sm/6 text-gray-500">
        Already have an account?{" "}
        <a href="/sign-in" class="font-semibold text-black hover:text-black/75">
          Sign In
        </a>
        .
      </p>
    </>
  );
}

const RegistrationSchema = v.pipe(
  v.object({
    firstName: v.pipe(v.string(), v.minLength(2), v.maxLength(255)),
    lastName: v.pipe(v.string(), v.minLength(2), v.maxLength(255)),
    email: v.pipe(v.string(), v.email(), v.maxLength(255)),
    emailConfirmation: v.pipe(v.string(), v.email()),
    password: v.pipe(v.string(), v.minLength(8), v.maxLength(255)),
    passwordConfirmation: v.pipe(v.string(), v.minLength(8), v.maxLength(255)),
  }),
  v.forward(
    v.partialCheck(
      [["password"], ["passwordConfirmation"]],
      (input) => input.password === input.passwordConfirmation,
      "Password and Confirm Password do not match.",
    ),
    ["passwordConfirmation"],
  ),
  v.forward(
    v.partialCheck(
      [["email"], ["emailConfirmation"]],
      (input) => input.email === input.emailConfirmation,
      "Email and Email Confirmation do not match.",
    ),
    ["emailConfirmation"],
  ),
);

const register = action(async (formData: FormData) => {
  "use server";

  const { output, success, issues } = v.safeParse(RegistrationSchema, {
    firstName: String(formData.get("firstName")),
    lastName: String(formData.get("lastName")),
    email: String(formData.get("email")),
    emailConfirmation: String(formData.get("emailConfirmation")),
    password: String(formData.get("password")),
    passwordConfirmation: String(formData.get("passwordConfirmation")),
  });

  if (!success) {
    throw respond(
      {
        message: "Please fix the errors and try again.",
        issues: issues.map(({ message }) => message),
      },
      { status: 400 },
    );
  }

  const { emailConfirmation, passwordConfirmation, ...user } = output;

  try {
    await db.users.create(user);

    // TODO: EMAIL TOKEN TO USER
    console.log(await db.tokens.create("account activation", user.email));
  } catch (e) {
    const message = (e as Error).message;

    if (message.toLocaleLowerCase().includes("email"))
      throw respond({ message, issues: [message] }, { status: 400 });

    console.error(message);

    throw respond({ message: "Unable to create an account." }, { status: 400 });
  }

  return respond({ success: true }, { status: 200 });
});
