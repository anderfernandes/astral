<script lang="ts">
	import { getContext } from 'svelte';
	import { close } from 'ui/icons';
	import { AIcon } from 'ui';
	import type { Cart } from '$lib';
	import { format, formatDistanceToNow } from 'date-fns';

	const ShoppingCart = getContext<Cart>('ShoppingCart');
</script>

<nav class="flex h-16 items-center px-6">
	<AIcon data={close} size={1.25} href="/" />
</nav>
<section class="flex flex-col gap-3 px-6 md:items-center">
	<article class="flex flex-col gap-3 lg:w-1/2">
		<h1>Shopping Cart ({ShoppingCart.count})</h1>
		{#each ShoppingCart.tickets as ticket}
			{@const start = new Date(ticket.event.start)}
			<div class="flex gap-3 text-sm">
				<div
					class="flex h-16 w-16 gap-3 rounded-xl bg-cover bg-center"
					style={`background-image:url(${ticket.event.show.cover})`}
				></div>
				<div class="flex flex-col">
					<span class="font-medium">
						{ticket.event.show.name}
					</span>
					<span>{ticket.type.name} (${ticket.type.price.toFixed(2)}) x {ticket.quantity}</span>
					<span class="text-zinc-500 dark:text-zinc-400">
						{format(new Date(start), 'EEE MMM d yyyy h:mm a')}
						({formatDistanceToNow(start, { addSuffix: true })})
					</span>
				</div>
			</div>
		{/each}
		{#each ShoppingCart.products as product}
			<div class="flex gap-3 text-sm">
				<div
					class="flex h-16 w-16 gap-3 rounded-xl bg-cover bg-center"
					style={`background-image:url(${product.cover})`}
				></div>
				<div class="flex flex-col">
					<span class="font-medium">{product.name} x {product.quantity}</span>
					<span class="text-zinc-500 dark:text-zinc-400">
						${product.price.toFixed(2)}
					</span>
				</div>
			</div>
		{/each}
	</article>
</section>
