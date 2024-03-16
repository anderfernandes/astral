import type { Meta, StoryObj } from '@storybook/svelte';
import AMiniCalendar from '../components/AMiniCalendar.svelte';

const meta = {
	title: 'UI/AMiniCalendar',
	component: AMiniCalendar,
	tags: ['autodocs']
} satisfies Meta<AMiniCalendar>;

export default meta;

export const Default: StoryObj<typeof meta> = {
	args: {}
};
