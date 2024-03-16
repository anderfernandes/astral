<script lang="ts">
	import { enhance } from '$app/forms';
	import { format } from 'date-fns';
	import _ from 'lodash';
	import { AIcon } from 'ui';
	import { arrow_left_thick, email_outline } from 'ui/icons';

	let { data } = $props();
	let { sale, organization } = data;

	const paid = data.sale.payments?.reduce((a, b) => a + b.total, 0);
	const tendered = data.sale.payments?.reduce((a, b) => a + b.tendered, 0);
</script>

<svelte:head>
	<title>Receipt #{sale.id} | {organization.name} &middot; Astral</title>
</svelte:head>

<nav class="fixed top-0 grid w-full grid-cols-2 p-4">
	<div class="flex justify-start gap-2 print:hidden">
		<a href={`/cashier/sales/${sale.id}`}>
			<AIcon data={arrow_left_thick} />
		</a>
	</div>
	{#if sale.customer_id == 1}
		<form
			class="flex justify-end gap-2 print:hidden"
			method="POST"
			use:enhance={({ cancel }) => {
				if (
					!confirm(
						`Are you sure you want to email Receipt #${data.sale.id} to ${data.sale.customer?.firstname} ${data.sale.customer?.lastname}?`
					)
				) {
					cancel();
				}

				return async ({ update }) => {
					await update();
					alert('Email sent successfully!');
				};
			}}
		>
			<button type="submit">
				<AIcon data={email_outline} />
			</button>
		</form>
	{/if}
</nav>

<main class="flex justify-center p-4 text-sm">
	<section class="w-full lg:w-7/12 xl:w-5/12">
		<div class="flex flex-col items-center justify-center gap-2">
			<img src={data.organization.logo} alt="logo" class="w-16" />
			<h5 class="text-center font-bold">{organization.name}<br />Receipt #{data.sale.id}</h5>
		</div>
		<br />
		<p class="font-medium">Date: {format(new Date(), 'EEEE, MMMM d, yyyy')}</p>
		<br />
		<br />
		<div class="flex gap-4 font-medium">
			{#if data.sale.customer && data.sale.customer_id !== 1}
				{@const customer = data.sale.customer}
				<div class="flex flex-col">
					<p>Bill to:</p>
					<p>{customer.firstname} {customer.lastname}</p>
					<p>{customer.address}</p>
					<p>{customer.city}, {customer.state} {customer.zip}</p>
				</div>
				<div class="flex flex-col">
					<p>Sold to:</p>
					<p>{customer.firstname} {customer.lastname}</p>
					<p>{customer.address}</p>
					<p>{customer.city}, {customer.state} {customer.zip}</p>
				</div>
			{/if}
		</div>
		<br />
		{#if data.sale.events}
			<table class="w-full table-auto">
				<thead>
					<tr>
						<th class="text-left">Item</th>
						<th class="text-left">Price</th>
						<th class="text-left">Quantity</th>
						<th class="text-right">Total</th>
					</tr>
				</thead>
				<tbody>
					{#each data.sale.events as event}
						{#each _.uniqBy( data.sale.tickets.filter((t) => t.event_id === event.id), 'ticket_type_id' ) as ticket}
							{@const quantity = data.sale.tickets.filter(
								(t) => t.type_id === ticket.type_id && t.event_id === ticket.event_id
							).length}
							<tr>
								<td class="flex flex-col">
									<span>
										{ticket.type.name}
										{quantity === 1 ? 'tickets' : 'ticket'} for {ticket.event?.type.name} Event #{ticket.event_id}
										{ticket.event?.show.name}
									</span>
									<span class="text-zinc-400">
										{ticket.event &&
											format(new Date(ticket.event.start), 'EEEE MMMM d, yyyy h:mm a')}
									</span>
								</td>
								<td>$ {ticket.type.price.toFixed(2)}</td>
								<td>{quantity}</td>
								<td class="flex justify-end">
									<span class="shrink">$</span>
									<span class="grow text-right">
										{(ticket.type.price * quantity).toFixed(2)}
									</span>
								</td>
							</tr>
						{/each}
					{/each}
					{#each _.uniqBy(data.sale.products, 'id') as product}
						{@const quantity = data.sale.products.filter((p) => p.id === product.id).length}
						<tr>
							<td>{product.name}</td>
							<td>$ {product.price.toFixed(2)}</td>
							<td>{quantity}</td>
							<td class="flex justify-end">
								<span>$</span>
								<span class="grow text-right">
									{(quantity * product.price).toFixed(2)}
								</span>
							</td>
						</tr>
					{/each}
					<tr>
						<td colspan="5">&nbsp;</td>
					</tr>
				</tbody>
				<tfoot>
					<tr class="border-t">
						<th colspan="3" class="px-4 text-right">Subtotal</th>
						<td class="flex">
							<span>$</span>
							<span class="grow text-right">
								{data.sale.subtotal.toFixed(2)}
							</span>
						</td>
					</tr>
					<tr class="border-t">
						<th colspan="3" class="px-4 text-right">Tax ({data.organization.tax}%)</th>
						<td class="flex">
							<span>$</span>
							<span class="grow text-right">
								{data.sale.tax.toFixed(2)}
							</span>
						</td>
					</tr>
					<tr class="border-t">
						<th colspan="3" class="px-4 text-right">Total</th>
						<td class="flex">
							<span>$</span>
							<span class="grow text-right">
								{data.sale.total.toFixed(2)}
							</span>
						</td>
					</tr>
					<tr class="border-t">
						<th colspan="3" class="px-4 text-right">Paid</th>
						<td class="flex">
							<span>$</span>
							<span class="grow text-right">
								{tendered.toFixed(2)}
							</span>
						</td>
					</tr>
					<tr class="border-t">
						<th colspan="3" class="px-4 text-right">Change</th>
						<td class="flex">
							<span>$</span>
							<span class="grow text-right">
								{(tendered - paid).toFixed(2)}
							</span>
						</td>
					</tr>
					<tr class="border-t">
						<th colspan="3" class="px-4 text-right">Balance</th>
						<td class="flex">
							<span>$</span>
							<span class="grow text-right">
								{data.sale.balance.toFixed(2)}
							</span>
						</td>
					</tr>
				</tfoot>
			</table>
		{/if}
		<br />
		<p>
			Thank you for choosing us. We sincerely appreciate the patronage and hope you enjoy our shows.
		</p>
		<br />
		<p>Sincerely,</p>
		<br />
		<p>Visitor Services</p>
		<p>{data.organization.name}</p>
		<br />
		<br />
		<div class="flex w-full flex-col items-center">
			<p class="font-semibold">{data.organization.name}</p>
			<p class="font-semibold">{data.organization.address}</p>
			<p class="flex gap-2">
				<span>{data.organization.phone} |</span>
				<span>{data.organization.email} |</span>
				<span>{data.organization.website} |</span>
				<span
					>Powered by <a class="text-blue-500" href="https://astral.anderfernandes.com">Astral</a
					></span
				>
			</p>
		</div>
	</section>
</main>
