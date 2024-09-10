<script lang="ts">
	import { page } from '$app/stores';
	import type { Snippet } from 'svelte';

	interface IATabItemProps {
		text: string;
		href: string;
		children: Snippet;
	}
	let { text, href, children }: IATabItemProps = $props();
</script>

<a
	{href}
	class="flex gap-2 rounded-t-md px-5 pb-2 pt-3 text-sm hover:bg-muted"
	class:a-tab-item-active={$page.url.pathname + $page.url.search === href}
>
	<div>{@render children()}</div>
	<div>{text}</div>
</a>

<style lang="postcss">
	.a-tab-item-active {
		@apply border-b-4 border-primary;
	}
</style>
