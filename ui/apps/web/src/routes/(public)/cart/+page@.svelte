<script lang="ts">
	import { getContext } from 'svelte';
	import { close, trash_can_outline } from 'ui/icons';
	import { AAlert, AButton, AIcon } from 'ui';
	import { Cart } from '$lib';
	import { format, formatDistanceToNow } from 'date-fns';
	import { enhance } from '$app/forms';

	let { data } = $props();
	let { organization } = data;

	const ShoppingCart = getContext<Cart>('ShoppingCart');
</script>

<svelte:head>
	<title>Cart - {organization.name} &middot; Astral</title>
</svelte:head>

<nav class="flex h-16 items-center px-6">
	<AIcon data={close} size={1.25} href="/" />
</nav>
<section class="flex flex-col gap-3 px-6 md:items-center">
	<form method="POST" class="flex flex-col gap-3 lg:w-1/2" use:enhance>
		<div class="flex gap-2">
			<h1 class="grow">Shopping Cart ({ShoppingCart.count})</h1>
			{#if ShoppingCart.count > 0}
				<AButton
					text="Clear"
					basic
					onclick={() => {
						if (confirm('Are you sure you want to clear your cart?')) {
							ShoppingCart.clear();
							return;
						}
					}}
				/>
			{/if}
		</div>

		{#if ShoppingCart.count <= 0}
			<div class="flex w-full justify-center">
				<AAlert message="Your cart is empty." />
			</div>
		{/if}

		{#each ShoppingCart.tickets as ticket, i}
			{@const start = new Date(ticket.event.start)}
			<div class="flex w-full items-center gap-3 text-sm">
				<div
					class="flex h-24 w-24 gap-3 rounded bg-cover bg-center"
					style={`background-image:url(${ticket.event.show.cover})`}
				></div>
				<div class="flex grow flex-col">
					<span class="font-medium">
						{ticket.event.show.name}
					</span>
					<span>{ticket.type.name} (${ticket.type.price.toFixed(2)}) x {ticket.quantity}</span>
					<span class="text-zinc-500 dark:text-zinc-400">
						{format(new Date(start), 'EEE MMM d yyyy h:mm a')}
						({formatDistanceToNow(start, { addSuffix: true })})
					</span>
				</div>
				<AIcon
					data={trash_can_outline}
					size={1.5}
					onclick={() => {
						if (
							confirm(
								`Are you sure you want to remove all ${ticket.type.name} tickets from your cart?`
							)
						) {
							ShoppingCart.clearTicket(ticket);
						}
					}}
				/>
			</div>
			<input type="hidden" name={`tickets[${i}][event_id]`} value={ticket.event.id} />
			<input type="hidden" name={`tickets[${i}][type_id]`} value={ticket.type.id} />
			<input type="hidden" name={`tickets[${i}][quantity]`} value={ticket.quantity} />
		{/each}

		{#each ShoppingCart.products as product, j}
			<div class="flex items-center gap-3 text-sm">
				<div
					class="flex h-24 w-24 gap-3 rounded bg-cover bg-center"
					style={`background-image:url(${product.cover})`}
				></div>
				<div class="flex grow flex-col">
					<span class="font-medium">{product.name} x {product.quantity}</span>
					<span class="text-zinc-500 dark:text-zinc-400">
						${product.price.toFixed(2)}
					</span>
				</div>
				<AIcon
					data={trash_can_outline}
					size={1.5}
					onclick={() => {
						if (confirm(`Are you sure you want to remove all ${product.name}(s) from your cart?`)) {
							ShoppingCart.clearProduct(product);
						}
					}}
				/>
			</div>
			<input type="hidden" name={`products[${j}][id]`} value={product.id} />
			<input type="hidden" name={`products[${j}][quantity]`} value={product.quantity} />
		{/each}

		{#if ShoppingCart.count > 0}
			<div>
				<div class="flex gap-2">
					<span class="grow">Subtotal</span>
					<span>$</span>
					<span class="w-16 text-right">{ShoppingCart.totals.subtotal}</span>
				</div>
				<div class="flex gap-2">
					<span class="grow">Tax</span>
					<span>$</span>
					<span class="w-16 text-right">{ShoppingCart.totals.tax}</span>
				</div>
				<div class="flex gap-2">
					<span class="grow">Total</span>
					<span>$</span>
					<span class="w-16 text-right">{ShoppingCart.totals.total}</span>
				</div>
			</div>
			<div class="flex justify-end">
				<AButton text="Checkout" type="submit" />
			</div>
		{/if}
	</form>
</section>
