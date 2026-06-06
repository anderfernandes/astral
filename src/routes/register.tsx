import { createFileRoute, Link } from "@tanstack/solid-router";
import { Button, Input } from "../components";

export const Route = createFileRoute("/register")({
  component: RegisterPage,
});

function RegisterPage() {
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
        <h2 class="my-3 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
          Register
        </h2>
        <form class="grid gap-3">
          <div class="grid gap-3 lg:grid-cols-2">
            <Input
              placeholder="First Name"
              label="First Name"
              name="firstName"
            />
            <Input placeholder="Last Name" label="Last Name" name="lastName" />
          </div>
          <Input type="email" label="Email" placeholder="Email" />
          <Input
            type="email"
            name="emailConfirmation"
            label="Confirm Email"
            placeholder="Confirm Email"
          />
          <Input type="password" label="Password" placeholder="Password" />
          <Input
            type="passwordConfirmation"
            label="Confirm Password"
            placeholder="Password"
          />
          <Button text="Register" />
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
      </div>
    </section>
  );
}
