// See https://kit.svelte.dev/docs/types#app
// for information about these interfaces
declare global {
	namespace App {
		// interface Error {}
		// interface Locals {}
		// interface PageData {}
		// interface PageState {}
		// interface Platform {}
	}

	interface IconData {
		name: string;
		path: string;
	}

	/**
	 * Calendar props.
	 */
	interface IACalendarProps {
		selected?: Date;
		url?: string;
		create?: string;
		events: {
			id?: number;
			start: string;
			end: string;
			show: { id?: number; name: string; type?: { id?: number; name: string } };
			type?: { id?: number; name: string };
			title?: string | null;
			is_all_day: boolean;
			is_public: boolean;
		}[];
	}

	/**
	 * Common input props for Input, Textarea and Select
	 */
	interface ICommonInputProps {
		label?: string;
		hint?: string;
		errors?: string[];
	}
}

export {};
