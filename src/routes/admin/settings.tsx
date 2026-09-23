import { useLinkState } from "@solidjs/router";
import { JSX } from "@solidjs/web";
import { ParentProps } from "solid-js";

export default function SettingsLayout(props: ParentProps) {
  return (
    <>
      <nav class="mb-3 flex h-13 items-center gap-3 border-b border-gray-300 text-sm">
        <TabItem text="General" href="/admin/settings" />
        <TabItem text="Membership" href="/admin/settings/membership" />
        <TabItem text="Payment" href="/admin/settings/payment" />
      </nav>
      {props.children}
    </>
  );
}

interface ITabItemProps {
  href: string;
  text: JSX.Element;
}

function TabItem(props: ITabItemProps) {
  const state = useLinkState(() => props.href, { end: true });
  return (
    <a
      class="flex h-full items-center border-b-2 border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 data-[selected=]:border-black data-[selected=]:text-black"
      data-selected={state.current()}
      href={props.href}
    >
      {props.text}
    </a>
  );
}
