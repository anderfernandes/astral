<script lang="ts">
	import { AButton, ACheckbox, ADialog, AInput, ATextArea } from 'ui';

	let { data } = $props();

	let selected = $state<IMembershipType>();

	let open = $state(false);

	const toggle = () => {
		open = !open;
	};
</script>

<svelte:head>
	<title>Membership Settings - Astral Admin</title>
</svelte:head>

<div class="flex justify-end">
	<AButton
		text="New Membership Type"
		onclick={() => {
			selected = undefined;
			toggle();
		}}
	/>
</div>

<section class="grid gap-6">
	{#each data.membership_types as membership_type}
		<button
			class="flex flex-col items-start gap-2 rounded-lg border p-3 text-left text-sm transition-all hover:bg-accent"
			onclick={() => {
				selected = membership_type;
				toggle();
			}}
		>
			<div class="flex w-full flex-col gap-1">
				<div class="flex items-center">
					<div class="flex items-center gap-2">
						<div class="font-semibold">{membership_type.name}</div>
					</div>
					<div class="ml-auto text-xs text-muted-foreground">
						{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
							membership_type.price
						)} each
					</div>
				</div>
				<div class="text-xs font-medium">
					{membership_type.max_secondaries}
					{membership_type.max_secondaries === 1 ? 'secondary' : 'secondaries'} max, {Intl.NumberFormat(
						'en-US',
						{ style: 'currency', currency: 'USD' }
					).format(membership_type.secondary_price)} each
				</div>
			</div>
			<div class="line-clamp-2 text-xs text-muted-foreground">
				{membership_type.description}
			</div>
			<div class="flex items-center gap-2">
				<div
					class="inline-flex items-center rounded-md border border-transparent bg-primary px-2.5 py-0.5 text-xs font-semibold text-primary-foreground shadow transition-colors hover:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
				>
					active: {membership_type.is_active === true ? 'yes' : 'no'}
				</div>

				<div
					class="inline-flex items-center rounded-md border border-transparent bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground transition-colors hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
				>
					keep remaining days: {membership_type.keep_remaining_days === true ? 'yes' : 'no'}
				</div>
			</div>
		</button>
	{/each}
</section>

{#if open}
	<ADialog
		onclose={toggle}
		title="Membership Type"
		subtitle={selected ? `Edit ${selected.name}` : 'New Membership Type'}
	>
		<form method="POST" class="grid gap-3">
			{#if selected}
				<input type="hidden" name="id" value={selected.id} />
			{/if}
			<AInput
				value={selected?.name || ''}
				name="name"
				label="Name"
				placeholder="Name"
				required
				hint="The name of the membership type"
			/>
			<ATextArea
				value={selected?.description || ''}
				name="description"
				label="Description"
				placeholder="Description"
				required
				hint="A short description of the membrship type and its benefits."
			/>
			<AInput
				value={selected?.price || undefined}
				name="price"
				label="Price"
				placeholder="Price"
				required
				hint="The price of the memberhsip"
			/>
			<AInput
				type="number"
				min={0}
				name="duration"
				value={selected?.duration || 365}
				label="Duration"
				required
				placeholder="Duration"
				hint="Duration in days of a membership"
			/>
			<AInput
				type="number"
				min={0}
				name="max_secondaries"
				value={selected?.max_secondaries || 0}
				label="Maximum number of secondaries"
				required
				placeholder="Max Secondaries"
				hint="The maximum number of secondaries allowed"
			/>
			<AInput
				value={selected?.secondary_price || 0}
				name="secondary_price"
				label="Secondary Price"
				placeholder="Secondary Price"
				required
				hint="The per secondary."
			/>
			<ACheckbox
				name="is_active"
				checked={selected?.is_active || false}
				label="Active"
				hint="Defines if this membership type is available for purchase"
			/>
			<ACheckbox
				name="keep_remaining_days"
				checked={selected?.keep_remaining_days}
				label="Keep Remaining Days"
				hint="Adds the remaining days of the membership, if any, to a membership renewal"
			/>
			<div class="flex justify-end gap-2">
				<AButton text="Save" type="submit" />
				<AButton text="Close" variant="secondary" onclick={toggle} />
			</div>
		</form>
	</ADialog>
{/if}
