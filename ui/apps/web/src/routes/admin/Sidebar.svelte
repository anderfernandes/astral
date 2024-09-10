<script lang="ts">
	import { AButton } from 'ui';
	import SidebarItem from './SidebarItem.svelte';
	import { page } from '$app/stores';

	interface ISidebarProps {
		account?: IUser;
		version: string;
	}

	let { account, version }: ISidebarProps = $props();
</script>

<aside class="hidden w-72 border-r lg:flex lg:flex-col">
	<div class="group flex h-full flex-col gap-4 p-2">
		<nav
			class="grid gap-1 px-2 group-[[data-collapsed=true]]:justify-center group-[[data-collapsed=true]]:px-2"
		>
			<SidebarItem href="/admin" active={$page.url.pathname === '/admin'}>
				<svg
					xmlns="http://www.w3.org/2000/svg"
					fill="none"
					viewBox="0 0 24 24"
					stroke-width="1.5"
					stroke="currentColor"
					class="mr-2 size-5"
				>
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z"
					/>
				</svg>
				Dashboard
			</SidebarItem>
			<SidebarItem
				href="/admin/calendar"
				active={$page.url.pathname.includes('/calendar') || $page.url.pathname.includes('/events')}
			>
				<svg
					xmlns="http://www.w3.org/2000/svg"
					fill="none"
					viewBox="0 0 24 24"
					stroke-width="1.5"
					stroke="currentColor"
					class="mr-2 size-5"
				>
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z"
					/>
				</svg>
				Calendar
			</SidebarItem>
			<SidebarItem href="/admin/shows" active={$page.url.pathname.includes('/admin/shows')}>
				<svg
					xmlns="http://www.w3.org/2000/svg"
					fill="none"
					viewBox="0 0 24 24"
					stroke-width="1.5"
					stroke="currentColor"
					class="mr-2 size-5"
				>
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25"
					/>
				</svg>
				Shows
			</SidebarItem>
			<SidebarItem href="/admin/sales" active={$page.url.pathname.includes('/admin/sales')}>
				<svg
					xmlns="http://www.w3.org/2000/svg"
					fill="none"
					viewBox="0 0 24 24"
					stroke-width="1.5"
					stroke="currentColor"
					class="mr-2 size-5"
				>
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"
					/>
				</svg>
				Sales
			</SidebarItem>
			<SidebarItem href="/admin/products" active={$page.url.pathname.includes('/admin/products')}>
				<svg
					xmlns="http://www.w3.org/2000/svg"
					fill="none"
					viewBox="0 0 24 24"
					stroke-width="1.5"
					stroke="currentColor"
					class="mr-2 size-5"
				>
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"
					/>
				</svg>
				Products
			</SidebarItem>
			<SidebarItem href="/admin/reports" active={$page.url.pathname.includes('/admin/reports')}>
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
					class="lucide lucide-archive mr-2 size-5"
					><rect width="20" height="5" x="2" y="3" rx="1"></rect><path
						d="M4 8v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8"
					></path><path d="M10 12h4"></path></svg
				>
				Reports
			</SidebarItem>
			<SidebarItem href="/admin/users" active={$page.url.pathname.includes('/admin/users')}>
				<svg class="mr-2 size-5" viewBox="0 0 24 24">
					<path
						fill="currentColor"
						d="M4 6H2V20C2 21.11 2.9 22 4 22H18V20H4V6M18.5 14.25C18.5 12.75 15.5 12 14 12S9.5 12.75 9.5 14.25V15H18.5M14 10.25C15.24 10.25 16.25 9.24 16.25 8S15.24 5.75 14 5.75 11.75 6.76 11.75 8 12.76 10.25 14 10.25M20 2H8C6.9 2 6 2.9 6 4V16C6 17.11 6.9 18 8 18H20C21.11 18 22 17.11 22 16V4C22 2.89 21.1 2 20 2M20 16H8V4H20V16Z"
					>
					</path>
				</svg>
				Users
			</SidebarItem>
			<SidebarItem
				href="/admin/organizations"
				active={$page.url.pathname.includes('/admin/organizations')}
			>
				<svg class="mr-2 size-5" viewBox="0 0 24 24"
					><path
						fill="currentColor"
						d="M10,2V4.26L12,5.59V4H22V19H17V21H24V2H10M7.5,5L0,10V21H15V10L7.5,5M14,6V6.93L15.61,8H16V6H14M18,6V8H20V6H18M7.5,7.5L13,11V19H10V13H5V19H2V11L7.5,7.5M18,10V12H20V10H18M18,14V16H20V14H18Z"
					></path></svg
				>
				Organizations
			</SidebarItem>
			<SidebarItem
				href="/admin/memberships"
				active={$page.url.pathname.includes('/admin/memberships')}
			>
				<svg class="mr-2 size-5" viewBox="0 0 24 24"
					><path
						fill="currentColor"
						d="M20 22.09L22.45 23.58L21.8 20.77L24 18.89L21.11 18.64L20 16L18.87 18.64L16 18.89L18.18 20.77L17.5 23.58L20 22.09M14.08 21H2C.91 20.96 .04 20.09 0 19V5C.04 3.91 .91 3.04 2 3H22C23.09 3.04 23.96 3.91 24 5V15.53C23.42 15 22.75 14.61 22 14.34V5H2V19H14.08C14.03 19.33 14 19.66 14 20C14 20.34 14.03 20.68 14.08 21M14 17H4V15.75C4 14.09 7.34 13.25 9 13.25C10.66 13.25 14 14.09 14 15.75V17M14 11H18V12H14V11M9 7C7.63 7 6.5 8.13 6.5 9.5C6.5 10.87 7.63 12 9 12C10.37 12 11.5 10.87 11.5 9.5C11.5 8.13 10.37 7 9 7M14 9H20V10H14V9M14 7H20V8H14V7Z"
					></path></svg
				>
				Memberships
			</SidebarItem>
			<SidebarItem href="/admin/settings" active={$page.url.pathname.includes('/admin/settings')}>
				<svg
					xmlns="http://www.w3.org/2000/svg"
					fill="none"
					viewBox="0 0 24 24"
					stroke-width="1.5"
					stroke="currentColor"
					class="mr-2 size-5"
				>
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z"
					/>
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
					/>
				</svg>
				Settings
			</SidebarItem>
		</nav>
		<div class="flex grow flex-col justify-end gap-4 p-2">
			{#if account}
				<div class="flex items-center">
					<span class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
							class="h-full w-full"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
							/>
						</svg>
					</span>
					<div class="ml-4 space-y-1">
						<p class="text-sm font-medium leading-none">{account.firstname} {account.lastname}</p>
						<p class="text-sm text-muted-foreground">{account.role.name}</p>
					</div>
				</div>
				<form action="/logout" class="grid" method="POST">
					<AButton text="Logout" type="submit" />
				</form>
			{/if}
			<span class="text-center text-sm">&copy 2017-{new Date().getFullYear()} @anderfernandes</span>
			<div class="mt-4 text-center text-sm">
				<div
					class="inline-flex items-center rounded-md border border-transparent bg-primary px-2.5 py-0.5 text-xs font-semibold text-primary-foreground shadow transition-colors hover:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
				>
					{version}
				</div>
			</div>
		</div>
	</div>
</aside>
