<script lang="ts">
	let { data } = $props();
	let { account } = data;
</script>

<section class="flex flex-col p-6">
	<h1>Account</h1>
	<h5 class="text-zinc-500 dark:text-zinc-400">
		{account?.firstname}
		{account?.lastname}
	</h5>
</section>
