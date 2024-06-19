# Installatie Instructies

### Voorbereidingen

Zorg ervoor dat PHP, Composer, en NodeJs correct geinstalleerd en geconfigureerd zijn
Alleen voor PHP is de sqlite extensie nodig.

1. Download de bestanden
2. Pak het bestand uit en open een terminal window in de folder van het project
3. Type dit in volgorde uit: `composer install` `npm install`.
4. Als dit succesvol is gebeurt (wat wel wordt verwacht aangezien dit het volledige project is met alle componenten) is alleen deze command nodig om de geuploadde images op de juiste plek te zetten: `php artisan storage:link`
5. Nu kan het project gestart worden met `php artisan serve` & `npm run dev`

> Als de database mist dan is het nodig om in de database folder een bestand genaamd `database.sqlite` aan te maken en daarna `php artisan migrate`. maar dit is alleen bij uitzondering als de database niet beschikbaar is.

## Online mogelijkheden

Er is geprobeerd om de applicatie online te zetten, zonder succes.
De applicatie werkt wel qua inloggen alleen laden de componenten van Vue.js niet dus is de applicatie niet bruikbaar online.

Met deze website was de bedoeling dat het omgebouwd zou worden naar een Progressive Web App, alleen zonder een applicatie die online draait is dit niet mogelijk.
[pwabuilder.com](https://www.pwabuilder.com)

Ook aangezien de applicatie niet goed kon werken op een niet beveiligde connectie werd het steeds lastiger om dit doel te bereiken
[webpagina](http://stadsjutters.atwebpages.com)
