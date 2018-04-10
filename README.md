# Eksamen - PRO101

EKsamensprosjektet skal startes på i løpet av mai.

## Om wordpress-installasjon 
* Si ifra så fort som mulig om noe i guiden er feil! Blir rot på hele prosjektet.. -@olaven
* Alle bruker sin egen, lokale installasjon av Wordpress/Bitnami. 
* Kun mappen ```apps/apps/wordpress/htdocs/wp-content``` skal deles
Prosessen for å få dette til å fungere er litt kronglete, men here we go: 
  1. Ta en midlertidig backup av ```apps/apps/wordpress/htdocs``` (Det gjorde ikke jeg, erfaring snakker) 
  2. Åpne terminalen og ```cd``` til ```apps/apps/wordpress/``` (hos meg: ```/Applications/wordpress-4.9.4-1/apps```) 
  3. Klon GitHub-repo hit. (```git clone https://github.com/olaven/PRO101-eksamen.git ```)
  4. Flytt alt i ```wordpress/htdocs``` __unntatt wp-content__ til ```wordpress/PRO101-eksamen```
  5. Slett ```wordpress/htdocs```
  6. Endre navn på GitHub-repo til 'htdocs'. (```mv PRO101-eksamen htdocs```)
 * Filen .gitignore skal være konfigurert slik at det eneste som pushes fra Wordpress til GitHub er wp-content og index.php.
 * Sjekk at 
  1. Din lokale wordpress-installasjon fungerer
  2. Det eneste som registreres av git er 'wp-content' og 'index.php'. (```git status```) 

## Nødvendige linker

* [Wordpress-themes Getting Started](https://developer.wordpress.org/themes/getting-started/who-should-read-this-handbook/)

### Møter og agendaer

* [Møtedokumentasjon](https://docs.google.com/document/d/1FUXLOJg794F6NIIu2mLVjFSWY7_rolldiPLHSG068us/edit)

### Undersøkelser

* [Spørreundersøkelsen 1](https://docs.google.com/forms/d/15b7D72Gg4rgdub0f1uqU4CA9Ao_-V0SKcULedAaiVB8/edit)
* [Spørreundersøkelse 1 (med endring)](https://docs.google.com/forms/d/1UR7eo3kX0v_yvSnWNsZMbWUsGRVToseopP5vBos-1L8/edit)

### Kommunikasjon

* Github Issues
* [Discord](https://discord.gg/FgPVHz)
* Facebook chat

### Annet nyttig

* [Markdown Cheat Sheet](https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet#links)
* [Grafisk profil Høyskolen Kristiania](http://designmanual.kristiania.no/)
