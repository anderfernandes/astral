export const load = async ({ fetch }) => {
	const [roles, organizations]: [{ data: IRole[] }, { data: IOrganization[] }] = await Promise.all([
		fetch('/roles').then((res) => res.json()),
		fetch('/organizations').then((res) => res.json())
	]);

	return { roles: roles.data, organizations: organizations.data };
};
