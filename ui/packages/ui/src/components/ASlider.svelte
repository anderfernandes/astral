<script lang="ts">
	import { minus, plus } from '../lib/icons';
	import AButton from './AButton.svelte';
	import AInputLabel from './AInputLabel.svelte';

	let {
		value,
		name,
		label,
		required,
		hint,
		errors,
		min = 1,
		max
	} = $props<
		Pick<HTMLInputElement, 'value' | 'required' | 'name' | 'min' | 'max' | 'step' | 'value'> &
			ICommonInputProps
	>();
</script>

<AInputLabel {label} {required} {hint} {errors}>
	<div class="flex items-center gap-2">
		<AButton icon={minus} />
		<div class="grow text-sm">
			<input type="range" {name} id={name} {min} {max} bind:value />
		</div>
		<AButton icon={plus} />
	</div>

	<span class="flex w-full justify-center">{value}</span>
</AInputLabel>

<style>
	input[type='range'] {
		-webkit-appearance: none;
		width: 100%;
		height: 0.5rem;
		border-radius: 5px;
		background-color: #d3d3d3;
		outline: none;
		opacity: 0.9;
		-webkit-transition: 0.2s;
		transition: opacity 0.2s;
	}

	input[type='range']::-webkit-slider-thumb {
		-webkit-appearance: none;
		appearance: none;
		width: 1.5rem;
		height: 1.5rem;
		border-radius: 50%;
		background-color: #000000;
		cursor: pointer;
		z-index: 0;
	}

	input[type='range']::-moz-range-thumb {
		width: 1.5rem;
		height: 1.5rem;
		border-radius: 50%;
		background-color: #000000;
		cursor: pointer;
		z-index: 0;
	}

	@media (prefers-color-scheme: dark) {
		input[type='range']::-webkit-slider-thumb {
			background-color: #fff !important;
		}
	}
</style>
