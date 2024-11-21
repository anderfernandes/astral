<script lang="ts">
	import { applyAction, enhance } from '$app/forms';
	import { AButton, ACheckbox, AInput, ASelect } from 'ui';

	const { form } = $props();
	let loading = $state(false);
</script>

<svelte:head>
	<title>New User | Astral</title>
</svelte:head>

<header
	class="sticky top-0 -mx-6 flex h-16 items-center gap-3 bg-background/50 px-6 font-semibold backdrop-blur"
>
	<a href="/admin/users" aria-label="back">
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
	<h2 class="grow">New User</h2>
</header>

{#if form?.message}
	<p class="text-sm text-red-500">{form.message}</p>
{/if}
<form
	method="POST"
	class="grid gap-6"
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
	<div class="grid gap-4 lg:grid-cols-2">
		<AInput
			name="firstname"
			label="First Name"
			placeholder="First Name"
			hint="The first name of the user."
			required
		/>
		<AInput
			name="lastname"
			label="Last Name"
			placeholder="Last Name"
			hint="The last name of the user."
			required
		/>
	</div>
	<div class="grid gap-4 lg:grid-cols-2">
		<AInput
			type="text"
			name="email"
			label="Email"
			placeholder="Email"
			hint="The email of the user. Must not be on record already."
			required
		/>
		<AInput
			type="tel"
			name="phone"
			label="Phone"
			placeholder="Phone"
			hint="Mobile phone."
			minlength={10}
			maxlength={10}
			required
		/>
	</div>
	<div class="grid gap-4 lg:grid-cols-2">
		<AInput name="address" label="Address" placeholder="Address" hint="The address of the user." />
		<AInput name="city" label="City" placeholder="City" hint="The city of the user." />
		<ASelect
			name="state"
			label="State"
			placeholder="Select one"
			hint="The state where the user lives."
			options={[{ value: 'Texas', text: 'Texas' }]}
		/>
		<AInput name="zip" label="Zip" placeholder="Zip" hint="Zip code." maxlength={5} />
	</div>

	<ACheckbox
		name="newsletter"
		label="Send newsletters"
		hint="Check if this user should receive email newsletters."
	/>
	<div>
		<AButton text="Save" type="submit" {loading} />
	</div>
</form>
