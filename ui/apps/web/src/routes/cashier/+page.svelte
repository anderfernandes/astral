<script lang="ts">
	import { applyAction, enhance } from '$app/forms';
	import { beforeNavigate, invalidate } from '$app/navigation';
	import { page } from '$app/stores';
	import { formatDistanceToNow } from 'date-fns';
	import { AButton, ADatePicker, AInput, ASelect } from 'ui';

	let { data, form } = $props();

	let loading = $state(false);

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

	let cart = $state<{ tickets: ICartTicket[]; products: ICartProduct[] }>({
		tickets: [],
		products: []
	});

	const { subtotal, tax, total, change, balance } = $derived.by(() => {
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

	const count = $derived.by(
		() =>
			cart.products.reduce((a, b) => a + b.quantity, 0) +
			cart.tickets.reduce((a, b) => a + b.quantity, 0)
	);
</script>

<svelte:head>
	<title>Cashier | Astral</title>
</svelte:head>

<div>
	<header
		class="sticky top-0 -mx-6 -mt-6 flex h-16 w-screen items-center bg-background/50 px-6 backdrop-blur lg:-mx-0 lg:w-full lg:pl-0 lg:pr-4"
	>
		<!-- Tabs -->
		<div
			class="flex w-full flex-col-reverse justify-center lg:flex lg:flex-row lg:items-center lg:justify-start lg:gap-1"
		>
			<div class="flex items-center overflow-x-auto">
				<a
					href="/cashier"
					class:border-b-4={$page.url.pathname.includes('/cashier') &&
						$page.url.searchParams.size === 0}
					class="flex gap-2 rounded-t-md border-primary px-3 pb-2 pt-3 text-sm font-semibold hover:bg-muted"
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
					<div class="hidden lg:block">Tickets</div>
				</a>
				<a
					href="?tab=products"
					data-sveltekit-preload-data
					class:border-b-4={$page.url.searchParams.has('tab') &&
						$page.url.searchParams.get('tab') === 'products'}
					class="flex gap-2 rounded-t-md border-primary px-3 pb-2 pt-3 text-sm font-semibold hover:bg-muted"
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
					<div class="hidden lg:block">Products</div>
				</a>
			</div>
		</div>
		<div class="flex items-center gap-1 px-1 text-sm">
			<svg class="size-5" viewBox="0 0 24 24"
				><path
					fill="currentColor"
					d="M12,19.2C9.5,19.2 7.29,17.92 6,16C6.03,14 10,12.9 12,12.9C14,12.9 17.97,14 18,16C16.71,17.92 14.5,19.2 12,19.2M12,5A3,3 0 0,1 15,8A3,3 0 0,1 12,11A3,3 0 0,1 9,8A3,3 0 0,1 12,5M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2Z"
				></path></svg
			>
			{data.account?.firstname}
		</div>
		<ADatePicker format={{ dateStyle: 'medium' }} value={new Date()} />
	</header>

	<div class="grid gap-3 lg:grid-flow-col lg:grid-cols-12">
		<!-- Events or Products -->
		<div class="grid content-start lg:col-span-6">
			<!-- Products -->
			{#if $page.url.searchParams.has('tab') && $page.url.searchParams.get('tab') === 'products'}
				<div class="grid grid-cols-2 gap-3">
					{#each data.products as product}
						<button
							onclick={() => {
								const i = cart.products.findIndex((p) => p.product.id === product.id);
								if (i === -1) cart.products.push({ product, quantity: 1 });
								else cart.products[i].quantity++;
							}}
						>
							<div
								class=" flex flex-col items-center justify-between gap-3 rounded-md border-2 border-muted bg-popover p-4 text-sm font-medium leading-none hover:bg-accent hover:text-accent-foreground peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
							>
								<div class="size-36">
									<img
										class="aspect-square size-full rounded-lg object-cover"
										src={product.cover}
										alt={product.name}
									/>
								</div>
								<span>{product.name}</span>
								<span class="text-muted-foregorund font-normal"
									>${product.price} &middot; {product.stock} in stock</span
								>
							</div>
						</button>
					{/each}
				</div>
			{:else}
				<!-- Events -->
				{#each data.days as day}
					<h5 class="my-3 flex items-center gap-1">
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
					</h5>
					<div>
						{#each day.events as event}
							{@const start = new Date(event.start)}
							{@const end = new Date(event.end)}
							<div class="flex items-center gap-3">
								<img
									src={event.show.cover}
									class="aspect-square size-[127px] rounded-md object-cover"
									alt={event.show.name}
								/>
								<div class="grid gap-1">
									<div class="flex items-center gap-1">
										<span class="text-xs text-muted-foreground">#{event.id} </span>
										<span
											class="inline-flex items-center rounded-md border bg-background px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
										>
											{event.type.name}
										</span>
									</div>

									<h4 class="truncate font-medium">{event.show.name}</h4>
									<span class="truncate text-sm text-muted-foreground">
										{Intl.DateTimeFormat('en-US', {
											dateStyle: 'medium',
											timeStyle: 'short'
										}).format(start)}
										({formatDistanceToNow(start, { addSuffix: true })})
									</span>
									<div class="flex gap-1">
										<span
											class="inline-flex items-center rounded-md border border-transparent bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground transition-colors hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
										>
											{event.show.type?.name}
										</span>

										<span class="text-sm"> {event.seats.available}/{event.seats.total}</span>
									</div>
									<div class="mt-2 flex flex-wrap gap-1">
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
			{/if}
		</div>
		<!-- Cart -->
		<div class="grid content-start gap-3 lg:col-span-3">
			<h3 class="group flex items-center gap-2 text-lg font-semibold tracking-tight">
				Cart ({count})
			</h3>
			{#each cart.tickets as cart_ticket}
				<div class="hover:bg flex items-center gap-1 text-sm">
					<div class="grid w-full content-center gap-1">
						<h5 class="truncate font-semibold">
							#{cart_ticket.event.id}
							{cart_ticket.event.show.name} ({cart_ticket.event.type.name})
						</h5>
						<h5 class="inline-flex items-center gap-1 truncate">
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
								<path
									d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"
								/>
								<path d="M13 5v2" />
								<path d="M13 17v2" /><path d="M13 11v2" />
							</svg>
							{cart_ticket.ticket_type.name} ${cart_ticket.ticket_type.price} x {cart_ticket.quantity}
						</h5>
						<div class="flex gap-3">
							<button
								onclick={() => {
									cart_ticket.quantity++;
								}}
								class="inline-flex h-9 w-9 items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
								aria-label="+1 ticket"
								><svg
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
								</svg><span class="sr-only">Archive</span></button
							>
							<button
								onclick={() => {
									if (cart_ticket.quantity > 1) cart_ticket.quantity--;
								}}
								aria-label="-1 ticket"
								class="inline-flex h-9 w-9 items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
								><svg
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
								</svg><span class="sr-only">Archive</span></button
							>
							<button
								aria-label="remove ticket"
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
								class="inline-flex h-9 w-9 items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
								><svg
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
								</svg><span class="sr-only">Archive</span></button
							>
						</div>
					</div>
					<img
						src={cart_ticket.event.show.cover}
						class="aspect-square size-[72px] rounded-full object-cover"
						alt={cart_ticket.event.show.name}
					/>
				</div>
			{/each}
			{#each cart.products as cart_product}
				<div class="hover:bg flex items-center gap-1 text-sm">
					<div class="grid w-full content-center gap-1">
						<h5 class="truncate font-semibold">
							{cart_product.product.name}
						</h5>
						<h5 class="inline-flex items-center gap-1 truncate">
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
								<path
									d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"
								/>
								<path d="M13 5v2" />
								<path d="M13 17v2" /><path d="M13 11v2" />
							</svg>
							${cart_product.product.price} x {cart_product.quantity}
						</h5>
						<div class="flex gap-3">
							<button
								onclick={() => {
									cart_product.quantity++;
								}}
								class="inline-flex h-9 w-9 items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
								aria-label="+1 ticket"
								><svg
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
								</svg><span class="sr-only">Archive</span></button
							>
							<button
								onclick={() => {
									if (cart_product.quantity > 1) cart_product.quantity--;
								}}
								aria-label="-1 ticket"
								class="inline-flex h-9 w-9 items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
								><svg
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
								</svg><span class="sr-only">Archive</span></button
							>
							<button
								aria-label="remove ticket"
								onclick={() => {
									if (
										confirm(
											`Are you sure you want to remove all ${cart_product.quantity} ${cart_product.product.name} from the cart?`
										)
									)
										cart.products = cart.products.filter(
											(p) => p.product.id !== cart_product.product.id
										);
								}}
								class="inline-flex h-9 w-9 items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
								><svg
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
								</svg><span class="sr-only">Archive</span></button
							>
						</div>
					</div>
					<img
						src={cart_product.product.cover}
						class="aspect-square size-[72px] rounded-full object-cover"
						alt={cart_product.product.name}
					/>
				</div>
			{/each}
		</div>
		<!-- Register -->
		<div class="grid content-start lg:col-span-3">
			<form
				method="post"
				class="p-4"
				use:enhance={() => {
					loading = true;
					return async ({ result, update }) => {
						console.log(result.status);
						if (result.status! >= 400) {
							loading = false;
						} else {
							await applyAction(result);
							loading = false;
							cart = { tickets: [], products: [] };
							tendered = '0.00';
							method = data.payment_methods[0].id;
						}
						await update();
					};
				}}
			>
				<ul class="grid gap-3 text-sm">
					<li>
						<ASelect
							name="customer_id"
							options={data.customers}
							placeholder="Customer"
							required
							value={data.customers[0].id}
						/>
					</li>
					<li class="flex items-center justify-between">
						<span class="text-muted-foreground">Subtotal</span>
						<span
							>{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
								subtotal
							)}</span
						>
					</li>
					<li class="flex items-center justify-between">
						<span class="text-muted-foreground">Tax ({data.settings.organization.tax}%)</span>
						<span
							>{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
								tax
							)}</span
						>
					</li>
					<li class="flex items-center justify-between font-semibold">
						<span class="text-muted-foreground">Total</span>
						<span
							>{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
								total
							)}</span
						>
					</li>
					<li class="flex items-center justify-between">
						<span class="text-muted-foreground">Tendered</span>
						<span>${tendered}</span>
					</li>
					<li class="flex items-center justify-between">
						<span class="text-muted-foreground">Change</span>
						<span
							>{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
								change
							)}</span
						>
					</li>
					<li class="flex items-center justify-between">
						<span class="text-muted-foreground">Balance</span>
						<span
							>{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
								balance
							)}</span
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
								//method = parseInt(value);
							}}
							value={data.payment_methods[0].id}
						/>
					</li>
					<li>
						<AInput
							name="reference"
							placeholder="Reference"
							required={method !== 1}
							errors={form?.errors?.method_id || []}
						/>
					</li>
					<li class="grid grid-cols-3 justify-items-center gap-1">
						<button
							onclick={handleKeyPress}
							class="size-16 rounded-lg bg-foreground text-xl font-semibold text-background"
							value="7">7</button
						>
						<button
							onclick={handleKeyPress}
							class="size-16 rounded-lg bg-foreground text-xl font-semibold text-background"
							value="8">8</button
						>
						<button
							onclick={handleKeyPress}
							class="size-16 rounded-lg bg-foreground text-xl font-semibold text-background"
							value="9">9</button
						>
						<button
							onclick={handleKeyPress}
							class="size-16 rounded-lg bg-foreground text-xl font-semibold text-background"
							value="4">4</button
						>
						<button
							onclick={handleKeyPress}
							class="size-16 rounded-lg bg-foreground text-xl font-semibold text-background"
							value="5">5</button
						>
						<button
							onclick={handleKeyPress}
							class="size-16 rounded-lg bg-foreground text-xl font-semibold text-background"
							value="6">6</button
						>
						<button
							onclick={handleKeyPress}
							class="size-16 rounded-lg bg-foreground text-xl font-semibold text-background"
							value="1">1</button
						>
						<button
							onclick={handleKeyPress}
							class="size-16 rounded-lg bg-foreground text-xl font-semibold text-background"
							value="2">2</button
						>
						<button
							onclick={handleKeyPress}
							class="size-16 rounded-lg bg-foreground text-xl font-semibold text-background"
							value="3">3</button
						>
						<button
							onclick={handleKeyPress}
							class="size-16 rounded-lg bg-foreground text-xl font-semibold text-background"
							value="0">0</button
						>
						<button
							onclick={handleKeyPress}
							class="size-16 rounded-lg bg-foreground text-xl font-semibold text-background"
							value=".">.</button
						>
						<button
							onclick={() => {
								tendered = '0.00';
							}}
							class="size-16 rounded-lg bg-foreground text-xl font-semibold text-background"
							>C</button
						>
					</li>
					<li class="grid gap-3">
						<AButton
							{loading}
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
									confirm(
										'Are you sure you want to clear the entire sale? All cart items will be lost.'
									)
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
		</div>
	</div>
</div>
