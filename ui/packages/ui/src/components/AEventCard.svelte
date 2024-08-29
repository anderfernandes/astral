<script lang="ts">
	interface IAEventCardProps {
		data: {
			id?: number;
			start: string;
			type: { name: string };
			seats: { available: number };
			show: {
				name: string;
				cover: string;
				type?: {
					name: string;
				};
			};
		};
	}

	let { data }: IAEventCardProps = $props();
</script>

<div class="w-[250px] space-y-3">
	<span data-state="closed"
		><div class="overflow-hidden rounded-md">
			<img
				alt="React Rendezvous"
				loading="lazy"
				width="250"
				height="330"
				decoding="async"
				data-nimg="1"
				class="aspect-[3/4] h-auto w-auto object-cover transition-all hover:scale-105"
				style="color: transparent;"
				src={data.show.cover}
			/>
		</div></span
	>
	<div class="space-y-1 text-sm">
		<h3 class="font-medium leading-none">{data.show.name}</h3>
		<p class="text-muted-foreground text-xs">{data.show.type?.name} &middot; {data.type.name}</p>
	</div>
</div>
