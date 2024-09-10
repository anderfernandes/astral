import { npm_package_version } from '$env/static/private';
import { redirect } from '@sveltejs/kit';

export const load = async ({ fetch, cookies }) => {
	let req = await fetch('/settings');

	const settings: ISettings = await req.json();

	const token = cookies.get('astral_token');

	if (!token || token.length === 0) return { settings };

	req = await fetch('/user', {
		headers: { Authorization: 'Bearer ' + token }
	});

	console.log(req.status, req.url);

	if (req.status === 401) redirect(301, '/login');

	if (req.status !== 200) return { settings };

	const account = (await req.json()) as IUser;

	return { settings, account, version: npm_package_version };
};
