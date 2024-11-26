<script lang="ts">
	import { AButton, ADateTimePicker, ASelect } from 'ui';

	let { data } = $props();
</script>

<svelte:head>
	<title>Reports | Astral</title>
</svelte:head>

{#snippet header()}
	<h2 class="text-xl font-bold">Reports</h2>
{/snippet}

<header
	class="sticky top-0 -mx-6 flex h-16 items-center gap-3 bg-background/50 px-6 font-semibold backdrop-blur"
>
	<h2 class="grow text-xl font-semibold">Reports</h2>
</header>

<div class="grid md:gap-3 lg:grid-cols-2">
	<div class="rounded-xl border bg-card text-card-foreground shadow">
		<div class="flex flex-col space-y-1.5 p-6 pb-3">
			<h3 class="font-semibold leading-none tracking-tight">Closeout</h3>
			<p class="text-sm text-muted-foreground">
				A report with the total of money a cashier made during a given date/time range.
			</p>
		</div>

		<form class="grid gap-4 p-6 pt-0" action="/cashier/reports/closeout" method="get">
			<ASelect
				name="cashier"
				options={data.users}
				label="Cashier"
				placeholder="Select a Cashier"
				required
			/>
			<ADateTimePicker name="start" label="Start" placeholder="Start" required unix />
			<ADateTimePicker name="end" label="End" placeholder="End" required unix />
			<AButton text="Submit" type="submit" />
		</form>
	</div>
	<div class="rounded-xl border bg-card text-card-foreground shadow">
		<div class="flex flex-col space-y-1.5 p-6 pb-3">
			<h3 class="font-semibold leading-none tracking-tight">Payment</h3>
			<p class="text-sm text-muted-foreground">
				Lists every transaction a cashier made during a given date/time range.
			</p>
		</div>

		<form class="grid gap-4 p-6 pt-0" action="/cashier/reports/payment" method="get">
			<ASelect
				name="cashier"
				options={data.users}
				label="Cashier"
				placeholder="Select a Cashier"
				required
			/>
			<ADateTimePicker name="start" label="Start" placeholder="Start" required unix />
			<ADateTimePicker name="end" label="End" placeholder="End" required unix />
			<AButton text="Submit" type="submit" />
		</form>
	</div>
</div>
