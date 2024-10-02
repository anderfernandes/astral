<script>
	import { AButton, ACheckbox, AFileUpload, AInput, ASelect, ATextArea } from 'ui';

	let { data } = $props();
	const { product } = data;
</script>

<svelte:head>
	<title>Edit Product - Astral Admin</title>
</svelte:head>

<header
	class="fixed left-0 top-0 flex w-full flex-col bg-background/95 px-5 backdrop-blur supports-[backdrop-filter]:bg-background/60 lg:left-[inherit] lg:-mx-6 lg:w-[calc(1080px-288px)]"
>
	<div class="flex h-16 items-center gap-3">
		<a href={`/admin/products/${product.id}`} aria-label="back">
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
		<h3 class="font-semibold leading-none tracking-tight">Edit Show #{product.id}</h3>
	</div>
</header>

<section class="mt-16 flex items-center">
	<br />
	<form method="POST" enctype="multipart/form-data" class="grid gap-6">
		<ACheckbox
			checked={data.product.is_active}
			name="is_active"
			label="Active"
			hint="Check if this product is available to be sold."
		/>
		<ACheckbox
			checked={data.product.is_public}
			name="is_public"
			label="Public"
			hint="Check if this product should be available for the general public (website, app)."
		/>
		<ACheckbox
			checked={data.product.in_cashier}
			name="in_cashier"
			label="Show in Cashier"
			hint="Check if you want this product to be available for sale in Cashier."
		/>
		<AInput
			value={data.product.name}
			name="name"
			placeholder="The name of the product"
			label="Name"
			required
			hint="Enter a name for the product."
		/>
		<AInput
			value={data.product.price}
			name="price"
			type="number"
			placeholder="Price of the product"
			label="Price"
			required
			hint="Price of product."
		/>
		<ATextArea
			value={data.product.description}
			name="description"
			placeholder="Describe the product in a few words"
			label="Description"
			required
			hint="A description of the product"
		/>
		<ASelect
			value={data.product.type_id}
			name="type_id"
			required
			options={data.product_types}
			label="Type"
			placeholder="Select one"
			hint="Type of product"
		/>
		<ACheckbox
			checked={data.product.inventory}
			name="inventory"
			label="Track inventory"
			hint="Check if you have a limited quantity."
		/>
		<AInput
			value={data.product.stock}
			name="stock"
			label="Stock"
			required
			hint="How many do you have in stock."
			placeholder="The quantity of this product you currently have."
			type="number"
		/>
		<AFileUpload
			value={data.product.cover}
			name="cover"
			label="Cover"
			required
			hint="A picture of the product."
		/>
		<div class="flex justify-end gap-3">
			<AButton text="Submit" type="submit" />
		</div>
	</form>
	<br />
</section>
