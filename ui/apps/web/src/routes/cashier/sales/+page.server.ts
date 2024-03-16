export const load = async ({ fetch, request }) => {
	const req = await fetch('/sales');
	const res: { data: ISale[] } = await req.json();
	if (req.status > 299) {
		console.log(req.status);
		console.log(res);
	}
	console.log(res.data[0].tickets);
	return { sales: res.data };
};
