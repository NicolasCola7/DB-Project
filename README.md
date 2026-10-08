# BoStarter

Piattaforma di **crowdfunding** in cui i creatori pubblicano progetti e gli utenti li finanziano.
Progetto del corso di Basi di Dati, Laurea Triennale in Informatica per il Management, Università di Bologna (2025).

📄 **Relazione completa:** [statics/relazione.pdf](statics/relazione.pdf)

## Cosa abbiamo fatto

- **Progettazione completa del database:** schema ER, ristrutturazione, normalizzazione e schema logico
- **MySQL:** 20 stored procedure, 4 trigger, 3 viste e un evento programmato
- **MongoDB** per la registrazione dei log degli eventi
- **Back-end in PHP** con tre ruoli utente: utente, creatore e amministratore
- Tutto l'ambiente avviabile con **Docker**

## Tecnologie

MySQL · MongoDB · PHP · Docker · Apache · phpMyAdmin

## Come avviarlo

Serve Docker installato. Dalla cartella principale del progetto, copia `.env.example` in `.env` e scegli una password (solo lettere e numeri). Poi:

    docker compose up -d

Al primo avvio, esegui `sql.sql` sul database: dalla scheda *SQL* di phpMyAdmin oppure con un client MySQL su `localhost:3307`.

Poi apri:

- **Applicazione:** http://localhost
- **phpMyAdmin:** http://localhost:9876
- **Mongo Express:** http://localhost:8081

## Gruppo

Matteo Boscherini, Alessandro Campedelli, Nicolas Cola
