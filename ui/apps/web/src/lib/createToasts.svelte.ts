/**
 * Access global toast notification
 */
export function createToasts() {
	/**
	 * List of toasts.
	 */
	const toasts: { title?: string; message: string }[] = $state([]);

	/**
	 * Pushes a new toast.
	 * @param toast
	 */
	function push(t: (typeof toasts)[number]) {
		console.log('adding toast');
		toasts.push(t);
		setTimeout(() => {
			toasts.splice(toasts.length - 1, 1);
			console.log('removing toast');
		}, 5000);
	}

	return {
		get toasts() {
			return toasts;
		},
		push
	};
}
