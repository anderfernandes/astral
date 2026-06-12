import { createFileRoute, Link } from "@tanstack/solid-router";
import { Button, Input } from "../../components";

export const Route = createFileRoute("/(auth)/register")({
  component: RegisterPage,
});

function RegisterPage() {
  return (
    <>
      <h2 class="my-3 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
        Register
      </h2>
      <form class="grid w-full max-w-xs gap-3">
        <div class="grid gap-3 lg:grid-cols-2">
          <Input placeholder="First Name" label="First Name" name="firstName" />
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
    </>
  );
}
