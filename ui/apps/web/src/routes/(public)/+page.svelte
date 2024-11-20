<script lang="ts">
	let { data } = $props();
	const { settings, account, events, products } = data;
</script>

<svelte:head>
	<title>{data.settings?.organization.name} Home | Astral</title>
</svelte:head>

<div>
	<div class="flex h-16 items-center px-4">
		<nav class="flex items-center space-x-4 lg:mx-3">
			<img src={settings.organization.logo} width="32" height="32" alt="Logo" />
			<h1 class="relative z-20 flex items-center text-lg font-medium">
				{settings?.organization.name}
			</h1>
			<!-- <a
				class="hidden text-sm font-medium transition-colors hover:text-primary lg:block"
				href="/examples/dashboard"
			>
				Home
			</a>
			<a
				class="hidden text-sm font-medium text-muted-foreground transition-colors hover:text-primary lg:block"
				href="/examples/dashboard">Events</a
			><a
				class="hidden text-sm font-medium text-muted-foreground transition-colors hover:text-primary lg:block"
				href="/examples/dashboard">Products</a
			> -->
		</nav>
		<div class="ml-auto flex items-center space-x-4">
			<!-- <div class="hidden lg:block">
				<input
					class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:w-[100px] lg:w-[300px]"
					placeholder="Search..."
					type="search"
				/>
			</div> -->
			{#if account === undefined}
				<a
					href="/login"
					class="inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow transition-colors hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
				>
					Login
				</a>
			{:else}
				<a
					href="/account"
					class="inline-flex h-9 w-9 items-center justify-center whitespace-nowrap rounded-full bg-secondary text-sm font-medium text-secondary-foreground shadow-sm transition-colors hover:bg-secondary/80 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
					type="button"
					id="radix-:R1db9uuuuu6ja:"
					aria-haspopup="menu"
					aria-expanded="false"
					data-state="closed"
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
						class="lucide lucide-circle-user h-5 w-5"
					>
						<circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="10" r="3" />
						<path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662" />
					</svg>
					<span class="sr-only">Toggle user menu</span>
				</a>
			{/if}
		</div>
	</div>
</div>

<section class="grid gap-3 p-6">
	<h2 class="text-2xl font-semibold tracking-tight">Upcoming Events ({events.length})</h2>
	<p class="text-sm text-muted-foreground">Our next scheduled public events.</p>
	<div role="none" class="my-4 h-[1px] w-full shrink-0 bg-border"></div>
	<div class="flex gap-3 overflow-x-auto py-3">
		{#each events as event}
			<a href={`/events/${event.id}`} class="w-[250px] flex-none space-y-3">
				<span data-state="closed">
					<div class="overflow-hidden rounded-md">
						<img
							alt="React Rendezvous"
							loading="lazy"
							width="250"
							height="330"
							decoding="async"
							data-nimg="1"
							class="aspect-[3/4] h-auto w-auto object-cover transition-all hover:scale-105"
							style="color: transparent;"
							src={event.show.cover}
						/>
					</div>
				</span>
				<div class="space-y-1 text-sm">
					<h3 class="truncate font-medium leading-none">{event.show.name}</h3>
					<p class="text-xs text-muted-foreground">
						{event.show.type?.name} &middot; {event.type.name}
					</p>
				</div>
			</a>
		{/each}
	</div>
	<br />
	<h2 class="text-2xl font-semibold tracking-tight">Products ({products?.length})</h2>
	<p class="text-sm text-muted-foreground">Gifts, souvenirs and other items you can buy from us.</p>
	<div role="none" class="my-4 h-[1px] w-full shrink-0 bg-border"></div>
	<div class="flex gap-3 overflow-x-auto py-3">
		{#each products as product}
			<a href={`/products/${product.id}`} class="w-[150px] flex-none space-y-3">
				<span data-state="closed">
					<div class="overflow-hidden rounded-md">
						<img
							alt={product.name}
							loading="lazy"
							width="150"
							height="150"
							decoding="async"
							data-nimg="1"
							class="aspect-square h-full w-full object-cover transition-all hover:scale-105"
							style="color: transparent;"
							src={product.cover}
						/>
					</div>
				</span>
				<div class="space-y-1 text-sm">
					<h3 class="font-medium leading-none">{product.name}</h3>
					<p class="text-xs text-muted-foreground">${product.price}</p>
				</div>
			</a>
		{/each}
	</div>
</section>
