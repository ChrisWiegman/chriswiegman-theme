import { defineConfig } from '@playwright/test';

// import base WordPress configuration
const baseConfig = require('@wordpress/scripts/config/playwright.config');

const config = defineConfig({
	...baseConfig,
	reporter: [
		['list'],
		['html'],
		['github']
	]
});

export default config;
