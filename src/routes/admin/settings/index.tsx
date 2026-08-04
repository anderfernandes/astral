import { createFileRoute } from "@tanstack/solid-router";

export const Route = createFileRoute("/admin/settings/")({
  component: RouteComponent,
});

function RouteComponent() {
  const context = Route.useRouteContext();

  return <div>{context().settings.database}</div>;
}
