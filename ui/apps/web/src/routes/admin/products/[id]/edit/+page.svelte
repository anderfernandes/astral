<script lang="ts">
	import { AButton, ACheckbox, AFileUpload, AInput, ASelect, ATextArea } from 'ui';
	import AdminLayout from '../../../AdminLayout.svelte';
	import { applyAction, enhance } from '$app/forms';

	const { data } = $props();
	const { product } = data;
	let loading = $state(false);
</script>

{#snippet header()}
	<h2 class="text-xl font-bold">Edit Product #{product.id}</h2>
{/snippet}

<AdminLayout
	title={`Edit Product #${product.id}`}
	{header}
	backHref={`/admin/products/${product.id}`}
>
	<form
		method="post"
		enctype="multipart/form-data"
		class="grid gap-6"
		use:enhance={() => {
			loading = true;
			return async ({ result, update }) => {
				console.log(result.status);
				if (result.status! >= 400) {
					loading = false;
				} else await applyAction(result);
				await update();
			};
		}}
	>
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
			label="Picture"
			required
			hint="A picture of the product."
		/>
		<div class="flex justify-end gap-3">
			<AButton text="Submit" type="submit" {loading} />
		</div>
	</form>
</AdminLayout>
