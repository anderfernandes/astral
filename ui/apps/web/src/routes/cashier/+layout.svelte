<script lang="ts">
	import { page } from '$app/stores';
	import { AIcon, AScreenSize } from 'ui';
	import {
		badge_account_horizontal_outline,
		calendar_month_outline,
		cash_register,
		file_table_outline,
		menu,
		receipt_text_outline
	} from 'ui/icons';

	let { children, data } = $props();

	let { organization, account } = data;
</script>

<svelte:head>
	<title>Cashier | {organization.name} &middot; Astral</title>
</svelte:head>

{#snippet sidebar_item(href, text, icon)}
	<a
		{href}
		class="flex h-20 w-20 flex-col items-center justify-center gap-2 text-xs hover:bg-zinc-100 dark:bg-black dark:hover:bg-zinc-900"
		class:active={$page.url.pathname.includes(href)}
	>
		<AIcon data={icon} size={1.5} />
		<span>{text}</span>
	</a>
{/snippet}

<nav class="flex h-16 items-center gap-2 border-b border-zinc-300 px-6 dark:border-zinc-800">
	<div class="md:hidden">
		<AIcon data={menu} size={1.5} />
	</div>
	<span class="font-semibold md:ml-20">Cashier</span>
	<div class="flex grow items-center justify-end gap-3">
		<AScreenSize />
		<div class="flex items-center gap-2 text-sm">
			<AIcon data={badge_account_horizontal_outline} />
			<span>{account.firstname}</span>
		</div>
	</div>
</nav>

<main class="flex">
	<aside class="hidden flex-col md:flex">
		<a
			href="/cashier"
			class="flex h-20 w-20 flex-col items-center justify-center gap-2 text-xs hover:bg-zinc-100 dark:bg-black dark:hover:bg-zinc-900"
			class:active={$page.url.pathname === '/cashier'}
		>
			<AIcon data={cash_register} size={1.5} />
			<span>Cashier</span>
		</a>
		{@render sidebar_item('/cashier/sales', 'Sales', receipt_text_outline)}
		<!-- <div class="flex h-20 w-20 flex-col items-center justify-center gap-2 text-xs">
			<AIcon data={calendar_month_outline} size={1.5} />
			<span>Calendar</span>
		</div> -->
		{@render sidebar_item('/cashier/reports', 'Reports', file_table_outline)}
	</aside>
	{@render children()}
</main>

<style lang="postcss">
	.active {
		@apply bg-black text-white dark:bg-white dark:text-black;
	}
</style>
