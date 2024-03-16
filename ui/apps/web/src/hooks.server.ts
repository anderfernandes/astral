import { BACKEND_URL, NODE_ENV } from '$env/static/private';
import type { Handle, HandleFetch } from '@sveltejs/kit';

export const handle: Handle = async ({ event, resolve }) => {
	//console.log('handle', event.url.host);
	//event.request.headers.append('X-FORWARDED-HOST', event.url.host);
	return await resolve(event);
};

export const handleFetch: HandleFetch = async ({ request, fetch, event }) => {
	const token = event.cookies.get('astral_token');

	//console.log(token);

	if (token !== undefined) request.headers.append('Authorization', `Bearer ${token}`);

	const parsedUrl = new URL(request.url);

	//if (NODE_ENV === 'development') parsedUrl.searchParams.append('XDEBUG_SESSION_START', 'PHPSTORM');

	const url = new URL('/api' + parsedUrl.pathname + parsedUrl.search, BACKEND_URL);

	request = new Request(url, request);

	request.headers.set('accept', 'application/json');
	request.headers.set('x-forwarded-port', event.url.port);
	request.headers.set('x-forwarded-for', event.url.hostname);
	//request.headers.set('x-forwarded-host', event.url.host);

	//console.log(request.headers, request.url);
	console.info(`${request.method} ${request.url.toString()} ${event.url.hostname}`);

	return fetch(request);
};
