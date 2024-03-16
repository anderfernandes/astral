<script lang="ts">
	import { AEventCard } from 'ui';

	let { data } = $props();

	const { organization, events } = data;
</script>

<main class="flex flex-col items-center gap-6 p-6 pt-24">
	<section class="grid gap-6 text-center lg:max-w-screen-lg">
		<h1 class=" text-3xl font-extrabold lg:text-6xl">
			Here education and entertainment are always together.
		</h1>
		<h5 class="text-xl font-medium">For you and your family.</h5>
	</section>
	<section class="flex w-screen gap-3 overflow-x-auto px-4 lg:max-w-screen-lg">
		{#each events as event}
			<AEventCard data={event} />
		{/each}
	</section>
</main>
