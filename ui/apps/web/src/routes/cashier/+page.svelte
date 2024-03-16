<script lang="ts">
	import { enhance } from '$app/forms';
	import { page } from '$app/stores';
	import { format, formatDistanceToNow } from 'date-fns';
	import { AButton, AIcon, AInput, ASelect, ATabItem, ATabs } from 'ui';
	import { calendar_month_outline, package_variant_closed, trash_can_outline } from 'ui/icons';

	let { data } = $props();
	let { customers, payment_methods, organization } = data;

	let items = $state<ISaleItems>({
		tickets: [],
		products: []
	});

	let tendered = $state('0.00');
	let payment_method_id = $state(1);
	let reference = $state('');
	let customer_id = $state(1);

	let totals = $derived.by(() => {
		const tickets_subtotal = items.tickets.reduce((sum, t) => t.type.price * t.quantity + sum, 0);
		const products_subtotal = items.products.reduce((sum, p) => p.data.price * p.quantity + sum, 0);
		const subtotal = tickets_subtotal + products_subtotal;
		const tax = parseFloat(((organization.tax / 100) * subtotal).toFixed(2));
		const total = subtotal + tax;
		const change = parseFloat(tendered) - total;
		return {
			subtotal: subtotal.toFixed(2),
			tax: tax.toFixed(2),
			total: total.toFixed(2),
			change: change >= 0 ? change.toFixed(2) : (0).toFixed(2)
		};
	});

	function keypad(e: MouseEvent & { currentTarget: EventTarget & HTMLButtonElement }) {
		e.preventDefault();
		if (payment_method_id !== 1 || parseFloat(totals.total) <= 0) return;
		const n = e.currentTarget.value;
		tendered = tendered === '0.00' ? n : tendered.concat(n);
	}

	function reset() {
		items = {
			tickets: [],
			products: []
		};
		tendered = '0.00';
		payment_method_id = 1;
		reference = '';
		customer_id = 1;
	}
</script>

