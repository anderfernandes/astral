<script lang="ts">
	let { data } = $props();
	let { number, primary } = data.membership;
</script>

<section class="flex w-full flex-col gap-3">
	<div class="flex w-full items-center">
		<h1 class="grow text-lg font-semibold md:text-2xl">Memberships Details</h1>
	</div>
	<p># {number} {primary.firstname} {primary.lastname}</p>
</section>
