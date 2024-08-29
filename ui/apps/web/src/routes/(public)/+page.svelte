<script lang="ts">
	import { AEventCard } from 'ui';

	let { data } = $props();

	const { organization, events, products } = data;
</script>

<svelte:head>
	<title>{organization.name} Home | Astral</title>
</svelte:head>

{#snippet product_card(p: IProduct)}
	<div class="w-[150px] space-y-3">
		<span data-state="closed"
			><div class="overflow-hidden rounded-md">
				<img
					alt="Thinking Components"
					loading="lazy"
					width="150"
					height="150"
					decoding="async"
					data-nimg="1"
					class="aspect-square h-auto w-auto object-cover transition-all hover:scale-105"
					style="color: transparent;"
					src={p.cover}
				/>
			</div></span
		>
		<div class="space-y-1 text-sm">
			<h3 class="font-medium leading-none">{p.name}</h3>
			<p class="text-muted-foreground text-xs">${p.price}</p>
		</div>
	</div>
{/snippet}

<section class="flex flex-col gap-3">
	<h2 class="text-2xl font-semibold tracking-tight">Upcoming Events ({events.length})</h2>
	<article class="flex w-screen gap-3 overflow-x-auto px-6 pb-3 lg:max-w-screen-lg">
		{#each events as event}
			<AEventCard data={event} />
		{:else}
			<span class="text-sm">No public events were found.</span>
		{/each}
	</article>
	<br />
	<h2 class="text-2xl font-semibold tracking-tight">Products ({products.length})</h2>
	<article class="flex w-screen gap-3 overflow-x-auto px-6 pb-3 lg:max-w-screen-lg">
		{#each products as product}
			{@render product_card(product)}
		{/each}
	</article>
</section>
