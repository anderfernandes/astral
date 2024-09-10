export const load = async ({ fetch }) => {
	const req = await fetch('/organization-types');
	const res: { data: IOrganizationType[] } = await req.json();
	console.log(req.status, req.url.toString());
	return { organization_types: res.data };
};
