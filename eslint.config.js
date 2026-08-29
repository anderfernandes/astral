import pluginQuery from "@tanstack/eslint-plugin-query";
import pluginRouter from "@tanstack/eslint-plugin-router";
import solid from "eslint-plugin-solid";

export default [
  ...pluginQuery.configs["flat/recommended-strict"],
  ...pluginRouter.configs["flat/recommended"],
  // Any other config...
  solid,
];
