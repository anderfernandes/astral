import { createFileRoute } from "@tanstack/solid-router";
import { Show } from "solid-js";
import { JSX } from "@solidjs/web";

export const Route = createFileRoute("/admin/")({
  component: RouteComponent,
});

function RouteComponent() {
  return <p>Dashboard</p>;
}
