import { createFileRoute } from "@tanstack/solid-router";

export const Route = createFileRoute("/admin/settings/")({
  component: RouteComponent,
  loader: () => ({ DB_DRIVER: process.env["DB_DRIVER"] as string }),
});

function RouteComponent() {
  const loaderData = Route.useLoaderData();
  return <div>{loaderData().DB_DRIVER}</div>;
}
