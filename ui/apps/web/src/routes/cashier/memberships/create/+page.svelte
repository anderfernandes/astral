<script lang="ts">
	import MembershipForm from '$lib/components/MembershipForm.svelte';

	const { data } = $props();
	const { membership_types, settings, users, payment_methods } = data;
</script>

<svelte:head>
	<title>New Membership | Astral</title>
</svelte:head>

<header
	class="sticky top-0 -mx-6 -mt-6 flex h-16 w-screen items-center bg-background/50 px-6 backdrop-blur lg:-mx-0 lg:w-full lg:pl-0 lg:pr-4"
>
	<a href="/admin/memberships" aria-label="back">
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
			class="size-6"
		>
			<path d="m12 19-7-7 7-7" />
			<path d="M19 12H5" />
		</svg>
	</a>
	<h2 class="grow">New Membership</h2>
</header>

<MembershipForm {membership_types} {settings} {users} {payment_methods} />
