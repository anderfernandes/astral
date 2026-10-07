# Astral

## Open Source CRM and POS for Planetariums, Museums and Science Centers

### About

Astral will be a system that will allow non-profit organizations (such as Planetariums, Science Theaters, Science Centers and Museums) to have a database of shows, create events, sell tickets for those events and report sales. The system at first will not process payments online. It requires your organization to have a credit card machine. It is being currently developed by Anderson Fernandes. If you would like to contact me about this project, my Twitter is @anderfernandes1.

### Setup

Build image:

```
docker build -t astral:dev .
```

Run the container with `docker compose up -d`.

#### SQLite

Create and seed the database with:

```
docker exec --user www-data astral php artisan migrate:fresh --seed
```

Ensure that the database file can be written by the container's `www-data` user:

```
docker exec astral chown www-data:www-data database/database.sqlite
```

If running in a container, you may set `DB_DATABASE` in `.env` to run the database from a different path of the host machine.

### License

Astral is licensed under the MIT license.
