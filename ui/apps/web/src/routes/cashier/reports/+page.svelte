<script lang="ts">
	import { AButton, ADateTimePicker, ASelect } from 'ui';

	let { data } = $props();
</script>

<svelte:head>
	<title>Astral Cashier | Reports</title>
</svelte:head>

<header
	class="sticky top-0 -mx-6 -mt-6 flex h-16 w-full items-center gap-1 bg-background/50 px-6 backdrop-blur lg:ml-0 lg:px-0 lg:pr-4"
>
	<h2 class="font-semibold">Reports</h2>
</header>

<div class="grid gap-3 lg:grid-cols-3">
	<div class="rounded-xl border bg-card text-card-foreground shadow">
		<div class="flex flex-col space-y-1.5 p-6 pb-3">
			<h3 class="font-semibold leading-none tracking-tight">Closeout</h3>
			<p class="text-sm text-muted-foreground">
				A conciliation closeout report during a given date/time range.
			</p>
		</div>

		<form class="grid gap-4 p-6 pt-0" action="/cashier/reports/closeout" method="GET">
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

		<form class="grid gap-4 p-6 pt-0" action="/cashier/reports/payment" method="GET">
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
