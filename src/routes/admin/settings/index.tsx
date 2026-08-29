import { createFileRoute } from "@tanstack/solid-router";
import { For, Loading } from "solid-js";

export const Route = createFileRoute("/admin/settings/")({
  component: RouteComponent,
});

function RouteComponent() {
  const context = Route.useRouteContext();

  return (
    <div class="grid gap-1 font-mono text-sm">
      <Loading fallback={<p>Loading...</p>}>
        <For each={Object.entries(context().settings)}>
          {([key, value]) => (
            <p>
              {key}: {value}
            </p>
          )}
        </For>
      </Loading>
    </div>
  );
}
