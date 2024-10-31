import { npm_package_version, npm_config_npm_version } from '$env/static/private';
import { redirect } from '@sveltejs/kit';
import { fileURLToPath } from 'url';
import { readFileSync } from 'fs';

export const load = async ({ fetch, cookies }) => {
	let req = await fetch('/settings');

	const settings: ISettings = await req.json();

	const token = cookies.get('astral_token');

	if (!token || token.length === 0) return { settings, version: npm_package_version };

	req = await fetch('/user', {
		headers: { Authorization: 'Bearer ' + token }
	});

	console.log(req.status, req.url);

	if (req.status === 401) redirect(301, '/login');

	if (req.status !== 200) return { settings };

	const account = (await req.json()) as IUser;

	// const sveltePackage = JSON.parse(
	// 	readFileSync(
	// 		fileURLToPath(new URL('../../../../node_modules/svelte/package.json', import.meta.url)),
	// 		'utf-8'
	// 	)
	// );

	// const kitPackage = JSON.parse(
	// 	readFileSync(
	// 		fileURLToPath(
	// 			new URL('../../../../node_modules/@sveltejs/kit/package.json', import.meta.url)
	// 		),
	// 		'utf-8'
	// 	)
	// );

	const ui: string[] = [
		process.versions.node,
		npm_config_npm_version
		//sveltePackage.version,
		//kitPackage.version
	];

	return { settings, account, version: npm_package_version, ui };
};
