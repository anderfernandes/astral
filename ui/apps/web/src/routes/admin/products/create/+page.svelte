<script>
	import { AButton, ACheckbox, AFileUpload, AInput, ASelect, ATextArea } from 'ui';

	let { data } = $props();
</script>

<svelte:head>
	<title>Products - Astral Admin</title>
</svelte:head>

<header
	class="fixed left-0 top-0 flex w-full flex-col bg-background/95 px-5 backdrop-blur supports-[backdrop-filter]:bg-background/60 lg:left-[inherit] lg:-mx-6 lg:w-[calc(1080px-288px)]"
>
	<div class="flex h-16 items-center">
		<a href="/admin/products" aria-label="back">
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
		<h2 class="px-3 font-semibold leading-none tracking-tight">New Product</h2>
	</div>
</header>

<section class="mt-16 grid gap-3">
	<form method="POST" enctype="multipart/form-data" class="grid gap-6">
		<ACheckbox
			checked
			name="is_active"
			label="Active"
			hint="Check if this product is available to be sold."
		/>
		<ACheckbox
			checked
			name="is_public"
			label="Public"
			hint="Check if this product should be available for the general public (website, app)."
		/>
		<ACheckbox
			checked
			name="in_cashier"
			label="Show in Cashier"
			hint="Check if you want this product to be available for sale in Cashier."
		/>
		<AInput
			name="name"
			placeholder="The name of the product"
			label="Name"
			required
			hint="Enter a name for the product."
		/>
		<AInput
			name="price"
			type="number"
			placeholder="Price of the product"
			label="Price"
			required
			hint="Price of product."
		/>
		<ATextArea
			name="description"
			placeholder="Describe the product in a few words"
			label="Description"
			required
			hint="A description of the product"
		/>
		<ASelect
			name="type_id"
			required
			options={data.product_types}
			label="Type"
			placeholder="Select one"
			hint="Type of product"
		/>
		<ACheckbox
			checked
			name="inventory"
			label="Track inventory"
			hint="Check if you have a limited quantity."
		/>
		<AInput
			name="stock"
			label="Stock"
			required
			hint="How many do you have in stock."
			placeholder="The quantity of this product you currently have."
			type="number"
		/>
		<AFileUpload name="cover" label="Picture" required hint="A picture of the product." />
		<div class="flex justify-end gap-3">
			<AButton text="Submit" type="submit" />
		</div>
	</form>
	<br />
</section>
