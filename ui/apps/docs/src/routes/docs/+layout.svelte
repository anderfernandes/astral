<script>
	import DocsMenuItems from '$lib/DocsMenuItems.svelte';

	let { children } = $props();
</script>

<div>
	<aside
		class="fixed left-6 top-16 hidden w-56 content-start gap-6 overflow-y-auto lg:left-[calc(50%-485px)] lg:grid"
	>
		<DocsMenuItems />
	</aside>
	<div class="pb-6 lg:ml-[calc(14.75rem)] lg:w-[752px]">{@render children()}</div>
</div>
