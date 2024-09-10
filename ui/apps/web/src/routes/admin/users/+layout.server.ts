export const load = async ({ fetch }) => {
	const req = await fetch('/roles');
	const res: { data: IUser[] } = await req.json();

	return { roles: res.data };
};
