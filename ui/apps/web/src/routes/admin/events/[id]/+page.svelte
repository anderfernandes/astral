<script lang="ts">
	import { format, formatDistanceToNow } from 'date-fns';
	import { AButton, AIcon } from 'ui';
	import { message_text_outline } from 'ui/icons';

	let { data } = $props();
	let { event, organization } = data;
	let { show, type, memos } = event;
	let start = new Date(event.start);
</script>

<svelte:head>
	<title>Event #${event.id} - {organization.name}</title>
</svelte:head>

<section class="grid p-6">
	<div class="flex items-center">
		<h1 class="grow">Event #{event.id}</h1>
		<AButton text="Edit" href={`/admin/events/${event.id}/edit`} />
	</div>

	<div class="text-sm">
		<span class="text-zinc-500 dark:text-zinc-400">
			{format(start, 'EEE, MMM d yyyy h:mm a')} ({formatDistanceToNow(start, { addSuffix: true })})
		</span>
	</div>
	<div class="text-sm">
		<span>{type.name}</span>
		<span>&middot;</span>
		<span>{event.seats.available} seats available</span>
	</div>
	<div></div>
	<div class="flex items-center gap-3 text-sm">
		<hr />
		<span class="shrink font-semibold">Shows</span>
		<hr />
	</div>
	<div class="flex gap-3 rounded-xl border border-zinc-300 p-3 text-sm dark:border-zinc-800">
		<img src={event.show.cover} class="h-40 w-28 rounded-xl" alt={event.show.name} />
		<div class="flex flex-col">
			<span class="font-medium">{show.name}</span>
			<div>
				<span class="text-zinc-500 dark:text-zinc-400">{show.type?.name}</span>
				<span>&middot;</span>
				<span>{show.duration} mins</span>
			</div>
		</div>
	</div>
	<div class="flex items-center gap-3 text-sm">
		<hr />
		<span class="w-52 text-center font-semibold">Memos ({event.memos.length})</span>
		<hr />
	</div>
	<div class="grid gap-3">
		{#each memos as memo}
			<div class="flex items-center gap-3 text-sm">
				<AIcon data={message_text_outline} size={2.5} />
				<div class="grid">
					<div class="flex gap-1">
						<span class="font-medium">{memo.author.firstname} &middot;</span>
						<span>{memo.author.role.name}</span>
						<span class="text-zinc-500 dark:text-zinc-400">
							({formatDistanceToNow(new Date(memo.created_at), { addSuffix: true })})
						</span>
					</div>
					<span>{memo.message}</span>
				</div>
			</div>
		{/each}
	</div>
</section>
