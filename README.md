# Notes
Notes er en nettside for å skrive og lagre notater.


## Installasjon
Denne guiden forventer at du allerede har en SQL-løsning. [Dette er en guide for det.](https://www.digitalocean.com/community/tutorials/how-to-install-mariadb-on-ubuntu-22-04)
### Linux:
```
sudo apt update
sudo apt upgrade
sudo apt install apache2
cd /var/www/html
git clone https://github.com/evoea005/notes
```

## Databaser
Det er 2 tables. Den første er user, som har brukerinformasjon som brukernavn og passord. Den andre har notatene, lagret i base64. Alt dette er lagret i `database.sql` Du kan importere dette med `sql mysql -u <username> -p termin < database.sql`
