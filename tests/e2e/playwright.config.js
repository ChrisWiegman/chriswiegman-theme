const { defineConfig } = require('@playwright/test');
const path = require('path');
const baseConfig = require('@wordpress/scripts/config/playwright.config');

const config = defineConfig({
	...baseConfig,
	reporter: [
		['list'],
		['html', { open: 'never', outputFolder: path.join(process.cwd(), 'artifacts', 'html') }],
		['github']
	]
});

export default config;
