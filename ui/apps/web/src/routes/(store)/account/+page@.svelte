<script lang="ts">
	import { AButton, AIcon, ASelect } from 'ui';
	import { account_circle, close } from 'ui/icons.js';
	import AInput from 'ui/src/components/AInput.svelte';

	let { data } = $props();
	let { account } = data;
</script>

<nav class="flex h-16 items-center px-6">
	<AIcon data={close} size={1.25} href="/" />
</nav>

<main class="flex justify-center p-6">
	<section class="flex flex-col gap-3 md:w-1/2">
		<div class="flex items-center gap-2">
			<AIcon data={account_circle} size={2.5} />
			<div>
				<h1>Account</h1>
				<h5 class="text-sm text-zinc-500 dark:text-zinc-400">
					{account?.firstname}
					{account?.lastname}
					&middot;
					{account?.role.name}
				</h5>
			</div>
		</div>
		<form method="POST" class="grid gap-2">
			<div class="grid gap-2 md:grid-cols-2">
				<AInput name="firstname" label="First Name" required placeholder="First Name" />
				<AInput name="lastname" label="Last Name" required placeholder="Last Name" />
			</div>
			<AInput name="address" label="Address" required placeholder="Address" />
			<div class="grid gap-2 md:grid-cols-2">
				<AInput name="city" label="City" placeholder="City" required />
				<ASelect name="state" label="State" required value="Texas" options={['Texas']} disabled />
			</div>
			<div class="grid gap-2 md:grid-cols-2">
				<AInput name="email" label="Email" placeholder="Email" type="email" required />
				<AInput name="phone" label="Phone" placeholder="Phone" type="string" />
			</div>
			<div class="my-3 flex justify-end">
				<AButton text="Save" />
			</div>
		</form>
	</section>
</main>
