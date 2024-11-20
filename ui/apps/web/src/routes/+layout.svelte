<script lang="ts">
	import '../styles.css';

	let { children } = $props();
</script>

<main class="mx-auto lg:max-w-screen-xl">
	{@render children()}
</main>
