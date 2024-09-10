<script lang="ts">
	interface IAFileUploadProps extends Pick<HTMLInputElement, 'name' | 'required'> {
		label: string;
		hint: string;
		value?: string;
	}

	let { name, required, label, hint, value }: IAFileUploadProps = $props();

	let input: HTMLInputElement;
	let preview = $state('');
</script>

<div class="grid gap-2">
	<label
		class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
		for={name}
	>
		{label}
		{#if required}
			<span class="text-red-500">*</span>
		{/if}
	</label>
	{#if hint}
		<span class="text-sm text-muted-foreground">{hint}</span>
	{/if}
	<div class="flex w-full flex-col items-center justify-center">
		<button
			class="flex size-64 flex-col items-center justify-center rounded-xl text-muted-foreground"
			onclick={(e) => {
				e.preventDefault();
				input.click();
				console.log('test');
			}}
		>
			{#if preview || value}
				<img
					src={preview || value}
					alt="test"
					class="aspect-square h-full w-full cursor-pointer rounded-xl object-cover"
				/>
			{:else}
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
					class="m-3 size-16"
					><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" /><path
						d="M14 2v4a2 2 0 0 0 2 2h4"
					/><circle cx="10" cy="12" r="2" /><path
						d="m20 17-1.296-1.296a2.41 2.41 0 0 0-3.408 0L9 22"
					/>
				</svg>
				<span class="text-center text-sm">PNG, JPEG or JPG up to 2MB</span>
			{/if}
		</button>
		<input
			style="opacity:0.01;margin-top:-2rem"
			type="file"
			bind:this={input}
			{name}
			required={value ? false : required}
			accept=".jpg, .jpeg, .png"
			onchange={(e) => {
				if (e.currentTarget.files) {
					for (const file of e.currentTarget.files) {
						preview = URL.createObjectURL(file);
					}
				}
			}}
		/>
	</div>
</div>
