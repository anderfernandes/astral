# Admin

**Astral Admin** is where you manage everything in your non-profit planetarium, science center or museum.

<div id="accounts"></div>

## Accounts

### Creating an Astral Admin account

You may register as a regular user and be given access to Astral Admin or have an account created by a current Astral Admin user.

<div id="authentication"></div>

### Authentication

On the top right corner of the **Home Page**, click in **Login**. Enter your credentials and you are good to go.

<div id="account-recovery"></div>

### Account Recovery

On the **Login** page, select the "Forgot Password" option and fill out the form.

<div id="dashboard"></div>

## Dashboard

If you are an Astral Admin user, upon login you will be redirected to the Astral Admin Dashboard, where you will see an overview of all the users, events, shows and members of your organization.

<div id="calendar"></div>

## Calendar

This is where Astral Admin will show all events: future and past.

<div id="shows"></div>

## Shows

Add here all shows or attractions that you can possibly have in your planetarium, science center or museum.

<div id="sales"></div>

## Sales

View and manage all the sales made.

<div id="products"></div>

## Products

If your non-profit planetarium, science center or museum has a gift shop, this is where you will create and manage the items you sell there. It can be used to sell anything that is not a ticket or membership.

<div id="reports"></div>

## Reports

Reports on sales for any purpose, including reconciliation, are located here.

<div id="users"></div>

## Users

Manage staff and visitor accounts.

<div id="organizations"></div>

## Organizations

Store data on organizations and add users to them to make everything more organized and easier to find.

<div id="memberships"></div>

## Memberships

Astral is a great way to manage memberhsips of planetariums, museums and science centers.

Memberships start the beginning of the day they are purchased and end at the beginning of the next day of their duration.

Before a user can take advantage of any membership perks, Astral checks if a membership is active, which means, the end date is not greater than the current date.

### Setup

The first step to setup up memberships is to create a membership type:

- Name
- Description
- Price (can be 0 if it is a free membership)
- Duration (in days)
- Maximum number of secondaries (can be 0 for no secondaries)
- Price of each secondary (can be 0 if secondaries are free)
- Active (`true` or `false`)
- Keep Remaining Days (`true` or `false`)

Pay attention to the values you enter in each field as they will be what drives the sale of memberships. Changing a membership type is not recommended as it will change the configuration for all members with that membership, unless doing so is desired.

### New Memberships

Any user who is not a member yet can be made a member by going through the membership wizard.

The main member in a membership is called the _primary_. Dependants on the membership (if alloweds) are called _secondaries_.

### Renewing Memberships Before Expiration

The remaining days will be added to the number of days of the new membership if the membership type is checked to _keep reamining days_. If not, the renewed membership will be starting from the beginning of the day it is purchased.

### Renewing Memberships After Expiration

In such case, memberships will follow the case mentioned in **New Memberships**.

<div id="settings"></div>

## Settings

This is the place to manage basic data such as the name of your organization, logo, address in addition to the types of events, memberships, organizations, products, shows and tickets.
