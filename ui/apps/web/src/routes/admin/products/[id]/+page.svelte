<script lang="ts">
	import { AButton } from 'ui';

	let { data } = $props();
	const { product } = data;
</script>

<svelte:head>
	<title>Product Details - Astral Admin</title>
</svelte:head>

<header
	class="fixed left-0 top-0 flex w-full flex-col bg-background/95 px-5 backdrop-blur supports-[backdrop-filter]:bg-background/60 lg:left-[inherit] lg:-mx-6 lg:w-[calc(1080px-288px)]"
>
	<div class="flex h-16 items-center">
		<a href="/admin/products" aria-label="back">
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
				class="size-6"
			>
				<path d="m12 19-7-7 7-7" />
				<path d="M19 12H5" />
			</svg>
		</a>
		<h2 class="px-3 font-semibold leading-none tracking-tight">
			Product #{data.product.id} Details
		</h2>
		<div class="ml-auto">
			<AButton text="Edit" href={`/admin/products/${product.id}/edit`} />
		</div>
	</div>
</header>

<div class="mt-16 flex gap-3">
	{#if data.product.stock > 0 && data.product.inventory}
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
			<span>{data.product.stock}</span>
		</div>
		<span class="flex items-center text-sm">${data.product.price}</span>
	{/if}
</div>

<div class="flex flex-col gap-3">
	<div class="w-36">
		<img
			alt={data.product.name}
			width="300"
			height="300"
			class="aspect-square w-full rounded-md object-cover"
			style="color:transparent"
			src={data.product.cover}
		/>
	</div>
	<p class="text-sm">{data.product.description}</p>
</div>
