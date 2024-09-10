<script>
	import DashboardCard from './DashboardCard.svelte';
	import OverviewChart from './OverviewChart.svelte';
	import RecentPaymentItem from './RecentPaymentItem.svelte';

	let { data } = $props();

	const { events, users, sales, tickets, payments, overview } = data;
</script>

<svelte:head>
	<title>Dashboard &middot; Astral</title>
</svelte:head>

<div class="flex items-center justify-between space-y-2">
	<h2 class="text-3xl font-bold tracking-tight">Dashboard</h2>
</div>
<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
	<DashboardCard title="Users" amount={users} />
	<DashboardCard title="Events" amount={events} />
	<DashboardCard title="Sales" amount={sales} currency />
	<DashboardCard title="Tickets" amount={tickets} />
</div>
<div class="flex gap-4">
	<OverviewChart data={overview} />
	<div class="col-span-3 w-full rounded-xl border bg-card text-card-foreground shadow">
		<div class="flex flex-col space-y-1.5 p-6">
			<h3 class="font-semibold leading-none tracking-tight">Recent Payments</h3>
			<p class="text-sm text-muted-foreground">
				You captured {Math.floor(Math.random() * 100)} payments this month.
			</p>
		</div>
		<div class="p-6 pt-0">
			<div class="space-y-8">
				{#each payments as payment}
					<RecentPaymentItem {payment} />
				{/each}
			</div>
		</div>
	</div>
</div>
