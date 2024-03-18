<script lang="ts">
	import { Cart } from '$lib';
	import { getContext } from 'svelte';
	import { AButton, AIcon } from 'ui';
	import { cart, close } from 'ui/icons';

	let { data } = $props();
	let { product, organization } = data;

	const ShoppingCart = getContext<Cart>('ShoppingCart');
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
	<div class="flex w-full gap-3 md:w-1/3">
		<div
			class="h-32 w-32 rounded bg-cover bg-center"
			style={`background-image:url(${product.cover})`}
		></div>
		<div class="flex flex-col gap-1">
			<h1>{product.name}</h1>
			<span class="text-sm text-zinc-500 dark:text-zinc-400">${product.price}</span>
			<span class="text-sm">{product.description}</span>
			<div>
				<AButton
					text="Add to Cart"
					basic
					onclick={() => {
						ShoppingCart.addProduct(product);
					}}
				/>
			</div>
		</div>
	</div>
</section>
