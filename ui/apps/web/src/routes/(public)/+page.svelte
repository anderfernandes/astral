<script lang="ts">
	import { AEventCard } from 'ui';

	let { data } = $props();

	const { organization, events, products } = data;
</script>

<svelte:head>
	<title>{organization.name} Home | Astral</title>
</svelte:head>

{#snippet product_card(p: IProduct)}
	<a href={`/products/${p.id}`} class="relative flex justify-end gap-3 rounded-2xl text-sm">
		<div
			class="h-16 w-16 rounded bg-cover bg-center"
			style={`background-image:url(${p.cover})`}
		></div>
		<div class="flex w-28 flex-col gap-1">
			<span class="w-28 truncate">{p.name}</span>
			<span class="text-zinc-500 dark:text-zinc-400">
				${p.price.toFixed(2)}
			</span>
		</div>
	</a>
{/snippet}

<main class="flex flex-col items-center gap-6 p-6 pt-24">
	<section class="grid gap-3 text-center lg:max-w-screen-lg">
		<h1 class="text-3xl font-extrabold lg:text-6xl">
			Here education and entertainment are always together.
		</h1>
		<h5 class="text-lg text-zinc-500 lg:text-xl">
			For you, your family, loved ones and community.
		</h5>
	</section>
	<section class="flex flex-col gap-3">
		<h5 class="px-6 text-left font-medium">Upcoming Events ({events.length})</h5>
		<article class="flex w-screen gap-3 overflow-x-auto px-6 pb-3 lg:max-w-screen-lg">
			{#each events as event}
				<AEventCard data={event} />
			{/each}
		</article>
		<h5 class="mt-6 px-6 text-left font-medium">Products ({products.length})</h5>
		<article class="flex w-screen gap-3 overflow-x-auto px-6 pb-3 lg:max-w-screen-lg">
			{#each products as product}
				{@render product_card(product)}
			{/each}
		</article>
	</section>
</main>
