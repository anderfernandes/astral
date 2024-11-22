<script lang="ts">
	import { page } from '$app/stores';
	import { AButton } from 'ui';
	import SidebarItem from './SidebarItem.svelte';
	import { enhance } from '$app/forms';

	let { children, data } = $props();
	const { account } = data;
</script>

<aside class="fixed top-0 hidden h-svh w-64 p-6 pt-0 lg:flex lg:flex-col lg:gap-6">
	<div class="flex h-16 items-center gap-3 py-6 pl-1">
		<svg
			viewBox="0 0 24 24"
			xmlns="http://www.w3.org/2000/svg"
			stroke="currentColor"
			stroke-width="1.75"
			class="size-7"
		>
			<circle cx="12" cy="12" r="4.5" fill="transparent" />
			<path
				stroke="currentColor"
				fill="transparent"
				d="M 3.3357286,6.9976809 6.3405211,6.3405212 6.9976805,3.3357289 9.9284869,4.2690082 12,1.9953613 14.071513,4.2690081 17.002319,3.3357286 17.659479,6.3405211 20.664271,6.9976805 19.730992,9.9284869 22.004639,12 l -2.273647,2.071513 0.933279,2.930806 -3.004792,0.65716 L 17.00232,20.664271 14.071513,19.730992 12,22.004639 9.9284871,19.730992 6.9976809,20.664271 6.3405212,17.659479 3.3357289,17.00232 4.2690082,14.071513 1.9953613,12 4.2690081,9.9284871 Z"
			/>
		</svg>
		<h1 class="text-xl font-bold">Astral</h1>
	</div>
	<div class="flex flex-col gap-1">
		<SidebarItem href="/admin" active={$page.url.pathname === '/admin'}>
			<svg
				xmlns="http://www.w3.org/2000/svg"
				viewBox="0 0 24 24"
				fill="none"
				stroke="currentColor"
				stroke-width="2"
				stroke-linecap="round"
				stroke-linejoin="round"
				class="size-5"
				><rect width="7" height="9" x="3" y="3" rx="1" /><rect
					width="7"
					height="5"
					x="14"
					y="3"
					rx="1"
				/><rect width="7" height="9" x="14" y="12" rx="1" /><rect
					width="7"
					height="5"
					x="3"
					y="16"
					rx="1"
				/></svg
			>
			Dashboard
		</SidebarItem>
		<SidebarItem
			href="/admin/calendar"
			active={$page.url.pathname.includes('/calendar') || $page.url.pathname.includes('/events')}
		>
			<svg
				xmlns="http://www.w3.org/2000/svg"
				viewBox="0 0 24 24"
				fill="none"
				stroke="currentColor"
				stroke-width="2"
				stroke-linecap="round"
				stroke-linejoin="round"
				class="size-5"
				><path d="M8 2v4" /><path d="M16 2v4" /><rect
					width="18"
					height="18"
					x="3"
					y="4"
					rx="2"
				/><path d="M3 10h18" /><path d="M8 14h.01" /><path d="M12 14h.01" /><path
					d="M16 14h.01"
				/><path d="M8 18h.01" /><path d="M12 18h.01" /><path d="M16 18h.01" /></svg
			>
			Calendar
		</SidebarItem>
		<SidebarItem href="/admin/shows" active={$page.url.pathname.includes('/admin/shows')}>
			<svg
				xmlns="http://www.w3.org/2000/svg"
				viewBox="0 0 24 24"
				fill="none"
				stroke="currentColor"
				stroke-width="2"
				stroke-linecap="round"
				stroke-linejoin="round"
				class="size-5"
				><path
					d="M10 7.75a.75.75 0 0 1 1.142-.638l3.664 2.249a.75.75 0 0 1 0 1.278l-3.664 2.25a.75.75 0 0 1-1.142-.64z"
				/><path d="M7 21h10" /><rect width="20" height="14" x="2" y="3" rx="2" /></svg
			>
			Shows
		</SidebarItem>
		<SidebarItem href="/admin/sales" active={$page.url.pathname.includes('/admin/sales')}>
			<svg
				xmlns="http://www.w3.org/2000/svg"
				viewBox="0 0 24 24"
				fill="none"
				stroke="currentColor"
				stroke-width="2"
				stroke-linecap="round"
				stroke-linejoin="round"
				class="size-5"
				><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" /><path d="M3 6h18" /><path
					d="M16 10a4 4 0 0 1-8 0"
				/></svg
			>
			Sales
		</SidebarItem>
		<SidebarItem href="/admin/products" active={$page.url.pathname.includes('/admin/products')}>
			<svg class="size-5" viewBox="0 0 24 24"
				><path
					fill="currentColor"
					d="M22,12V20A2,2 0 0,1 20,22H4A2,2 0 0,1 2,20V12A1,1 0 0,1 1,11V8A2,2 0 0,1 3,6H6.17C6.06,5.69 6,5.35 6,5A3,3 0 0,1 9,2C10,2 10.88,2.5 11.43,3.24V3.23L12,4L12.57,3.23V3.24C13.12,2.5 14,2 15,2A3,3 0 0,1 18,5C18,5.35 17.94,5.69 17.83,6H21A2,2 0 0,1 23,8V11A1,1 0 0,1 22,12M4,20H11V12H4V20M20,20V12H13V20H20M9,4A1,1 0 0,0 8,5A1,1 0 0,0 9,6A1,1 0 0,0 10,5A1,1 0 0,0 9,4M15,4A1,1 0 0,0 14,5A1,1 0 0,0 15,6A1,1 0 0,0 16,5A1,1 0 0,0 15,4M3,8V10H11V8H3M13,8V10H21V8H13Z"
				></path></svg
			>
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
				class="size-5"
			>
				<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
				<path d="M14 2v4a2 2 0 0 0 2 2h4" />
				<path d="m16 13-3.5 3.5-2-2L8 17" />
			</svg>
			Reports
		</SidebarItem>
		<SidebarItem href="/admin/users" active={$page.url.pathname.includes('/admin/users')}>
			<svg class="size-5" viewBox="0 0 24 24">
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
			<svg class="size-5" viewBox="0 0 24 24"
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
			<svg class="size-5" viewBox="0 0 24 24"
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
				viewBox="0 0 24 24"
				fill="none"
				stroke="currentColor"
				stroke-width="2"
				stroke-linecap="round"
				stroke-linejoin="round"
				class="size-5"
				><path
					d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"
				/><circle cx="12" cy="12" r="3" /></svg
			>
			Settings
		</SidebarItem>
		<a
			href="/cashier"
			class="mt-3 inline-flex h-9 items-center justify-center whitespace-nowrap rounded-md border border-input bg-background px-3 text-sm font-medium ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 lg:ml-0"
			>Cashier</a
		>
	</div>
	<div class="grid h-full content-end gap-6">
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
			<form action="/logout" class="grid" method="post">
				<AButton text="Logout" type="submit" />
			</form>
		{/if}
	</div>
