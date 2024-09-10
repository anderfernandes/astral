export const load = async ({ fetch }) => {
	const req = await fetch('/organizations');
	const res: { data: IOrganization[] } = await req.json();
	console.log(req.status, req.url.toString());
	console.log(res.data);
	return { organizations: res.data };
};
