# BoStarter

A **crowdfunding** platform where creators publish projects and users fund them.
Project for the Databases course, BSc in Computer Science for Management, University of Bologna (2025).

**Full report (in Italian):** [statics/relazione.pdf](statics/relazione.pdf)

## What we built

- **Complete database design:** ER model, restructuring, normalisation and logical schema
- **MySQL:** 20 stored procedures, 4 triggers, 3 views and a scheduled event
- **MongoDB** for event logging
- **PHP back end** with three user roles: user, creator and administrator
- The whole environment runs with **Docker**

## Technologies

MySQL · MongoDB · PHP · Docker · Apache · phpMyAdmin

## How to run it

You need Docker installed. From the project's main folder, copy `.env.example` to `.env` and choose a password (letters and numbers only). Then:

    docker compose up -d

On the first run, execute `sql.sql` on the database: from the *SQL* tab in phpMyAdmin, or with a MySQL client on `localhost:3307`.

Then open:

- **Application:** http://localhost
- **phpMyAdmin:** http://localhost:9876
- **Mongo Express:** http://localhost:8081

## Team

Matteo Boscherini, Alessandro Campedelli, Nicolas Cola
