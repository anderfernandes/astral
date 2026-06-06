import { createFileRoute, Link } from "@tanstack/solid-router";
import { Button, Input } from "../components";
import { createServerFn, useServerFn } from "@tanstack/solid-start";
import { useMutation } from "@tanstack/solid-query";

export const Route = createFileRoute("/sign-in")({
  component: SignInPage,
});

function SignInPage() {
  const mutation = useMutation(() => ({
    mutationFn: useServerFn(loginFn),
  }));

  return (
    <section class="mx-auto grid h-svh max-w-7xl grid-cols-12">
      <div class="hidden bg-[url('/sky-5114501_1280.jpg')] bg-cover bg-center lg:col-span-8 lg:block">
        left
      </div>
      <div class="col-span-12 content-center p-8 lg:col-span-4">
        <svg
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
          stroke="currentColor"
          stroke-width="1.75"
          class="mx-auto size-16"
        >
          <circle cx="12" cy="12" r="5" fill="black" />
          <path
            stroke="currentColor"
            fill="transparent"
            d="M 3.3357286,6.9976809 6.3405211,6.3405212 6.9976805,3.3357289 9.9284869,4.2690082 12,1.9953613 14.071513,4.2690081 17.002319,3.3357286 17.659479,6.3405211 20.664271,6.9976805 19.730992,9.9284869 22.004639,12 l -2.273647,2.071513 0.933279,2.930806 -3.004792,0.65716 L 17.00232,20.664271 14.071513,19.730992 12,22.004639 9.9284871,19.730992 6.9976809,20.664271 6.3405212,17.659479 3.3357289,17.00232 4.2690082,14.071513 1.9953613,12 4.2690081,9.9284871 Z"
          />
        </svg>
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
      </div>
    </section>
  );
}

const loginFn = createServerFn({ method: "POST" })
  .inputValidator((data: { email: string; password: string }) => data)
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
