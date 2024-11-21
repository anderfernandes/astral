<script lang="ts">
	import { applyAction, enhance } from '$app/forms';
	import { AButton, ACheckbox, AChip, ADialog, AInput, ATextArea } from 'ui';

	const { data } = $props();

	let selected: ITicketType | undefined = $state();

	let dialog = $state(false);

	const toggle = () => {
		dialog = !dialog;
	};

	let loading = $state(false);
</script>

<svelte:head>
	<title>Ticket Settings | Astral</title>
</svelte:head>

<div class="flex justify-end">
	<AButton
		text="New Ticket Type"
		onclick={() => {
			selected = undefined;
			toggle();
		}}
	/>
</div>

<div class="grid gap-1">
	{#each data.ticket_types as ticket_type}
		<button
			onclick={() => {
				selected = ticket_type;
				toggle();
			}}
			class="-mx-2 flex cursor-pointer items-center space-x-4 rounded-md p-2 transition-all hover:bg-accent hover:text-accent-foreground"
		>
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
				class="lucide lucide-ticket"
				><path
					d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"
				/><path d="M13 5v2" /><path d="M13 17v2" /><path d="M13 11v2" /></svg
			>

			<div class="space-y-1">
				<div class="flex items-center gap-1 text-left text-sm font-medium leading-none">
					{ticket_type.name} &middot; ${ticket_type.price.toFixed(2)}
					{#if ticket_type.in_cashier}
						<svg class="size-5" viewBox="0 0 24 24"
							><path
								fill="currentColor"
								d="M2,17H22V21H2V17M6.25,7H9V6H6V3H14V6H11V7H17.8C18.8,7 19.8,8 20,9L20.5,16H3.5L4.05,9C4.05,8 5.05,7 6.25,7M13,9V11H18V9H13M6,9V10H8V9H6M9,9V10H11V9H9M6,11V12H8V11H6M9,11V12H11V11H9M6,13V14H8V13H6M9,13V14H11V13H9M7,4V5H13V4H7Z"
							></path></svg
						>
					{/if}
					{#if ticket_type.is_public}
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
							class="size-4"
							><circle cx="12" cy="12" r="10" /><path
								d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"
							/><path d="M2 12h20" /></svg
						>
					{/if}
					{#if ticket_type.is_active}
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
							class="size-4"
							><path d="M7 10v12" /><path
								d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z"
							/></svg
						>
					{/if}
				</div>
				<p class="text-left text-sm text-muted-foreground">{ticket_type.description}</p>
			</div>
		</button>
	{/each}
</div>

{#if dialog}
	<ADialog
		onclose={toggle}
		title={selected === undefined ? 'New Ticket Type' : `Edit Ticket Type`}
		subtitle="Make sure you can't reuse the ones that already exist."
	>
		<form
			method="POST"
			class="grid gap-3"
			use:enhance={() => {
				loading = true;
				return async ({ result, update }) => {
					console.log(result.status);
					if (result.status! >= 400) {
						loading = false;
					} else await applyAction(result);
					dialog = false;
					await update();
					loading = false;
				};
			}}
		>
			{#if selected?.id}
				<input type="hidden" name="_method" value="PUT" />
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
			<ATextArea
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
				hint="Makes ticket type available to the general public."
			/>
			<ACheckbox
				checked={selected?.in_cashier || false}
				name="in_cashier"
				label="Cashier"
				hint="Makes this ticket type available in Cashier."
			/>
			<div class="mt-2 flex justify-end gap-3">
				<AButton text="Save" type="submit" {loading} />
				<AButton text="Close" variant="secondary" />
			</div>
		</form>
	</ADialog>
{/if}
