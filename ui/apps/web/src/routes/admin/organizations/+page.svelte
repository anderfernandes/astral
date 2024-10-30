<script>
	import { AButton, AChip } from 'ui';
	import Navbar from '../Navbar.svelte';
	import AdminLayout from '../AdminLayout.svelte';

	let { data } = $props();
</script>

{#snippet header()}
	<div class="flex w-full items-center justify-between">
		<h2 class="text-xl font-bold">Organizations</h2>
		<AButton text="New Organization" href="/admin/organizations/create" />
	</div>
{/snippet}

<AdminLayout title="Organizations" {header}>
	{#each data.organizations as { id, name, city, state, phone, type }}
		<a
			href={`/admin/organizations/${id}`}
			class="rounded-xl border bg-card text-card-foreground shadow"
		>
			<div class="flex flex-col space-y-1.5 p-6">
				<h3 class="flex items-center font-semibold leading-none tracking-tight">
					{name}
					<AChip text={type?.name} basic />
				</h3>
				<p class="text-sm text-muted-foreground">
					{city}, {state}
					{phone?.replace(/\D+/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3')}
				</p>
			</div>
		</a>
	{/each}
</AdminLayout>
