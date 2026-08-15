/// <reference types="vitest/config" />

import { defineConfig, type PluginOption } from "vite";
import { tanstackStart } from "@tanstack/solid-start/plugin/vite";
import viteSolid from "@solidjs/vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import { nitro } from "nitro/vite";

export default defineConfig(() => {
  const plugins: PluginOption = [
    tailwindcss(),
    tanstackStart(),
    // solid's vite plugin must come after start's vite plugin
    viteSolid({ ssr: true }),
    nitro(),
  ];

  return {
    resolve: {
      tsconfigPaths: true,
    },
    plugins,
  };
});
