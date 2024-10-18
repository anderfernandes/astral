<script>
	import { AButton } from 'ui';
	import Navbar from '../Navbar.svelte';
	import AdminLayout from '../AdminLayout.svelte';

	let { data } = $props();
</script>

{#snippet header()}
	<div class="flex w-full items-center justify-between">
		<h2 class="text-xl font-bold">Products</h2>
		<AButton text="New Product" href="/admin/products/create" />
	</div>
{/snippet}

<AdminLayout title="Products" {header} nav>
	<div class="grid gap-3 lg:grid-cols-2">
		{#each data.products as product}
			<a
				href={`/admin/products/${product.id}`}
				class="-mx-2 flex items-start space-x-4 rounded-md p-2 transition-all hover:bg-accent hover:text-accent-foreground"
			>
				<span class="relative flex size-16 shrink-0 overflow-hidden rounded">
					<img
						class="aspect-square h-full w-full object-cover"
						src={product.cover}
						alt={product.name}
					/>
				</span>
				<div class="space-y-1">
					<p class="flex items-center gap-1 text-sm font-medium leading-none">
						{product.name} &middot; ${product.price}
						{#if product.is_public}
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
								><path d="M21.54 15H17a2 2 0 0 0-2 2v4.54" /><path
									d="M7 3.34V5a3 3 0 0 0 3 3a2 2 0 0 1 2 2c0 1.1.9 2 2 2a2 2 0 0 0 2-2c0-1.1.9-2 2-2h3.17"
								/><path d="M11 21.95V18a2 2 0 0 0-2-2a2 2 0 0 1-2-2v-1a2 2 0 0 0-2-2H2.05" /><circle
									cx="12"
									cy="12"
									r="10"
								/></svg
							>
						{/if}
					</p>
					<p class="text-sm text-muted-foreground">{product.description}</p>
				</div>
			</a>
		{/each}
	</div>
</AdminLayout>
