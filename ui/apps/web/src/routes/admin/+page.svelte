<script>
	import DashboardCard from './DashboardCard.svelte';
	import RecentPaymentItem from './RecentPaymentItem.svelte';

	let { data } = $props();

	const { events, users, sales, tickets, payments } = data;
</script>

<h2
	class="sticky top-0 -mx-6 flex h-16 items-center bg-background/50 px-6 text-xl font-bold backdrop-blur"
>
	Dashboard
</h2>

<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
	<DashboardCard title="Users" amount={users} />
	<DashboardCard title="Events" amount={events} />
	<DashboardCard title="Sales" amount={sales} />
	<DashboardCard title="Tickets" amount={tickets} />
</div>

<div class="flex gap-4">
	<div class="col-span-3 w-full rounded-xl border bg-card text-card-foreground shadow">
		<div class="flex flex-col space-y-1.5 p-6">
			<h3 class="font-semibold leading-none tracking-tight">Recent Payments</h3>
			<p class="text-sm text-muted-foreground">Last 5 payments received</p>
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
