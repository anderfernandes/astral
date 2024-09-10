export const load = async ({ fetch }) => {
	const req = await fetch('/product-types');
	const res: { data: IProductType[] } = await req.json();
	return { product_types: res.data };
};
