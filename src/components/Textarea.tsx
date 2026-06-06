import { JSX, Show } from "@solidjs/web";

interface ITextareaProps extends Partial<
  Pick<
    JSX.HTMLElementTags["textarea"],
    "name" | "placeholder" | "required" | "value"
  >
> {
  label?: JSX.Element;
  hint?: JSX.Element;
}

export function Textarea(props: ITextareaProps) {
  return (
    <div class="col-span-full">
      <label for="about" class="block text-sm/6 font-medium text-gray-900">
        {props.label}
        <Show when={props.required}>
          <span class="ml-1 text-red-500">*</span>
        </Show>
      </label>
      <Show when={props.hint}>
        <p class="text-sm/6 text-gray-600">{props.hint}</p>
      </Show>
      <div class="mt-2">
        <textarea
          id={props.name}
          name={props.name}
          placeholder={props.placeholder}
          required={props.required}
          value={props.value}
          rows="3"
          class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-black sm:text-sm/6"
        ></textarea>
      </div>
    </div>
  );
}
