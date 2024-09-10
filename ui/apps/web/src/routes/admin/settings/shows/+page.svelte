<script lang="ts">
	import { AButton } from 'ui';

	let { data } = $props();
</script>

<div class="grid gap-3">
	{#each data.show_types as show_type}
		<button
			class="flex flex-col items-start gap-2 rounded-lg border p-3 text-left text-sm transition-all hover:bg-accent"
			><div class="flex w-full flex-col gap-1">
				<div class="flex items-center">
					<div class="flex items-center gap-2">
						<div class="font-semibold">
							{show_type.name}
							{#if show_type.is_active}
								<span class="size-3 rounded-full bg-green-500"></span>
							{/if}
						</div>
					</div>
					<!-- <div class="ml-auto text-xs text-muted-foreground">9 months ago</div> -->
				</div>
				<!-- <div class="text-xs font-medium">Re: Project Update</div> -->
			</div>
			<div class="line-clamp-2 text-xs text-muted-foreground">
				{show_type.description}
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
		</button>
	{/each}
</div>
