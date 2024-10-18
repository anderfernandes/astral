<script lang="ts">
	import { AButton, ADateTimePicker, ASelect } from 'ui';
	import AdminLayout from '../AdminLayout.svelte';

	let { data } = $props();
</script>

{#snippet header()}
	<h2 class="text-xl font-bold">Reports</h2>
{/snippet}

<AdminLayout title="Reports" {header} nav>
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
</AdminLayout>
