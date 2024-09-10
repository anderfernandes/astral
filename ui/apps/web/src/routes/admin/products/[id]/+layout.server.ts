export const load = async ({ fetch, params }) => {
	const req = await fetch(`/products/${params.id}`);
	const product: IProduct = await req.json();

	console.log(product);

	return { product };
};
