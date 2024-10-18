<script lang="ts">
	import { AButton, AChip } from 'ui';
	import AdminLayout from '../../AdminLayout.svelte';

	let { data } = $props();
	const { show } = data;
	const title = `Show Details ${show.name} (${show.type?.name})`;
</script>

{#snippet header()}
	<div class="flex w-full items-center justify-between">
		<h2 class="text-xl font-bold">Show #{show.id} Details</h2>
		<AButton text="Edit" href={`/admin/shows/${show.id}/edit`} />
	</div>
{/snippet}

<AdminLayout {title} {header} backHref="/admin/shows">
	<div class="flex w-full items-center justify-end gap-3">
		<div class="w-20 grow lg:w-full">
			<h2 class="truncate text-center text-2xl font-semibold tracking-tight">
				{show.name}
			</h2>
		</div>
	</div>

	<div class="-mt-3 flex w-full justify-center gap-3">
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
				class="size-5"
			>
				<circle cx="12" cy="12" r="10" />
				<polyline points="12 6 12 12 16 14" />
			</svg>
			{show.duration} mins
		</span>
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
		<p class="text-center text-sm text-muted-foreground">
			{show.description}
		</p>
	</div>
</AdminLayout>
