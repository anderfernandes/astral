<h1 align="center">Astral</h1>

<p align="center">
  <img src="https://img.shields.io/badge/version-2.0.0--alpha.0-black" />
  <img src="https://img.shields.io/github/stars/anderfernandes/astral" />
</p>

We help non-profit planetariums, museums and science centers focus on teaching the wonders of science and the universe to the communities they serve.

Astral is an open source application that helps non-profit educational organizations manage events, tickets, sales, visitors and memberships.

If you work in a non-profit planetarium, museum or science center and are struggling to find the right software to help you run things, Astral is what you are looking for.

## Setup

### Database

Astral works with the following databases:

| Database              | Minimum Version |
| --------------------- | --------------- |
| SQLite (`sqlite`)     | 3.37            |
| Postgres (`postgres`) | 14              |
| SQL Server            | 2017            |

MySQL support will be added soon.

**Note: all columns of the database representing date and time must be in UTC.**

### General Settings

Environment defined settings.

- `NAME`
- `SALE_TAX_RATE` (e.g. 8.25 to get 8.25%)
- `CONVENIENCE_FEE` (e.g 350 to charge a $3.50 convenince fee for online sales)
- `LOCALE`
- `CURRENCY`
- `TIMEZONE`

### Membership Settings

Define one or more membership types to enable a Memberships page in the public portal. The ones made `active` and `public` will show a sign up button allowing online sign up when a working online [payment method](#payment-methods) is setup.

- Name
- Description
- Duration (in days, use only 365 for yearly memberships and 30 for monthly)
- Price
- Max Free Secondaries
- Max Paid Secondaries
- Active
- Public (makes it available in the public portal)

Memberships by default only include 1 person. To make them include more people, use their respective max (free or paid) settings. For example:

- 3 free secondaries and 0 paid secondaries: 1 to 4 people, all inclusive.
- 3 free secondaries and 2 paid secondaries: 1 to 6 people, 2 paid secondaries in which each pay the amount set in paid secondary price

### Payment Methods

For tagging and/or categorizing payments. For example, you have add cash, card or check and make their type reflect those options, or you can have a Visa being a card if you want to track the card being used in payments.

- Name
- Description
- Type (`CASH`, `CARD`, `OTHER`)
- Active
- Public

Astral may be configured to take online payments with Stripe.

#### Online Payments with Stripe

Sign up for [Stripe](https://stripe.com), setup a `STRIPE_TAX_RATE_ID`, a `STRIPE_PUBLIC_KEY` and a `STRIPE_SECRET_KEY`.

Next, create a payment method called stripe (all lower case) with the type `OTHER`, make it `active` and `public`.

With the set up above correct and your stripe reporting that your acccount and set up is good, online sales is enabled.
