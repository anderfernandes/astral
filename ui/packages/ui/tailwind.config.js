/** @type {import('tailwindcss').Config} */
import { theme } from '../../tailwind.config';
import tailwindForms from '@tailwindcss/forms';

export default {
	content: ['./src/**/*.{html,js,svelte,ts}'],
	theme,
	plugins: [tailwindForms]
};
