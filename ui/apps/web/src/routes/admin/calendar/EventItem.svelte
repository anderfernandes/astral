<script lang="ts">
	let { data }: { data: IEvent } = $props();
	let { id, show, type, seats, is_public } = data;
	const start = new Date(data.start);
</script>

<tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
	<td
		class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] hidden p-2 align-middle sm:table-cell"
	>
		<img
			alt={`${show.name} cover`}
			loading="lazy"
			width="64"
			height="64"
			decoding="async"
			class="aspect-square rounded-md object-cover"
			style="color:transparent"
			src={show.cover}
		/>
	</td>
	<td
		class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] p-2 align-middle font-medium"
	>
		<a href={`/admin/events/${id}`} class="flex gap-1">
			{#if is_public}
				<svg
					xmlns="http://www.w3.org/2000/svg"
					fill="none"
					viewBox="0 0 24 24"
					stroke-width="1.5"
					stroke="currentColor"
					class="size-6"
				>
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 0 1-1.161.886l-.143.048a1.107 1.107 0 0 0-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 0 1-1.652.928l-.679-.906a1.125 1.125 0 0 0-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 0 0-8.862 12.872M12.75 3.031a9 9 0 0 1 6.69 14.036m0 0-.177-.529A2.25 2.25 0 0 0 17.128 15H16.5l-.324-.324a1.453 1.453 0 0 0-2.328.377l-.036.073a1.586 1.586 0 0 1-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 0 1-5.276 3.67m0 0a9 9 0 0 1-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25"
					/>
				</svg>
			{/if}
			{show.name}
			<div
				class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
			>
				{show.type?.name}
			</div>
		</a>
	</td>
	<td
		class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] p-2 align-middle"
	>
		<div
			class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-xs font-semibold text-foreground transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
		>
			{type.name}
		</div>
	</td>
	<td
		class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] p-2 align-middle"
		>$499.99
	</td>
	<td
		class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] hidden p-2 align-middle md:table-cell"
	>
		{seats.available}/{seats.total}
	</td>
	<td
		class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] hidden p-2 align-middle md:table-cell"
	>
		{Intl.DateTimeFormat('en-US', { dateStyle: 'medium', timeStyle: 'short' }).format(start)}
	</td>
	<td
		class="[&amp;:has([role=checkbox])]:pr-0 [&amp;>[role=checkbox]]:translate-y-[2px] p-2 align-middle"
	>
		<a
			href={`/admin/events/${id}/edit`}
			class="inline-flex h-9 w-9 items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
			aria-haspopup="true"
			type="button"
			id="radix-:Rsqmipuuuuu6ja:"
			aria-expanded="false"
			data-state="closed"
		>
			<svg
				xmlns="http://www.w3.org/2000/svg"
				fill="none"
				viewBox="0 0 24 24"
				stroke-width="1.5"
				stroke="currentColor"
				class="size-6"
			>
				<path
					stroke-linecap="round"
					stroke-linejoin="round"
					d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"
				/>
			</svg>
		</a>
	</td>
</tr>
