import { JSX } from "@solidjs/web/jsx-runtime";

function Table(props: { children: JSX.Element }) {
  return (
    <div class="max-h-96 w-full overflow-auto">
      <table class="text-sm">{props.children}</table>
    </div>
  );
}

function TableHeader(props: { text: JSX.Element }) {
  return (
    <th class="border-b border-b-gray-300 px-4 py-2 font-medium whitespace-nowrap text-gray-500">
      {props.text}
    </th>
  );
}

function TableHead(props: { children: JSX.Element }) {
  return (
    <thead>
      <tr>{props.children}</tr>
    </thead>
  );
}

function TableBody(props: { children: JSX.Element }) {
  return <tbody>{props.children}</tbody>;
}

function TableRow(props: { children: JSX.Element }) {
  return <tr class="hover:bg-gray-100">{props.children}</tr>;
}

function TableDataCell(props: { children?: JSX.Element; text?: JSX.Element }) {
  return (
    <td class="border-b border-b-gray-300 px-4 py-2 whitespace-nowrap">
      {props.children} {props.text}
    </td>
  );
}

Table.Header = TableHeader;
Table.Head = TableHead;
Table.Body = TableBody;
Table.Row = TableRow;
Table.DataCell = TableDataCell;

export { Table };
