<script lang="ts">
	import { AInput, ASelect, ASlider, AButton } from 'ui';
	import AdminLayout from '../../AdminLayout.svelte';

	let { data } = $props();

	let membership_type_id = $state<number>();

	let number_of_secondaries = $state(0);

	let payment_method_id = $state<number>();

	let selected = $derived.by(() => data.membership_types.find((t) => t.id === membership_type_id));

	let tendered = $state(0);

	let { subtotal, tax, total } = $derived.by(() => {
		const primary_subtotal = selected?.price || 0;

		const secondaries_subtotal = selected?.secondary_price
			? selected.secondary_price * number_of_secondaries
			: 0;

		const subtotal = primary_subtotal + secondaries_subtotal;

		const tax = subtotal * (data.settings.organization.tax / 100);

		const total = subtotal + tax;

		return { subtotal, tax, total };
	});
</script>

{#snippet header()}
	<div class="flex w-full items-center justify-between">
		<h2 class="text-xl font-bold">Shows</h2>
		<AButton text="New Show" href="/admin/shows/create" />
	</div>
{/snippet}

<AdminLayout title="New Membership" {header} backHref="/admin/memberships">
	<form method="post" class="grid gap-6">
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
		<div class="grid h-14 text-center" class:grid-cols-4={selected}>
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
				<span>
					{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(tax)}</span
				>
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
		<div class="grid lg:grid-cols-3 lg:gap-6">
			<AInput
				name="tendered"
				label="Tendered"
				placeholder="Tendered"
				disabled={payment_method_id !== 1}
				bind:value={tendered}
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
			<AButton text="Save" disabled={tendered < total} />
		</div>
	</form>
</AdminLayout>
