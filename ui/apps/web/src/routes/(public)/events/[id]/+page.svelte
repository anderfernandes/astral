<script lang="ts">
	let { data } = $props();
	const { settings, event } = data;
	const { organization } = settings;
</script>

<svelte:head>
	<title>{organization.name} Event #{event.id} | Astral</title>
</svelte:head>

<section class="grid gap-3 p-6">
	<a href="/" aria-label="Home">
		<svg class="h-6 w-6" viewBox="0 0 24 24">
			<path
				fill="currentColor"
				d="M20,10V14H11L14.5,17.5L12.08,19.92L4.16,12L12.08,4.08L14.5,6.5L11,10H20Z"
			></path>
		</svg>
	</a>
	<h2 class="text-2xl font-bold tracking-tight">#{event.id} {event.show.name}</h2>
	<p class="text-muted-foreground">
		{Intl.DateTimeFormat('en-US', { dateStyle: 'long', timeStyle: 'short' }).format(
			new Date(event.start)
		)}
	</p>
</section>
