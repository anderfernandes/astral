<script lang="ts">
	let { children } = $props();
</script>

<main class="flex h-screen w-screen justify-center">
	<div class="w-full max-w-screen-2xl">
		{@render children()}
	</div>
</main>
