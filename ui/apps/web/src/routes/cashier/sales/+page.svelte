<script lang="ts">
	interface ITicketWithQuantity extends ITicket {
		quantity: number;
	}
	interface IProductWithQuantity extends IProduct {
		quantity: number;
	}

	let { data } = $props();
</script>

<svelte:head>
	<title>Sales | Astral Cashier</title>
</svelte:head>

<header
	class="sticky top-0 -mx-6 -mt-6 flex h-16 w-screen items-center bg-background/50 px-6 backdrop-blur lg:-mx-0 lg:w-full lg:pl-0 lg:pr-4"
>
	<h2 class="font-semibold">Sales</h2>
</header>

<div class="relative w-full overflow-auto">
	<table class="w-full caption-bottom text-sm">
		<thead class="[&amp;_tr]:border-b">
			<tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
				<th class="h-10 px-2 text-left align-middle font-medium text-muted-foreground"> # </th>
				<th class="h-10 px-2 text-left align-middle font-medium text-muted-foreground"> Status </th>
				<th class="h-10 px-2 text-left align-middle font-medium text-muted-foreground"> Total </th>
				<th
					class="hidden h-10 px-2 text-left align-middle font-medium text-muted-foreground md:table-cell"
				>
					Items
				</th>
				<th
					class="hidden h-10 px-2 text-left align-middle font-medium text-muted-foreground md:table-cell"
				>
					Created at
				</th>
				<th class="h-10 truncate px-2 text-left align-middle font-medium text-muted-foreground">
					Customer
				</th>
				<th class="h-10 truncate px-2 text-left align-middle font-medium text-muted-foreground">
					Created by
				</th>
			</tr>
		</thead>
		<tbody class="[&amp;_tr:last-child]:border-0">
			{#each data.sales as sale}
				<tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
					<td
						class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] p-2 align-middle font-medium"
					>
						<a href={`/cashier/sales/${sale.id}`}>{sale.id}</a>
					</td>
					<td
						class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] p-2 align-middle"
					>
						<div
							class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
						>
							{sale.status}
						</div>
					</td>
					<td
						class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] p-2 align-middle"
					>
						{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(sale.total)}
					</td>
					<td
						class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] hidden p-2 align-middle md:table-cell"
					>
						<div class="flex flex-col gap-2">
							{#each sale.events! as event}
								<div class="flex flex-col">
									<div class="flex gap-1 text-xs">
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
											<path d="M8 2v4" />
											<path d="M16 2v4" />
											<path d="M21 17V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11Z" />
											<path d="M3 10h18" />
											<path d="M15 22v-4a2 2 0 0 1 2-2h4" />
										</svg>
										#{event.id}
										{event.show.name}
										{event.show.type?.name}
									</div>
									<div class="flex gap-1">
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
											<path d="M13 17v2" />
											<path d="M13 11v2" />
										</svg>
										{#each sale.tickets.filter((t) => t.event_id === event.id) as ticket}
											<div class="text-xs">
												{ticket.type.name} x {(ticket as ITicketWithQuantity).quantity}
											</div>
										{/each}
									</div>
								</div>
							{/each}
							{#each sale.products as product}
								<div class="flex gap-1 text-xs">
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
											d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"
										/>
										<path d="m3.3 7 8.7 5 8.7-5" />
										<path d="M12 22V12" />
									</svg>
									{product.name} x {(product as IProductWithQuantity).quantity}
								</div>
							{/each}
						</div>
					</td>
					<td
						class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] hidden p-2 align-middle md:table-cell"
					>
						{Intl.DateTimeFormat('en-US', { dateStyle: 'medium', timeStyle: 'short' }).format(
							new Date(sale.created_at)
						)}
					</td>
					<td class="truncate p-2 align-middle">
						<div class="flex items-center gap-2 text-sm">
							<svg class="size-6" viewBox="0 0 24 24"
								><path
									fill="currentColor"
									d="M19,19H5V5H19M19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M16.5,16.25C16.5,14.75 13.5,14 12,14C10.5,14 7.5,14.75 7.5,16.25V17H16.5M12,12.25A2.25,2.25 0 0,0 14.25,10A2.25,2.25 0 0,0 12,7.75A2.25,2.25 0 0,0 9.75,10A2.25,2.25 0 0,0 12,12.25Z"
								></path></svg
							>
							{sale.customer?.name}
						</div>
					</td>
					<td class="truncate p-2 align-middle">
						<div class="flex items-center gap-2 text-sm">
							<svg class="size-6" viewBox="0 0 24 24"
								><path
									fill="currentColor"
									d="M12,19.2C9.5,19.2 7.29,17.92 6,16C6.03,14 10,12.9 12,12.9C14,12.9 17.97,14 18,16C16.71,17.92 14.5,19.2 12,19.2M12,5A3,3 0 0,1 15,8A3,3 0 0,1 12,11A3,3 0 0,1 9,8A3,3 0 0,1 12,5M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2Z"
								></path></svg
							>
							{sale.creator?.name}
						</div>
					</td>
				</tr>
			{/each}
		</tbody>
	</table>
</div>
