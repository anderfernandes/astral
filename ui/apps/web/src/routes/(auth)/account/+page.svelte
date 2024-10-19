<script lang="ts">
	import { AButton } from 'ui';

	let { data } = $props();
	let { account } = data;
</script>

<svelte:head>
	<title>{account?.firstname} {account?.lastname}'s Account &middot; Astral</title>
</svelte:head>

<section class="flex items-center gap-6 p-6">
	<div class="flex grow flex-col gap-3">
		<h3 class="flex items-center gap-1 text-lg font-medium">
			<a href="/" aria-label="Back to Home">
				<svg class="size-5" viewBox="0 0 24 24">
					<path
						fill="currentColor"
						d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"
					/>
				</svg>
			</a>
			{account?.firstname}
			{account?.lastname}
			<div
				class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
			>
				{account?.role.name}
			</div>
			{#if account?.role.staff}
				<div
					class="inline-flex items-center rounded-md border border-transparent bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground transition-colors hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
				>
					Staff
				</div>
			{/if}
			<div class="grow"></div>
			<form action="/logout" class="grid" method="post">
				<AButton text="Logout" type="submit" />
			</form>
		</h3>
		{#if account?.address}
			<p class="flex text-sm text-muted-foreground">
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
					class="mr-1 size-5"
					><path
						d="M15 22a1 1 0 0 1-1-1v-4a1 1 0 0 1 .445-.832l3-2a1 1 0 0 1 1.11 0l3 2A1 1 0 0 1 22 17v4a1 1 0 0 1-1 1z"
					/><path
						d="M18 10a8 8 0 0 0-16 0c0 4.993 5.539 10.193 7.399 11.799a1 1 0 0 0 .601.2"
					/><path d="M18 22v-3" /><circle cx="10" cy="10" r="3" /></svg
				>
				{account?.address}
				{account?.city},
				{account?.state}
				{account?.zip}
			</p>
		{/if}
		<!-- <span>{account?.membership_id}</span> -->
		<div class="flex justify-end">
			{#if account?.role.staff}
				<AButton text="Admin" href={`/admin`} />
			{/if}
		</div>
	</div>
</section>
