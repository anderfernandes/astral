<script lang="ts">
	import { page } from '$app/stores';
	import AIcon from './AIcon.svelte';

	let { icon, href, text } = $props<{ icon: IconData; href: string; text: string }>();
</script>

<a
	{href}
	class:a-tab-item-active={$page.url.pathname + $page.url.search === href}
	class="flex items-center gap-2 rounded-t-lg border-black px-6 py-3 text-sm font-medium hover:bg-zinc-100 dark:border-white dark:hover:bg-zinc-900"
>
	<AIcon data={icon} size={1.25} />{text}
</a>

<style lang="postcss">
	.a-tab-item-active {
		@apply border-b-4;
	}
</style>
