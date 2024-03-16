<script lang="ts">
	import { enhance } from '$app/forms';
	import { goto } from '$app/navigation';
	import { AButton, ADateTimePicker, ASelect } from 'ui';

	let { data } = $props();
	let { users } = data;
</script>

<section class="flex h-[calc(100vh-5rem)] flex-col gap-3 overflow-y-auto p-6">
	<h1>Reports</h1>
	<article class="grid md:grid-cols-4 md:gap-3">
		<div class="flex flex-col gap-3 rounded-xl border border-zinc-200 p-3 text-sm">
			<h5 class="text-base font-semibold">Closeout</h5>
			<span class="text-zinc-500 dark:text-zinc-400">
				A report with the total of money a cashier made during a given date/time range.
			</span>
			<form
				class="grid gap-3"
				action="/cashier/reports/closeout"
				method="POST"
				use:enhance={({ formData, cancel }) => {
          const cashier = formData.get('cashier')
					const start = new Date(formData.get('start') as string).getTime() / 1000
					const end = new Date(formData.get('end') as string).getTime() / 1000
          goto(`/cashier/reports/closeout?cashier=${cashier}&start=${start}&end=${end}`)
					cancel();
					return async () => {};
				}}
			>
				<ASelect
					name="cashier"
					options={users}
					label="Cashier"
					placeholder="Select a Cashier"
					required
				/>
				<ADateTimePicker name="start" label="Start" placeholder="Start" required />
				<ADateTimePicker name="end" label="End" placeholder="End" required />
				<AButton text="Submit" type="submit" />
			</form>
		</div>
		<div class="flex flex-col gap-3 rounded-xl border border-zinc-200 p-3 text-sm">
			<h5 class="text-base font-semibold">Payment</h5>
			<span class="text-zinc-500 dark:text-zinc-400">
				A report that lists every transaction a cashier made during a given date/time range.
			</span>
			<form
				class="grid gap-3"
				action="/cashier/reports/payment"
				method="POST"
				use:enhance={({ formData, cancel }) => {
        const cashier = formData.get('cashier')
        const start = new Date(formData.get('start') as string).getTime() / 1000
        const end = new Date(formData.get('end') as string).getTime() / 1000
        goto(`/cashier/reports/payment?cashier=${cashier}&start=${start}&end=${end}`)
        cancel();
        return async () => {};
      }}
			>
				<ASelect
					name="cashier"
					options={users}
					label="Cashier"
					placeholder="Select a Cashier"
					required
				/>
				<ADateTimePicker name="start" label="Start" placeholder="Start" required />
				<ADateTimePicker name="end" label="End" placeholder="End" required />
				<AButton text="Submit" type="submit" />
			</form>
		</div>
	</article>
</section>
