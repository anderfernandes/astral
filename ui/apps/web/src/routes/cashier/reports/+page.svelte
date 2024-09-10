<script lang="ts">
	import { AButton, ADateTimePicker, ASelect } from 'ui';

	let { data } = $props();
</script>

<svelte:head>
	<title>Astral Cashier | Reports</title>
</svelte:head>

<section class="flex w-full flex-col gap-3 px-6 py-4">
	<div class="flex items-center">
		<h1 class="text-lg font-semibold md:text-2xl">Reports</h1>
	</div>
	<div class="grid md:grid-cols-4 md:gap-3">
		<div class="rounded-xl border bg-card text-card-foreground shadow">
			<div class="flex flex-col space-y-1.5 p-6 pb-3">
				<h3 class="font-semibold leading-none tracking-tight">Closeout</h3>
				<p class="text-sm text-muted-foreground">
					A report with the total of money a cashier made during a given date/time range.
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
</section>
