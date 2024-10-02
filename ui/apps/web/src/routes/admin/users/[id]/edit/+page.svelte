<script>
	import { enhance } from '$app/forms';
	import { AButton, ACheckbox, AInput, ASelect } from 'ui';

	let { data, form } = $props();
	const { user } = data;
</script>

<header
	class="fixed left-0 top-0 flex w-full flex-col bg-background/95 px-5 backdrop-blur supports-[backdrop-filter]:bg-background/60 lg:left-[inherit] lg:-mx-6 lg:w-[calc(1080px-288px)]"
>
	<div class="flex h-16 items-center gap-3">
		<a href={`/admin/users/${user.id}`} aria-label="back">
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
		<h3 class="font-semibold leading-none tracking-tight">Edit User #{user.id}</h3>
	</div>
</header>

<section class="mt-24 flex flex-col gap-6">
	{#if form?.message}
		<div
			role="alert"
			class="relative w-full rounded-lg border border-destructive/50 px-4 py-3 text-sm text-destructive dark:border-destructive [&>svg+div]:translate-y-[-3px] [&>svg]:absolute [&>svg]:left-4 [&>svg]:top-4 [&>svg]:text-destructive [&>svg~*]:pl-7"
		>
			<svg
				width="15"
				height="15"
				viewBox="0 0 15 15"
				fill="none"
				xmlns="http://www.w3.org/2000/svg"
				class="h-4 w-4"
			>
				<path
					d="M8.4449 0.608765C8.0183 -0.107015 6.9817 -0.107015 6.55509 0.608766L0.161178 11.3368C-0.275824 12.07 0.252503 13 1.10608 13H13.8939C14.7475 13 15.2758 12.07 14.8388 11.3368L8.4449 0.608765ZM7.4141 1.12073C7.45288 1.05566 7.54712 1.05566 7.5859 1.12073L13.9798 11.8488C14.0196 11.9154 13.9715 12 13.8939 12H1.10608C1.02849 12 0.980454 11.9154 1.02018 11.8488L7.4141 1.12073ZM6.8269 4.48611C6.81221 4.10423 7.11783 3.78663 7.5 3.78663C7.88217 3.78663 8.18778 4.10423 8.1731 4.48612L8.01921 8.48701C8.00848 8.766 7.7792 8.98664 7.5 8.98664C7.2208 8.98664 6.99151 8.766 6.98078 8.48701L6.8269 4.48611ZM8.24989 10.476C8.24989 10.8902 7.9141 11.226 7.49989 11.226C7.08567 11.226 6.74989 10.8902 6.74989 10.476C6.74989 10.0618 7.08567 9.72599 7.49989 9.72599C7.9141 9.72599 8.24989 10.0618 8.24989 10.476Z"
					fill="currentColor"
					fill-rule="evenodd"
					clip-rule="evenodd"
				></path>
			</svg>
			<h5 class="mb-1 font-medium leading-none tracking-tight">Error</h5>
			<div class="[&amp;_p]:leading-relaxed text-sm">
				{form.message}
			</div>
		</div>
	{/if}
</section>

<form method="POST" class="grid gap-6" use:enhance>
	<div class="grid gap-4 lg:grid-cols-2">
		<AInput
			value={user.firstname}
			name="firstname"
			label="First Name"
			placeholder="First Name"
			hint="The first name of the user."
			required
		/>
		<AInput
			value={user.lastname}
			name="lastname"
			label="Last Name"
			placeholder="Last Name"
			hint="The last name of the user."
			required
		/>
	</div>
	<AInput
		value={user.email}
		type="text"
		name="email"
		label="Email"
		placeholder="Email"
		hint="The email of the user. Must not be on record already."
		required
	/>
	<div class="grid gap-4 lg:grid-cols-2">
		<AInput
			value={user.address}
			name="address"
			label="Address"
			placeholder="Address"
			hint="The address of the user."
		/>
		<AInput
			value={user.city}
			name="city"
			label="City"
			placeholder="City"
			hint="The city of the user."
		/>
		<ASelect
			value={user.state}
			name="state"
			label="State"
			placeholder="Select one"
			hint="The state where the user lives."
			options={[{ value: 'Texas', text: 'Texas' }]}
		/>
		<AInput name="zip" label="Zip" placeholder="Zip" hint="Zip code." />
	</div>
	<ACheckbox
		checked={user.newsletter}
		name="newsletter"
		label="Send newsletters"
		hint="Check if this user should receive email newsletters."
	/>
	<ASelect
		value={user.role_id}
		name="role_id"
		label="Role"
		placeholder="Select one"
		hint="The role of the user."
		options={data.roles}
	/>
	<div>
		<AButton text="Save" type="submit" />
	</div>
</form>
