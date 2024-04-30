<script lang="ts">
	import { AButton, AIcon } from 'ui';
	import { cash_register } from 'ui/icons';

	let { data } = $props();
	let { product } = data;
</script>

<div>
	<div class="flex gap-3">
		<h1 class="grow">{product.name}</h1>
		<AButton text="Edit" href={`/admin/products/${product.id}/edit`} />
	</div>
	<div class="text-sm text-zinc-500 dark:text-zinc-400 items-center flex gap-2">
		<span>${product.price.toFixed(2)} each &middot;</span>
		<span>{product.type?.name}</span>
		{#if product.inventory}
			<span>&middot; {product.stock} in stock</span>
		{/if}
		{#if product.in_cashier}
			<AIcon data={cash_register} />
		{/if}
	</div>
</div>

<img src={product.cover} class="h-64 w-64 rounded" alt={product.name} />
