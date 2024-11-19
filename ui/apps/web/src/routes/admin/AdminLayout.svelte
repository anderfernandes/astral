<script lang="ts">
	import { page } from '$app/stores';
	import type { Snippet } from 'svelte';

	interface IAdminLayoutProps {
		title: string;
		header: Snippet;
		children: Snippet;
		//nav?: boolean;
		backHref?: string;
	}
	let { title, header, children, backHref }: IAdminLayoutProps = $props();
</script>

<svelte:head>
	<title>{title} &middot; Astral</title>
</svelte:head>

<nav class="flex h-16 items-center gap-3 border-b px-6">
	{#if backHref}
		<a href={backHref} aria-label="back">
			<svg
				xmlns="http://www.w3.org/2000/svg"
				width="24"
				height="24"
				viewBox="0 0 24 24"
				fill="none"
				stroke="currentColor"
				stroke-width="2"
				stroke-linecap="round"
				stroke-linejoin="round"
				class="size-6"
			>
				<path d="m12 19-7-7 7-7" />
				<path d="M19 12H5" />
			</svg>
		</a>
	{/if}
	{@render header()}
</nav>

<article
	class="flex h-[calc(100svh-128px)] flex-col gap-3 overflow-y-auto px-6 lg:h-[calc(100svh-64px)]"
>
	{@render children()}
</article>
