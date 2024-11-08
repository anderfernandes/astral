<script lang="ts">
	let { children } = $props();
</script>

<main>
	<div class="mx-auto w-full max-w-screen-2xl">
		{@render children()}
	</div>
</main>
