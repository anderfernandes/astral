<script lang="ts">
	import { page } from '$app/stores';
	import { AIcon } from 'ui';

	let { text, icon, href } = $props<{ text: string; icon: IconPath; href: string }>();
</script>

<a {href} class:a-sidebar-item-active={$page.url.pathname === href} class="a-sidebar-item">
	<AIcon size={1.5} data={icon} />
	{text}
</a>

<style lang="postcss">
	.a-sidebar-item {
		@apply inline-flex h-9 items-center justify-start gap-2 whitespace-nowrap rounded-md bg-transparent px-3 text-sm font-medium ring-offset-black transition-colors hover:bg-black/90 hover:bg-zinc-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-black focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 dark:hover:bg-zinc-900;
	}
	.a-sidebar-item-active {
		@apply bg-black text-white hover:bg-black dark:bg-white dark:text-black dark:hover:bg-white;
	}
</style>
