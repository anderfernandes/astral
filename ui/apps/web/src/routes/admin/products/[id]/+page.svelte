<script lang="ts">
	import { AButton } from 'ui';
	import AdminLayout from '../../AdminLayout.svelte';

	let { data } = $props();
	const { product } = data;
</script>

{#snippet header()}
	<div class="flex w-full items-center justify-between">
		<h2 class="text-xl font-bold">Product #{product.id} Details</h2>
		<AButton text="Edit" href={`/admin/products/${product.id}/edit`} />
	</div>
{/snippet}

<AdminLayout title={`Product #${product.id} Details`} {header} backHref="/admin/products">
	<h2 class="text-lg font-semibold md:text-2xl">{product.name}</h2>
	<div class="flex gap-3">
		{#if product.in_cashier}
			<svg class="size-5" viewBox="0 0 24 24"
				><path
					fill="currentColor"
					d="M2,17H22V21H2V17M6.25,7H9V6H6V3H14V6H11V7H17.8C18.8,7 19.8,8 20,9L20.5,16H3.5L4.05,9C4.05,8 5.05,7 6.25,7M13,9V11H18V9H13M6,9V10H8V9H6M9,9V10H11V9H9M6,11V12H8V11H6M9,11V12H11V11H9M6,13V14H8V13H6M9,13V14H11V13H9M7,4V5H13V4H7Z"
				></path></svg
			>
		{/if}
		{#if product.stock > 0 && product.inventory}
			<div
				class="ml-auto inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 sm:ml-0"
			>
				In stock
			</div>
			<div class="flex items-center gap-3 text-sm text-muted-foreground">
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
					><path d="m7.5 4.27 9 5.15" /><path
						d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"
					/><path d="m3.3 7 8.7 5 8.7-5" /><path d="M12 22V12" /></svg
				>
				<span class="text-sm">{data.product.stock}</span>
			</div>
			<span class="flex items-center text-sm">${data.product.price}</span>
		{/if}
	</div>
	<div class="flex flex-col gap-3">
		<div class="w-full lg:w-80">
			<img
				alt={data.product.name}
				class="aspect-square w-full rounded-md object-cover"
				style="color:transparent"
				src={data.product.cover}
			/>
		</div>
		<p class="text-sm">{data.product.description}</p>
	</div>
</AdminLayout>
