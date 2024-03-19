<script lang="ts">
	import { AButton } from 'ui';

	let { data } = $props();
	let { shows } = data;
</script>

<section class="flex gap-3">
	<h1 class="grow">Shows ({shows.length})</h1>
	<AButton text="New Show" href="/admin/shows/create" />
</section>

<section class="grid gap-3">
	{#each shows as show}
		<a href={`/admin/shows/${show.id}`} class="flex gap-3">
			<img class="h-44 w-32 rounded-xl" src={show.cover} alt={show.name} />
			<div class="flex flex-col">
				<span class="font-medium">{show.name}</span>
				<span class="text-sm text-zinc-500 dark:text-zinc-400"
					>{show.type?.name} &middot; {show.duration} min &middot; {show.is_active
						? 'active'
						: 'inactive'}
					{#if show.is_expired}
						&middot; expired
					{/if}
				</span>
			</div>
		</a>
	{/each}
</section>
