<script lang="ts">
	import { page } from '$app/stores';
	import { AButton } from 'ui';
	import SidebarItem from './SidebarItem.svelte';

	let open = $state(true);
	const toggle = () => {
		open = !open;
	};
</script>

{#if open}
	<div
		class="fixed left-0 top-0 z-10 flex h-full w-full items-center justify-center bg-background/50 backdrop-blur lg:hidden"
	>
		<div class="m-6 w-full rounded border bg-background p-6">
			<div class="flex w-full justify-end">
				<svg
					class="size-5"
					viewBox="0 0 24 24"
					onclick={toggle}
					onkeypress={toggle}
					role="button"
					tabindex="0"
				>
					<path
						fill="currentColor"
						d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"
					/>
				</svg>
			</div>
			<div
				class="my-3 grid grid-cols-3"
				onclick={toggle}
				onkeypress={toggle}
				role="button"
				tabindex="0"
			>
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
					active={$page.url.pathname.includes('/calendar') ||
						$page.url.pathname.includes('/events')}
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
						><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" /><path
							d="M3 6h18"
						/><path d="M16 10a4 4 0 0 1-8 0" /></svg
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
			</div>
			<form action="/logout" class="grid" method="POST">
				<AButton text="Logout" type="submit" />
			</form>
		</div>
	</div>
{/if}

<div
	class="fixed left-0 top-0 flex w-full flex-col bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60"
>
	<div class="border-b">
		<div class="flex h-16 items-center px-4">
			<div
				class="inline-flex h-9 w-[200px] items-center whitespace-nowrap rounded-md bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
			>
				<svg
					onclick={toggle}
					onkeypress={toggle}
					role="button"
					tabindex="0"
					xmlns="http://www.w3.org/2000/svg"
					width="24"
					height="24"
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					stroke-width="2"
					stroke-linecap="round"
					stroke-linejoin="round"
					class="-ml-2 mr-4 block lg:hidden"
				>
					<line x1="4" x2="20" y1="12" y2="12" /><line x1="4" x2="20" y1="6" y2="6" /><line
						x1="4"
						x2="20"
						y1="18"
						y2="18"
					/>
				</svg>
				<span class="relative -ml-2 mr-2 flex size-8 shrink-0 overflow-hidden">
					<svg
						viewBox="0 0 24 24"
						xmlns="http://www.w3.org/2000/svg"
						stroke="currentColor"
						stroke-width="1.75"
					>
						<circle cx="12" cy="12" r="4.5" fill="transparent" />
						<path
							stroke="currentColor"
							fill="transparent"
							d="M 3.3357286,6.9976809 6.3405211,6.3405212 6.9976805,3.3357289 9.9284869,4.2690082 12,1.9953613 14.071513,4.2690081 17.002319,3.3357286 17.659479,6.3405211 20.664271,6.9976805 19.730992,9.9284869 22.004639,12 l -2.273647,2.071513 0.933279,2.930806 -3.004792,0.65716 L 17.00232,20.664271 14.071513,19.730992 12,22.004639 9.9284871,19.730992 6.9976809,20.664271 6.3405212,17.659479 3.3357289,17.00232 4.2690082,14.071513 1.9953613,12 4.2690081,9.9284871 Z"
						/>
					</svg>
					<!-- <svg
						version="1.1"
						xmlns="http://www.w3.org/2000/svg"
						xmlns:xlink="http://www.w3.org/1999/xlink"
						x="0px"
						y="0px"
						viewBox="0 0 256 256"
						enable-background="new 0 0 256 256"
						xml:space="preserve"
					>
						<g
							><g
								><g
									><path
										fill="currentColor"
										d="M125.5,4.7c-0.4,0.3-5.9,9.8-12.1,20.9c-6.2,11.1-11.5,20.4-11.7,20.7c-0.2,0.2-9.8-3.6-21.5-8.5c-11.6-4.9-21.7-9.1-22.4-9.4c-1.7-0.7-3.7,0.2-4.1,1.8c-0.1,0.6,1,11.5,2.5,24.2c1.5,12.7,2.5,23.2,2.3,23.4c-0.2,0.2-1.6,0.6-3.1,0.9c-8,1.7-40.8,9-41.2,9.2c-0.2,0.1,0,0.5,0.4,0.7c0.8,0.4,0.8,0.5,0,1.4c-1.2,1.4-1.8,1.1-1.6-0.5c0.2-1.7,0-1.8-1.8-0.4c-1.8,1.4-1.6,3,0.6,5.5c1,1.1,8.4,9.3,16.4,18l14.5,16l-2.1,2.2c-2.7,2.8-26.8,29.4-29.1,31.9c-0.8,1-1.6,2.2-1.6,2.7c0,2.5,0.7,2.7,25,8.2c12.8,2.9,23.4,5.4,23.6,5.6s-1,10.6-2.5,23.3c-1.6,12.7-2.6,23.5-2.5,24.1c0.1,0.6,0.8,1.4,1.6,1.7c1.2,0.5,3.2-0.2,24.2-9.3c20.9-8.9,23-9.8,23.6-9c0.3,0.4,5.6,9.8,11.7,20.8c11.6,20.8,12.1,21.6,14.5,20.5c0.8-0.4,4.8-6.9,13-21c6.5-11.2,12-20.6,12.2-20.8c0.2-0.2,10,3.9,21.7,9.2c11.8,5.3,22,9.7,22.7,9.7c2,0,2.8-1,2.8-3.3c0-1.1-1-12.1-2.2-24.4c-1.2-12.3-2.2-22.8-2.2-23.2c0-0.6,4.8-1.7,23.3-5.4c16.3-3.3,23.6-4.9,24.4-5.5c1.8-1.4,1.4-3-1.2-5.9c-1.3-1.4-8.9-9.5-16.9-18l-14.5-15.5l6.3-6.6C244.1,93.7,246,91.7,246,90.4c0-0.7-0.4-1.6-0.9-2.1c-0.6-0.5-8.4-2.3-24.3-5.5c-12.9-2.6-23.7-4.9-24.1-5.1c-0.5-0.3-0.2-4.5,1.5-20.6c1.1-11.1,2.2-21.6,2.5-23.5c0.5-3.9,0-5.4-1.7-6.2c-1-0.5-3.8,0.6-23.2,9.3c-13.2,5.9-22.3,9.7-22.5,9.4c-0.2-0.2-5.5-9.2-11.6-19.9c-6.1-10.7-11.7-20-12.4-20.8C128,4.1,126.7,3.8,125.5,4.7z M138.9,33.9c7.5,13,11.2,19,12.1,19.5c1.2,0.7,2.2,0.3,22.2-8.6c11.5-5.1,20.9-9.3,21-9.2c0,0-1,10.3-2.2,22.8c-2.1,20.2-2.3,22.8-1.7,23.7c0.4,0.6,0.8,1.1,0.9,1.1c0.7,0,44,8.9,44.7,9.2c0.6,0.2-2.6,4-15,17.1c-12.8,13.6-15.8,17-15.8,18c0,1.1,3,4.5,15.6,18c8.6,9.2,15.7,16.8,15.7,17c0,0.2-9.8,2.4-21.9,4.8c-12.1,2.4-22.4,4.8-22.8,5.1c-1.1,0.9-1,2.7,1.4,26.8c1.2,11.7,2,21.3,2,21.3c0,0-9.4-4-20.7-9.1c-11.4-5.1-21-9.3-21.4-9.3c-0.4,0-1.2,0.5-1.8,1.1c-0.6,0.6-6,9.6-12,19.9c-8.3,14.4-11.1,18.8-11.5,18.3c-0.3-0.3-5.3-9.2-11.1-19.7c-8.4-15.1-10.9-19.2-11.8-19.4c-0.8-0.2-7.3,2.4-22.8,9c-11.8,5.1-21.6,9.1-21.7,8.9c0-0.2,1-9.5,2.3-20.7c2.5-20.8,2.7-23.5,2-24.5c-0.6-0.9-1.7-1.2-24.1-6.3c-11.8-2.6-21.4-4.9-21.4-5.1s6.9-7.8,15.4-17.1C45,135.2,50,129.4,50,128.7c0-1.4-0.3-1.7-16.8-19.9c-7.5-8.2-13.7-15.2-13.8-15.4c-0.1-0.4,3.3-1.3,27.7-6.6c9.2-2,17.1-3.9,17.4-4.2c1-0.8,0.8-2.9-1.9-25.2c-1.3-11.4-2.3-20.8-2.2-20.9c0.1-0.1,9.7,3.8,21.3,8.6c20,8.4,21.2,8.9,22.3,8.2c1.1-0.6,6.5-9.8,22.6-38.7c0.4-0.8,0.6-0.8,1-0.2C127.9,14.8,132.9,23.6,138.9,33.9z"
										data-title="Layer 0"
									></path><path
										fill="currentColor"
										d="M119.6,62.7c-25,2.9-47.2,21-55.3,45.2c-4.3,12.9-4.3,28.3,0,41.2c1.5,4.4,5.3,12.1,7.9,16c6.4,9.5,16,17.8,26.2,22.7c9.8,4.8,17.6,6.6,28.6,6.6c8.5,0,14.2-0.9,21.8-3.6c22.2-7.9,38.7-27.1,43.4-50.5c1.2-5.9,1.2-17.8,0-23.7C185.4,82.4,153.7,58.8,119.6,62.7z M139.7,69.7c11.2,2.5,20.7,7.4,28.7,15.1c12.1,11.6,18.6,26.7,18.6,43.6c0,16.5-5.8,30.6-17.3,42.2c-12,12.2-27.5,18.3-44.9,17.6c-16-0.7-29.2-6.4-40.2-17.4c-8.5-8.5-13.8-18.4-16.4-30.7c-1.2-5.7-1.2-17.7,0-23.4c4.6-21.7,19.1-38.3,39.5-45.1c2.9-1,7.1-2,9.5-2.4C122.6,68.4,134.6,68.6,139.7,69.7z"
										data-title="Layer 1"
									></path></g
								></g
							></g
						>
					</svg> -->
				</span>
				<h1 class="text-xl font-bold">Astral</h1>
			</div>
			<nav class="mx-6 flex items-center space-x-4 lg:space-x-6">
				<!-- <a
                    class="text-sm font-medium transition-colors hover:text-primary"
                    href="/examples/dashboard">Overview</a
                ><a
                    class="text-sm font-medium text-muted-foreground transition-colors hover:text-primary"
                    href="/examples/dashboard">Customers</a
                ><a
                    class="text-sm font-medium text-muted-foreground transition-colors hover:text-primary"
                    href="/examples/dashboard">Products</a
                ><a
                    class="text-sm font-medium text-muted-foreground transition-colors hover:text-primary"
                    href="/examples/dashboard">Settings</a
                > -->
			</nav>
			<div class="ml-auto flex items-center space-x-4">
				<a
					href="/cashier"
					class="ml-auto hidden h-8 items-center justify-center whitespace-nowrap rounded-md border border-input bg-background px-3 text-xs font-medium shadow-sm transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 lg:flex"
					type="button"
					id="radix-:r3g:"
					aria-haspopup="menu"
					aria-expanded="false"
					data-state="closed"
				>
					<svg class="size-4" viewBox="0 0 24 24"
						><path
							fill="currentColor"
							d="M2,17H22V21H2V17M6.25,7H9V6H6V3H14V6H11V7H17.8C18.8,7 19.8,8 20,9L20.5,16H3.5L4.05,9C4.05,8 5.05,7 6.25,7M13,9V11H18V9H13M6,9V10H8V9H6M9,9V10H11V9H9M6,11V12H8V11H6M9,11V12H11V11H9M6,13V14H8V13H6M9,13V14H11V13H9M7,4V5H13V4H7Z"
						></path></svg
					>
					Cashier
				</a>
				<div>
					<input
						class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 md:w-[100px] lg:w-[300px]"
						placeholder="Search..."
						type="search"
					/>
				</div>
				<!-- <button
					class="relative inline-flex h-8 w-8 items-center justify-center whitespace-nowrap rounded-full px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50"
					type="button"
					id="radix-:r38:"
					aria-haspopup="menu"
					aria-expanded="false"
					data-state="closed"
					><span class="relative flex h-8 w-8 shrink-0 items-center overflow-hidden rounded-full">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
							class="size-6"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
							/>
						</svg>
					</span>
				</button> -->
			</div>
		</div>
	</div>
</div>
