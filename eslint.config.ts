import js from "@eslint/js";
import globals from "globals";
import tseslint from "typescript-eslint";
//import { defineConfig } from "eslint/config";
import solid from "eslint-plugin-solid/configs/v2";

export default [
  {
    files: ["**/*.{js,mjs,cjs,ts,mts,cts}"],
    plugins: { js },
    extends: ["js/recommended"],
    languageOptions: { globals: { ...globals.browser, ...globals.node } },
  },
  tseslint.configs.recommended,
  solid,
];
