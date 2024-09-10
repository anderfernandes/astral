<script lang="ts">
	import { AButton, ADialog, AInput } from 'ui';

	let { data } = $props();

	let selected: IProductType | undefined = $state();
	let open = $state(false);
	const toggle = () => {
		open = !open;
	};
</script>

<svelte:head>
	<title>Product Settings - Astral Admin</title>
</svelte:head>

<div class="flex justify-end">
	<AButton
		text="New Product Type"
		onclick={() => {
			selected = undefined;
			toggle();
		}}
	/>
</div>

<div class="grid gap-3">
	{#each data.product_types as product_type}
		<button
			class="flex items-center"
			onclick={() => {
				selected = product_type;
				toggle();
			}}
		>
			<span class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full">
				<svg viewBox="0 0 24 24"
					><path
						fill="currentColor"
						d="M21,16.5C21,16.88 20.79,17.21 20.47,17.38L12.57,21.82C12.41,21.94 12.21,22 12,22C11.79,22 11.59,21.94 11.43,21.82L3.53,17.38C3.21,17.21 3,16.88 3,16.5V7.5C3,7.12 3.21,6.79 3.53,6.62L11.43,2.18C11.59,2.06 11.79,2 12,2C12.21,2 12.41,2.06 12.57,2.18L20.47,6.62C20.79,6.79 21,7.12 21,7.5V16.5M12,4.15L10.11,5.22L16,8.61L17.96,7.5L12,4.15M6.04,7.5L12,10.85L13.96,9.75L8.08,6.35L6.04,7.5M5,15.91L11,19.29V12.58L5,9.21V15.91M19,15.91V9.21L13,12.58V19.29L19,15.91Z"
					></path>
				</svg>
			</span>
			<div class="ml-4 space-y-1">
				<p class="text-left text-sm font-medium leading-none">{product_type.name}</p>
				<p class="text-left text-sm text-muted-foreground">{product_type.description}</p>
			</div>
			<!-- <div class="ml-auto font-medium">+$1,999.00</div> -->
		</button>
	{/each}
</div>

{#if open}
	<ADialog onclose={toggle} title="New Product Type" subtitle="Product Type">
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
			<div class="flex justify-end gap-2">
				<AButton text="Save" type="submit" />
				<AButton text="Close" variant="secondary" onclick={toggle} />
			</div>
		</form>
	</ADialog>
{/if}
