<script>
	import { AButton } from 'ui';

	let { data } = $props();
</script>

<header
	class="sticky top-0 -mx-6 flex h-16 items-center gap-3 bg-background/50 px-6 font-semibold backdrop-blur"
>
	<h2 class="grow text-xl font-semibold">Shows</h2>
	<AButton text="New Show" href="/admin/shows/create" />
</header>

<div class="grid grid-cols-2 gap-6 lg:flex lg:gap-0 lg:space-x-4">
	{#each data.shows as show}
		<a href={`/admin/shows/${show.id}`} class="w-full space-y-3 lg:w-[150px]">
			<span data-state="closed"
				><div class="overflow-hidden rounded-md">
					<img
						alt={show.name}
						loading="lazy"
						width="150"
						height="150"
						decoding="async"
						data-nimg="1"
						class="aspect-square h-auto w-auto object-cover transition-all hover:scale-105"
						style="color: transparent;"
						src={show.cover}
					/>
				</div></span
			>
			<div class="space-y-1 text-sm">
				<h3 class="truncate font-medium leading-none">{show.name}</h3>
				<p class="text-xs text-muted-foreground">{show.type?.name}</p>
			</div>
		</a>
	{/each}
</div>
