<?php include 'requests.php' ?>


<h1>Alle stasjoners koordinater</h1>
<!-- Hente alle stasjoner --> 
<?php 
    getBysykkel('https://oslobysykkel.no/api/v1/stations', 'a16d4b4514e7fe7adaf1522b2843b26f'); 
?> 

<h1>Antall ledige ved hver stasjon!</h1>
<!-- Hente antall tilgjengelige sykler på hver stasjon-->
<?php 
    getBysykkel('https://oslobysykkel.no/api/v1/stations/availability', 'a16d4b4514e7fe7adaf1522b2843b26f'); 
?> 





