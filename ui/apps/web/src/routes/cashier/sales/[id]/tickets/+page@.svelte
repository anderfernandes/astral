<script lang="ts">
	import { format } from 'date-fns';

	let { data } = $props();
	let { sale, organization } = data;

	function getEvent(id: number): IEvent | undefined {
		return sale.events?.find((e) => e.id === id);
	}
</script>

<svelte:head>
	<title>Tickets | Sale #{sale.id} | {organization.name} &middot; Astral</title>
</svelte:head>

<main class="grid justify-items-center p-4 font-mono text-xs">
	<div class="w-full md:max-w-screen-sm">
		{#each sale.tickets as ticket}
			<div class="flex flex-col gap-1 border-x border-b border-zinc-500 p-4 first:border-t">
				<p class="w-full text-right">Ticket #{ticket.event_id}{ticket.sale_id}{ticket.id}</p>
				<p class="font-bold">{organization.name}</p>
				<p>Event #{ticket.event_id} &middot; {getEvent(ticket.event_id)?.type.name}</p>
				<p>
					{getEvent(ticket.event_id)?.show.name} &middot;
					{getEvent(ticket.event_id)?.show.type?.name}
				</p>
				{#if getEvent(ticket.event_id)}
					<p>{format(new Date(getEvent(ticket.event_id)?.start!), 'EEE MMM d yyyy @ h:mm a')}</p>
				{/if}
			</div>
		{/each}
	</div>
</main>
