<script>
	import { AButton, AChip } from 'ui';

	let { data } = $props();
	const { organization } = data;
</script>

<svelte:head>
	<title>Organization #{organization.id} Details | Astral</title>
</svelte:head>

<header
	class="sticky top-0 -mx-6 flex h-16 items-center gap-3 bg-background/50 px-6 font-semibold backdrop-blur"
>
	<a href="/admin/organizations" aria-label="back">
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
	<h2 class="grow text-xl font-semibold">Organization #{organization.id} Details</h2>
	<AButton text="Edit" href={`/admin/organizations/${organization.id}/edit`} />
</header>

<div>
	<h3 class="text-2xl font-semibold tracking-tight">
		{data.organization.name}
		<AChip text={data.organization.type?.name} basic />
	</h3>
	<p class="gap-1 text-sm text-muted-foreground">
		{data.organization.address}
		&middot;
		{data.organization.city}, {data.organization.state}
		{data.organization.zip}
	</p>
</div>
<h3 class="font-semibold leading-none tracking-tight">
	Users ({data.organization.users.length})
</h3>
<div>
	{#each data.organization?.users as { firstname, lastname, email, role }}
		<div class="flex items-center gap-4">
			<span class="relative hidden h-9 w-9 shrink-0 overflow-hidden rounded-full sm:flex">
				<svg viewBox="0 0 24 24">
					<path
						fill="currentColor"
						d="M19,19H5V5H19M19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M16.5,16.25C16.5,14.75 13.5,14 12,14C10.5,14 7.5,14.75 7.5,16.25V17H16.5M12,12.25A2.25,2.25 0 0,0 14.25,10A2.25,2.25 0 0,0 12,7.75A2.25,2.25 0 0,0 9.75,10A2.25,2.25 0 0,0 12,12.25Z"
					></path>
				</svg>
			</span>
			<div class="grid gap-1">
				<p class="text-sm font-medium leading-none">
					{firstname}
					{lastname}
					<AChip basic text={role.name} />
				</p>
				<p class="text-sm text-muted-foreground">{email}</p>
			</div>
			<!-- <div class="ml-auto font-medium">+$1,999.00</div> -->
		</div>
	{/each}
</div>
