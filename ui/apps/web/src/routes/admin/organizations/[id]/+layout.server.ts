export const load = async ({ fetch, params }) => {
	const req = await fetch(`/organizations/${params.id}`);
	const res: IOrganization = await req.json();
	console.log(res);
	return { organization: res };
};
