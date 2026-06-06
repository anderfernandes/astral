/// <reference types="vitest/config" />

import { defineConfig, type PluginOption } from "vite";
import { tanstackStart } from "@tanstack/solid-start/plugin/vite";
import viteSolid from "vite-plugin-solid";
import tailwindcss from "@tailwindcss/vite";
import { nitro } from "nitro/vite";

export default defineConfig(({ mode }) => {
  const plugins: PluginOption = [
    tailwindcss(),
    tanstackStart(),
    // solid's vite plugin must come after start's vite plugin
    viteSolid({ ssr: true }),
  ];

  if (mode === "production") plugins.push(nitro());

  return {
    resolve: {
      tsconfigPaths: true,
    },
    plugins,
  };
});
