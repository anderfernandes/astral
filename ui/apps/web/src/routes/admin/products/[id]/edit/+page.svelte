<script>
	import { enhance } from '$app/forms';
	import { AButton, ACheckbox, AFileUpload, AInput, ASelect, ATextarea } from 'ui';

	let { data } = $props();
	let { product_types, product } = data;
</script>

<form
	method="POST"
	enctype="multipart/form-data"
	class="grid h-[calc(100vh-7rem)] gap-3 overflow-y-auto px-3 md:mx-64"
	use:enhance={() => {
		return async ({ result, update }) => {
			await update();
		};
	}}
>
	<ACheckbox
		checked={product.is_active}
		name="is_active"
		label="Active"
		hint="Check if this product is available to be sold."
	/>
	<ACheckbox
		checked={product.is_public}
		name="is_public"
		label="Public"
		hint="Check if this product should be available for the general public (website, app)."
	/>
	<ACheckbox
		checked={product.in_cashier}
		name="in_cashier"
		label="Show in Cashier"
		hint="Check if you want this product to be available for sale in Cashier."
	/>
	<AInput
		value={product.name}
		name="name"
		placeholder="The name of the product"
		label="Name"
		required
		hint="Enter a name for the product."
	/>
	<AInput
		value={product.price}
		name="price"
		type="number"
		placeholder="Price of the product"
		label="Price"
		required
		hint="Price of product."
	/>
	<ATextarea
		value={product.description}
		name="description"
		placeholder="Describe the product in a few words"
		label="Description"
		required
		hint="A description of the product"
	/>
	<ASelect
		value={product.type_id}
		name="type_id"
		options={product_types}
		label="Type"
		placeholder="Select one"
		hint="Type of product"
	/>
	<ACheckbox
		checked={product.inventory}
		name="inventory"
		label="Track inventory"
		hint="Check if you have a limited quantity."
	/>
	<AInput
		value={product.stock}
		name="stock"
		label="Stock"
		required
		hint="How many do you have in stock."
		placeholder="The quantity of this product you currently have."
		type="number"
	/>
	<AFileUpload value={product.cover} name="cover" label="Cover" hint="A picture of the product." />
	<div>
		<AButton text="Submit" type="submit" />
	</div>
</form>
