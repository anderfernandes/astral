import { RouteProps } from "@solidjs/router";
import { Router } from "../../../../router";

type SaleDetailsPageProps = RouteProps<typeof Router.paths.admin.sales>;

export default function SaleDetailsPage(props: SaleDetailsPageProps) {
  return <p>Sale #{props.params.id}</p>;
}
