<script lang="ts">
	import { applyAction, enhance } from '$app/forms';
	import { AButton, ACheckbox, AChip, ADialog, AInput, ATextArea } from 'ui';

	const { data } = $props();

	let selected: IOrganizationType | undefined = $state();

	let dialog = $state(false);

	const toggle = () => {
		dialog = !dialog;
	};

	let loading = $state(false);
</script>

<svelte:head>
	<title>Settings - Astral Admin</title>
</svelte:head>

<section class="grid gap-3">
	<div class="flex w-full justify-end">
		<AButton
			text="New Organization Type"
			onclick={() => {
				selected = undefined;
				toggle();
			}}
		/>
	</div>
	{#each data.organization_types as organization_type}
		<button
			class="p-1 text-left"
			onclick={() => {
				selected = organization_type;
				toggle();
			}}
		>
			<h3 class="font-semibold leading-none tracking-tight">
				{organization_type.name}
				{#if organization_type.taxable}
					<AChip basic text="taxable" />
				{/if}
			</h3>
			<p class="text-sm text-muted-foreground">
				{organization_type.description}
			</p>
		</button>
	{/each}
</section>

{#if dialog}
	<ADialog
		onclose={toggle}
		title={selected ? 'Edit Organization Type' : 'New Organization Type'}
		subtitle="Manage organization types."
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
			{#if selected}
				<input type="hidden" name="id" value={selected.id} />
			{/if}
			<AInput
				value={selected ? selected.name : ''}
				name="name"
				label="Name"
				hint="The name of the organization type."
				placeholder="Name"
				required
			/>
			<ATextArea
				value={selected ? selected.description : ''}
				name="description"
				label="Description"
				hint="A short description of the organization type."
				placeholder="Description"
				required
			/>
			<ACheckbox
				checked={selected ? selected.taxable : false}
				name="taxable"
				label="Taxable"
				hint="Whether or not organizations under this type should be charged taxes by default. This can be changed in each sale."
			/>
			<div class="flex justify-end gap-3">
				<AButton text="Save" type="submit" {loading} />
				<AButton text="Close" variant="secondary" onclick={toggle} />
			</div>
		</form>
	</ADialog>
{/if}
