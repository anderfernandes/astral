import util from 'node:util';
import child_process from 'node:child_process';

export const load = async ({ fetch, params }) => {
	const req = await fetch(`/sales/${params.id}`);
	const sale: ISale = await req.json();

	return { sale };
};

export const actions = {
	default: async ({ fetch, params }) => {
		// TODO: ADD MEMO THAT RECORDS SOMEONE EMAILED THIS DOCUMENT

		const chromium = util.promisify(child_process.exec);

		await chromium(
			`chromium --enable-chrome-browser-cloud-management --headless=new --disable-gpu --print-to-pdf=/home/anderson/astral/server/storage/app/receipt_${params.id}.pdf --no-pdf-header-footer http://127.0.0.1:3000/cashier/sales/${params.id}/receipt`
		);

		const req = await fetch(`/mail/sales/${params.id}/receipt`);

		if (!(req.status > 299)) return { success: true };

		console.log(await req.json());
	}
};
