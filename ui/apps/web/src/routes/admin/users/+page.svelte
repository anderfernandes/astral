<script lang="ts">
	import { AButton } from 'ui';

	let { data } = $props();
</script>

<svelte:head>
	<title>Users &middot; Astral Admin</title>
</svelte:head>

<section class="mt-16 flex flex-col gap-6">
	<div class="flex items-center">
		<h2 class="grow text-lg font-semibold md:text-2xl">Users</h2>
		<AButton text="New User" href="/admin/users/create" />
	</div>
	<div class="flex flex-col gap-3">
		{#each data.users as user}
			<a href={`/admin/users/${user.id}`} class="flex items-center">
				<span class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full">
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
						class="size-full"
					>
						<path d="M18 20a6 6 0 0 0-12 0" />
						<circle cx="12" cy="10" r="4" />
						<circle cx="12" cy="12" r="10" />
					</svg>
				</span>
				<div class="ml-4 space-y-1">
					<p class="text-sm font-medium leading-none">{user.firstname} {user.lastname}</p>
					<p class="text-sm text-muted-foreground">{user.email}</p>
				</div>
				<div
					class="ml-auto inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
				>
					{user.role.name}
				</div>
			</a>
		{/each}
	</div>
</section>
