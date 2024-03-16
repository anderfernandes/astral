import type { Meta, StoryObj } from '@storybook/svelte';
import ADatePicker from '../components/ADatePicker.svelte';

const meta = {
	title: 'Input/ADatePicker',
	component: ADatePicker,
	tags: ['autodocs']
} satisfies Meta<ADatePicker>;

export default meta;

export const Default: StoryObj<typeof meta> = {
	args: {
		value: new Date(2023, 1, 27).toDateString(),
		label: 'Birthday',
		required: true,
		hint: 'The date you were born.'
	}
};
