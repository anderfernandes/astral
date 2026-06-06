import { JSX } from "@solidjs/web";

interface IBadgeProps {
  text?: JSX.Element;
  children?: JSX.Element;
}

export function Badge(props: IBadgeProps) {
  return (
    <span class="block rounded-lg bg-gray-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-gray-700">
      {props.text}
      {props.children}
    </span>
  );
}
