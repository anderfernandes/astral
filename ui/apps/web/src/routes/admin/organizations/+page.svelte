<script>
	import { AButton, AChip } from 'ui';

	let { data } = $props();
</script>

<svelte:head>
	<title>Organizations - Astral Admin</title>
</svelte:head>

<div class="flex items-center justify-between space-y-2">
	<div class="flex flex-col space-y-1.5 py-6">
		<h2 class="text-3xl font-bold tracking-tight">Organizations</h2>
	</div>
	<div class="flex items-center space-x-2">
		<AButton text="New Organization" href="/admin/organizations/create" />
	</div>
</div>

<div class="grid gap-3">
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
					{phone}
				</p>
			</div>
		</a>
	{/each}
</div>
