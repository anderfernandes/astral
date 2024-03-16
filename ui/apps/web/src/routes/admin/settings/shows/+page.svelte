<script lang="ts">
	import { AButton, ACheckbox, ADialog, AIcon, AInput, ATextarea } from 'ui';
	import { calendar_badge, earth, movie_open_star_outline } from 'ui/icons';

	let { data } = $props();
	let { show_types } = data;

	let dialog = $state(false);

	const toggle = () => (dialog = !dialog);
</script>

<div>
	<AButton text="New Show Type" disabled onclick={toggle} />
	{#if dialog}
		<ADialog
			title="New Show Type"
			subtitle="Adds a new Show Type to the database."
			onclose={toggle}
		>
			<AInput
				name="name"
				label="Name"
				hint="The name of the show type."
				placeholder="Name"
				required
			/>
			<ATextarea
				name="description"
				label="Description"
				hint="A description for this show type"
				placeholder="Description"
				required
			/>
			<ACheckbox
				name="is_active"
				label="Active"
				hint="Check if this ticket type should be available."
			/>
			<div>
				<AButton text="Save" />
			</div>
		</ADialog>
	{/if}
</div>

{#snippet list_item(show_type: IShowType)}
	<div
		class="flex cursor-pointer gap-3 rounded-xl p-3 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700"
	>
		<div class="flex items-center">
			<AIcon data={movie_open_star_outline} size={2} />
		</div>
		<div class="flex flex-col justify-center">
			<span class="flex items-center gap-1">
				{show_type.name}
				{#if show_type.is_active}
					<span class="flex items-center rounded-full bg-black/75 px-2 py-1 text-xs text-white">
						active
					</span>
				{/if}
			</span>
			<span class="text-zinc-500 dark:text-zinc-400">
				{show_type.description}
			</span>
		</div>
	</div>
{/snippet}

{#each show_types as show_type}
	{@render list_item(show_type)}
{/each}
