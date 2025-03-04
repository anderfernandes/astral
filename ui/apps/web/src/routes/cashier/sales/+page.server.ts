export const load = async ({ fetch }) => {
	const req = await fetch('/sales');
	const res: { data: ISale[] } = await req.json();
	if (req.status > 299) {
		console.log(req.status, res);
	}

	return { sales: res.data };
};