</aside>

<section class="mx-auto grid gap-3 px-6 pb-20 lg:pb-6 lg:pl-[16rem]">
	<!-- <header
		class="fixed top-0 -ml-6 h-16 w-full border-b bg-yellow-200 p-6 lg:w-[calc(1280px-16rem)]"
	>
		header
	</header> -->
	{@render children()}
</section>

<nav
	class="fixed bottom-0 left-0 z-10 grid h-16 w-full auto-cols-auto grid-flow-col overflow-x-auto border-t bg-background text-xs lg:hidden"
>
	<a
		href="/admin"
		class:active={$page.url.pathname === '/admin'}
		class="flex h-full min-w-20 flex-col items-center justify-center gap-1 font-medium"
	>
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			fill="none"
			stroke="currentColor"
			stroke-width="2"
			stroke-linecap="round"
			stroke-linejoin="round"
			class="size-6"
			><rect width="7" height="9" x="3" y="3" rx="1" /><rect
				width="7"
				height="5"
				x="14"
				y="3"
				rx="1"
			/><rect width="7" height="9" x="14" y="12" rx="1" /><rect
				width="7"
				height="5"
				x="3"
				y="16"
				rx="1"
			/></svg
		>
		Dashboard
	</a>
	<a
		href="/admin/calendar"
		class:active={$page.url.pathname.includes('/admin/calendar') ||
			$page.url.pathname.includes('/admin/events')}
		class="flex h-full min-w-20 flex-col items-center justify-center gap-1 font-medium"
	>
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			fill="none"
			stroke="currentColor"
			stroke-width="2"
			stroke-linecap="round"
			stroke-linejoin="round"
			class="size-6"
			><path d="M8 2v4" /><path d="M16 2v4" /><rect
				width="18"
				height="18"
				x="3"
				y="4"
				rx="2"
			/><path d="M3 10h18" /><path d="M8 14h.01" /><path d="M12 14h.01" /><path
				d="M16 14h.01"
			/><path d="M8 18h.01" /><path d="M12 18h.01" /><path d="M16 18h.01" /></svg
		>
		Calendar
	</a>
	<a
		href="/admin/shows"
		class:active={$page.url.pathname.includes('/admin/shows')}
		class="flex h-full min-w-20 flex-col items-center justify-center gap-1 font-medium"
	>
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			fill="none"
			stroke="currentColor"
			stroke-width="2"
			stroke-linecap="round"
			stroke-linejoin="round"
			class="size-6"
			><path
				d="M10 7.75a.75.75 0 0 1 1.142-.638l3.664 2.249a.75.75 0 0 1 0 1.278l-3.664 2.25a.75.75 0 0 1-1.142-.64z"
			/><path d="M7 21h10" /><rect width="20" height="14" x="2" y="3" rx="2" /></svg
		>
		Shows
	</a>
	<a
		href="/admin/sales"
		class:active={$page.url.pathname.includes('/admin/sales')}
		class="flex h-full min-w-20 flex-col items-center justify-center gap-1 font-medium"
	>
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			fill="none"
			stroke="currentColor"
			stroke-width="2"
			stroke-linecap="round"
			stroke-linejoin="round"
			class="size-6"
			><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" /><path d="M3 6h18" /><path
				d="M16 10a4 4 0 0 1-8 0"
			/></svg
		>
		Sales
	</a>
	<a
		href="/admin/products"
		class:active={$page.url.pathname.includes('/admin/products')}
		class="flex h-full min-w-20 flex-col items-center justify-center gap-1 font-medium"
	>
		<svg class="size-6" viewBox="0 0 24 24"
			><path
				fill="currentColor"
				d="M22,12V20A2,2 0 0,1 20,22H4A2,2 0 0,1 2,20V12A1,1 0 0,1 1,11V8A2,2 0 0,1 3,6H6.17C6.06,5.69 6,5.35 6,5A3,3 0 0,1 9,2C10,2 10.88,2.5 11.43,3.24V3.23L12,4L12.57,3.23V3.24C13.12,2.5 14,2 15,2A3,3 0 0,1 18,5C18,5.35 17.94,5.69 17.83,6H21A2,2 0 0,1 23,8V11A1,1 0 0,1 22,12M4,20H11V12H4V20M20,20V12H13V20H20M9,4A1,1 0 0,0 8,5A1,1 0 0,0 9,6A1,1 0 0,0 10,5A1,1 0 0,0 9,4M15,4A1,1 0 0,0 14,5A1,1 0 0,0 15,6A1,1 0 0,0 16,5A1,1 0 0,0 15,4M3,8V10H11V8H3M13,8V10H21V8H13Z"
			></path></svg
		>
		Products
	</a>
	<a
		href="/admin/reports"
		class:active={$page.url.pathname.includes('/admin/reports')}
		class="flex h-full min-w-20 flex-col items-center justify-center gap-1 font-medium"
	>
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
			<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
			<path d="M14 2v4a2 2 0 0 0 2 2h4" />
			<path d="m16 13-3.5 3.5-2-2L8 17" />
		</svg>
		Reports
	</a>
	<a
		href="/admin/users"
		class:active={$page.url.pathname.includes('/admin/users')}
		class="flex h-full w-20 flex-col items-center justify-center gap-1 font-medium"
	>
		<svg class="size-6" viewBox="0 0 24 24">
			<path
				fill="currentColor"
				d="M4 6H2V20C2 21.11 2.9 22 4 22H18V20H4V6M18.5 14.25C18.5 12.75 15.5 12 14 12S9.5 12.75 9.5 14.25V15H18.5M14 10.25C15.24 10.25 16.25 9.24 16.25 8S15.24 5.75 14 5.75 11.75 6.76 11.75 8 12.76 10.25 14 10.25M20 2H8C6.9 2 6 2.9 6 4V16C6 17.11 6.9 18 8 18H20C21.11 18 22 17.11 22 16V4C22 2.89 21.1 2 20 2M20 16H8V4H20V16Z"
			>
			</path>
		</svg>
		Users
	</a>
	<a
		href="/admin/organizations"
		class:active={$page.url.pathname.includes('/admin/organizations')}
		class="flex h-full w-24 flex-col items-center justify-center gap-1 font-medium"
	>
		<svg class="size-6" viewBox="0 0 24 24"
			><path
				fill="currentColor"
				d="M10,2V4.26L12,5.59V4H22V19H17V21H24V2H10M7.5,5L0,10V21H15V10L7.5,5M14,6V6.93L15.61,8H16V6H14M18,6V8H20V6H18M7.5,7.5L13,11V19H10V13H5V19H2V11L7.5,7.5M18,10V12H20V10H18M18,14V16H20V14H18Z"
			></path></svg
		>
		Organizations
	</a>
	<a
		href="/admin/memberships"
		class:active={$page.url.pathname.includes('/admin/memberships')}
		class="flex h-full w-24 flex-col items-center justify-center gap-1 font-medium"
	>
		<svg class="size-6" viewBox="0 0 24 24"
			><path
				fill="currentColor"
				d="M20 22.09L22.45 23.58L21.8 20.77L24 18.89L21.11 18.64L20 16L18.87 18.64L16 18.89L18.18 20.77L17.5 23.58L20 22.09M14.08 21H2C.91 20.96 .04 20.09 0 19V5C.04 3.91 .91 3.04 2 3H22C23.09 3.04 23.96 3.91 24 5V15.53C23.42 15 22.75 14.61 22 14.34V5H2V19H14.08C14.03 19.33 14 19.66 14 20C14 20.34 14.03 20.68 14.08 21M14 17H4V15.75C4 14.09 7.34 13.25 9 13.25C10.66 13.25 14 14.09 14 15.75V17M14 11H18V12H14V11M9 7C7.63 7 6.5 8.13 6.5 9.5C6.5 10.87 7.63 12 9 12C10.37 12 11.5 10.87 11.5 9.5C11.5 8.13 10.37 7 9 7M14 9H20V10H14V9M14 7H20V8H14V7Z"
			></path></svg
		>
		Memberships
	</a>
	<a
		href="/admin/settings"
		class:active={$page.url.pathname.includes('/admin/settings')}
		class="flex h-full min-w-20 flex-col items-center justify-center gap-1 font-medium"
	>
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			fill="none"
			stroke="currentColor"
			stroke-width="2"
			stroke-linecap="round"
			stroke-linejoin="round"
			class="size-6"
			><path
				d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"
			/><circle cx="12" cy="12" r="3" /></svg
		>
		Settings
	</a>
	<a
		href="/cashier"
		class="flex h-full min-w-20 flex-col items-center justify-center gap-1 font-medium"
	>
		<svg class="size-6"
			><path
				fill="currentColor"
				d="M2,17H22V21H2V17M6.25,7H9V6H6V3H14V6H11V7H17.8C18.8,7 19.8,8 20,9L20.5,16H3.5L4.05,9C4.05,8 5.05,7 6.25,7M13,9V11H18V9H13M6,9V10H8V9H6M9,9V10H11V9H9M6,11V12H8V11H6M9,11V12H11V11H9M6,13V14H8V13H6M9,13V14H11V13H9M7,4V5H13V4H7Z"
			></path></svg
		>
		Cashier
	</a>
	<form
		action="/logout"
		method="post"
		use:enhance
		class="flex h-full min-w-20 flex-col items-center justify-center gap-1 font-medium"
	>
		<button type="submit" class="flex w-full flex-col items-center justify-center gap-1">
			<svg
				xmlns="http://www.w3.org/2000/svg"
				viewBox="0 0 24 24"
				fill="none"
				stroke="currentColor"
				stroke-width="2"
				stroke-linecap="round"
				stroke-linejoin="round"
				class="size-6"
			>
				<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
				<polyline points="16 17 21 12 16 7" />
				<line x1="21" x2="9" y1="12" y2="12" />
			</svg>
			Logout
		</button>
	</form>
</nav>

<style lang="postcss">
	a.active {
		@apply bg-primary text-primary-foreground;
	}
</style>
