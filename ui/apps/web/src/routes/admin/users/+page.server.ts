export const load = async ({ fetch }) => {
	const req = await fetch('/users?type=individual');
	const res: { data: IUser[] } = await req.json();
	return { users: res.data };
};
