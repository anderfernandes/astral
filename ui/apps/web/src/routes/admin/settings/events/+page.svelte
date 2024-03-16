<script lang="ts">
	import { AButton, ACheckbox, ADialog, AIcon, AInput, ATextarea } from 'ui';
	import { calendar_badge, earth } from 'ui/icons';

	let { data } = $props();

	let dialog = $state(false);

	let selected: IEventType | undefined = $state();

	const toggle = () => (dialog = !dialog);
</script>

<div>
	<AButton
		text="New Event Type"
		onclick={() => {
			selected = undefined;
			toggle();
		}}
	/>
	{#if dialog}
		<ADialog
			title="New Event Type"
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
				<ATextarea
					value={selected ? selected.description : ''}
					name="description"
					label="Description"
					hint="Describe the purpose of the ticket"
					placeholder="Description"
					required
				/>
				<ACheckbox
					checked={selected?.is_public || false}
					name="is_public"
					label="Public"
					hint="Check if this ticket type should be available to the general public."
				/>
				<div>
					<AButton text="Save" type="submit" />
				</div>
			</form>
		</ADialog>
	{/if}
</div>

{#snippet list_item(event_type: IEventType)}
	<button
		onclick={() => {
			selected = event_type;
			toggle();
		}}
		class="flex cursor-pointer gap-3 rounded-xl p-3 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700"
	>
		<div class="flex items-center">
			<AIcon data={calendar_badge} size={2} />
		</div>
		<div class="flex flex-col justify-center">
			<span class="flex items-center gap-1">
				{event_type.name}
				{#if event_type.is_public}
					&middot;
					<AIcon data={earth} />
				{/if}
			</span>
			<span class="text-left text-zinc-500 dark:text-zinc-400">
				{event_type.description}
			</span>
		</div>
	</button>
{/snippet}

{#each data.event_types as event_type}
	{@render list_item(event_type)}
{/each}
