export const load = async ({ fetch }) => {
	const req = await fetch('/memberships');
	const res: { data: IMembership[] } = await req.json();
	return { memberships: res.data };
};
