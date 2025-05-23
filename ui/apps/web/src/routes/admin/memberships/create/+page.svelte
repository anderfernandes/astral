<script lang="ts">
	import { AInput, ASelect, ASlider, AButton } from 'ui';

	const { data } = $props();

	let membership_type_id = $state<number>();

	let number_of_secondaries = $state(0);

	let payment_method_id = $state<number>();

	let selected = $derived.by(() => data.membership_types.find((t) => t.id === membership_type_id));

	let tendered = $state(0);

	let { subtotal, tax, total } = $derived.by(() => {
		let primary_subtotal = selected?.price || 0;

		let secondaries_subtotal = selected?.secondary_price
			? selected.secondary_price * number_of_secondaries
			: 0;

		let subtotal = primary_subtotal + secondaries_subtotal;

		let tax = subtotal * (data.settings.organization.tax / 100);

		let total = subtotal + tax;

		return { subtotal, tax, total };
	});

	let loading = $state(false);
</script>

<svelte:head>
	<title>New Membership | Astral</title>
</svelte:head>

<header
	class="sticky top-0 -mx-6 flex h-16 items-center gap-3 bg-background/50 px-6 font-semibold backdrop-blur"
>
	<a href="/admin/memberships" aria-label="back">
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
	<h2 class="grow text-xl font-semibold">New Membership</h2>
</header>

<form method="post" class="grid gap-6 lg:w-[calc(100%-20rem)]">
	<div class="grid gap-6 lg:grid-cols-2">
		<ASelect
			name="type_id"
			options={data.membership_types}
			bind:value={membership_type_id}
			label="Type"
			required
			placeholder="Select one"
		/>
	</div>
	<div class="grid h-36 text-center" class:membership-details={selected}>
		{#if selected}
			<div>
				<h3 class="text-sm font-medium tracking-tight">Price</h3>
				<div class="text-2xl font-bold">
					{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
						selected.price
					)}
				</div>
				<span class="text-xs text-muted-foreground">each</span>
			</div>
			<div>
				<h3 class="text-sm font-medium tracking-tight">Duration</h3>
				<div class="text-2xl font-bold">{selected?.duration}</div>
				<span class="text-xs text-muted-foreground">days</span>
			</div>
			<div>
				<h3 class="text-sm font-medium tracking-tight">Max Secondaries</h3>
				<div class="text-2xl font-bold">{selected?.max_secondaries}</div>
				<span class="text-xs text-muted-foreground">secondaries</span>
			</div>
			<div>
				<h3 class="text-sm font-medium tracking-tight">Secondary Price</h3>
				<div class="text-2xl font-bold">
					{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
						selected.secondary_price
					)}
				</div>
				<span class="text-xs text-muted-foreground">each</span>
			</div>
		{:else}
			<span class="text-center text-sm">Select one membership type above to see its perks.</span>
		{/if}
	</div>
	<ASelect
		name="primary_id"
		options={data.users}
		label="Primary"
		required
		placeholder="Select one"
		hint="The individual must be a user already. If they are not, please create an account first."
	/>
	<ASlider
		bind:value={number_of_secondaries}
		min="0"
		max={selected?.max_secondaries || 0}
		disabled={selected?.max_secondaries === 0 || selected?.max_secondaries === undefined}
		label="Secondaries"
		hint="The number of secondaries in this membership"
	/>
	<div class="grid lg:grid-cols-2 lg:gap-6">
		{#each Array(number_of_secondaries) as _, i}
			<ASelect name={`secondaries[${i}]`} options={data.users} label={`Secondary #${i + 1}`} />
		{/each}
	</div>
	<ul class="grid gap-3 text-sm">
		<li class="flex items-center justify-between">
			<span class="text-muted-foreground">Subtotal</span>
			<span>
				{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(subtotal)}
			</span>
		</li>
		<li class="flex items-center justify-between">
			<span class="text-muted-foreground">Tax ({data.settings.organization.tax}%)</span>
			<span> {Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(tax)}</span>
		</li>
		<li class="flex items-center justify-between font-semibold">
			<span class="text-muted-foreground">Total</span>
			<span>
				{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(total)}</span
			>
		</li>
		<li class="flex items-center justify-between">
			<span class="text-muted-foreground">Tendered</span>
			<span>
				{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(tendered)}
			</span>
		</li>
		<li class="flex items-center justify-between">
			<span class="text-muted-foreground">Change</span>
			<span>
				{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
					tendered >= total ? tendered - total : 0
				)}
			</span>
		</li>
		<li class="flex items-center justify-between">
			<span class="text-muted-foreground">Balance</span>
			<span>
				{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
					tendered < total ? tendered - total * -1 : 0
				)}
			</span>
		</li>
	</ul>
	<div class="grid gap-6 lg:grid-cols-3">
		<AInput
			name="tendered"
			label="Tendered"
			placeholder="Tendered"
			disabled={payment_method_id !== 1}
			value={tendered.toFixed(2)}
			required
		/>
		<ASelect
			name="method_id"
			bind:value={payment_method_id}
			options={data.payment_methods}
			onchange={(e) => {
				tendered = e.currentTarget.value === '1' ? 0 : total;
			}}
			label="Payment Method"
			placeholder="Select one"
			required
		/>
		<AInput
			name="reference"
			label="Reference"
			required={payment_method_id !== 1}
			placeholder="Last 4 of CC/Check"
		/>
	</div>
	<div class="flex justify-end gap-3">
		<AButton text="Reset" type="reset" variant="secondary" />
		<AButton text="Save" disabled={tendered < total} {loading} />
	</div>
</form>

<style lang="postcss">
	.membership-details {
		@apply grid-cols-2 lg:grid-cols-4;
	}
</style>
