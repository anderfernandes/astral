import { JSX } from "@solidjs/web/jsx-runtime";
import { Show } from "solid-js";

interface IAlertProps {
  variant?: "primary" | "warning" | "error" | "success";
  text: JSX.Element;
}

export function Alert(props: IAlertProps) {
  return (
    <div
      data-variant={props.variant}
      class="group my-4 rounded-md bg-gray-100 p-4 data-[variant=error]:bg-red-50"
    >
      <div class="flex">
        <div class="shrink-0">
          <svg
            class="size-5 text-black group-data-[variant=error]:text-red-400"
            viewBox="0 0 20 20"
            fill="currentColor"
            aria-hidden="true"
            data-slot="icon"
          >
            <path
              d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
              clip-rule="evenodd"
              fill-rule="evenodd"
            />
          </svg>
        </div>
        <div class="ml-3 flex-1 md:flex md:justify-between">
          <Show when={props.text}>
            <p class="text-sm text-black group-data-[variant=error]:text-red-700">
              {props.text}
            </p>
          </Show>
          {/* <p class="mt-3 text-sm md:mt-0 md:ml-6">
            <a
              href="#"
              class="font-medium whitespace-nowrap text-blue-700 hover:text-blue-600"
            >
              Details
              <span aria-hidden="true"> &rarr;</span>
            </a>
          </p> */}
        </div>
      </div>
    </div>
  );
}
