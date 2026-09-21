import { Title } from "@solidjs/meta";
import { Loading } from "solid-js";
// A typed, validated client env var, baked into the bundle at build time
// (defaults applied — see env.ts).
import { env } from "virtual:env/client";
import { paths, Router } from "./router";
import "./App.css";

// The app root: the router and the site-wide layout live here. Pages are
// the modules under src/routes.
export default function App() {
  return (
    <Router>
      {(props) => (
        <>
          <Title>Astral</Title>
          <Loading fallback={<main>Loading…</main>}>{props.children}</Loading>
        </>
      )}
    </Router>
  );
}
