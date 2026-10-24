import { JSX } from "@solidjs/web/jsx-runtime";
import { Show } from "solid-js";

export function Header(props: { title?: JSX.Element; children?: JSX.Element }) {
  return (
    <header class="fixed top-0 left-64 flex h-16 w-[calc(100vw-18rem)] items-center bg-white/50 p-4">
      <Show
        when={props.children}
        fallback={<span class="text-base/6 font-bold">{props.title}</span>}
      >
        {props.children}
      </Show>
    </header>
  );
}
