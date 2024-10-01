<script>
	import { AButton, AChip } from 'ui';

	let { data } = $props();
</script>

<svelte:head>
	<title>Organizations - Astral Admin</title>
</svelte:head>

<div class="mt-16 grid gap-6">
	<div class="flex items-center justify-between space-y-2">
		<h2 class="grow text-lg font-semibold md:text-2xl">Organizations</h2>

		<div class="flex items-center space-x-2">
			<AButton text="New Organization" href="/admin/organizations/create" />
		</div>
	</div>
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
