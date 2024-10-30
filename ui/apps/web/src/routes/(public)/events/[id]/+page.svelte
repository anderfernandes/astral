<script lang="ts">
	let { data } = $props();
	const { settings, event } = data;
	const { organization } = settings;
</script>

<svelte:head>
	<title>{organization.name} Event #{event.id} | Astral</title>
</svelte:head>

<section class="grid gap-6 p-6">
	<a href="/" aria-label="Home">
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
			class="size-6"
		>
			<path d="m12 19-7-7 7-7" />
			<path d="M19 12H5" />
		</svg>
	</a>
	<img src={event.show.cover} alt={event.show.name} class="w-full rounded lg:w-[192px]" />
	<div>
		<h2 class="text-2xl font-bold tracking-tight">#{event.id} {event.show.name}</h2>
		<p class="text-muted-foreground">
			{Intl.DateTimeFormat('en-US', {
				weekday: 'short',
				day: 'numeric',
				month: 'short',
				year: 'numeric',
				hour: 'numeric',
				minute: 'numeric'
			}).format(new Date(event.start))}
		</p>
	</div>
</section>
