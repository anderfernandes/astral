<script lang="ts">
	let { text = '', basic = false } = $props();
</script>

{#if basic}
	<span
		class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
	>
		{text}
	</span>
{:else}
	<span
		class="inline-flex items-center rounded-md border border-transparent bg-primary px-2.5 py-0.5 text-xs font-semibold text-primary-foreground shadow transition-colors hover:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
	>
		{text}
	</span>
{/if}
