<script lang="ts">
	import { page } from '$app/stores';
	import { Cart } from '$lib';
	import { getContext, setContext } from 'svelte';
	import { AButton, AIcon } from 'ui';
	import { account_circle, account_circle_outline, cart } from 'ui/icons';

	let { data, children } = $props();

	const { organization } = data;

	const ShoppingCart = getContext<Cart>('ShoppingCart');
</script>

<nav
	class="fixed left-0 top-0 flex h-24 w-screen items-center justify-center bg-white p-6 dark:bg-black"
>
	<div class="flex w-full items-center gap-3 2xl:max-w-screen-2xl">
		<div class="flex items-center gap-3">
			<img src={organization.logo} alt={organization.name} class="h-8 w-auto" />
			<span class="hidden font-semibold lg:block">{organization.name}</span>
		</div>
		<div class="flex grow justify-center gap-3 md:gap-12">
			<a class="navbar-item" class:active={$page.url.pathname === '/'} href="/">Home</a>
			<a class="navbar-item" class:active={$page.url.pathname.includes('/events')} href="/events">
				Events
			</a>
			<a
				class="navbar-item"
				class:font-bold={$page.url.pathname.includes('/products')}
				href="/products">Products</a
			>
		</div>
		<div class="flex items-center gap-2">
			<a href="/cart" class="flex grow items-center justify-end gap-2">
				{ShoppingCart.count}
				<AIcon data={cart} size={1.25} />
			</a>
			{#if data.account === undefined}
				<AButton text="Login" href="/login" />
			{:else}
				<AIcon data={account_circle} size={1.25} href="/account" />
			{/if}
		</div>
	</div>
</nav>

<main>
	{@render children()}
</main>

<style lang="postcss">
	a.active {
		@apply font-bold !important;
	}

	a.navbar-item {
		@apply font-medium;
	}
</style>
