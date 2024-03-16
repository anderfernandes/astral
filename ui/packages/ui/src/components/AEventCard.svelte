<script lang="ts">
	interface IAEventCardProps {
		data: {
			id?: number;
			start: string;
			show: {
				name: string;
				cover: string;
				type?: {
					name: string;
				};
			};
		};
	}
	let { data } = $props<IAEventCardProps>();
</script>

<a
	href={`/events/${data.id}`}
	class="relative flex h-96 w-60 flex-col justify-end gap-1 rounded-2xl p-6 text-sm"
>
	<div
		class="absolute left-0 top-0 z-10 h-full w-full rounded-2xl bg-gradient-to-t from-zinc-900 from-20%"
	></div>
	<img
		class="absolute left-0 top-0 h-full w-full rounded-2xl object-cover"
		src={data.show.cover}
		alt="Black Holes: The Other Side of Infinity"
	/>
	<span class="z-10 w-[calc(100%)] truncate text-zinc-400"
		>{new Date(data.start).toDateString()} &middot; Weekend</span
	>
	<span class="z-10 w-[calc(100%)] truncate text-lg font-bold text-white">{data.show.name}</span>
	<span class="zinc-500 z-10 w-[calc(100%)] truncate text-white"
		>{data.show.type?.name} &middot; 180 seats</span
	>
</a>
