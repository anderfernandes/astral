<script lang="ts">
	import { Cart } from '$lib';
	import { getContext } from 'svelte';
	import { AAlert, AButton, AIcon } from 'ui';
	import { cart, close } from 'ui/icons';

	let { data } = $props();
	let { product, organization } = data;

	const ShoppingCart = getContext<Cart>('ShoppingCart');

	let count = $derived(ShoppingCart.products.find((p) => p.id === product.id)?.quantity);
</script>

<svelte:head>
	<title>{organization.name} {product.name} | Astral</title>
</svelte:head>

<nav class="flex h-16 items-center px-6">
	<AIcon data={close} size={1.25} href="/" />
	<a href="/cart" class="flex grow items-center justify-end gap-2">
		{ShoppingCart.count}
		<AIcon data={cart} size={1.25} />
	</a>
</nav>
<section class="flex flex-col items-center gap-3 p-4">
	<article class="flex w-full flex-col gap-3 md:w-1/3">
		{#if product.stock <= 0}
			<AAlert message="This product is out of stock." />
		{/if}
		<div class="flex w-full gap-3">
			<div
				class="h-32 w-32 rounded bg-cover bg-center"
				style={`background-image:url(${product.cover})`}
			></div>
			<div class="flex flex-col gap-1">
				<h1>{product.name}</h1>
				<span class="text-sm">
					${product.price.toFixed(2)}
					{#if count}x {count}{/if}
				</span>
				<div>
					<AButton
						text="Add to Cart"
						basic
						disabled={product.stock <= 0}
						onclick={() => {
							ShoppingCart.addProduct(product);
						}}
					/>
				</div>
			</div>
		</div>
		<span class="w-full text-left text-sm">{product.description}</span>
	</article>
</section>
