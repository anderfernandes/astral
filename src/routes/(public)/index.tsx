import { createFileRoute, Link } from "@tanstack/solid-router";
import { Button } from "~components";

export const Route = createFileRoute("/(public)/")({
  component: IndexPage,
});

function IndexPage() {
  return (
    <section class="relative isolate h-screen bg-[url(/sky-5114501_1280.jpg)] bg-cover bg-center px-6 pt-14 lg:px-8">
      <div class="absolute top-0 left-0 -z-10 h-screen w-screen bg-white/85">
        &nbsp;
      </div>
      <div
        aria-hidden="true"
        class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
      >
        <div
          style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
          class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-black to-gray-100 opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75"
        >
          &nbsp;
        </div>
      </div>
      <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
        <div class="hidden sm:mb-8 sm:flex sm:justify-center">
          <div class="relative rounded-full px-3 py-1 text-sm/6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
            Memberships and Tickets now available for purchase online.{" "}
            <a href="#" class="font-semibold text-black">
              <span aria-hidden="true" class="absolute inset-0"></span>Read more{" "}
              <span aria-hidden="true">&rarr;</span>
            </a>
          </div>
        </div>
        <div class="text-center">
          <h1 class="text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-7xl">
            To inspire the explorer in everyone.
          </h1>
          <p class="mt-8 text-lg font-medium text-pretty text-gray-500 sm:text-xl/8">
            We connecting our community to the wonders of science, space, and
            discovery through experiences that educate, entertain, and inspire.
          </p>
          <div class="mt-10 flex items-center justify-center gap-x-6">
            <Button to="/" text="Events" />
            <Link to="/" class="text-sm/6 font-semibold text-gray-900">
              Learn more <span aria-hidden="true">→</span>
            </Link>
          </div>
        </div>
      </div>
      <div
        aria-hidden="true"
        class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
      >
        <div
          style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
          class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-gray-100 to-black opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75"
        ></div>
      </div>
    </section>
  );
}
