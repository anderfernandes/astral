<script lang="ts">
	import { AButton, AChip } from 'ui';

	let { data } = $props();
	let { show } = data;
</script>

<svelte:head>
	<title>Show Details {show.name} ({show.type?.name}) &middot; Astral</title>
</svelte:head>

<article class="grid gap-6">
	<div class="flex w-full justify-end">
		<AButton text="Edit" href={`/admin/shows/${show.id}/edit`} />
	</div>
	<div class="flex justify-center overflow-hidden rounded-md">
		<img
			alt={show.name}
			loading="lazy"
			width="250"
			height="330"
			decoding="async"
			data-nimg="1"
			class="aspect-[3/4] object-cover transition-all hover:scale-105"
			style="color: transparent;"
			src={show.cover}
		/>
	</div>
	<div class="space-y-1">
		<h2 class="text-center text-2xl font-semibold tracking-tight">
			{show.name}
		</h2>
		<div class="flex w-full justify-center gap-3 py-3">
			<AChip text={show.type?.name} basic />
			<span class="flex items-center gap-1 text-sm">
				<svg
					xmlns="http://www.w3.org/2000/svg"
					width="24"
					height="24"
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					stroke-width="2"
					stroke-linecap="round"
					stroke-linejoin="round"
					class="size-4"
					><circle cx="12" cy="12" r="10" /><polyline points="12 6 12 12 16 14" /></svg
				>
				{show.duration} mins
			</span>
		</div>
		<p class="text-center text-sm text-muted-foreground">
			{show.description}
		</p>
	</div>
</article>
