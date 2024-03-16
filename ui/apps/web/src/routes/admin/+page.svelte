<script lang="ts">
	let { data } = $props();

	const { events } = data;
</script>

<h1>Dashboard</h1>

<div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
	<div class="bg-card text-card-foreground rounded-xl border shadow">
		<div class="flex flex-row items-center justify-between space-y-0 p-6 pb-2">
			<h3 class="text-sm font-medium tracking-tight">Events</h3>
		</div>
		<div class="p-6 pt-0">
			<div class="text-2xl font-bold">{events}</div>
			<p class="text-muted-foreground text-xs">+20.1% from last month</p>
		</div>
	</div>
</div>
