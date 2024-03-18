export const load = async ({ fetch, params }) => {
	const req = await fetch(`/products/${params.id}`);
	const product: IProduct = await req.json();
	return { product };
};
