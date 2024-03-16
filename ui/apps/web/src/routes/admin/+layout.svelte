<script lang="ts">
	import { AButton, AIcon, AScreenSize } from 'ui';
	import ASidebarItem from '$lib/components/ASidebarItem.svelte';
	import {
		account_box_multiple_outline,
		account_circle,
		calendar_month_outline,
		cog_outline,
		file_table_outline,
		invoice_list_outline,
		menu,
		monitor_dashboard,
		package_variant_closed,
		times,
		video_vintage
	} from 'ui/icons';
	import { setContext, type Snippet } from 'svelte';

	let sidebar = $state(false);

	let { data, children } = $props();

	const { account, organization } = data;

	const toggle = () => {
		sidebar = !sidebar;
	};

	let right = $state<Snippet>();
</script>

<svelte:head>
	<title>Admin | {organization.name} &middot; Astral</title>
</svelte:head>

{#snippet sidebar_items()}
	<ASidebarItem href="/admin" text="Dashboard" icon={monitor_dashboard} />
	<ASidebarItem href="/admin/calendar" text="Calendar" icon={calendar_month_outline} />
	<!-- <ASidebarItem href="/admin/sales" text="Sales" icon={invoice_list_outline} /> -->
	<ASidebarItem href="/admin/shows" text="Shows" icon={video_vintage} />
	<ASidebarItem href="/admin/products" text="Products" icon={package_variant_closed} />
	<ASidebarItem href="/admin/users" text="Users" icon={account_box_multiple_outline} />
	<!-- <ASidebarItem href="/admin/reports" text="Reports" icon={file_table_outline} /> -->
	<ASidebarItem href="/admin/settings" text="Settings" icon={cog_outline} />
	<div class="flex grow flex-col justify-end gap-6 text-sm">
		<div class="flex items-center gap-1">
			<div>
				<AIcon data={account_circle} size={2.5} />
			</div>
			<div>
				<p class="font-medium">{account.firstname}</p>
				<span class="text-zinc-500 dark:text-zinc-400">{account.role.name}</span>
			</div>
		</div>
		<form method="POST" action="/logout/?" class="grid">
			<AButton text="Logout" type="submit" />
		</form>
	</div>
{/snippet}

{#if sidebar}
	<aside
		class="fixed z-40 flex h-[calc(100svh)] w-60 flex-col gap-3 border-r border-zinc-200 bg-white p-3 dark:border-zinc-800 dark:bg-black"
	>
		<AIcon size={1.5} data={times} onclick={toggle} />
		{@render sidebar_items()}
	</aside>
{/if}

<nav class="flex h-16 items-center gap-2 border-b border-zinc-300 px-6 dark:border-zinc-800">
	<div class="md:hidden">
		<AIcon data={menu} size={1.5} onclick={toggle} />
	</div>
	<div class="flex grow items-center justify-end gap-3">
		<AScreenSize />
		<AButton text="Cashier" href="/cashier" />
	</div>
</nav>

<main class="flex gap-6">
	<aside
		class="hidden h-[calc(100vh-4rem)] w-60 flex-col gap-1 border-r border-zinc-300 px-3 pb-6 pt-3 text-sm lg:flex dark:border-zinc-800"
	>
		{@render sidebar_items()}
	</aside>
	<section class="flex grow flex-col gap-3 p-6 md:py-6">
		{@render children()}
	</section>
	<aside
		class="hidden h-[calc(100vh-4rem)] w-60 flex-col border-l border-zinc-300 p-3 lg:flex dark:border-zinc-900"
	>
		{#if right}
			{@render right()}
		{/if}
	</aside>
</main>
