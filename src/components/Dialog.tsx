import { JSX } from "@solidjs/web/jsx-runtime";
import { Link } from "@tanstack/solid-router";

interface IDialogProps {
  title?: JSX.Element;
  subtitle?: JSX.Element;
  children?: JSX.Element;
  footer?: JSX.Element;
}

export function Dialog(props: IDialogProps) {
  return (
    <dialog
      open={true}
      id="dialog"
      aria-labelledby="dialog-title"
      class="fixed inset-0 z-10 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent"
    >
      <div
        id="backdrop"
        class="fixed inset-0 bg-black/75 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"
      ></div>

      <div
        tabindex="0"
        class="flex min-h-full items-center justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0"
      >
        <div
          id="panel"
          class="relative w-96 transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95 lg:max-w-96"
        >
          <div class="bg-white px-5 pt-5 pb-4 sm:pb-4">
            <div class="grid">
              {/* <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                <svg
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.5"
                  data-slot="icon"
                  aria-hidden="true"
                  class="size-6 text-red-600"
                >
                  <path
                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </div> */}
              <div class="absolute right-0 pr-5">
                <Link to="." class="text-gray-400">
                  <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    data-slot="icon"
                    aria-hidden="true"
                    class="size-6"
                  >
                    <path
                      d="M6 18 18 6M6 6l12 12"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    ></path>
                  </svg>
                </Link>
              </div>
              <div class="text-center sm:mt-0 sm:text-left">
                <h3
                  id="dialog-title"
                  class="text-base font-semibold text-gray-900"
                >
                  {props.title}
                </h3>
                <div>
                  <p class="text-sm text-gray-500">{props.subtitle}</p>
                </div>
              </div>
              <div class="-mx-5 mt-2 -mb-4 grid max-h-96 overflow-y-auto px-5 pb-6">
                {props.children}
              </div>
            </div>
          </div>
          {/* <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            <button
              type="button"
              command="close"
              commandfor="dialog"
              class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto"
            >
              Deactivate
            </button>
            <button
              type="button"
              command="close"
              commandfor="dialog"
              class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
            >
              Cancel
            </button>
          </div> */}
        </div>
      </div>
    </dialog>
  );
}
