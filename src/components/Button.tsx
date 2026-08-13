import { Link, LinkProps } from "@tanstack/solid-router";
import { JSX, Show } from "@solidjs/web";

type BaseLinkProps = Partial<Pick<LinkProps, "to" | "search" | "params">>;

type BaseButtonProps = Partial<
  Pick<
    JSX.ButtonHTMLAttributes<HTMLButtonElement>,
    "type" | "disabled" | "onClick"
  >
>;

interface IButtonProps extends BaseLinkProps, BaseButtonProps {
  text: JSX.Element;
  variant?: "primary" | "secondary";
}

export function Button(props: IButtonProps) {
  return (
    <Show
      when={props.to}
      fallback={
        <button
          data-variant={props.variant ?? "primary"}
          class="inline-flex cursor-pointer justify-center rounded-md bg-black px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-black/95 disabled:cursor-not-allowed disabled:bg-black/50 data-[variant=secondary]:bg-white data-[variant=secondary]:text-black data-[variant=secondary]:inset-ring data-[variant=secondary]:inset-ring-gray-300 disabled:data-[variant=secondary]:opacity-50 sm:w-auto"
          disabled={props.disabled}
          type={props.type}
          onClick={props.onClick}
        >
          {props.text}
        </button>
      }
    >
      <Link
        data-variant={props.variant ?? "primary"}
        class="inline-flex cursor-pointer justify-center rounded-md bg-black px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-black/95 data-[variant=secondary]:bg-white data-[variant=secondary]:text-black data-[variant=secondary]:inset-ring data-[variant=secondary]:inset-ring-gray-300 disabled:data-[variant=secondary]:opacity-50 sm:w-auto"
        search={props.search}
        params={props.params}
        to={props.to}
      >
        {props.text}
      </Link>
    </Show>
  );
}
