<script>
	import { AButton, ACheckbox, AFileUpload, AInput, ASelect, ATextArea } from 'ui';

	let { data } = $props();
</script>

<svelte:head>
	<title>Products - Astral Admin</title>
</svelte:head>

<section class="h-[calc(100%)] overflow-y-auto">
	<div class="space-y-1 md:mx-64">
		<h2 class="text-2xl font-semibold tracking-tight">New Product</h2>
		<p class="text-sm text-muted-foreground">Changes take effect upon clicking save.</p>
	</div>
	<br />
	<form
		method="POST"
		enctype="multipart/form-data"
		class="grid gap-6 overflow-y-auto px-3 md:mx-64"
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
		<AFileUpload name="cover" label="Cover" required hint="A picture of the product." />
		<div class="flex justify-end gap-3">
			<AButton text="Submit" type="submit" />
		</div>
	</form>
	<br />
</section>
