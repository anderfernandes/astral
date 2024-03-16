<script lang="ts">
	import type { MouseEventHandler } from 'svelte/elements';

	let {
		data,
		/**
		 * Size in rem.
		 */
		size = 1,
		href,
		onclick
	} = $props<{
		data: IconData;
		size?: number;
		href?: string;
		onclick?: MouseEventHandler<SVGElement>;
	}>();
</script>

{#if href}
	<a {href}>
		<svg role="presentation" style={`height: ${size}rem; width: ${size}rem`} viewBox="0 0 24 24">
			<title>{data.name}</title>
			<path d={data.path} style="fill: currentcolor;"></path>
		</svg>
	</a>
{:else}
	<svg
		role="presentation"
		style={`height: ${size}rem; width: ${size}rem`}
		viewBox="0 0 24 24"
		{onclick}
	>
		<!-- <title>monitor-dashboard</title> -->
		<path d={data.path} style="fill: currentcolor;"></path>
	</svg>
{/if}
