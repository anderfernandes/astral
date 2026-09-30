import { createMemo, For, Loading } from "solid-js";
import { getOrganizationSettingsFn } from "~lib";

export default function SettingsIndexPage() {
  const organization = createMemo(() => getOrganizationSettingsFn());

  return (
    <section class="grid gap-1 font-mono text-sm">
      <Loading fallback={<p>Loading...</p>}>
        <For each={Object.entries(organization())}>
          {([key, value]) => (
            <p>
              {key}: {value?.toString()}
            </p>
          )}
        </For>
      </Loading>
    </section>
  );
}
