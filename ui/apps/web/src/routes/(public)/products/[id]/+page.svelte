<script lang="ts">
	let { data } = $props();
	const { settings, product } = data;
	const { organization } = settings;
</script>

<svelte:head>
	<title>{organization.name} #{product.id} | Astral</title>
</svelte:head>

<section class="grid gap-6 p-6">
	<a href="/" aria-label="Home">
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
	<img src={product.cover} alt={product.name} class="w-full rounded lg:w-[192px]" />
	<div>
		<h2 class="text-2xl font-bold tracking-tight">#{product.id} {product.name}</h2>
		<p class="text-muted-foreground">
			${product.price}
		</p>
	</div>
</section>
