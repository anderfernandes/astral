<script lang="ts">
	import { formatDistanceToNow } from 'date-fns';
	import { AChip } from 'ui';

	let { data } = $props();
	const { id, is_expired, primary, secondaries, primary_id } = data.membership;
	const end = new Date(data.membership.end);
</script>

<svelte:head>
	<title>Membership #{data.membership.number} Details | Astral</title>
</svelte:head>

<header
	class="sticky top-0 -mx-6 -mt-6 flex h-16 w-screen items-center bg-background/50 px-6 backdrop-blur lg:-mx-0 lg:w-full lg:pl-0 lg:pr-4"
>
	<a href="/admin/memberships" aria-label="back">
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
	<h2>Membership #{data.membership.number} Details</h2>
	<AChip text={is_expired ? 'expired' : 'current'} />
</header>

<div class="grid lg:grid-cols-3">
	<div>
		<div class="text-lg font-medium">{primary.firstname} {primary.lastname}</div>
		<p class="text-sm text-muted-foreground">#{data.membership.number}</p>
	</div>
	<div>
		<h3 class="text-lg font-medium">
			Ends on {Intl.DateTimeFormat('en-US', { dateStyle: 'medium' }).format(end)}
		</h3>
		<p class="text-sm text-muted-foreground">{formatDistanceToNow(end, { addSuffix: true })}</p>
	</div>
</div>
<div class="flex flex-col space-y-1.5">
	<h3 class="font-semibold leading-none tracking-tight">
		Secondaries ({secondaries.filter((s) => s.id !== primary_id).length})
	</h3>
	<p class="text-sm text-muted-foreground">Additional users of this membership</p>
</div>
{#each secondaries.filter((s) => s.id !== primary.id) as secondary}
	<div class="flex items-center">
		<span class="relative flex h-9 w-9 shrink-0 overflow-hidden">
			<svg viewBox="0 0 24 24">
				<path
					fill="currentColor"
					d="M22,3H2C0.91,3.04 0.04,3.91 0,5V19C0.04,20.09 0.91,20.96 2,21H22C23.09,20.96 23.96,20.09 24,19V5C23.96,3.91 23.09,3.04 22,3M22,19H2V5H22V19M14,17V15.75C14,14.09 10.66,13.25 9,13.25C7.34,13.25 4,14.09 4,15.75V17H14M9,7A2.5,2.5 0 0,0 6.5,9.5A2.5,2.5 0 0,0 9,12A2.5,2.5 0 0,0 11.5,9.5A2.5,2.5 0 0,0 9,7M14,7V8H20V7H14M14,9V10H20V9H14M14,11V12H18V11H14"
				/>
			</svg>
		</span>
		<div class="ml-4 space-y-1">
			<p class="text-sm font-medium leading-none">{secondary.firstname} {secondary.lastname}</p>
			<p class="text-sm text-muted-foreground">{secondary.email}</p>
		</div>
		<!-- <div class="ml-auto font-medium">+$1,999.00</div> -->
	</div>
{:else}
	<p>No secondaries on this membership.</p>
{/each}
