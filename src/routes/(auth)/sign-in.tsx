import {
  action,
  query,
  RouteDefinition,
  useSubmissions,
} from "@solidjs/router";
import { createEffect, createMemo, Show } from "solid-js";
import { Alert, Button, Input } from "~components";
import { decrypt, encrypt, getOrganizationSettingsFn } from "~lib";
import * as v from "valibot";
import db from "~db";
import { getRequestEvent, redirect, respond } from "@solidjs/web";
import { createCookie } from "@remix-run/cookie";

export const route = {
  preload: () => {
    void getOrganizationSettingsFn();
    void getSigninSession();
  },
} satisfies RouteDefinition;

export default function SigninPage() {
  const user = createMemo(() => getSigninSession());

  const organization = createMemo(() => getOrganizationSettingsFn());

  const submissions = useSubmissions(signin);

  const submission = () => submissions?.at(-1);

  let passwordInput!: HTMLInputElement;

  createEffect(
    () => user(),
    () => {
      if (passwordInput) passwordInput.focus();
    },
  );

  return (
    <>
      <h2 class="text-center text-xl/9 font-bold tracking-tight text-gray-900">
        <Show when={user()} fallback={<>Sign In</>}>
          Welcome back, {user()?.firstName}!
        </Show>
      </h2>
      <span class="mb-8 text-center text-sm/6 text-gray-500">
        {organization().name}
      </span>
      <Show
        when={submission()?.error?.issues?.length > 0}
        fallback={<Alert text="Enter your credentials." />}
      >
        <Alert variant="error" text={submission()?.error?.message} />
      </Show>
      <form
        action={signin}
        method="post"
        class="grid w-full max-w-80 gap-3 justify-self-center"
      >
        <Input
          placeholder="Email"
          label="Email"
          type="email"
          name="email"
          min={3}
          max={127}
          hint="The email from your account."
          errors={submission()?.error?.issues}
          required
          value={user()?.email}
          disabled={user()?.email ? true : false}
        />
        <Show when={user()}>
          <Input
            type="password"
            name="password"
            label="Password"
            placeholder="Password"
            required
            hint="Password"
            errors={submission()?.error?.issues}
            ref={(el) => {
              passwordInput = el;
            }}
          />
        </Show>
        <Button text="Sign In" />
        <p class="mt-10 text-center text-sm/6 text-gray-500">
          New?{" "}
          <a
            href="/register"
            class="font-semibold text-black hover:text-black/75"
          >
            Register
          </a>
          .
        </p>
        <p class="text-center text-sm/6 text-gray-500">
          <a
            href="/recover"
            class="font-semibold text-black hover:text-black/75"
          >
            I forgot my password
          </a>
          .
        </p>
      </form>
    </>
  );
}

const SigninSchema = v.pipe(
  v.object({
    email: v.pipe(v.string(), v.email(), v.minLength(8), v.maxLength(255)),
    password: v.pipe(v.string(), v.minLength(8), v.maxLength(255)),
  }),
);

const signin = action(async (formData: FormData) => {
  "use server";

  if (!formData.has("password")) {
    console.info("sign in");

    const { output, success, issues } = v.safeParse(
      SigninSchema.entries.email,
      formData.get("email"),
    );

    if (!success)
      throw respond(
        { message: "Invalid email.", issues: "Invalid email." },
        { status: 400 },
      );

    const user = await db.users.findBy({ email: output as string });

    if (!user) {
      console.log("user not found");

      const message = "Invalid credentials.";

      throw respond({ message, issues: [message] }, { status: 400 });
    }

    if (!user.activatedAt) {
      console.log("account not active");

      const message = "Invalid credentials.";

      throw respond({ message, issues: [message] }, { status: 400 });
    }

    console.log("user: ", user);

    try {
      const { iv, cipherString, tag } = await encrypt(user.email);

      const token = `${iv}:${cipherString}:${tag}`;

      const maxAge = 60 * 5; // 5 minutes

      console.log("token generated: ", token);

      getRequestEvent()?.response.headers.append(
        "set-cookie",
        import.meta.env.PROD
          ? `__Host-ASTRALSIGNINSESSION=${token}; HttpOnly; Secure; SameSite=Lax; Path=/; Max-Age=${maxAge}`
          : `ASTRALSIGNINSESSION=${token}; HttpOnly; Path=/; Max-Age=${maxAge}`,
      );

      return respond({ success: true }, { status: 200 });
    } catch (e) {
      const error = e as Error;
      console.error(error.message, error.stack);
    }
  }

  const { output, success, issues } = v.safeParse(
    SigninSchema.entries.password,
    formData.get("password"),
  );

  if (!success) {
    console.error("Validation failed.");

    throw respond({ message: "Invalid password." }, { status: 400 });
  }

  const token = (getRequestEvent()?.request.headers.get("cookie") as string)
    .split("=")
    .at(1);

  if (!token) {
    console.error("Invalid token.");

    throw respond({ message: "Invalid credentials." }, { status: 400 });
  }

  const [iv, cipherString, tag] = token.split(":");

  const email = await decrypt({ iv, cipherString, tag });

  if (!email) {
    console.error("Invalid email");

    throw respond({ message: "Invalid credentials." }, { status: 400 });
  }

  try {
    const data = await db.users.signin({
      email,
      password: output,
    });

    getRequestEvent()?.response.headers.append(
      "set-cookie",
      import.meta.env.PROD
        ? "__Host-ASTRALSIGNINSESSION=; HttpOnly; Secure; SameSite=Lax; Path=/; Max-Age=0"
        : "ASTRALSIGNINSESSION=; HttpOnly; Path=/; Max-Age=0",
    );

    const maxAge = 60 * 60; // 1 hour

    getRequestEvent()?.response.headers.append(
      "set-cookie",
      import.meta.env.PROD
        ? `__Host-ASTRALSESSION=${data}; HttpOnly; Secure; SameSite=Lax; Path=/; Max-Age=${maxAge}`
        : `ASTRALSESSION=${data}; HttpOnly; Path=/; Max-Age=${maxAge}`,
    );

    return redirect("/admin");
  } catch (e) {
    console.log((e as Error).message, output);

    throw respond(
      { message: "Invalid credentials.", issues: ["Invalid credentials."] },
      { status: 400 },
    );
  }

  // if (!data) {
  //   console.error("Invalid user token.");

  //   throw respond({ message: "Invalid credentials." }, { status: 400 });
  // }

  // console.log("token: ", data);

  // CHECK IF SINGINSESSION cookie still exist. If it doesn't, make user enter email again

  // TODO: CLEAR ASTRALSIGNINSESSION cookie
});

const getSigninSession = query(async () => {
  "use server";

  if (getRequestEvent()?.request.headers.has("cookie")) {
    const token = (getRequestEvent()?.request.headers.get("cookie") as string)
      ?.split("=")
      ?.at(1);

    if (!token) return null;

    const [iv, cipherString, tag] = token.split(":");

    const email = await decrypt({ iv, cipherString, tag });

    if (!email) return null;

    const user = await db.users.findBy({ email });

    if (!user) return null;

    return user;
  }

  return null;
}, "getSigninSession");
