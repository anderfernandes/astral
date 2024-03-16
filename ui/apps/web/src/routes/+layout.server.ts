export const load = async ({ fetch, cookies }) => {
	let req = await fetch('/settings');
	const settings: ISettings = await req.json();

	const token = cookies.get('astral_token');

	if (!token || token.length === 0) return { ...settings };

	req = await fetch('/user', {
		headers: { Authorization: 'Bearer ' + token }
	});

	if (req.status !== 200) return { ...settings };

	const account = (await req.json()) as IUser;

	return { ...settings, account };
};
