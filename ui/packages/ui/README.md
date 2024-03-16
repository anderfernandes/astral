# Astral

## Loging in

Users who have an account can enter their credentials: email and password.

Upon login, staff will be redirected to **Astral Admin** or **Astral Cashier** depending on their account's access control rules. Visitors will be redirected back to the main screen where they can see events and purchase tickets and products.

Users who don't have an account must create one. Please read the **Creating an account** section for more information.

## Creating an account

Users can create an account by going to the **login** page and clicling on **Create an account**.

The data Astral asks for to create an account has the following validation rules:

* `First Name` and `Last Name`: required, between 2 and 64 characters
* `Email`: required, between 3 and 64 characters, unique in the database
* `Password`: required, must match the `Password Confirmation` field.

All data must be invalid for the account to be created. 

Newly registered users will receive an account confirmation email and they must click on the link to be able to login.

By default, all new user accounts created are of the Visitor accounts.

## Password Recovery

Users can recover password by clicking **I forgot my password** at the bottom of the login screen.

Users will enter their password and if they have an account, they will receive an email with a link that will redirect them to set up a new password.

Users won't receive an email if they don't have an account.

Upon on clicking on the link they receive in their email, users will be redirected to the password reset screen. The email is already set and they only have to enter and confirm a new password. Upon resetting their email, users will be redirected to the login screen.

Password reset links are valid for 60 minutes.