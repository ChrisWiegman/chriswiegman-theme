module.exports = {
  root: true,
  env: {
    browser: true,
    node: true,
  },
  settings: {
    react: {
      version: "detect",
    },
  },
  parserOptions: {
    parser: "babel-eslint",
    ecmaVersion: 2020,
    ecmaFeatures: {
      jsx: true,
      modules: true,
      experimentalObjectRestSpread: true,
      globalReturn: true,
    },
    sourceType: "module",
  },
  extends: ["plugin:prettier/recommended"],
  plugins: [],
  // add your custom rules here
  ignorePatterns: ["**/dist", "**/includes/settings/scss/bootstrap"],
  rules: {
    "no-console": ["error", { allow: ["warn", "error"] }],
    "no-unsafe-optional-chaining": 0,
  },
};
