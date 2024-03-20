<script lang="ts">
	let { data } = $props();
	let { organization } = data;
</script>

<svelte:head>
	<title>Checkout | {organization.name} &middot; Astral</title>
</svelte:head>

<section class="flex flex-col gap-3 p-6">
	<h1>Checkout</h1>
</section>
