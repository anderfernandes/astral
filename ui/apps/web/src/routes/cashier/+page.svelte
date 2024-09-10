<script lang="ts">
	import { page } from '$app/stores';
	import { AButton, ADatePicker, AInput, ASelect } from 'ui';

	let { data } = $props();

	let tendered = $state('0.00');

	let method = $state(data.payment_methods[0].id);

	const handleKeyPress = (e: MouseEvent & { currentTarget: EventTarget & HTMLButtonElement }) => {
		e.preventDefault();
		if (method !== 1) {
			return;
		}
		const value = e.currentTarget.value;
		// Only one decimal separator
		if (value === '.' && tendered.includes('.')) return;
		// Only two decimal places
		if (
			tendered !== '0.00' &&
			tendered.includes('.') &&
			tendered.concat(value).split('.')[1].length > 2
		)
			return;
		// Update tendered
		tendered = tendered === '0.00' ? e.currentTarget.value : tendered.concat(e.currentTarget.value);
	};

	interface ICartTicket {
		ticket_type: ITicketType;
		event: IEvent;
		quantity: number;
	}
	interface ICartProduct {
		product: IProduct;
		quantity: number;
	}

	let cart = $state<{ tickets: ICartTicket[]; products: ICartProduct[] }>({
		tickets: [],
		products: []
	});

	let { subtotal, tax, total, change, balance } = $derived.by(() => {
		const tickets_subtotal = cart.tickets.reduce(
			(sum, t) => t.ticket_type.price * t.quantity + sum,
			0
		);
		const products_subtotal = cart.products.reduce(
			(sum, p) => p.product.price * p.quantity + sum,
			0
		);
		const subtotal = tickets_subtotal + products_subtotal;
		const tax = parseFloat(((data.settings.organization.tax / 100) * subtotal).toFixed(2));
		const total = subtotal + tax;
		const change = parseFloat(tendered) - total;
		const balance = parseFloat(tendered) - total;
		return {
			subtotal,
			tax,
			total,
			change: change >= 0 ? change : 0,
			balance: balance >= 0 ? 0 : balance * -1
		};
	});
</script>

<svelte:head>
	<title>Astral - Cashier</title>
</svelte:head>

