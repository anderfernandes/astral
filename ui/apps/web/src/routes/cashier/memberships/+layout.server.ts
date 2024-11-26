export const load = async ({ fetch }) => {
	const req = await fetch('/membership-types?active');
	const res: { data: IMembershipType[] } = await req.json();
	return { membership_types: res.data };
};
