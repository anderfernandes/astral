export const load = async ({ fetch }) => {
	const req = await fetch('/shows');
	const res: { data: IShow[] } = await req.json();
	//console.log(res.data);
	return { shows: res.data };
};
