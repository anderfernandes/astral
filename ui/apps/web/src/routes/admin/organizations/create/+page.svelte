<script lang="ts">
	import { AAlert, AButton, AInput, ASelect } from 'ui';
	import { applyAction, enhance } from '$app/forms';

	const { data, form } = $props();
	let loading = $state(false);
</script>

<svelte:head>
	<title>New Organization | Astral</title>
</svelte:head>

<header
	class="sticky top-0 -mx-6 flex h-16 items-center gap-3 bg-background/50 px-6 font-semibold backdrop-blur"
>
	<a href="/admin/organizations" aria-label="back">
		<svg
			xmlns="http://www.w3.org/2000/svg"
			width="24"
			height="24"
			viewBox="0 0 24 24"
			fill="none"
			stroke="currentColor"
			stroke-width="2"
			stroke-linecap="round"
			stroke-linejoin="round"
			class="size-6"
		>
			<path d="m12 19-7-7 7-7" />
			<path d="M19 12H5" />
		</svg>
	</a>
	<h2 class="grow">New Organizations</h2>
</header>

{#if form?.message}
	<div class="space-y-1">
		<AAlert title={form.message} type="error" />
	</div>
{/if}
<form
	method="post"
	class="grid gap-6 lg:w-[calc(100%-20rem)]"
	use:enhance={() => {
		loading = true;
		return async ({ result, update }) => {
			console.log(result.status);
			if (result.status! >= 400) {
				loading = false;
			} else await applyAction(result);
			await update();
		};
	}}
>
	<AInput
		name="name"
		required
		label="Name"
		hint="The full name of the organization"
		placeholder="Name"
	/>
	<AInput
		name="address"
		required
		label="Address"
		hint="Address of the organization"
		placeholder="Address"
	/>
	<AInput name="city" required placeholder="City" label="City" />
	<ASelect
		required
		label="State"
		disabled
		value="Texas"
		options={[{ text: 'Texas', value: 'Texas' }]}
	/>
	<input type="hidden" name="state" value="Texas" />
	<AInput name="zip" required label="ZIP" placeholder="ZIP" />
	<AInput
		type="tel"
		name="phone"
		required
		label="Phone"
		placeholder="Phone"
		hint="Phone"
		maxlength={10}
	/>
	<AInput
		type="tel"
		name="fax"
		label="Fax"
		placeholder="Fax"
		hint="Fax or secondary phone"
		maxlength={10}
	/>
	<AInput
		name="email"
		type="email"
		required
		label="Email"
		placeholder="Email"
		hint="Main email of the organization"
	/>
	<AInput type="url" name="website" label="Website" placeholder="Website" hint="Website" />
	<ASelect
		name="type_id"
		required
		label="Type"
		placeholder="Type"
		hint="Type"
		options={data.organization_types}
	/>
	<div class="flex justify-end gap-3">
		<AButton text="Reset" type="reset" variant="secondary" />
		<AButton text="Save" {loading} />
	</div>
</form>
