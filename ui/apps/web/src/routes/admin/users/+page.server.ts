export const load = async ({ fetch, url }) => {
	console.log(url.search);

	const req = await fetch('/users' + url.search);

	const res: { data: IUser[] } = await req.json();

	console.log(res.data.length);

	return { users: res.data.filter((u) => u.id !== 1) };
};
