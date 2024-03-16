<p align="center">
  <img src="https://astral.anderfernandes.com/assets/astral-logo-dark.png" width="100">
</p>
<h1 align="center">Astral</h1>
<p align="center">
  <img src="https://img.shields.io/badge/version-1.0.0--beta.0-black" />
  <img src="https://img.shields.io/github/issues/anderfernandes/astral" />
  <img src="https://img.shields.io/github/stars/anderfernandes/astral" />
  <img src="https://img.shields.io/github/license/anderfernandes/astral" />
</p>

We believe in empowering non-profit science centers so that they can inspire people of all ages in
their community. Astral is an open source point of sale (POS), customer relationship manager (CRM),
box office, membership, marketing and reservation manager for non-profit educational organizations
such as planetariums, museums and science centers. It will allow your organization to:

- Sell tickets
- Generate sale, attendance and revenue reports
- Manage events, shows, products, sales, members, users, organizations and work shifts
- Schedule and manage events such as school field trips, birthday parties, special events, civic events, etc, with
  automated email and/or in app notifications
- Calendar view with past, present and future events and sales
- Send automated marketing emails such as newsletters, reminders and alerts to members, teachers and visitors
- Process credit card payments online

If your organization has Astral, it can be installed (PWA) or run straight from modern browsers in smartphones, tablets,
PC, MacOS or Linux.

If you work in a non-profit planetarium, museum or science center and are struggling to find the right app to help you
run things, Astral is what you are looking for.

<hr />

Everything you need to build a Svelte project, powered by [`create-svelte`](https://github.com/sveltejs/kit/tree/master/packages/create-svelte).

## Developing

Once you've created a project and installed dependencies with `npm install` (or `pnpm install` or `yarn`), start a development server:

```bash
npm run dev
```

## Building

To create a production version of your app:

```bash
npm run build
```

You can preview the production build with `npm run preview`.

## Creating a symlink to Astral Server's filesystem

Run this in the **root of the ui monorepo**:

```bash
ln -s /path-to-astral-directory/server/storage/app/public apps/web/static/storage
```
