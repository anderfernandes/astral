export const load = async ({ fetch, params }) => {
	const req = await fetch(`/users/${params.id}`);
	const res: IUser = await req.json();
	return { user: res };
};
