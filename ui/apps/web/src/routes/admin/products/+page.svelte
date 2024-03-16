<script lang="ts">
	import { AButton } from 'ui';

	let { data } = $props();
	let { products, organization } = data;
</script>

<svelte:head>
	<title>Products | {organization.name} &middot; Astral</title>
</svelte:head>

<div class="flex gap-3">
	<h1 class="grow">Products ({products.length})</h1>
	<AButton text="New Product" href="/admin/products/create" />
</div>

<section class="grid gap-3 lg:grid-cols-2">
	{#each products as product}
		<a
			href={`/admin/products/${product.id}`}
			class="flex gap-3 rounded-xl border border-zinc-200 text-sm dark:border-zinc-700"
		>
			<img src={product.cover} class="h-20 w-20 rounded-bl-xl rounded-tl-xl" alt={product.name} />
			<div class="flex flex-col p-1">
				<span class="font-medium">{product.name}</span>
				<div class="text-zinc-500 dark:text-zinc-400">
					<span>{product.type?.name} &middot;</span>
					<span>${product.price.toFixed(2)} each</span>
					{#if product.inventory}
						<span>
							&middot; {product.stock} in stock
						</span>
					{/if}
				</div>
			</div>
		</a>
	{/each}
</section>
