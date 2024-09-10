<script lang="ts">
	import '../styles.css';

	let { children } = $props();
</script>

<div class="flex h-full justify-center">
	<div class="3xl:max-w-screen-2xl h-full w-full">
		{@render children()}
	</div>
</div>
