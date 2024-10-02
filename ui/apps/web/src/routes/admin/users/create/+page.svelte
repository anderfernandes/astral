<script>
	import { enhance } from '$app/forms';
	import { AButton, ACheckbox, AInput, ASelect } from 'ui';

	let { form } = $props();
</script>

<svelte:head>
	<title>New User | Astral</title>
</svelte:head>

<header
	class="fixed left-0 top-0 flex w-full flex-col bg-background/95 px-5 backdrop-blur supports-[backdrop-filter]:bg-background/60 lg:left-[inherit] lg:-mx-6 lg:w-[calc(1080px-288px)]"
>
	<div class="flex h-16 items-center gap-3">
		<a href={`/admin/users`} aria-label="back">
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
		<h3 class="font-semibold leading-none tracking-tight">New User</h3>
	</div>
</header>

<section class="mt-24 grid gap-6">
	{#if form?.message}
		<p class="text-sm text-red-500">{form.message}</p>
	{/if}
</section>

<form method="POST" class="grid gap-6" use:enhance>
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
	<AInput
		type="email"
		name="email"
		label="Email"
		placeholder="Email"
		hint="The email of the user. Must not be on record already."
		required
	/>
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
		<AInput name="zip" label="Zip" placeholder="Zip" hint="Zip code." />
	</div>

	<ACheckbox
		name="newsletter"
		label="Send newsletters"
		hint="Check if this user should receive email newsletters."
	/>
	<div>
		<AButton text="Save" type="submit" />
	</div>
</form>
