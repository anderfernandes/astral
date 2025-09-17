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

Go to `Memberships` and then `New Membership` and fill out the form providing the following data:

#### Type

The type of membership. Each type is supposed to have different benefits, set by your organization in settings.

Changing this for values already set will reset all other fields because Astral needs to recalculate what options to give users for all other fields.

#### Primary

The owner of the membership. In order to appear in as an option in the dropdown, individual must have an account.

#### Start

The start date of the membership. This is automatically set based on today's date, but can be changed. Note that changing the start date will automatically change the end date based on the set length in days of the membership.

Memberships by default start at the time they are purchased and end at the end of the day of their duration. For example, if a 365 day membership was purchased on August 26 at 9:02 PM, it will start at that date and time and end at August 26 of the next year at 11:59:59 PM.

#### End

The end date of the membership. It is automatically set, can be overriden to any date.

Enter the payment, double check to make sure everything is to the customer liking and click `Save`. Only then the membership will be granted. It will be available to the customer right away.

#### Free Secondaries

If the selected membership type allows, the next step will be selecting the free secondaries. The user selected as the primary for this membership is not allowed to be selected as secondary as here.

#### Paid Secondaries

If the selected membership allows and if all alloed free secondary spots have been taken (if any), the next step is to select the free secondaries. The user selected as the primary for this membership is not allowed to be selected as secondary as here.

#### Payments

In order to create the membership, a payment must be made. Payments

### Updating

This section refers to adding secondaries to memberships that have secondaries and have not used all of them. For extending/adding time/renewing a membership, see [renewing](#reneweing).

Astral gives you the option to add secondaries of any unexpired memberships.

Find a membership and click `edit`. **Only secondaries can be changed on a membership**.

This feature is useful if, for example, at the moment of a membership purchase, the primary selected no or not all secondaries they are allowed to have.

Remember that **adding paid secondaries always requires a payment**. Changes will not extend the period of the membership, only [renewing](#reneweing) will do that.

### Reneweing

Membership renewals are subject to the following rules:

- Primaries cannot be changed
- Only an expired primary can be added as a secondary on another membership
- The minimum membership starting date for non-expired memberships is the the ending date of the current one plus one day

Go to `Memberships`, find the membership, click on it to go to details and click `Renew`. The rest of the process is very similar to [creating](#creating).

### Canceling

A membership can be canceled. This might come handy if a previous primary wants to be a secondary in someone else's membership.

Go to `membership details` and click `cancel membership`.

**Be careful! Canceling a current membership should only be done by customer request. Membership days are not transferable to other memberships.**
