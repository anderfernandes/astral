<script lang="ts">
	import { AButton } from 'ui';

	let { data } = $props();
</script>

<svelte:head>
	<title>Users | Astral</title>
</svelte:head>

<header
	class="sticky top-0 -mx-6 flex h-16 items-center gap-3 bg-background/50 px-6 font-semibold backdrop-blur"
>
	<h2 class="grow text-xl font-semibold">Users</h2>
	<AButton text="New User" href="/admin/users/create" />
</header>

{#each data.users as user}
	<a href={`/admin/users/${user.id}`} class="flex items-center rounded-md hover:bg-accent">
		<span class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full">
			<svg class="w-full" viewBox="0 0 24 24"
				><path
					fill="currentColor"
					d="M19,19H5V5H19M19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M16.5,16.25C16.5,14.75 13.5,14 12,14C10.5,14 7.5,14.75 7.5,16.25V17H16.5M12,12.25A2.25,2.25 0 0,0 14.25,10A2.25,2.25 0 0,0 12,7.75A2.25,2.25 0 0,0 9.75,10A2.25,2.25 0 0,0 12,12.25Z"
				></path></svg
			>
		</span>
		<div class="ml-4 space-y-1">
			<div class="flex items-center gap-3 text-sm font-medium leading-none">
				{user.firstname}
				{user.lastname}
				{#if user.membership_id !== 1}
					<svg class="size-4" viewBox="0 0 24 24"
						><path
							fill="currentColor"
							d="M20 22.09L22.45 23.58L21.8 20.77L24 18.89L21.11 18.64L20 16L18.87 18.64L16 18.89L18.18 20.77L17.5 23.58L20 22.09M14.08 21H2C.91 20.96 .04 20.09 0 19V5C.04 3.91 .91 3.04 2 3H22C23.09 3.04 23.96 3.91 24 5V15.53C23.42 15 22.75 14.61 22 14.34V5H2V19H14.08C14.03 19.33 14 19.66 14 20C14 20.34 14.03 20.68 14.08 21M14 17H4V15.75C4 14.09 7.34 13.25 9 13.25C10.66 13.25 14 14.09 14 15.75V17M14 11H18V12H14V11M9 7C7.63 7 6.5 8.13 6.5 9.5C6.5 10.87 7.63 12 9 12C10.37 12 11.5 10.87 11.5 9.5C11.5 8.13 10.37 7 9 7M14 9H20V10H14V9M14 7H20V8H14V7Z"
						></path></svg
					>
				{/if}
				{#if user.organization_id !== 1}
					<svg class="size-4" viewBox="0 0 24 24"
						><path
							fill="currentColor"
							d="M19 3V21H13V17.5H11V21H5V3H19M15 7H17V5H15V7M11 7H13V5H11V7M7 7H9V5H7V7M15 11H17V9H15V11M11 11H13V9H11V11M7 11H9V9H7V11M15 15H17V13H15V15M11 15H13V13H11V15M7 15H9V13H7V15M15 19H17V17H15V19M7 19H9V17H7V19M21 1H3V23H21V1Z"
						></path></svg
					>
				{/if}
				<span
					class="ml-auto inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
				>
					{user.role.name}
				</span>
			</div>
			<p class="text-sm text-muted-foreground">{user.email}</p>
		</div>
	</a>
{/each}