<div class="flex flex-col gap-2 pl-4 lg:w-3/5">
	<!-- Tabs -->

	<div class="flex items-center gap-3">
		<div class="my-4 flex items-center overflow-x-auto">
			<a
				href="/cashier"
				class:border-b-4={$page.url.pathname.includes('/cashier') &&
					$page.url.searchParams.size === 0}
				class="flex gap-2 rounded-t-md border-primary px-5 pb-2 pt-3 text-sm font-semibold hover:bg-muted"
			>
				<svg
					xmlns="http://www.w3.org/2000/svg"
					width="24"
					height="24"
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					stroke-width="2"
					stroke-linecap="round"
					stroke-linejoin="round"
					class="lucide lucide-ticket"
					><path
						d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"
					/><path d="M13 5v2" /><path d="M13 17v2" /><path d="M13 11v2" /></svg
				>
				<div>Tickets</div>
			</a>
			<a
				href="?tab=products"
				class:border-b-4={$page.url.searchParams.has('tab') &&
					$page.url.searchParams.get('tab') === 'products'}
				class="flex gap-2 rounded-t-md border-primary px-5 pb-2 pt-3 text-sm font-semibold hover:bg-muted"
			>
				<svg
					xmlns="http://www.w3.org/2000/svg"
					width="24"
					height="24"
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					stroke-width="2"
					stroke-linecap="round"
					stroke-linejoin="round"
					class="lucide lucide-box"
					><path
						d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"
					/><path d="m3.3 7 8.7 5 8.7-5" /><path d="M12 22V12" /></svg
				>
				<div>Products</div>
			</a>
		</div>
		<div class="mr-4 flex grow items-center justify-end">
			<ADatePicker format={{ dateStyle: 'medium' }} value={new Date()} />
		</div>
	</div>
	<!-- Events or Products -->
	{#if $page.url.searchParams.has('tab') && $page.url.searchParams.get('tab') === 'products'}
		<!-- Products -->
		<div class="grid grid-cols-2 gap-4">
			{#each data.products as product}
				<button
					class="flex items-center justify-between space-x-4"
					onclick={() => {
						const i = cart.products.findIndex((p) => p.product.id === product.id);
						if (i === -1) cart.products.push({ product, quantity: 1 });
						else cart.products[i].quantity++;
					}}
				>
					<div class="flex items-center space-x-4">
						<span class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full">
							<img class="aspect-square h-full w-full" alt={product.name} src={product.cover} />
						</span>
						<div>
							<p class="text-left text-sm font-medium leading-none">
								{product.name} &middot; ${product.price}
							</p>
							<p class="text-left text-sm text-muted-foreground">
								{product.type?.name} &middot; {product.stock} in stock
							</p>
						</div>
					</div>
					<!-- <button
				class="ml-auto inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md border border-input bg-background px-4 py-2 text-sm font-medium shadow-sm transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
				type="button"
				aria-haspopup="dialog"
				aria-expanded="false"
				aria-controls="radix-:rsj:"
				data-state="closed"
				>Owner <svg
					width="15"
					height="15"
					viewBox="0 0 15 15"
					fill="none"
					xmlns="http://www.w3.org/2000/svg"
					class="ml-2 h-4 w-4 text-muted-foreground"
					><path
						d="M3.13523 6.15803C3.3241 5.95657 3.64052 5.94637 3.84197 6.13523L7.5 9.56464L11.158 6.13523C11.3595 5.94637 11.6759 5.95657 11.8648 6.15803C12.0536 6.35949 12.0434 6.67591 11.842 6.86477L7.84197 10.6148C7.64964 10.7951 7.35036 10.7951 7.15803 10.6148L3.15803 6.86477C2.95657 6.67591 2.94637 6.35949 3.13523 6.15803Z"
						fill="currentColor"
						fill-rule="evenodd"
						clip-rule="evenodd"
					></path></svg
				></button
			> -->
				</button>
			{/each}
		</div>
	{:else}
		<!-- Events-->
		<div class="grid gap-4" id="dates-container">
			{#each data.days as day}
				<p class="flex items-center gap-1">
					<svg
						xmlns="http://www.w3.org/2000/svg"
						width="24"
						height="24"
						viewBox="0 0 24 24"
						fill="none"
						stroke="currentColor"
						stroke-width="2"
						stroke-linecap="round"
						stroke-linejoin="round"
						class="size-5"
						><path d="M8 2v4" /><path d="M16 2v4" /><rect
							width="18"
							height="18"
							x="3"
							y="4"
							rx="2"
						/><path d="M3 10h18" /><path d="m9 16 2 2 4-4" /></svg
					>
					{Intl.DateTimeFormat('en-US', { dateStyle: 'medium' }).format(new Date(day.date))}
				</p>
				<div class="grid gap-2">
					{#each day.events as event}
						{@const start = new Date(event.start)}
						{@const end = new Date(event.end)}
						<div class="flex gap-3">
							<img
								src={event.show.cover}
								class="aspect-square rounded-md object-cover"
								width="96"
								height="96"
								alt={event.show.name}
							/>
							<div class="flex w-full gap-2">
								<div class="flex w-2/5 flex-col gap-1">
									<h3 class="font-medium">{event.show.name}</h3>
									<p class="text-sm text-muted-foreground">
										{Intl.DateTimeFormat('en-US', {
											dateStyle: 'medium',
											timeStyle: 'short'
										}).format(start)}
									</p>
									<div class="flex gap-1">
										<span
											class="inline-flex items-center rounded-md border border-transparent bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground transition-colors hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
										>
											{event.show.type?.name}
										</span>
										<div
											class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
										>
											{event.type.name}
										</div>
										{event.seats.available}/{event.seats.total}
									</div>
								</div>
								<div class="flex flex-nowrap justify-end gap-2">
									{#each event.type.allowed_tickets as ticket_type}
										<AButton
											text={`${ticket_type.name} $${ticket_type.price}`}
											variant="secondary"
											onclick={() => {
												const existing = cart.tickets.filter(
													(t) => t.event.id === event.id && t.ticket_type.id === ticket_type.id
												);
												if (existing.length > 0) existing[0].quantity = existing[0].quantity + 1;
												else cart.tickets.push({ ticket_type, event, quantity: 1 });
											}}
										/>
									{/each}
								</div>
							</div>
						</div>
					{/each}
				</div>
			{/each}
		</div>
	{/if}
</div>
<div class="flex h-[calc(100vh-3.5rem)] flex-col gap-3 border-x border-input p-4 lg:w-1/4">
	<div>
		<h3 class="group flex items-center gap-2 text-lg font-semibold tracking-tight">Cart (0)</h3>
		<p class="text-sm text-muted-foreground">Tickets and Products</p>
	</div>

	{#each cart.tickets as cart_ticket}
		<div
			class="-mx-2 flex items-start space-x-4 rounded-md bg-accent p-2 text-accent-foreground transition-all"
		>
			<svg
				xmlns="http://www.w3.org/2000/svg"
				width="24"
				height="24"
				viewBox="0 0 24 24"
				fill="none"
				stroke="currentColor"
				stroke-width="2"
				stroke-linecap="round"
				stroke-linejoin="round"
				class="size-9"
			>
				<path
					d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"
				/>
				<path d="M13 5v2" />
				<path d="M13 17v2" /><path d="M13 11v2" />
			</svg>
			<div class="w-[calc(100%)] space-y-1">
				<div class="flex gap-3 text-sm font-medium leading-none">
					<span class="grow">
						{cart_ticket.ticket_type.name} ${cart_ticket.ticket_type.price} x {cart_ticket.quantity}
					</span>
					<button
						onclick={() => {
							cart_ticket.quantity++;
						}}
					>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							width="24"
							height="24"
							viewBox="0 0 24 24"
							fill="none"
							stroke="currentColor"
							stroke-width="2"
							stroke-linecap="round"
							stroke-linejoin="round"
							class="size-4"
						>
							<path d="M5 12h14" />
							<path d="M12 5v14" />
						</svg>
					</button>
					<button
						onclick={() => {
							if (cart_ticket.quantity > 1) cart_ticket.quantity--;
						}}
					>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							width="24"
							height="24"
							viewBox="0 0 24 24"
							fill="none"
							stroke="currentColor"
							stroke-width="2"
							stroke-linecap="round"
							stroke-linejoin="round"
							class="size-4"
						>
							<path d="M5 12h14" />
						</svg>
					</button>
					<button
						onclick={() => {
							if (
								confirm(
									`Are you sure you want to remove all ${cart_ticket.quantity} ${cart_ticket.ticket_type.name} ticket(s) form the cart?`
								)
							)
								cart.tickets = cart.tickets.filter(
									(t) =>
										!(
											t.event.id === cart_ticket.event.id &&
											t.ticket_type.id === cart_ticket.ticket_type.id
										)
								);
						}}
					>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							width="24"
							height="24"
							viewBox="0 0 24 24"
							fill="none"
							stroke="currentColor"
							stroke-width="2"
							stroke-linecap="round"
							stroke-linejoin="round"
							class="size-4"
						>
							<path d="M3 6h18" />
							<path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
							<path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
							<line x1="10" x2="10" y1="11" y2="17" /><line x1="14" x2="14" y1="11" y2="17" />
						</svg>
					</button>
				</div>
				<div class="flex text-xs text-muted-foreground">
					<span class="grow">
						#{cart_ticket.event.id}
						{cart_ticket.event.show.name} ({cart_ticket.event.type.name})
					</span>
				</div>
			</div>
		</div>
	{/each}
	{#each cart.products as cart_product}
		<div
			class="-mx-2 flex items-start space-x-4 rounded-md bg-accent p-2 text-accent-foreground transition-all"
		>
			<svg
				xmlns="http://www.w3.org/2000/svg"
				width="24"
				height="24"
				viewBox="0 0 24 24"
				fill="none"
				stroke="currentColor"
				stroke-width="2"
				stroke-linecap="round"
				stroke-linejoin="round"
				class="size-9"
			>
				<path
					d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"
				/>
				<path d="m3.3 7 8.7 5 8.7-5" />
				<path d="M12 22V12" />
			</svg>
			<div class="w-[calc(100%)] space-y-1">
				<div class="flex gap-3 text-sm font-medium leading-none">
					<span class="grow">
						{cart_product.product.name} ${cart_product.product.price} x {cart_product.quantity}
					</span>
					<svg
						xmlns="http://www.w3.org/2000/svg"
						width="24"
						height="24"
						viewBox="0 0 24 24"
						fill="none"
						stroke="currentColor"
						stroke-width="2"
						stroke-linecap="round"
						stroke-linejoin="round"
						class="size-4"
					>
						<path d="M5 12h14" />
						<path d="M12 5v14" />
					</svg>
					<svg
						xmlns="http://www.w3.org/2000/svg"
						width="24"
						height="24"
						viewBox="0 0 24 24"
						fill="none"
						stroke="currentColor"
						stroke-width="2"
						stroke-linecap="round"
						stroke-linejoin="round"
						class="size-4"
					>
						<path d="M5 12h14" />
					</svg>
					<svg
						xmlns="http://www.w3.org/2000/svg"
						width="24"
						height="24"
						viewBox="0 0 24 24"
						fill="none"
						stroke="currentColor"
						stroke-width="2"
						stroke-linecap="round"
						stroke-linejoin="round"
						class="size-4"
					>
						<path d="M3 6h18" />
						<path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
						<path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
						<line x1="10" x2="10" y1="11" y2="17" /><line x1="14" x2="14" y1="11" y2="17" />
					</svg>
				</div>
				<div class="flex text-xs text-muted-foreground">
					<span class="grow">
						{cart_product.product.type?.name}
					</span>
				</div>
			</div>
		</div>
	{/each}
</div>
<form method="POST" class="p-4 lg:w-1/5">
	<ul class="grid gap-3 text-sm">
		<li>
			<ASelect
				name="customer_id"
				options={data.customers}
				placeholder="Customer"
				required
				value={1}
			/>
		</li>
		<li class="flex items-center justify-between">
			<span class="text-muted-foreground">Subtotal</span>
			<span
				>{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(subtotal)}</span
			>
		</li>
		<li class="flex items-center justify-between">
			<span class="text-muted-foreground">Tax ({data.settings.organization.tax}%)</span>
			<span>{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(tax)}</span>
		</li>
		<li class="flex items-center justify-between font-semibold">
			<span class="text-muted-foreground">Total</span>
			<span>{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(total)}</span
			>
		</li>
		<li class="flex items-center justify-between">
			<span class="text-muted-foreground">Tendered</span>
			<span>${tendered}</span>
		</li>
		<li class="flex items-center justify-between">
			<span class="text-muted-foreground">Change</span>
			<span
				>{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(change)}</span
			>
		</li>
		<li class="flex items-center justify-between">
			<span class="text-muted-foreground">Balance</span>
			<span
				>{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(balance)}</span
			>
		</li>
		<li>
			<ASelect
				name="method_id"
				options={data.payment_methods}
				placeholder="Select a Payment Method"
				onchange={(e) => {
					const value = e.currentTarget.value;
					tendered = value !== '1' ? total.toFixed(2) : '0.00';
				}}
				value={1}
			/>
		</li>
		<li>
			<AInput name="reference" placeholder="Reference" required={method !== 1} />
		</li>
		<li class="grid grid-cols-3 gap-3">
			<div class="flex items-center justify-center">
				<button
					value="7"
					onclick={handleKeyPress}
					class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
				>
					7
				</button>
			</div>
			<div class="flex items-center justify-center">
				<button
					value="8"
					onclick={handleKeyPress}
					class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
				>
					8
				</button>
			</div>
			<div class="flex items-center justify-center">
				<button
					value="9"
					onclick={handleKeyPress}
					class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
				>
					9
				</button>
			</div>
			<div class="flex items-center justify-center">
				<button
					value="4"
					onclick={handleKeyPress}
					class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
				>
					4
				</button>
			</div>
			<div class="flex items-center justify-center">
				<button
					value="5"
					onclick={handleKeyPress}
					class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
				>
					5
				</button>
			</div>
			<div class="flex items-center justify-center">
				<button
					value="6"
					onclick={handleKeyPress}
					class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
				>
					6
				</button>
			</div>
			<div class="flex items-center justify-center">
				<button
					value="1"
					onclick={handleKeyPress}
					class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
				>
					1
				</button>
			</div>
			<div class="flex items-center justify-center">
				<button
					value="2"
					onclick={handleKeyPress}
					class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
				>
					2
				</button>
			</div>
			<div class="flex items-center justify-center">
				<button
					value="3"
					onclick={handleKeyPress}
					class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
				>
					3
				</button>
			</div>
			<div class="flex items-center justify-center">
				<button
					value="0"
					onclick={handleKeyPress}
					class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
				>
					0
				</button>
			</div>
			<div class="flex items-center justify-center">
				<button
					value="."
					onclick={handleKeyPress}
					class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
				>
					.
				</button>
			</div>
			<div class="flex items-center justify-center">
				<button
					onclick={() => {
						tendered = '0.00';
					}}
					class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
				>
					C
				</button>
			</div>
		</li>
		<li class="grid gap-3">
			<AButton
				type="submit"
				onclick={(e) => {
					if (!confirm('Are you sure you want to save this sale?')) e.preventDefault();
				}}
				text={`Charge ${Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(total)}`}
				disabled={cart.products.length + cart.tickets.length <= 0 || balance > 0}
			/>
			<AButton
				type="button"
				text="Clear"
				variant="secondary"
				onclick={() => {
					if (
						confirm('Are you sure you want to clear the entire sale? All cart items will be lost.')
					) {
						cart = { tickets: [], products: [] };
						tendered = '0.00';
					}
				}}
			/>
		</li>
	</ul>
	{#each cart.tickets as ticket, i}
		<input type="hidden" name={`tickets[${i}][type_id]`} value={ticket.ticket_type.id} />
		<input type="hidden" name={`tickets[${i}][event_id]`} value={ticket.event.id} />
		<input type="hidden" name={`tickets[${i}][quantity]`} value={ticket.quantity} />
	{/each}
	{#each cart.products as product, i}
		<input type="hidden" name={`products[${i}][id]`} value={product.product.id} />
		<input type="hidden" name={`products[${i}][quantity]`} value={product.quantity} />
	{/each}
	<input type="hidden" name="tendered" bind:value={tendered} />
</form>
