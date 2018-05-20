<?php include 'requests.php' ?>

<html>

<head>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoaG4FMY_Iwo0xS2aQIp8sb6eGp7RnVT0&libraries=places&callback=initMap"></script>
    <style>
        body,
        html {
            position: absolute;
            width: 100%;
            overflow-y: hidden;
            top: 0;
            bottom: 0;
        }

        #left-element {
            display: inline-block;
        }

        #map {
            height: 50vh;
            background-color: rgb(229, 227, 223);
        }


        #infoPanel {
            position: relative;
            font-family: 'Roboto', 'sans-serif';
            font-size: 12px;
            max-height: 20vh;
            width: 10em;
            display: none;
            overflow: scroll;
        }

        button,
        select {
            position: relative;
            z-index: 99;
        }

    </style>




    <script>
        /*
                                        type -> hva du vil hente
                                        callback -> funksjonen som skal kjøres (respons blir sendt som parameter)

                                        ex. 
                                        getBysykkelJS("station", (response) => {
                                            //gjør det du vil med response her 
                                            console.log(response); 
                                        })
                                    */
        let getBysykkelJS = (type, callback) => {
            //sjekk om parameter er valid 
            if (['stations', 'availability'].indexOf(type) === -1) {
                throw "Du kan bare hente 'stations' eller 'availability'";
            }

            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    callback(this.responseText);
                }
            };
            xhttp.open("GET", "wp-content/plugins/beaver_modules/bysykkel/includes/" + type + ".php", true);
            xhttp.send();
        }

    </script>

</head>
<script>
    var map;
    var oslo = {
        lat: 59.915997,
        lng: 10.760110
    };





    function initMap() {
        var pos;

        var infowindow;
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var markers = [];
        var marker = new google.maps.Marker();

        map = new google.maps.Map(document.getElementById('map'), {
            center: oslo,
            zoom: 15
        });
        var Butikk = document.createElement('button');
        var Trening = document.createElement('button');
        var Sykkel = document.createElement('button');

        Butikk.setAttribute("id", "butikk");
        Trening.setAttribute("id", "trening");
        Sykkel.setAttribute("id", "sykkel");
        var createButikk = new butikk(Butikk, map);
        var createTrening = new trening(Trening, map);
        var createSykkel = new sykkel(Sykkel, map);



        Butikk.index = 1;
        Trening.index = 1;
        Sykkel.index = 1;
        map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(Butikk);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(Trening);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(Sykkel);

        function butikk(controlDiv, map) {
            // Set CSS for the control border.
            var controlUI = document.createElement('div');
            controlUI.style.backgroundColor = '#fff';
            controlDiv.appendChild(controlUI);
            // Set CSS for the control interior.
            var controlText = document.createElement('div');
            controlText.style.color = 'rgb(25,25,25)';
            controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
            controlText.innerHTML = 'Butikk';
            controlUI.appendChild(controlText);
            // Setup the click event listeners: simply set the map to Chicago.
            controlUI.addEventListener('click', function() {
                console.log("hei"); 
                //document.getElementById('right-panel').style.display = "none";
                //document.getElementById('mode').style.display = "none";
                infowindow = new google.maps.InfoWindow();
                var service = new google.maps.places.PlacesService(map);
                directionsDisplay.setMap();
                map.setZoom(14);
                map.setCenter(oslo);
                service.nearbySearch({
                    location: oslo,
                    radius: 500,
                    type: ['butikk']
                }, callback)
            });

        }

        function trening(controlDiv, map) {
            // Set CSS for the control border.
            var controlUI = document.createElement('div');
            controlUI.style.backgroundColor = '#fff';
            controlDiv.appendChild(controlUI);
            // Set CSS for the control interior.
            var controlText = document.createElement('div');
            controlText.style.color = 'rgb(25,25,25)';
            controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
            controlText.innerHTML = 'Trening';
            controlUI.appendChild(controlText);
            // Setup the click event listeners: simply set the map to Chicago.
            controlUI.addEventListener('click', function() {
                //document.getElementById('right-panel').style.display = "none";
                //document.getElementById('mode').style.display = "none";
                infowindow = new google.maps.InfoWindow();
                var service = new google.maps.places.PlacesService(map);
                directionsDisplay.setMap();
                map.setZoom(14);
                map.setCenter(oslo);
                service.nearbySearch({
                    location: oslo,
                    radius: 500,
                    type: ['gym']
                }, callback)
            });

        }

        function sykkel(controlDiv, map) {

            var controlUI = document.createElement('div');
            controlUI.style.backgroundColor = '#fff';
            controlDiv.appendChild(controlUI);
            // Set CSS for the control interior.
            var controlText = document.createElement('div');
            controlText.style.color = 'rgb(25,25,25)';
            controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
            controlText.innerHTML = 'Bysykkel';
            controlUI.appendChild(controlText);

            controlUI.addEventListener('click', function() {
                infowindow = new google.maps.InfoWindow();
                var service = new google.maps.places.PlacesService(map);
                directionsDisplay.setMap();
                map.setZoom(14);
                map.setCenter(oslo);
                removeMarkers();
                //Prøve å legge markers med en array, prøve å få til en JSON hvis du kan
                getBysykkelJS("stations", (response) => {
                    //'1' på slutten av reponse.. aner ikke hvorfor. Fjerner. 
                    response = response.substring(0, response.length - 3);
                    //gjør om til JS-objekt
                    response = JSON.parse(response);
                    //loop gjennom og legg til på kart            
                    for (station of response.stations) {
                        let position = {
                            lat: station.center.latitude,
                            lng: station.center.longitude
                        };

                        let marker = new google.maps.Marker({
                            map: map,
                            position: position,
                            animation: google.maps.Animation.DROP,
                            icon: 'images/ikoner/bike.png'
                        });

                        markers.push(marker);
                    }
                    displayMarkers();
                })
            });

        }

        function createMarker(place) {
            var placeLoc = place.geometry.location;
            var marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location,
                animation: google.maps.Animation.DROP,
            });
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.setContent(place.name);
                infowindow.open(map, this);
            });
            markers.push(marker);
        }

        function callback(results, status) {
            if (status == google.maps.places.PlacesServiceStatus.OK) {
                removeMarkers();
                for (var i = 0; i < results.length; i++) {
                    createMarker(results[i]);
                }
            }
        }
        var markerCampus = new google.maps.Marker({
            map: map,
            position: oslo,
            animation: google.maps.Animation.DROP,
        });

        /*
            Fjerner markers på kartet
        */
        function removeMarkers() {
            for (let i in markers) {
                markers[i].setMap(null);
            }
            //fjerner ubrukte markers 
            markers = [];
        }
        /*
            Viser markers som er i markers-arrayet 
        */
        function displayMarkers() {
            for (let marker of markers) {
                marker.setMap(map);
            }
        }


    }


    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }

</script>

<body>
    <div id="map"></div>
    <!--<button type="button" id="posisjon">Vis veien</button>
            <button type="button" id="hide" style="display:none">Skjul</button>
            <div id="infoPanel">
                <select id="mode" style="display:none">
                <option value="DRIVING">Driving</option>
                <option value="WALKING">Walking</option>
                <option value="BICYCLING">Bicycling</option>
                <option value="TRANSIT">Transit</option>
            </select>
            </div>-->


</body>

</html>
