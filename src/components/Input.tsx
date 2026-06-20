import { JSX, Show } from "@solidjs/web";

interface IInputProps extends Partial<
  Pick<
    JSX.HTMLElementTags["input"],
    | "type"
    | "name"
    | "placeholder"
    | "disabled"
    | "required"
    | "min"
    | "max"
    | "minlength"
    | "maxlength"
    | "value"
    | "defaultValue"
  >
> {
  label?: JSX.Element;
  hint?: JSX.Element;
}

export function Input(props: IInputProps) {
  return (
    <div>
      <label for="email" class="block text-sm font-medium text-gray-900">
        {props.label}
        <Show when={props.required}>
          <span class="ml-1 text-red-500">*</span>
        </Show>
      </label>
      <div class="mt-2">
        <Show
          when={props.value === undefined}
          fallback={
            <input
              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-black disabled:cursor-not-allowed disabled:bg-gray-100 sm:text-sm/6"
              type={props.type}
              name={props.name}
              placeholder={props.placeholder}
              disabled={props.disabled}
              required={props.required}
              min={props.min}
              max={props.max}
              minlength={props.minlength}
              maxlength={props.maxlength}
              value={props.value}
            />
          }
        >
          <input
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-black disabled:cursor-not-allowed disabled:bg-gray-100 sm:text-sm/6"
            type={props.type}
            name={props.name}
            placeholder={props.placeholder}
            disabled={props.disabled}
            required={props.required}
            min={props.min}
            max={props.max}
            minlength={props.minlength}
            maxlength={props.maxlength}
            defaultValue={props.defaultValue}
          />
        </Show>
      </div>
      <Show when={props.hint}>
        <span class="text-sm text-gray-500">{props.hint}</span>
      </Show>
    </div>
  );
}
