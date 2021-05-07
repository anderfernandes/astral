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

Inspire people of all ages by teaching them science in your non-profit science center. Astral is an open source point of sale (POS), customer relationship manager (CRM), box office, membership, marketing and reservation manager for non-profit educational organizations such as planetariums, museums and science centers. It will allow your organization to:

- Sell tickets
- Generate sale, attendance and revenue reports
- Manage events, shows, products, sales, members, users, organizations and work shifts
- Schedule and manage school field trips, birthday parties, special events, civic events, etc, with automated email and/or in app notifications
- Calendar view with past, present and future events/sales
- Send automated marketing emails such as newsletters, reminders and alerts to members, teachers and visitors
- Process credit card payments online

If your organization has Astral, it can be installed (PWA) or run straight from modern browsers in smartphones, tablets, PC, MacOS or Linux.

If you work in a non-profit planetarium, museum or science center and are struggling to find the right app to help you run things, Astral is what you are looking for.

<hr />

## Docker

Build image:

```
docker build -t anderfernandes/astral:1.0.0-beta.0 .
```

Run container:

```
docker compose up
```

This image should be used only for development. It runs on a single container
with Arch Linux, nginx, SQLite 3 and PHP 8.

<hr />

## Running Tests

```
php artisan test
```

<hr />

## Learning Astral

Astral has an extensive and thorough [documentation](https://astral.anderfernandes.com/docs).

The master repository constains the code to the latest alpha pre-release. Documentation for the beta release will be worked on as we develop them.

<hr />

## Astral Users

We would like to extend our thanks to the following organizations for their feedback on Astral. They have adoped us since alpha and couldn't be happier with the results.

- [Mayborn Science Theater](http://www.starsatnight.org)
- [Scobee Education Center](https://http://sacscobee.org)

<hr />

## Contributing

Thank you for considering contributing to Astral! We are not planning on taking any pull requests at this moment.

<hr />

## Code of Conduct

Please be corteous to other users and the dev team.

<hr />

## License

Astral is free and open-source, and is licensed under the [MIT license](https://opensource.org/licenses/MIT).

<hr />

## Creator

Astral is an idea and creation of [Anderson Fernandes](https://anderfernandes.com).

<hr />

## Thanks

I would like to thank my mother for keeping me company and encouraging me when I first started this project. Fred Chavez, Clifford Bailey, Prof. Chad Burrows, Prof. Matt Lyles, Killian Brooks, David Cantwell, Donald Hubbs, Daniel Kahn, Anjelicca Spruce, Hayley Howard and Desiree Bates helped me with ideas and reporting bugs. Last but not least, extended thanks to my best friend Dani, his sister Che, Chachis, Thomas, Mauri and their families for pretty much adopting me along with Choko, Diego, Javier, Sandro, Adriana, Z, Yoli and Abuela for always treating me like family.