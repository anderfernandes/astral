<script>
	import { enhance } from '$app/forms';
	import { AButton, ACheckbox, AFileUpload, AInput, ASelect, ATextarea } from 'ui';

	let { data } = $props();
	let { product_types } = data;
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
	<ATextarea
		name="description"
		placeholder="Describe the product in a few words"
		label="Description"
		required
		hint="A description of the product"
	/>
	<ASelect
		name="type_id"
		required
		options={product_types}
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
	<AFileUpload name="cover" label="Cover" required hint="A picture of the product." />
	<div>
		<AButton text="Submit" type="submit" />
	</div>
</form>
