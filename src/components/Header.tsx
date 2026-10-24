import { JSX } from "@solidjs/web/jsx-runtime";
import { Show } from "solid-js";

export function Header(props: { title?: JSX.Element; children?: JSX.Element }) {
  return (
    <header class="fixed top-0 left-0 flex h-16 w-screen items-center bg-white/50 p-4 backdrop-blur-sm lg:left-64 lg:w-[calc(100vw-18rem)]">
      <Show
        when={props.children}
        fallback={<span class="text-base/6 font-bold">{props.title}</span>}
      >
        {props.children}
      </Show>
    </header>
  );
}
