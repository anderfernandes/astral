import { error } from '@sveltejs/kit';

export const load = async ({ url, fetch }) => {
	if (
		!url.searchParams.has('cashier') ||
		!url.searchParams.has('start') ||
		!url.searchParams.has('end')
	)
		return error(404, { message: 'Not found' });

	const cashier = url.searchParams.get('cashier');
	const start = url.searchParams.get('start');
	const end = url.searchParams.get('end');

	const req = await fetch(`/reports/payment?cashier=${cashier}&start=${start}&end=${end}`);
	const res: { data: IPaymentReportData } = await req.json();

	console.log(req.status, res);

	return res.data;
};

interface IPaymentReportData {
	start: string;
	end: string;
	totals: string;
	report: {
		cashier: string;
		totals: string;
		transactions: {
			created_at: string;
			sale_id: number;
			reference: string | null;
			tendered: number;
			change: number;
			amount: number;
			customer: string;
			refunded: boolean;
			cashier: string;
			method: string;
		}[];
	}[];
}
