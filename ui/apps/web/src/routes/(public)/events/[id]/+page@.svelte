<script lang="ts">
	import type { Cart } from '$lib';
	import { format, formatDistanceToNow } from 'date-fns';
	import { getContext } from 'svelte';
	import { AButton, AChip, AIcon } from 'ui';
	import { cart, close } from 'ui/icons';

	let { data } = $props();
	let { event, organization } = data;
	const start = new Date(event.start);

	const ShoppingCart = getContext<Cart>('ShoppingCart');
</script>

<svelte:head>
	<title>{organization.name} Event#{event.id} | Astral</title>
</svelte:head>

<nav class="flex h-16 items-center px-6">
	<AIcon data={close} size={1.25} href="/" />
	<a href="/cart" class="flex grow items-center justify-end gap-2">
		{ShoppingCart.count}
		<AIcon data={cart} size={1.25} />
	</a>
</nav>
<section class="flex flex-col items-center p-4">
	<div
		class="h-96 w-60 rounded-xl bg-black bg-cover bg-center"
		style={`background-image:url(${event.show.cover})`}
	></div>
	<br />
	<AChip text={event.show.type?.name!} />
	<h1 class="py-3">{event.show.name}</h1>
	<span class="text-sm">
		{format(start, 'EEE MMM d yyyy @ h:mm a')}
		({formatDistanceToNow(start, { addSuffix: true })})
	</span>
	<span class="text-sm text-zinc-500 dark:text-zinc-400">
		{event.type.name} &middot;
		{event.seats.available} seats left
	</span>
	<div class="flex gap-3 py-3">
		{#each event.type.allowed_tickets.filter((t) => t.price > 0) as ticket_type}
			<AButton
				basic
				text={`${ticket_type.name} $${ticket_type.price.toFixed(2)}`}
				onclick={() => {
					ShoppingCart.addTicket({
						type: ticket_type,
						event
					});
				}}
			/>
		{/each}
	</div>
	<span class="text-sm">
		{event.show.description}
	</span>
</section>
