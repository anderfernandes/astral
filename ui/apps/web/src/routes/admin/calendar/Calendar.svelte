<script lang="ts">
	import { isSameDay, startOfDay } from 'date-fns';
	import uniq from 'lodash/uniq';
	import { AChip } from 'ui';

	interface ICalendarProps {
		data: { date: string; events: IEvent[] }[];
	}

	let { data }: ICalendarProps = $props();

	// const dates = uniq(events.map((e) => startOfDay(new Date(e.start)).toISOString())).map(
	// 	(e) => new Date(e)
	// );
</script>

{#each data as { date, events }}
	<h3 class="font-semibold leading-none tracking-tight">
		{Intl.DateTimeFormat('en-US', { dateStyle: 'medium' }).format(new Date(date))}
	</h3>
	{#each events as event}
		<a
			href={`/admin/events/${event.id}`}
			class="flex border-l-8 border-primary pl-2 transition-colors hover:bg-muted/50"
		>
			<div class="mr-2 flex flex-col items-center justify-center">
				<span>
					{Intl.DateTimeFormat('en-US', { timeStyle: 'short' }).format(new Date(event.start))}
				</span>
				<AChip text={event.type.name} />
			</div>
			<img
				alt={`${event.show.name} cover`}
				loading="lazy"
				width="64"
				height="64"
				decoding="async"
				class="aspect-square rounded-md object-cover"
				style="color:transparent"
				src={event.show.cover}
			/>
			<div class="px-3">
				<div class="flex items-center gap-2">
					{#if event.is_public}
						<svg
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
							class="size-5"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 0 1-1.161.886l-.143.048a1.107 1.107 0 0 0-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 0 1-1.652.928l-.679-.906a1.125 1.125 0 0 0-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 0 0-8.862 12.872M12.75 3.031a9 9 0 0 1 6.69 14.036m0 0-.177-.529A2.25 2.25 0 0 0 17.128 15H16.5l-.324-.324a1.453 1.453 0 0 0-2.328.377l-.036.073a1.586 1.586 0 0 1-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 0 1-5.276 3.67m0 0a9 9 0 0 1-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25"
							/>
						</svg>
					{/if}

					<svg
						xmlns="http://www.w3.org/2000/svg"
						width="24"
						height="24"
						viewBox="0 0 24 24"
						fill="none"
						stroke="currentColor"
						stroke-width="2"
						stroke-linecap="round"
						stroke-linejoin="round"
						class="size-5"
						><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /><circle
							cx="9"
							cy="7"
							r="4"
						/><path d="M22 21v-2a4 4 0 0 0-3-3.87" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /></svg
					>
					<span>{event.seats.available}/{event.seats.total}</span>
				</div>
				<div class="flex items-center gap-1 truncate">
					<h3 class="font-semibold leading-none tracking-tight">{event.show.name}</h3>

					<AChip basic text={event.show.type?.name} />
				</div>
			</div>
		</a>
	{/each}
{:else}
	<span class="w-full text-center">No events.</span>
{/each}
