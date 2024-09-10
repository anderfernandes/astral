export const load = async ({ fetch, params }) => {
	const req = await fetch(`/sales/${params.id}`);
	const sale: ISale = await req.json();
	return { sale };
};
