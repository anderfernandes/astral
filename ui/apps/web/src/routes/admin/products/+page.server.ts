export const load = async ({ fetch }) => {
	const req = await fetch('/products');
	const res: { data: IProduct[] } = await req.json();
	console.log(res);
	return { products: res.data };
};
