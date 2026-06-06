import { createFileRoute, Link } from "@tanstack/solid-router";

export const Route = createFileRoute("/")({
  component: IndexPage,
});

function IndexPage() {
  return (
    <section class="p-4">
      <Link
        to="/sign-in"
        class="rounded-md bg-black px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-black/75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
      >
        Sign in
      </Link>
    </section>
  );
}
