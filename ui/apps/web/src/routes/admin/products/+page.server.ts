export const load = async ({ fetch }) => {
	const req = await fetch('/products');
	const res: { data: IProduct[] } = await req.json();
	return { products: res.data };
};
