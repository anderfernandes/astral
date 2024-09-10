export const load = () => {
	return {
		users: Math.floor(Math.random() * 1000),
		events: Math.floor(Math.random() * 100),
		sales: Math.floor(Math.random() * 1000),
		tickets: Math.floor(Math.random() * 1000),
		payments: [
			{ total: Math.floor(Math.random() * 1000), sale_id: Math.floor(Math.random() * 1000) },
			{ total: Math.floor(Math.random() * 1000), sale_id: Math.floor(Math.random() * 1000) },
			{ total: Math.floor(Math.random() * 1000), sale_id: Math.floor(Math.random() * 1000) },
			{ total: Math.floor(Math.random() * 1000), sale_id: Math.floor(Math.random() * 1000) },
			{ total: Math.floor(Math.random() * 1000), sale_id: Math.floor(Math.random() * 1000) }
		],
		overview: [
			{ month: 'Jan', amount: Math.floor(Math.random() * 1000) },
			{ month: 'Feb', amount: Math.floor(Math.random() * 1000) },
			{ month: 'Mar', amount: Math.floor(Math.random() * 1000) },
			{ month: 'Apr', amount: Math.floor(Math.random() * 1000) },
			{ month: 'May', amount: Math.floor(Math.random() * 1000) },
			{ month: 'Jun', amount: Math.floor(Math.random() * 1000) },
			{ month: 'Jul', amount: Math.floor(Math.random() * 1000) },
			{ month: 'Aug', amount: Math.floor(Math.random() * 1000) },
			{ month: 'Sep', amount: Math.floor(Math.random() * 1000) },
			{ month: 'Oct', amount: Math.floor(Math.random() * 1000) },
			{ month: 'Nov', amount: Math.floor(Math.random() * 1000) },
			{ month: 'Dec', amount: Math.floor(Math.random() * 1000) }
		]
	};
};
