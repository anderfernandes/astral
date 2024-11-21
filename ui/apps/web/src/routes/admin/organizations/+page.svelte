<script>
	import { AButton, AChip } from 'ui';

	let { data } = $props();
</script>

<svelte:head>
	<title>Organizations | Astral</title>
</svelte:head>

<header
	class="sticky top-0 -mx-6 flex h-16 items-center gap-3 bg-background/50 px-6 font-semibold backdrop-blur"
>
	<h2 class="grow">Organizations</h2>
	<AButton text="New Organization" href="/admin/organizations/create" />
</header>

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
