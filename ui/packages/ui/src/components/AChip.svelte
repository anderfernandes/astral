<script lang="ts">
	interface IAChipProps {
		text: string;
		basic?: boolean;
	}

	let { text, basic = true } = $props<IAChipProps>();
</script>

<span
	class="inline-flex items-center rounded-md border border-zinc-300 px-2.5 py-0.5 text-xs font-semibold"
	>{text}</span
>
