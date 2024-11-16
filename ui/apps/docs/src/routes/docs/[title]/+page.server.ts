import { readFileSync } from 'fs';
import { marked } from 'marked';
import path from 'path';
import { fileURLToPath } from 'url';

export const load = ({ params }) => {
	const __filename = fileURLToPath(import.meta.url);
	const __dirname = path.dirname(__filename);
	const filePath = path.join(__dirname, `../../../docs/${params.title}.md`);
	const data = readFileSync(filePath).toString();

	return { content: marked.parse(data) };
};
