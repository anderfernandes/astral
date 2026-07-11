import { JSX } from "@solidjs/web/jsx-runtime";
import { Match, Show, Switch } from "solid-js";

interface IAlertProps {
  variant?: "primary" | "warning" | "error" | "success";
  title?: JSX.Element;
  text?: JSX.Element;
}

export function Alert(props: IAlertProps) {
  return (
    <div
      data-variant={props.variant}
      class="group my-4 rounded-md bg-gray-100 p-4 data-[variant=error]:bg-red-50 data-[variant=success]:bg-green-50"
    >
      <div class="flex">
        <div class="shrink-0">
          <svg
            class="size-5 text-black group-data-[variant=error]:text-red-400 group-data-[variant=success]:text-green-400"
            viewBox="0 0 20 20"
            fill="currentColor"
            aria-hidden="true"
            data-slot="icon"
          >
            <Switch
              fallback={
                <path
                  d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z"
                  clip-rule="evenodd"
                  fill-rule="evenodd"
                />
              }
            >
              <Match when={props.variant === "success"}>
                <path
                  d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                  clip-rule="evenodd"
                  fill-rule="evenodd"
                />
              </Match>
              <Match when={props.variant === "error"}>
                <path
                  d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
                  clip-rule="evenodd"
                  fill-rule="evenodd"
                />
              </Match>
              <Match when={props.variant === "warning"}>
                <path
                  d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                  clip-rule="evenodd"
                  fill-rule="evenodd"
                />
              </Match>
            </Switch>
          </svg>
        </div>
        <div class="ml-3 flex-1 md:flex md:justify-between">
          <Show when={props.title}>
            <p class="text-sm text-black group-data-[variant=error]:text-red-800 group-data-[variant=success]:text-green-800">
              {props.title}
            </p>
          </Show>
          <Show when={props.text}>
            <p class="mt-2 text-sm text-gray-700 group-data-[variant=error]:text-red-700 group-data-[variant=success]:text-green-700 md:mt-0 md:ml-6">
              {props.text}
            </p>
          </Show>
        </div>
      </div>
    </div>
  );
}
