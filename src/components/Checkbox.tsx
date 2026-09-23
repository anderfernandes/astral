import { Show } from "solid-js";
import { JSX } from "@solidjs/web";

interface ICheckboxProps extends Partial<
  Pick<HTMLInputElement, "name" | "value" | "checked">
> {
  label: JSX.Element;
  hint?: JSX.Element;
}

export function Checkbox(props: ICheckboxProps) {
  return (
    <div class="flex gap-3">
      <div class="flex h-6 shrink-0 items-center">
        <div class="group grid size-4 grid-cols-1">
          <input
            id={props.name}
            name={props.name}
            value={props.value}
            checked={props.checked}
            type="checkbox"
            aria-describedby={props.name}
            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-black checked:bg-black indeterminate:border-black indeterminate:bg-black focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto"
          />
          <svg
            viewBox="0 0 14 14"
            fill="none"
            class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25"
          >
            <path
              d="M3 8L6 11L11 3.5"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="opacity-0 group-has-checked:opacity-100"
            />
            <path
              d="M3 7H11"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="opacity-0 group-has-indeterminate:opacity-100"
            />
          </svg>
        </div>
      </div>
      <div class="text-sm/6">
        <label for={props.name} class="font-medium text-gray-900">
          {props.label}
        </label>
        <Show when={props.hint}>
          <p id="comments-description" class="text-gray-500">
            {props.hint}
          </p>
        </Show>
      </div>
    </div>
  );
}
