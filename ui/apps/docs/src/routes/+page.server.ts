import { npm_package_version } from '$env/static/private';

export const load = async () => {
	return {
		version: npm_package_version
	};
};
