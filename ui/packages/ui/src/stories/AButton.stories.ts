import type { Meta, StoryObj } from '@storybook/svelte';
import AButton from '../components/AButton.svelte';

const meta = {
	title: 'Input/AButton',
	component: AButton,
	tags: ['autodocs']
} satisfies Meta<AButton>;

export default meta;

export const Default: StoryObj<typeof meta> = {
	args: {
		text: 'AButton'
	}
};
