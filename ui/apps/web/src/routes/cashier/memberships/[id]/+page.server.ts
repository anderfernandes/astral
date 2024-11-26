export const load = async ({ fetch, params }) => {
	const req = await fetch(`/memberships/${params.id}`);
	const data: IMembership = await req.json();
	console.log(data);
	return { membership: data };
};
