<script lang="ts">
	import { information_outline } from '../lib/icons';
	import AIcon from './AIcon.svelte';

	let { title = '', message = '' } = $props();
</script>

<div class="flex items-center gap-2 rounded-xl border border-zinc-300 p-3 dark:border-zinc-800">
	<AIcon data={information_outline} />
	<div class="flex flex-col gap-2 text-sm">
		{#if title}
			<span class="font-medium">{title}</span>
		{/if}
		{#if message}
			<span>{message}</span>
		{/if}
	</div>
</div>
