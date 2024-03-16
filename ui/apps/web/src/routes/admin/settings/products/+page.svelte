<script lang="ts">
	import { AButton, ADialog, AIcon, AInput } from 'ui';
	import { box, calendar_badge } from 'ui/icons';

	let { data } = $props();

	let dialog = $state(false);

	let selected: IProductType | undefined = $state();

	const toggle = () => (dialog = !dialog);
</script>

<div>
	<AButton
		text="New Product Type"
		onclick={() => {
			selected = undefined;
			toggle();
		}}
	/>
</div>

{#if dialog}
	<ADialog
		title="New Product Type"
		subtitle="Adds a new Product Type to the database."
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
				placeholder="Name"
				hint="The name of the product type"
				required
			/>
			<AInput
				value={selected ? selected.description : ''}
				name="description"
				label="Description"
				hint="A description for the product type."
				placeholder="Name"
			/>
			<div>
				<AButton text="Save" type="submit" />
			</div>
		</form>
	</ADialog>
{/if}

{#snippet list_item(product_type: IProductType)}
	<button
		onclick={() => {
			selected = product_type;
			toggle();
		}}
		class="flex cursor-pointer gap-3 rounded-xl p-3 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700"
	>
		<div class="flex items-center">
			<AIcon data={box} size={2} />
		</div>
		<div class="flex flex-col justify-center">
			<span class="flex items-center gap-1">
				{product_type.name}
			</span>
			<span class="text-zinc-500 dark:text-zinc-400">
				{product_type.description}
			</span>
		</div>
	</button>
{/snippet}

{#each data.product_types as product_type}
	{@render list_item(product_type)}
{/each}
