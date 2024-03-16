export const load = async ({ fetch }) => {
	const req = await fetch('/users?staff');

	const res: { data: { id: number; firstname: string }[] } = await req.json();

	res.data.unshift({ id: 0, firstname: 'All' });

	console.log(res);

	return {
		users: res.data.map((u) => ({ id: u.id, name: u.firstname }))
	};
};
