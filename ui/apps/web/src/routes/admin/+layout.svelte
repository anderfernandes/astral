<script lang="ts">
	import Navbar from './Navbar.svelte';
	import Sidebar from './Sidebar.svelte';

	let { children, data } = $props();
	let { account, settings } = data;
</script>

<div class="flex h-screen w-full justify-center">
	<section class="flex h-screen w-full xl:w-[1080px]">
		<!-- <Navbar /> -->
		<Sidebar {account} version={settings.version} />
		<div class="w-full px-6 lg:ml-[288px]">
			{@render children()}
			<br />
		</div>
	</section>
</div>
