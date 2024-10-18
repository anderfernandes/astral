<script lang="ts">
	import AdminLayout from '../AdminLayout.svelte';
	import Navbar from '../Navbar.svelte';

	interface ITicketWithQuantity extends ITicket {
		quantity: number;
	}
	interface IProductWithQuantity extends IProduct {
		quantity: number;
	}

	let { data } = $props();
</script>

{#snippet header()}
	<h2 class="text-xl font-bold">Sales</h2>
{/snippet}

<AdminLayout title="Sales" {header} nav>
	<div class="relative w-full overflow-auto">
		<table class="w-full caption-bottom text-sm">
			<thead class="[&amp;_tr]:border-b">
				<tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
					<th
						class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] hidden h-10 w-[100px] px-2 text-left align-middle font-medium text-muted-foreground sm:table-cell"
					>
						<span class="sr-only">Image</span>
					</th>
					<th
						class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] h-10 px-2 text-left align-middle font-medium text-muted-foreground"
					>
						#
					</th>
					<th
						class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] h-10 px-2 text-left align-middle font-medium text-muted-foreground"
					>
						Status
					</th>
					<th
						class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] h-10 px-2 text-left align-middle font-medium text-muted-foreground"
					>
						Total
					</th>
					<th
						class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] hidden h-10 px-2 text-left align-middle font-medium text-muted-foreground md:table-cell"
					>
						Items
					</th>
					<th
						class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] hidden h-10 px-2 text-left align-middle font-medium text-muted-foreground md:table-cell"
					>
						Created at
					</th>
					<th
						class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] h-10 px-2 text-left align-middle font-medium text-muted-foreground"
					>
						Customer
					</th>
					<th
						class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] h-10 px-2 text-left align-middle font-medium text-muted-foreground"
					>
						Created by
					</th>
				</tr>
			</thead>
			<tbody class="[&amp;_tr:last-child]:border-0">
				{#each data.sales as sale}
					{@const cover =
						sale.events && sale.events?.length! > 0
							? sale.events[0].show.cover
							: '/storage/default.png'}
					<tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
						<td
							class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] hidden p-2 align-middle sm:table-cell"
						>
							<img
								alt="Product"
								loading="lazy"
								width="64"
								height="64"
								decoding="async"
								data-nimg="1"
								class="aspect-square rounded-md object-cover"
								style="color:transparent"
								src={cover}
							/>
						</td>
						<td
							class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] p-2 align-middle font-medium"
						>
							<a href={`/admin/sales/${sale.id}`}>{sale.id}</a>
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
							{Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(
								sale.total
							)}
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
						<td
							class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] p-2 align-middle"
						>
							<div class="flex items-center gap-2 text-sm">
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
									class="lucide lucide-square-user-round"
									><path d="M18 21a6 6 0 0 0-12 0" /><circle cx="12" cy="11" r="4" /><rect
										width="18"
										height="18"
										x="3"
										y="3"
										rx="2"
									/></svg
								>
								{sale.customer?.name}
							</div>
						</td>
						<td
							class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] p-2 align-middle"
						>
							<div class="flex items-center gap-2 text-sm">
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
									class="lucide lucide-circle-user-round"
								>
									<path d="M18 20a6 6 0 0 0-12 0" />
									<circle cx="12" cy="10" r="4" />
									<circle cx="12" cy="12" r="10" />
								</svg>
								{sale.creator?.name}
							</div>
						</td>
					</tr>
				{/each}
			</tbody>
		</table>
	</div>
</AdminLayout>
