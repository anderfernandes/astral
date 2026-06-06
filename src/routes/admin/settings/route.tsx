import {
  createFileRoute,
  Link,
  LinkProps,
  Outlet,
} from "@tanstack/solid-router";
import { JSX } from "@solidjs/web";

export const Route = createFileRoute("/admin/settings")({
  component: RouteComponent,
});

function RouteComponent() {
  return (
    <div>
      <nav class="mb-3 flex h-13 items-center gap-3 border-b border-gray-300 text-sm">
        <TabItem text="General" to="/admin/settings" />
        <TabItem text="Membership" to="/admin/settings/membership" />
        <TabItem text="Payment" to="/admin/settings/payment" />
      </nav>
      <Outlet />
    </div>
  );
}

interface ITabItemProps {
  to?: LinkProps["to"];
  text: JSX.Element;
}

function TabItem({ to, text }: ITabItemProps) {
  return (
    <Link
      class="flex h-full items-center border-b-2 border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 data-[status=active]:border-black data-[status=active]:text-black"
      to={to}
      activeOptions={{ exact: true }}
    >
      {text}
    </Link>
  );
}
