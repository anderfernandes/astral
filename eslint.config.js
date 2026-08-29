import pluginQuery from "@tanstack/eslint-plugin-query";
import pluginRouter from "@tanstack/eslint-plugin-router";
import solid from "eslint-plugin-solid/config/v2";
import tseslint from "typescript-eslint";

export default [
  pluginQuery.configs["flat/recommended-strict"],
  pluginRouter.configs["flat/recommended"],
  solid,
  {
    files: ["**/*.{ts,tsx}"],
    languageOptions: {
      parser: tseslint.parser,
      parserOptions: {
        projectService: true,
      },
    },
    plugins: {
      "@typescript-eslint": tseslint.plugin,
    },
    rules: {
      "@typescript-eslint/no-floating-promises": "error",
    },
  },
];
