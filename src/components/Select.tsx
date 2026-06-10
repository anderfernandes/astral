import { JSX } from "@solidjs/web";

interface ISelectProps extends Partial<
  Pick<HTMLSelectElement, "name" | "value">
> {
  children: JSX.Element;
  label?: JSX.Element;
}

export function Select(props: ISelectProps) {
  ///const { label, children, ...otherProps } = props;
  return (
    <div>
      <label for="country" class="block text-sm/6 font-medium text-gray-900">
        {props.label}
      </label>
      <div class="mt-2 grid grid-cols-1">
        <select
          id={props.name}
          name={props.name}
          autocomplete={props.name}
          value={props.value}
          class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-black sm:text-sm/6"
        >
          <option value={undefined}>Select one</option>
          {props.children}
        </select>
        <svg
          viewBox="0 0 16 16"
          fill="currentColor"
          data-slot="icon"
          aria-hidden="true"
          class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
        >
          <path
            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
            clip-rule="evenodd"
            fill-rule="evenodd"
          ></path>
        </svg>
      </div>
    </div>
  );
}
