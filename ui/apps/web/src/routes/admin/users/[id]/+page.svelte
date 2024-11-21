<script lang="ts">
	import { AButton } from 'ui';

	let { data } = $props();
	//const { user } = data;
</script>

<svelte:head>
	<title>User #{data.user.id} Details | Astral</title>
</svelte:head>

<header
	class="sticky top-0 -mx-6 flex h-16 items-center gap-3 bg-background/50 px-6 font-semibold backdrop-blur"
>
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
	<h2 class="grow">User #{data.user.id} Details</h2>
	<AButton text="Edit" href={`/admin/users/${data.user.id}/edit`} />
</header>

<div class="flex grow flex-col gap-1">
	<h3 class="flex items-center gap-1 text-lg font-medium">
		{data.user.firstname}
		{data.user.lastname}
		{#if data.user.membership_id !== 1}
			<a href={`/admin/memberships/${data.user.membership_id}`} aria-label="membership">
				<svg class="mx-1 size-4" viewBox="0 0 24 24"
					><path
						fill="currentColor"
						d="M20 22.09L22.45 23.58L21.8 20.77L24 18.89L21.11 18.64L20 16L18.87 18.64L16 18.89L18.18 20.77L17.5 23.58L20 22.09M14.08 21H2C.91 20.96 .04 20.09 0 19V5C.04 3.91 .91 3.04 2 3H22C23.09 3.04 23.96 3.91 24 5V15.53C23.42 15 22.75 14.61 22 14.34V5H2V19H14.08C14.03 19.33 14 19.66 14 20C14 20.34 14.03 20.68 14.08 21M14 17H4V15.75C4 14.09 7.34 13.25 9 13.25C10.66 13.25 14 14.09 14 15.75V17M14 11H18V12H14V11M9 7C7.63 7 6.5 8.13 6.5 9.5C6.5 10.87 7.63 12 9 12C10.37 12 11.5 10.87 11.5 9.5C11.5 8.13 10.37 7 9 7M14 9H20V10H14V9M14 7H20V8H14V7Z"
					></path></svg
				>
			</a>
		{/if}
		<div
			class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
		>
			{data.user.role.name}
		</div>
		{#if data.user.role.staff}
			<div
				class="inline-flex items-center rounded-md border border-transparent bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground transition-colors hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
			>
				Staff
			</div>
		{/if}
	</h3>
	{#if data.user.organization_id !== 1}
		<a
			href={`/admin/organizations/${data.user.organization_id}`}
			class="flex items-center text-sm text-muted-foreground"
		>
			<svg class="mr-2 size-4" viewBox="0 0 24 24"
				><path
					fill="currentColor"
					d="M19 3V21H13V17.5H11V21H5V3H19M15 7H17V5H15V7M11 7H13V5H11V7M7 7H9V5H7V7M15 11H17V9H15V11M11 11H13V9H11V11M7 11H9V9H7V11M15 15H17V13H15V15M11 15H13V13H11V15M7 15H9V13H7V15M15 19H17V17H15V19M7 19H9V17H7V19M21 1H3V23H21V1Z"
				></path></svg
			>
			{data.user.organization?.name}
		</a>
	{/if}
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
		{data.user.address}
		{data.user.city},
		{data.user.state}
		{data.user.zip}
	</p>
</div>