<section class="flex w-full flex-col gap-3 p-6 md:flex-row">
	<article class="flex grow flex-col gap-3">
		<ATabs>
			<ATabItem
				text={`Events (${data.events.length})`}
				href="/cashier"
				icon={calendar_month_outline}
			/>
			<ATabItem
				text={`Products (${data.products.length})`}
				href="/cashier?tab=products"
				icon={package_variant_closed}
			/>
		</ATabs>
		{#if $page.url.searchParams.has('tab') && $page.url.searchParams.get('tab') === 'products'}
			<div class="grid grid-cols-2 gap-2" id="products">
				{#each data.products as product}
					<button
						class="flex gap-2 text-left text-sm"
						onclick={() => {
							const p = items.products.find((_p) => product.id === _p.id);

							if (p === undefined) {
								items.products.push({id: product.id!, quantity: 1, data: product})
							} else {
								const i = items.products.findIndex(_p => _p.id === p.id)
								items.products.splice(i, 1, {...p, quantity: p.quantity + 1})
							}
						}}
					>
						<div
							class="h-16 w-16 rounded bg-cover bg-center"
							style={`background-image:url(${product.cover}) `}
						></div>
						<div class="grid">
							<span class="font-medium">{product.name}</span>
							<span>{product.type?.name} &middot; ${product.price.toFixed(2)}</span>
							{#if product.inventory}
								<span class="text-zinc-500 dark:text-zinc-400">{product.stock} in stock</span>
							{/if}
						</div>
					</button>
				{/each}
			</div>
		{:else}
			<div class="grid gap-2" id="events">
				{#each data.events as event}
					{@const start = new Date(event.start)}
					<div class="flex gap-2">
						<div
							class="h-24 w-24 rounded-xl bg-black bg-cover bg-center"
							style={`background-image:url(${event.show.cover})`}
						></div>
						<div class="flex flex-col gap-2 text-sm">
							<span class="font-medium">{event.show.name}</span>
							<div class="text-zinc-500 dark:text-zinc-400">
								<span>{event.seats.available}/{event.seats.total} seats</span>
								&middot;
								<span>{event.show.type?.name}</span>
								&middot;
								<span>{event.type.name}</span>
								&middot;
								<span
									>{format(
										start,
										start.getMinutes() === 0 ? 'EEE MMM d @ h a' : 'EEE MMM d @ h:mm a'
									)}</span
								>
								<span>({formatDistanceToNow(start, { addSuffix: true })})</span>
							</div>
							<div class="flex gap-2">
								{#each event.type.allowed_tickets as allowed_ticket}
									<AButton
										text={`${allowed_ticket.name} $${allowed_ticket.price.toFixed(2)}`}
										basic
										onclick={() => {
										const ticket = items.tickets.find(
											(t) => t.type_id === allowed_ticket.id && t.event_id === event.id
										);
										console.log(ticket);
										if (ticket === undefined) {
											items?.tickets.push({type_id: allowed_ticket.id!, quantity: 1, event_id: event.id!, event, type: allowed_ticket})
										} else {
											const i = items.tickets.findIndex((t) => t.type_id === allowed_ticket.id && t.event_id === event.id)
											items.tickets.splice(i, 1, {...ticket, quantity: ticket.quantity + 1})
										}
										if (payment_method_id !== 1)
											tendered = totals.total
									}}
									/>
								{/each}
							</div>
						</div>
					</div>
				{/each}
			</div>
		{/if}
	</article>

	<article class="flex w-64 flex-col gap-3">
		<h5 class="font-medium">Sale Items ({items.tickets.length + items.products.length})</h5>
		{#each items.tickets as ticket}
			<div class="grid gap-2 text-sm">
				<span class="w-[calc(95%)] truncate font-medium">
					#{ticket.event_id}
					{ticket.event.show.name}
				</span>
				<div class="flex grow">
					<span class="grow">
						{ticket.type.name}
						${ticket.type.price.toFixed(2)} x {ticket.quantity}
					</span>
					<AIcon
						data={trash_can_outline}
						onclick={() => {
							if (
								confirm(
									`You're about to remove all ${ticket.quantity}${ticket.type.name} from this sale. Are you sure?`
								)
							) {
								items.tickets = items.tickets.filter(
									(t) => !(t.type_id === ticket.type_id && t.event_id === ticket.event_id)
								);
							}
						}}
					/>
				</div>
			</div>
		{/each}
		{#each items.products as product}
			<div class="grid text-sm">
				<span class="font-medium">
					{product.data.name}
				</span>
				<div class="flex">
					<span class="grow">
						{product.quantity} x ${product.data.price.toFixed(2)}
					</span>
					<AIcon
						data={trash_can_outline}
						onclick={() => {
							if (
								confirm(
									`You are about to remove all ${product.quantity} ${product.data.name} from this sale. Are you sure?`
								)
							) {
								items.products = items.products.filter((p) => p.id !== product.id);
							}
						}}
					/>
				</div>
			</div>
		{/each}
	</article>

	<form
		class="flex w-64 flex-col gap-3"
		method="POST"
		use:enhance={({ cancel }) => {
			if (!confirm(`Charge $${totals.total}?`)) cancel();
			return async ({ result, update }) => {
				await update();
				if (result.type === 'redirect') {
					alert(`Sale registered successfully!`);
					reset();
				}
				console.log(result);
			};
		}}
	>
		<ASelect
			name="customer_id"
			bind:value={customer_id}
			options={customers}
			label="Customer"
			required
		/>
		<div class="grid gap-2">
			<div class="flex text-sm">
				<span class="grow">Subtotal</span>
				<span>+</span>
				<span class="w-16 text-right">${totals.subtotal}</span>
			</div>
			<div class="flex text-sm">
				<span class="grow">Tax ({organization.tax}%)</span>
				<span>+</span>
				<span class="w-16 text-right">${totals.tax}</span>
			</div>
			<div class="flex text-sm font-bold">
				<span class="grow">Total</span>
				<span>=</span>
				<span class="w-16 text-right">${totals.total}</span>
			</div>
			<div class="flex text-sm">
				<span class="grow">Change</span>
				<span class="w-16 text-right">${totals.change}</span>
			</div>
			<div class="flex text-xl font-medium">
				<span class="grow">Tendered</span>
				<span class="text-right">${tendered}</span>
				<input type="hidden" name="tendered" bind:value={tendered} />
			</div>
		</div>
		<div class="grid grid-cols-3 gap-2 text-sm">
			<button class="a-keypad-button" value="7" onclick={keypad}>7</button>
			<button class="a-keypad-button" value="8" onclick={keypad}>8</button>
			<button class="a-keypad-button" value="9" onclick={keypad}>9</button>
			<button class="a-keypad-button" value="4" onclick={keypad}>4</button>
			<button class="a-keypad-button" value="5" onclick={keypad}>5</button>
			<button class="a-keypad-button" value="6" onclick={keypad}>6</button>
			<button class="a-keypad-button" value="1" onclick={keypad}>1</button>
			<button class="a-keypad-button" value="2" onclick={keypad}>2</button>
			<button class="a-keypad-button" value="3" onclick={keypad}>3</button>
			<button
				class="a-keypad-button"
				onclick={(e) => {
					e.preventDefault();
					tendered = '0.00';
				}}>C</button
			>
			<button class="a-keypad-button" value="0" onclick={keypad}>0</button>
			<button class="a-keypad-button" value="." onclick={keypad}>.</button>
		</div>
		<ASelect
			name="method_id"
			options={payment_methods}
			required
			label="Payment Method"
			bind:value={payment_method_id}
			onchange={(e: { currentTarget: EventTarget & HTMLSelectElement}) => {
				if (e.currentTarget.value !== "1")
					tendered = totals.total
			}}
		/>
		<AInput
			name="reference"
			bind:value={reference}
			label="Reference"
			placeholder="Reference"
			disabled={payment_method_id === 1}
			required={payment_method_id !== 1}
		/>
		<AButton
			text={`Charge $${totals.total}`}
			type="submit"
			disabled={items.tickets.length + items.products.length <= 0 ||
				parseFloat(tendered) < parseFloat(totals.total)}
		/>
		<AButton
			text="Reset"
			disabled={items.tickets.length + items.products.length <= 0}
			onclick={() => {
				if (confirm('Are you sure you want to clear all items in this sale and start over?'))
					reset();
			}}
			basic
		/>
		{#each items.tickets as ticket, i}
			<input type="hidden" name={`tickets[${i}][type_id]`} value={ticket.type_id} />
			<input type="hidden" name={`tickets[${i}][event_id]`} value={ticket.event_id} />
			<input type="hidden" name={`tickets[${i}][quantity]`} value={ticket.quantity} />
		{/each}
		{#each items.products as product, i}
			<input type="hidden" name={`products[${i}][id]`} value={product.id} />
			<input type="hidden" name={`products[${i}][quantity]`} value={product.quantity} />
		{/each}
	</form>
</section>

<style lang="postcss">
	.a-keypad-button {
		@apply h-12 rounded bg-black text-lg font-bold text-white dark:bg-white dark:text-black;
	}
</style>
