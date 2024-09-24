<script lang="ts">
	import Navbar from './Navbar.svelte';
	import Sidebar from './Sidebar.svelte';

	let { children, data } = $props();
	let { account, settings } = data;
</script>

<div class="h-full overflow-hidden rounded-[0.5rem] bg-background lg:border">
	<Navbar />
	<section class="flex h-full pt-16">
		<Sidebar {account} version={settings.version} />
		<div class="h-[calc(100vh-4rem)] w-full flex-1 space-y-4 overflow-y-auto p-6">
			{@render children()}
		</div>
	</section>
</div>
