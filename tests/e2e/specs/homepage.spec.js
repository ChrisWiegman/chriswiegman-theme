// @ts-check
const { test, expect } = require('@playwright/test');

test('has theme title', async ({ page }) => {
  await page.goto('http://localhost:8889/');

  // Expect a title "to contain" a substring.
  await expect(page).toHaveTitle(/chriswiegman-theme/);
});

test('get started link', async ({ page }) => {
  await page.goto('http://localhost:8889/');

  // Expects page to have a heading with the name of Installation.
  await expect(page.getByRole('heading', { name: 'Recent Posts' })).toBeVisible();
});
