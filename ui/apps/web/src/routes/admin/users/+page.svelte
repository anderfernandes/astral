<script lang="ts">
	import { page } from '$app/stores';
	import { AButton, AChip, AIcon, AInput } from 'ui';
	import { account_circle } from 'ui/icons';

	let { data } = $props();

	let q = $state($page.url.searchParams.get('q') || '');
</script>

<section class="flex flex-col gap-3 px-3">
	<div class="flex">
		<h1 class="grow">Users ({data.users.length})</h1>
		<div>
			<AButton text="New User" href="/admin/users/create" />
		</div>
	</div>

	<div class="flex items-center gap-3">
		<AInput bind:value={q} name="q" placeholder="Search" />
		<AButton basic text="Search" href={`?q=${q}`} />
	</div>

	{#snippet user_item(user: IUser)}
		<a
			href={`/admin/users/${user.id}`}
			class="flex items-center gap-3 rounded-xl border border-zinc-200 p-3 hover:bg-zinc-100 dark:border-zinc-800 dark:hover:bg-zinc-800"
		>
			<AIcon data={account_circle} size={2.5} />
			<div class="flex flex-col">
				<span class="text-sm">{user.firstname} {user.lastname}</span>
				<div>
					<AChip text={user.role.name} />
				</div>
			</div>
		</a>
	{/snippet}

	{#each data.users as user}
		{@render user_item(user)}
	{/each}
</section>
