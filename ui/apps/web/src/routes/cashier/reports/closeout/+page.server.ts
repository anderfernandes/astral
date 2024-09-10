import { error } from '@sveltejs/kit';

interface ICloseoutReportData {
	transactions: number;
	total: number;
	start: string;
	end: string;
	report: {
		cashier: string;
		items: { method: string; transactions: number; amount: number }[];
		transactions: number;
		total: number;
	}[];
}

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

	const req = await fetch(`/reports/closeout?cashier=${cashier}&start=${start}&end=${end}`);
	const res: { data: ICloseoutReportData } = await req.json();

	console.log(res.data.report);

	return { closeout: res.data };
};
