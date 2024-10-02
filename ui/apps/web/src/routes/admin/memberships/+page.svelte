<script>
	import { formatDistanceToNow } from 'date-fns';
	import { AButton } from 'ui';
	import Navbar from '../Navbar.svelte';

	let { data } = $props();
</script>

<Navbar />

<section class="mt-16 flex w-full flex-col gap-3">
	<div class="flex w-full items-center">
		<h1 class="grow text-lg font-semibold md:text-2xl">Memberships</h1>
		<AButton text="New Membership" href="/admin/memberships/create" />
	</div>

	<div class="grid gap-3">
		{#each data.memberships as membership}
			<a
				href={`/admin/memberships/${membership.id}`}
				class="flex flex-col items-start gap-2 rounded-lg border p-3 text-left text-sm transition-all hover:bg-accent"
			>
				<div class="flex w-full flex-col gap-1">
					<div class="flex items-center">
						<div class="flex items-center gap-2">
							<div class="font-semibold">
								#{membership.number}
								{membership.primary.firstname}
								{membership.primary.lastname}
							</div>
						</div>
						<div class="ml-auto text-xs text-muted-foreground">
							expires {formatDistanceToNow(new Date(membership.start), { addSuffix: true })}
						</div>
					</div>
					<div class="text-xs font-medium">
						{membership.type.name}
					</div>
				</div>
				<div class="line-clamp-2 text-xs text-muted-foreground">
					{membership.secondaries.length}
					{membership.secondaries.length === 1 ? 'secondary' : 'secondaries'}
				</div>
				<!-- <div class="flex items-center gap-2">
					<div
						class="inline-flex items-center rounded-md border border-transparent bg-primary px-2.5 py-0.5 text-xs font-semibold text-primary-foreground shadow transition-colors hover:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
					>
						work
					</div>
					<div
						class="inline-flex items-center rounded-md border border-transparent bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground transition-colors hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
					>
						important
					</div>
				</div> -->
			</a>
		{/each}
	</div>
</section>
