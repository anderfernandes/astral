export function Radio() {
  return (
    <div class="flex gap-3">
      <div class="flex h-6 shrink-0 items-center">
        <div class="group grid size-4 grid-cols-1">
          <input
            id="push-everything"
            type="radio"
            name="push-notifications"
            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-black checked:bg-black focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden"
          />
        </div>
      </div>
      <div class="text-sm/6">
        <label for="comments" class="font-medium text-gray-900">
          Comments
        </label>
        <p id="comments-description" class="text-gray-500">
          Get notified when someones posts a comment on a posting.
        </p>
      </div>
    </div>
  );
}
