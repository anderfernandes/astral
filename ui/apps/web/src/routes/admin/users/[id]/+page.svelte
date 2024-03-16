<script lang="ts">
	import { AButton, AIcon } from 'ui';
	import { account_badge_outline } from 'ui/icons';

	let { data } = $props();
	let { user } = data;
</script>

<section class="flex flex-col">
	<div class="flex">
		<h1 class="grow">{user.firstname} {user.lastname}</h1>
		<AButton text="Edit" href={`/admin/users/${user.id}/edit`} />
	</div>

	<div class="flex gap-1 text-sm text-zinc-500 dark:text-zinc-400">
		<span>{user.role.name}</span> &middot;
		<span>{user.email}</span>
		{#if user.staff}
			&middot;
			<AIcon data={account_badge_outline} />
		{/if}
	</div>
</section>
