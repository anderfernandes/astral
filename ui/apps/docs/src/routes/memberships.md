# Memberships

Astral is a great way to manage memberhsips of planetariums, museums and science centers.

Memberships start the beginning of the day they are purchased and end at the beginning of the next day of their duration.

Before a user can take advantage of any membership perks, Astral checks if a membership is active, which means, the end date is not greater than the current date.

## Setup

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

## New Memberships

Any user who is not a member yet can be made a member by going through the membership wizard.

The main member in a membership is called the _primary_. Dependants on the membership (if alloweds) are called _secondaries_.

## Renewing Memberships Before Expiration

The remaining days will be added to the number of days of the new membership if the membership type is checked to _keep reamining days_. If not, the renewed membership will be starting from the beginning of the day it is purchased.

## Renewing Memberships After Expiration

In such case, memberships will follow the case mentioned in **New Memberships**.
