<script lang="ts">
	import { page } from '$app/stores';

	let { children, data } = $props();
	const { account } = data;
</script>

<div>
	<aside class="fixed hidden h-screen w-14 border-t lg:flex lg:flex-col">
		<div aria-label="cashier" class="flex size-14 items-center justify-center border-b">
			<div class="size-9 rounded-full bg-background p-1 shadow-sm">
				<svg
					viewBox="0 0 24 24"
					xmlns="http://www.w3.org/2000/svg"
					stroke="currentColor"
					stroke-width="1.5"
				>
					<circle cx="12" cy="12" r="5" fill="transparent" />
					<path
						stroke="currentColor"
						fill="transparent"
						d="M 3.3357286,6.9976809 6.3405211,6.3405212 6.9976805,3.3357289 9.9284869,4.2690082 12,1.9953613 14.071513,4.2690081 17.002319,3.3357286 17.659479,6.3405211 20.664271,6.9976805 19.730992,9.9284869 22.004639,12 l -2.273647,2.071513 0.933279,2.930806 -3.004792,0.65716 L 17.00232,20.664271 14.071513,19.730992 12,22.004639 9.9284871,19.730992 6.9976809,20.664271 6.3405212,17.659479 3.3357289,17.00232 4.2690082,14.071513 1.9953613,12 4.2690081,9.9284871 Z"
					/>
				</svg>
			</div>
		</div>
		<a href="/cashier" aria-label="cashier" class="flex size-14 items-center justify-center">
			<div
				class="flex size-9 items-center justify-center rounded-full bg-background shadow-sm"
				class:active={$page.url.pathname === '/cashier'}
			>
				<svg class="mb-1 mr-1 size-5" width="24" height="24"
					><path
						fill="currentColor"
						d="M2,17H22V21H2V17M6.25,7H9V6H6V3H14V6H11V7H17.8C18.8,7 19.8,8 20,9L20.5,16H3.5L4.05,9C4.05,8 5.05,7 6.25,7M13,9V11H18V9H13M6,9V10H8V9H6M9,9V10H11V9H9M6,11V12H8V11H6M9,11V12H11V11H9M6,13V14H8V13H6M9,13V14H11V13H9M7,4V5H13V4H7Z"
					></path></svg
				>
			</div>
		</a>
		<a href="/cashier/sales" aria-label="sales" class="flex size-14 items-center justify-center">
			<div
				class="flex size-9 items-center justify-center rounded-full bg-background shadow-sm"
				class:active={$page.url.pathname.includes('/cashier/sales')}
			>
				<svg
					class="size-5"
					xmlns="http://www.w3.org/2000/svg"
					width="24"
					height="24"
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					stroke-width="2"
					stroke-linecap="round"
					stroke-linejoin="round"
				>
					<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
					<path d="M3 6h18" />
					<path d="M16 10a4 4 0 0 1-8 0" />
				</svg>
			</div>
		</a>
		<a
			href="/cashier/reports"
			aria-label="reports"
			class="flex size-14 items-center justify-center"
		>
			<div
				class="flex size-9 items-center justify-center rounded-full bg-background shadow-sm"
				class:active={$page.url.pathname.includes('/cashier/reports')}
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
					class="size-5"
					><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" /><path
						d="M14 2v4a2 2 0 0 0 2 2h4"
					/><path d="M8 13h2" /><path d="M14 13h2" /><path d="M8 17h2" /><path d="M14 17h2" /></svg
				>
			</div>
		</a>
		<a
			href="/cashier/memberships"
			aria-label="memberships"
			class="flex size-14 items-center justify-center"
		>
			<div
				class="flex size-9 items-center justify-center rounded-full bg-background shadow-sm"
				class:active={$page.url.pathname.includes('/cashier/memberships')}
			>
				<svg class="size-5" viewBox="0 0 24 24"
					><path
						fill="currentColor"
						d="M20 22.09L22.45 23.58L21.8 20.77L24 18.89L21.11 18.64L20 16L18.87 18.64L16 18.89L18.18 20.77L17.5 23.58L20 22.09M14.08 21H2C.91 20.96 .04 20.09 0 19V5C.04 3.91 .91 3.04 2 3H22C23.09 3.04 23.96 3.91 24 5V15.53C23.42 15 22.75 14.61 22 14.34V5H2V19H14.08C14.03 19.33 14 19.66 14 20C14 20.34 14.03 20.68 14.08 21M14 17H4V15.75C4 14.09 7.34 13.25 9 13.25C10.66 13.25 14 14.09 14 15.75V17M14 11H18V12H14V11M9 7C7.63 7 6.5 8.13 6.5 9.5C6.5 10.87 7.63 12 9 12C10.37 12 11.5 10.87 11.5 9.5C11.5 8.13 10.37 7 9 7M14 9H20V10H14V9M14 7H20V8H14V7Z"
					></path></svg
				>
			</div>
		</a>
		<div class="grow"></div>
		<form method="post" action="/logout" class="flex size-14 items-center justify-center pb-6">
			<button
				type="submit"
				aria-label="logout"
				class="flex size-9 items-center justify-center rounded border border-input bg-background p-1 shadow-sm"
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
				>
					<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
					<polyline points="16 17 21 12 16 7" />
					<line x1="21" x2="9" y1="12" y2="12" />
				</svg>
			</button>
		</form>
	</aside>

	<section class="grid w-full gap-3 p-6 pb-20 lg:mb-0 lg:ml-14">
		{@render children()}
	</section>

	<nav
		class="fixed bottom-0 left-0 z-10 grid h-16 w-full grid-cols-4 border-t bg-background lg:hidden"
	>
		<a
			href="/cashier"
			aria-label="cashier"
			class="flex flex-col items-center justify-center gap-2"
			class:active={$page.url.pathname === '/cashier'}
		>
			<svg class="size-5" width="24" height="24"
				><path
					fill="currentColor"
					d="M2,17H22V21H2V17M6.25,7H9V6H6V3H14V6H11V7H17.8C18.8,7 19.8,8 20,9L20.5,16H3.5L4.05,9C4.05,8 5.05,7 6.25,7M13,9V11H18V9H13M6,9V10H8V9H6M9,9V10H11V9H9M6,11V12H8V11H6M9,11V12H11V11H9M6,13V14H8V13H6M9,13V14H11V13H9M7,4V5H13V4H7Z"
				></path></svg
			>
			<span class="text-xs">Cashier</span>
		</a>

		<a
			href="/cashier/sales"
			aria-label="sales"
			class="flex flex-col items-center justify-center gap-2"
			class:active={$page.url.pathname.includes('/cashier/sales')}
		>
			<svg
				class="size-5"
				xmlns="http://www.w3.org/2000/svg"
				width="24"
				height="24"
				viewBox="0 0 24 24"
				fill="none"
				stroke="currentColor"
				stroke-width="2"
				stroke-linecap="round"
				stroke-linejoin="round"
			>
				<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
				<path d="M3 6h18" />
				<path d="M16 10a4 4 0 0 1-8 0" />
			</svg>
			<span class="text-xs">Sales</span>
		</a>
		<a
			href="/cashier/reports"
			aria-label="report"
			class="flex flex-col items-center justify-center gap-2"
			class:active={$page.url.pathname.includes('/cashier/reports')}
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
				class="size-5"
				><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" /><path
					d="M14 2v4a2 2 0 0 0 2 2h4"
				/><path d="M8 13h2" /><path d="M14 13h2" /><path d="M8 17h2" /><path d="M14 17h2" /></svg
			>
			<span class="text-xs">Reports</span>
		</a>
		<a
			href="/cashier/memberships"
			aria-label="memberships"
			class="flex flex-col items-center justify-center gap-2"
			class:active={$page.url.pathname.includes('/cashier/memberships')}
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
				class="size-5"
				><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" /><path
					d="M14 2v4a2 2 0 0 0 2 2h4"
				/><path d="M8 13h2" /><path d="M14 13h2" /><path d="M8 17h2" /><path d="M14 17h2" /></svg
			>
			<span class="text-xs">Memberships</span>
		</a>
	</nav>
</div>

<style lang="postcss">
	.active {
		@apply bg-foreground text-background;
	}
</style>
