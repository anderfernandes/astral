interface IDashboardData {
	users: number;
	events: number;
	sales: number;
	tickets: number;
	payments: IPayment[];
}

export const load = async ({ fetch }) => {
	const req = await fetch('/dashboard');
	const res: { data: IDashboardData } = await req.json();

	console.log(res.data);

	return { ...res.data };
};
