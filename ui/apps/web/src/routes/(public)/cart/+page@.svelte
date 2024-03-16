<script lang="ts">
	import { getContext } from 'svelte';
	import { close } from 'ui/icons';
	import { AIcon } from 'ui';
	import type { Cart } from '$lib';

	const ShoppingCart = getContext<Cart>('ShoppingCart');
</script>

<nav class="flex h-16 items-center px-6">
	<AIcon data={close} size={1.25} href="/" />
</nav>
<section class="flex flex-col gap-3 px-6 md:items-center">
	<article class="flex flex-col gap-3 lg:w-1/2">
		<h1>Shopping Cart ({ShoppingCart.count})</h1>
		{#each ShoppingCart.tickets as ticket}
			<div class="flex gap-3 text-sm">
				<div
					class="flex h-16 w-16 gap-3 rounded-xl bg-cover bg-center"
					style={`background-image:url(${ticket.event.show.cover})`}
				></div>
				<div>
					<span class="font-medium">
						#{ticket.event.id}
						{ticket.event.show.name}
					</span>
					<span>{ticket.type.name} x {ticket.quantity}</span>
				</div>
			</div>
		{/each}
	</article>
</section>
