<script lang="ts">
	import Navbar from './Navbar.svelte';
	import Sidebar from './Sidebar.svelte';

	let { children, data } = $props();
	let { account, settings } = data;
</script>

<div class="flex h-screen w-full justify-center">
	<section class="flex h-screen w-full max-w-screen-2xl">
		<!-- <Navbar /> -->
		<Sidebar {account} version={settings.version} />
		<div class="h-screen w-full lg:ml-[288px]">
			{@render children()}
		</div>
	</section>
</div>
