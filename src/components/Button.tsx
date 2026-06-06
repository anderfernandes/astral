import { Link, LinkProps } from "@tanstack/solid-router";
import { JSX } from "@solidjs/web";

type BaseLinkProps = Partial<Pick<LinkProps, "to" | "search" | "params">>;

type BaseButtonProps = Partial<Pick<HTMLButtonElement, "type" | "disabled">>;

interface IButtonProps extends BaseLinkProps, BaseButtonProps {
  text: JSX.Element;
  variant?: "primary" | "secondary";
}

export function Button(props: IButtonProps) {
  const { text, variant = "primary", type, disabled, ...linkProps } = props;
  return props.to ? (
    <Link
      data-variant={variant}
      class="inline-flex w-full cursor-pointer justify-center rounded-md bg-black px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-black/80 data-[variant=secondary]:bg-white data-[variant=secondary]:text-black data-[variant=secondary]:inset-ring data-[variant=secondary]:inset-ring-gray-300 sm:w-auto"
      {...linkProps}
    >
      {text}
    </Link>
  ) : (
    <button
      data-variant={props.variant}
      class="inline-flex w-full cursor-pointer justify-center rounded-md bg-black px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-black/80 disabled:cursor-not-allowed disabled:bg-black/50 data-[variant=secondary]:bg-white data-[variant=secondary]:text-black data-[variant=secondary]:inset-ring data-[variant=secondary]:inset-ring-gray-300 sm:w-auto"
      disabled={props.disabled}
    >
      {text}
    </button>
  );
}
