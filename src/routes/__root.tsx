// src/routes/__root.tsx
/// <reference types="vite/client" />
import * as Solid from "solid-js";
import {
  Outlet,
  createRootRoute,
  HeadContent,
  Scripts,
  createRootRouteWithContext,
} from "@tanstack/solid-router";
import { HydrationScript, JSX } from "@solidjs/web";
import "../styles.css";
import { QueryClient, QueryClientProvider } from "@tanstack/solid-query";

export const Route = createRootRoute({
  head: () => ({
    meta: [
      {
        charSet: "utf-8",
      },
      {
        name: "viewport",
        content: "width=device-width, initial-scale=1",
      },
      {
        title: "TanStack Start Starter",
      },
    ],
  }),
  component: RootComponent,
});

const queryClient = new QueryClient();

function RootComponent() {
  return (
    <QueryClientProvider client={queryClient}>
      <RootDocument>
        <Outlet />
      </RootDocument>
    </QueryClientProvider>
  );
}

function RootDocument({ children }: Readonly<{ children: JSX.Element }>) {
  return (
    <html>
      <head>
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <HydrationScript />
      </head>
      <body>
        <HeadContent />
        {children}
        <Scripts />
      </body>
    </html>
  );
}
