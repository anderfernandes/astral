<script lang="ts">
	const { data } = $props();
</script>

<div>
	<div class="mb-3 flex flex-col space-y-1.5">
		<h3 class="font-semibold leading-none tracking-tight">System Information</h3>
		<p class="text-sm text-muted-foreground">Useful information about the application</p>
	</div>
	<div class="grid gap-1">
		<div
			class="-mx-2 flex items-start space-x-4 rounded-md p-2 transition-all hover:bg-accent hover:text-accent-foreground"
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
				class="lucide lucide-tag"
			>
				<path
					d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"
				/>
				<circle cx="7.5" cy="7.5" r=".5" fill="currentColor" />
			</svg>
			<div class="space-y-1">
				<p class="text-sm font-medium leading-none">Version</p>
				<p class="text-sm text-muted-foreground">{data.version}</p>
			</div>
		</div>
		<div
			class="-mx-2 flex items-start space-x-4 rounded-md bg-accent p-2 text-accent-foreground transition-all"
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
				class="lucide lucide-clock"
			>
				<circle cx="12" cy="12" r="10" />
				<polyline points="12 6 12 12 16 14" />
			</svg>
			<div class="space-y-1">
				<p class="text-sm font-medium leading-none">Browser Timezone</p>
				<p class="text-sm text-muted-foreground">
					{Intl.DateTimeFormat().resolvedOptions().timeZone}
				</p>
			</div>
		</div>
		<div
			class="-mx-2 flex items-start space-x-4 rounded-md p-2 transition-all hover:bg-accent hover:text-accent-foreground"
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
				class="lucide lucide-clock-8"
			>
				<circle cx="12" cy="12" r="10" />
				<polyline points="12 6 12 12 8 14" />
			</svg>
			<div class="space-y-1">
				<p class="text-sm font-medium leading-none">Server Timezone</p>
				<p class="text-sm text-muted-foreground">{data.settings.timezone}</p>
			</div>
		</div>
		<div
			class="-mx-2 flex items-start space-x-4 rounded-md p-2 transition-all hover:bg-accent hover:text-accent-foreground"
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
				class="lucide lucide-server"
			>
				<rect width="20" height="8" x="2" y="2" rx="2" ry="2" /><rect
					width="20"
					height="8"
					x="2"
					y="14"
					rx="2"
					ry="2"
				/>
				<line x1="6" x2="6.01" y1="6" y2="6" /><line x1="6" x2="6.01" y1="18" y2="18" />
			</svg>
			<div class="space-y-1">
				<p class="text-sm font-medium leading-none">Server</p>
				<p class="text-sm text-muted-foreground">{data.settings.other}</p>
			</div>
		</div>
		<div
			class="-mx-2 flex items-start space-x-4 rounded-md p-2 transition-all hover:bg-accent hover:text-accent-foreground"
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
				class="lucide lucide-monitor-smartphone"
				><path d="M18 8V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h8" /><path
					d="M10 19v-3.96 3.15"
				/><path d="M7 19h5" /><rect width="6" height="10" x="16" y="12" rx="2" /></svg
			>
			<div class="space-y-1">
				<p class="text-sm font-medium leading-none">UI</p>
				<p class="text-sm text-muted-foreground">
					{data.ui?.at(0)}/{data.ui?.at(1)}/{data.ui?.at(2)}/{data.ui?.at(3)}
				</p>
			</div>
		</div>
		<div
			class="-mx-2 flex items-start space-x-4 rounded-md p-2 transition-all hover:bg-accent hover:text-accent-foreground"
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
				class="lucide lucide-file-up"
			>
				<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" /><path
					d="M14 2v4a2 2 0 0 0 2 2h4"
				/>
				<path d="M12 12v6" />
				<path d="m15 15-3-3-3 3" />
			</svg>
			<div class="space-y-1">
				<p class="text-sm font-medium leading-none">Max Upload File Size</p>
				<p class="text-sm text-muted-foreground">{data.settings.upload_max_filesize}B</p>
			</div>
		</div>
		<div
			class="-mx-2 flex items-start space-x-4 rounded-md p-2 transition-all hover:bg-accent hover:text-accent-foreground"
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
				class="lucide lucide-memory-stick"
			>
				<path d="M6 19v-3" />
				<path d="M10 19v-3" />
				<path d="M14 19v-3" />
				<path d="M18 19v-3" />
				<path d="M8 11V9" />
				<path d="M16 11V9" />
				<path d="M12 11V9" />
				<path d="M2 15h20" />
				<path
					d="M2 7a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v1.1a2 2 0 0 0 0 3.837V17a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-5.1a2 2 0 0 0 0-3.837Z"
				/>
			</svg>
			<div class="space-y-1">
				<p class="text-sm font-medium leading-none">Memory</p>
				<p class="text-sm text-muted-foreground">{data.settings.memory_limit}</p>
			</div>
		</div>
		<div
			class="-mx-2 flex items-start space-x-4 rounded-md p-2 transition-all hover:bg-accent hover:text-accent-foreground"
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
			>
				<rect width="7" height="7" x="14" y="3" rx="1" />
				<path
					d="M10 21V8a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1H3"
				/>
			</svg>
			<div class="w-full space-y-1 lg:w-4/5">
				<p class="text-sm font-medium leading-none">
					Extensions: {data.settings.extensions.length}
				</p>
				<div class="text-sm text-muted-foreground">
					<br />
					<div class="flex flex-wrap gap-1">
						{#each data.settings.extensions as extension}
							<span
								class="inline-flex items-center rounded-md border border-transparent bg-secondary px-2.5 py-0.5 text-xs font-semibold text-secondary-foreground transition-colors hover:bg-secondary/80 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
								>{extension}</span
							>
						{/each}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
