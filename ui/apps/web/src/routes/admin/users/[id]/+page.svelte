<script lang="ts">
	import { AButton } from 'ui';

	let { data } = $props();
	const { user } = data;
</script>

<svelte:head>
	<title>{data.user.firstname} {data.user.lastname} Details &middot; Astral Admin</title>
</svelte:head>

<header
	class="fixed left-0 top-0 flex w-full flex-col bg-background/95 px-5 backdrop-blur supports-[backdrop-filter]:bg-background/60 lg:left-[inherit] lg:-mx-6 lg:w-[calc(1080px-288px)]"
>
	<div class="flex h-16 items-center gap-3">
		<a href="/admin/users" aria-label="back">
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
		<h3 class="grow font-semibold leading-none tracking-tight">User #{user.id}</h3>
		<AButton text="Edit" href={`/admin/users/${user.id}/edit`} />
	</div>
</header>

<section class="mt-24 flex items-center gap-6">
	<div class="flex grow flex-col gap-1">
		<h3 class="flex items-center gap-1 text-lg font-medium">
			{user.firstname}
			{user.lastname}
			<div
				class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
			>
				{user.role.name}
			</div>
			{#if user.role.staff}
				<div
					class="inline-flex items-center rounded-md border border-transparent bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground transition-colors hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
				>
					Staff
				</div>
			{/if}
		</h3>
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
				/><path d="M18 10a8 8 0 0 0-16 0c0 4.993 5.539 10.193 7.399 11.799a1 1 0 0 0 .601.2" /><path
					d="M18 22v-3"
				/><circle cx="10" cy="10" r="3" /></svg
			>
			{user.address}
			{user.city},
			{user.state}
			{user.zip}
		</p>
		<!-- <span>{data.user.membership_id}</span> -->
	</div>
</section>
