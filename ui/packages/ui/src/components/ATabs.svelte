<script lang="ts">
	import { office_building_cog_outline } from '../lib/icons';
	import type { Snippet } from 'svelte';
	import AIcon from './AIcon.svelte';

	let { children } = $props<{ children: Snippet }>();
</script>

<div
	class="flex w-[calc(100vw-3rem)] overflow-x-auto border-b border-zinc-200 md:w-[calc(100%-3rem)] dark:border-zinc-800"
>
	{@render children()}
</div>
