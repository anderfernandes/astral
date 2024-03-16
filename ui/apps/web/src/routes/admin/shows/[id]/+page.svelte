<script lang="ts">
	import { getContext } from 'svelte';
	import { AButton } from 'ui';

	let { data } = $props();
	let { show } = data;

	const AdminLayout = getContext('AdminLayout');
</script>

<section class="grid gap-3">
	<div class="flex justify-end">
		<AButton text="Edit" href={`/admin/shows/${show.id}/edit`} />
	</div>
	<div class="text-center">
		<h1>{show.name}</h1>
		<h5 class="text-sm text-zinc-500 dark:text-zinc-400">
			{show.type?.name} &middot; {show.duration} min &middot; {show.is_active
				? 'active'
				: 'inactive'} &middot;
			{show.is_expired ? 'expired' : 'not expired'}
		</h5>
	</div>
	<div class="flex w-full justify-center">
		<img class="w-64 rounded-xl text-center" src={show.cover} alt={show.name} />
	</div>
	<p class="text-center text-sm">{show.description}</p>
</section>
