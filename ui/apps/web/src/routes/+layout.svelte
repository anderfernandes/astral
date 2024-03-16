<script lang="ts">
	import '../styles.css';
	import { Cart, createToasts } from '$lib';
	import { AToast } from 'ui';
	import { setContext } from 'svelte';

	let { children } = $props();

	const toastsContext: IToastContext = createToasts();

	setContext('toasts', toastsContext);

	const ShoppingCart = new Cart();

	setContext('ShoppingCart', ShoppingCart);
</script>

{@render children()}

<ol
	class="fixed top-0 z-30 flex max-h-screen w-full flex-col-reverse gap-2 p-4 sm:bottom-0 sm:right-0 sm:top-auto sm:flex-col md:max-w-[420px]"
>
	<!-- <p class="bg-white text-black">{toastsContext.toasts.length}</p> -->
	{#each toastsContext.toasts as { title, message }}
		<AToast {title} {message} />
	{/each}
</ol>
