import { createFileRoute, Link } from "@tanstack/solid-router";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { useMutation } from "@tanstack/solid-query";
import { Input, Button } from "~components";

export const Route = createFileRoute("/(auth)/sign-in")({
  component: SignInPage,
});

function SignInPage() {
  const mutation = useMutation(() => ({
    mutationFn: useServerFn(loginFn),
  }));

  return (
    <>
      <h2 class="my-4 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
        Sign in to your account
      </h2>
      <form
        class="grid gap-3"
        onSubmit={async (e) => {
          e.preventDefault();

          const formData = new FormData(e.currentTarget);

          const res = await mutation.mutateAsync({
            data: {
              email: formData.get("email") as string,
              password: formData.get("password") as string,
            },
          });

          console.log(res);
        }}
      >
        <Input
          disabled={mutation.isPending}
          placeholder="Email"
          label="Email"
          type="email"
          name="email"
        />
        <Input
          placeholder="Password"
          disabled={mutation.isPending}
          label="Password"
          type="password"
          name="password"
        />
        <Button disabled={mutation.isPending} text="Sign in" />
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

const loginFn = createServerFn({ method: "POST" })
  .validator((data: { email: string; password: string }) => data)
  .handler(async ({ data }) => {
    const url = new URL("/login", "http://localhost:8000");

    const req = await fetch(url, {
      method: "POST",
      body: JSON.stringify(data),
      headers: { "content-type": "application/json" },
    });

    console.log(req.status, req.url);

    if (req.status >= 500) {
      console.error(await req.json());

      return { message: "Invalid credentials.", success: false };
    }

    if (req.status > 299) {
      console.error(await req.json());
      return { message: "Invalid credentials.", success: false };
    }

    return { success: true };
  });
