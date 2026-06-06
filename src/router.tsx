// src/router.tsx
import { createRouter } from "@tanstack/solid-router";
import { routeTree } from "./routeTree.gen";
import { QueryClient } from "@tanstack/solid-query";

export function getRouter() {
  const queryClient = new QueryClient();

  const router = createRouter({
    routeTree,
    scrollRestoration: true,
  });

  return router;
}
