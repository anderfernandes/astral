<script lang="ts">
	import { AButton, ACheckbox, ADialog, AInput, ATextArea } from 'ui';

	let { data } = $props();

	let selected: IEventType | undefined = $state();
	let open = $state(false);
	const toggle = () => {
		open = !open;
	};
</script>

<div class="flex justify-end">
	<AButton
		text="New Event Type"
		onclick={() => {
			selected = undefined;
			toggle();
		}}
	/>
</div>

<div class="grid gap-3">
	{#each data.event_types as event_type}
		<button
			onclick={() => {
				selected = event_type;
				toggle();
			}}
			class="rounded-xl border bg-card text-card-foreground shadow"
		>
			<div class="grid grid-cols-[1fr_110px] flex-col items-start gap-4 space-y-0 p-6">
				<div class="space-y-1">
					<h3 class="text-left font-semibold leading-none tracking-tight">{event_type.name}</h3>
					<p class="text-left text-sm text-muted-foreground">
						{event_type.description}
					</p>
				</div>
				<div class="flex items-center justify-end space-x-1 rounded-md">
					{#if event_type.is_public}
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
							class="size-4"
							><circle cx="12" cy="12" r="10" /><path
								d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"
							/><path d="M2 12h20" /></svg
						>
					{/if}
				</div>
			</div>
			<!-- <div class="p-6 pt-0">
			<div class="flex space-x-4 text-sm text-muted-foreground">
				<div class="flex items-center">
					<svg
						width="15"
						height="15"
						viewBox="0 0 15 15"
						fill="none"
						xmlns="http://www.w3.org/2000/svg"
						class="mr-1 h-3 w-3 fill-sky-400 text-sky-400"
						><path
							d="M0.877075 7.49991C0.877075 3.84222 3.84222 0.877075 7.49991 0.877075C11.1576 0.877075 14.1227 3.84222 14.1227 7.49991C14.1227 11.1576 11.1576 14.1227 7.49991 14.1227C3.84222 14.1227 0.877075 11.1576 0.877075 7.49991ZM7.49991 1.82708C4.36689 1.82708 1.82708 4.36689 1.82708 7.49991C1.82708 10.6329 4.36689 13.1727 7.49991 13.1727C10.6329 13.1727 13.1727 10.6329 13.1727 7.49991C13.1727 4.36689 10.6329 1.82708 7.49991 1.82708Z"
							fill="currentColor"
							fill-rule="evenodd"
							clip-rule="evenodd"
						></path></svg
					>TypeScript
				</div>
				<div class="flex items-center">
					<svg
						width="15"
						height="15"
						viewBox="0 0 15 15"
						fill="none"
						xmlns="http://www.w3.org/2000/svg"
						class="mr-1 h-3 w-3"
						><path
							d="M6.97942 1.25171L6.9585 1.30199L5.58662 4.60039C5.54342 4.70426 5.44573 4.77523 5.3336 4.78422L1.7727 5.0697L1.71841 5.07405L1.38687 5.10063L1.08608 5.12475C0.820085 5.14607 0.712228 5.47802 0.914889 5.65162L1.14406 5.84793L1.39666 6.06431L1.43802 6.09974L4.15105 8.42374C4.23648 8.49692 4.2738 8.61176 4.24769 8.72118L3.41882 12.196L3.40618 12.249L3.32901 12.5725L3.25899 12.866C3.19708 13.1256 3.47945 13.3308 3.70718 13.1917L3.9647 13.0344L4.24854 12.861L4.29502 12.8326L7.34365 10.9705C7.43965 10.9119 7.5604 10.9119 7.6564 10.9705L10.705 12.8326L10.7515 12.861L11.0354 13.0344L11.2929 13.1917C11.5206 13.3308 11.803 13.1256 11.7411 12.866L11.671 12.5725L11.5939 12.249L11.5812 12.196L10.7524 8.72118C10.7263 8.61176 10.7636 8.49692 10.849 8.42374L13.562 6.09974L13.6034 6.06431L13.856 5.84793L14.0852 5.65162C14.2878 5.47802 14.18 5.14607 13.914 5.12475L13.6132 5.10063L13.2816 5.07405L13.2274 5.0697L9.66645 4.78422C9.55432 4.77523 9.45663 4.70426 9.41343 4.60039L8.04155 1.30199L8.02064 1.25171L7.89291 0.944609L7.77702 0.665992C7.67454 0.419604 7.32551 0.419604 7.22303 0.665992L7.10715 0.944609L6.97942 1.25171ZM7.50003 2.60397L6.50994 4.98442C6.32273 5.43453 5.89944 5.74207 5.41351 5.78103L2.84361 5.98705L4.8016 7.66428C5.17183 7.98142 5.33351 8.47903 5.2204 8.95321L4.62221 11.461L6.8224 10.1171C7.23842 9.86302 7.76164 9.86302 8.17766 10.1171L10.3778 11.461L9.77965 8.95321C9.66654 8.47903 9.82822 7.98142 10.1984 7.66428L12.1564 5.98705L9.58654 5.78103C9.10061 5.74207 8.67732 5.43453 8.49011 4.98442L7.50003 2.60397Z"
							fill="currentColor"
							fill-rule="evenodd"
							clip-rule="evenodd"
						></path></svg
					>20k
				</div>
				<div>Updated April 2023</div>
			</div>
		</div> -->
		</button>
	{/each}
</div>

{#if open}
	<ADialog
		onclose={toggle}
		title={selected === undefined ? 'New Event Type' : 'Edit Event Type'}
		subtitle="Make sure you can't reuse event types. Changing event types affected events created with the type."
	>
		<form method="POST" class="grid gap-3">
			{#if selected}
				<input type="hidden" name="id" value={selected.id} />
			{/if}
			<AInput
				value={selected ? selected.name : ''}
				name="name"
				label="Name"
				hint="The name of the ticket type."
				placeholder="Name"
				required
			/>
			<ATextArea
				value={selected ? selected.description : ''}
				name="description"
				label="Description"
				hint="Describe the purpose of the ticket"
				placeholder="Description"
				required
			/>
			<ACheckbox
				checked={selected?.is_public || false}
				name="is_public"
				label="Public"
				hint="Makes all events of this type available to the general public."
			/>
			<div class="flex justify-end gap-3">
				<AButton text="Save" type="submit" />
				<AButton text="Close" variant="secondary" onclick={toggle} />
			</div>
		</form>
	</ADialog>
{/if}
