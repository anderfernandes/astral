<p align="center">
  <img src="https://raw.githubusercontent.com/anderfernandes/astral/refs/heads/beta/server/storage/app/public/logo.svg" width="100" />
</p>

<h1 align="center">Astral</h1>

<hr />

<p align="center">
  <img src="https://img.shields.io/badge/version-2.0.0--alpha.0-black" />
  <img src="https://img.shields.io/github/issues/anderfernandes/astral" />
  <img src="https://img.shields.io/github/stars/anderfernandes/astral" />
  <img src="https://img.shields.io/github/license/anderfernandes/astral" />
</p>

We help non-profit planetariums, museums and science centers focus on teaching the wonders of science and the universe to the communities they serve.

Astral is an open source application that helps non-profit educational organizations manage events, tickets, sales, visitors and memberships.

If you work in a non-profit planetarium, museum or science center and are struggling to find the right software to help you run things, Astral is what you are looking for.

## Memberships

Astral can help your organization manager memberships.

### Setup

Start by creating one or more `Membership Types` in admin `Settings` for each membership package your organization offers. You will need to know:

1. `name`: give it a short name like **Family** or **Individual**.
2. `description`: write a short description with, for example, who it is for.
3. `price`: how much the memberhsip type will cost before tax.
4. `duration`: how long the membership lasts, in days.
5. `max free secondaries`: the maximum number of free secondaries allowed. Default is 0.
6. `max paid secondaries`: Default is also 0. The maximum number of paid secondaries, each is charged the amount in...
7. `secondary price`: the price per paid secondary
8. `is active`: if checked, makes it available as a membership type option for creating and reneweing memberships.
9. `is public`: makes a membership type available for sale for the general public online. Make sure it is also active.

Knowing and configuring this is essential to get memberships right. Make sure you and your staff understand each setting before creating memberships.

Memberships have one `primary` by default and the sum of `free` and `paid` secondaries. For example (names are examples):

- Individual: 1 primary, 1 paid secondary (up to 2 people)
- Family: 1 primary, 3 free secondaries (up to 4 people)
- Sponsor: 1 primary, 3 free secondaries, 2 paid secondaries (up to 6 people)

Astral will always ask to fill all the free secondaries before asking for paid secondaries. Make sure to change the number of free and paid secondaries to adjust to what your organization wants.

### Creating

Go to `Memberships` and then `New Membership`. To appear as an option for primary and secondaries, individuals will have to have an account. They can register or they can be added as an user.

Enter the payment, double check to make sure everything is to the customer liking and click `Save`. Only then the membership will be granted. It will be available to the customer right away.

### Updating

This section refers to adding or changing who the secondaries are. For extending/adding time/renewing a membership, see [renewing](#reneweing).

Astral gives you the option to change or add secondaries of any unexpired memberships. We suggest you coming up with written an explicit policies for memberships in your organization that either allow or prohibit this. In case you do want to allow that, it can be done in admin.

Find a membership and click `edit`. **Secondaries may be changed but primaries cannot**.

Remember that adding paid secondaries always requires a payment. Changes will not extend the period of the membership, only [renewing](#reneweing) would do that.

### Reneweing

Membership renewals are subject to the following rules:

- Primaries cannot be changed
- Only an expired primary can be added as a secondary on another membership

Go to `Memberships`, find the membership, click on it to go to details and click `Renew`. The rest of the process is very similar to [creating](#creating).
