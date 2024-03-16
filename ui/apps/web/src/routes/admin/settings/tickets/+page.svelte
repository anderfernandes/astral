<script lang="ts">
	import { enhance } from '$app/forms';
	import { AButton, ADialog, AIcon, AInput, ATextarea } from 'ui';
	import { book_outline, cash_register, earth } from 'ui/icons';
	import ACheckbox from 'ui/src/components/ACheckbox.svelte';

	let { data } = $props();

	let dialog = $state(false);

	const toggle = () => (dialog = !dialog);

	let selected: ITicketType | undefined = $state(undefined);
</script>

<div>
	<AButton
		text="New Ticket Type"
		onclick={() => {
			selected = undefined;
			toggle();
		}}
	/>
	{#if dialog}
		<ADialog
			title="New Ticket Type"
			subtitle="Adds a new Ticket Type to the database."
			onclose={toggle}
		>
			<form method="POST" class="grid gap-3">
				{#if selected}
					<input type="hidden" name="id" value={selected.id} />
				{/if}
				<AInput
					value={selected ? selected.name : ''}
					name="name"
					label="Name"
					hint="The name of the ticket type."
					placeholder="Name"
					required
				/>
				<AInput
					value={selected ? selected.price : ''}
					name="price"
					type="number"
					label="Price"
					hint="The price of tickets of this type."
					placeholder="Price"
					required
				/>
				<ATextarea
					value={selected ? selected.description : ''}
					name="description"
					label="Description"
					hint="Describe the purpose of the ticket"
					placeholder="Description"
					required
				/>
				<ACheckbox
					checked={selected?.is_active || false}
					name="is_active"
					label="Active"
					hint="Check to make this ticket type available."
				/>
				<ACheckbox
					checked={selected?.is_public || false}
					name="is_public"
					label="Public"
					hint="Check if this ticket type should be available to the general public."
				/>
				<ACheckbox
					checked={selected?.in_cashier || false}
					name="in_cashier"
					label="Cashier"
					hint="Check if this ticket type should be available in Cashier."
				/>
				<div>
					<AButton text="Save" type="submit" />
				</div>
			</form>
		</ADialog>
	{/if}
</div>

{#snippet list_item(ticket_type: ITicketType)}
	<button
		onclick={() => {
			toggle();
			selected = ticket_type;
		}}
		class="flex cursor-pointer gap-3 rounded-xl p-3 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700"
	>
		<div class="flex items-center">
			<AIcon data={book_outline} size={2} />
		</div>
		<div class="flex flex-col items-start justify-center">
			<span class="flex items-center gap-1">
				{ticket_type.name} &middot; ${ticket_type.price.toFixed(2)}
				{#if ticket_type.in_cashier}
					&middot;
					<AIcon data={cash_register} />
				{/if}
				{#if ticket_type.is_public}
					&middot;
					<AIcon data={earth} />
				{/if}
				{#if ticket_type.is_active}
					<span class="flex items-center rounded-full bg-black/75 px-2 py-1 text-xs text-white">
						active
					</span>
				{:else}
					<span class="flex items-center text-sm">inactive</span>
				{/if}
			</span>
			<span class="text-zinc-500 dark:text-zinc-400">
				{ticket_type.description}
			</span>
		</div>
	</button>
{/snippet}

{#each data.ticket_types as ticket_type}
	{@render list_item(ticket_type)}
{/each}
