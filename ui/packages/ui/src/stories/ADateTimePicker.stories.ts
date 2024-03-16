import type { Meta, StoryObj } from '@storybook/svelte';
import ADateTimePicker from '../components/ADateTimePicker.svelte';

const meta = {
	title: 'Input/ADateTimePicker',
	component: ADateTimePicker,
	tags: ['autodocs']
} satisfies Meta<ADateTimePicker>;

export default meta;

export const Default: StoryObj<typeof meta> = {
	args: {
		value: new Date(2023, 1, 27).toISOString(),
		label: 'Start',
		required: true,
		hint: 'The date and time of the event.'
	}
};
