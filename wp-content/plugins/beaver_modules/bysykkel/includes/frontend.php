<?php include 'requests.php' ?>

<style>
    body,
    html {
        position: absolute;
        width: 100%;
        overflow-y: hidden;
        top: 0;
        bottom: 0;
    }

    #container {
        display: flex;
        justify-content: center;
        overflow: hidden;
    }

    #left-element {
        display: inline-block;
        width: 10em;
        margin-right: 5em;
    }

    #right-element {

        display: inline-block;
        margin-bottom: auto;
        width: 100%;
    }


    #right-panel {
        position: relative;
        font-family: 'Roboto', 'sans-serif';
        font-size: 12px;
        max-height: 20vh;
        width: 10em;
        display: none;
        overflow: scroll;
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
    let getBysykkelJS = (type, callback) => 
    {
        //sjekk om parameter er valid 
        if(['stations', 'availability'].indexOf(type) === -1)
        {
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


<script>
    function initMap() {
        var pos;
        var map;
        var infowindow;
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var markers = [];
        var marker = new google.maps.Marker();
        var oslo = {
            lat: 59.915997,
            lng: 10.760110
        };

        map = new google.maps.Map(document.getElementById('map'), {
            center: oslo,
            zoom: 15
        });




        google.maps.event.addDomListener(document.getElementById('posisjon'), 'click', function(evt) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
            document.getElementById('mode').style.display = "block";
            document.getElementById('hide').style.display = "block";
            document.getElementById('right-panel').style.display = "initial";
            infoWindow = new google.maps.InfoWindow;
            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    infoWindow.setPosition(pos);
                    map.setCenter(pos);


                    directionsDisplay.setMap(map);
                    directionsDisplay.setPanel(document.getElementById('right-panel'));
                    directionsDisplay.getPanel().style.height = "5px";

                    directionsService.route({
                        origin: pos,
                        destination: oslo,
                        travelMode: google.maps.TravelMode["DRIVING"]
                    }, function(response, status) {
                        if (status === 'OK') {
                            directionsDisplay.setDirections(response);
                        } else {
                            window.alert('Directions request failed due to ' + status);
                        }
                    });
                    document.getElementById('mode').addEventListener('change', function() {
                        var selectedMode = document.getElementById('mode').value;
                        directionsService.route({
                            origin: pos,
                            destination: oslo,
                            travelMode: google.maps.TravelMode[selectedMode]
                        }, function(response, status) {
                            if (status === 'OK') {
                                directionsDisplay.setDirections(response);
                            } else {
                                window.alert('Directions request failed due to ' + status);
                            }
                        });
                    })
                })
            }
        });
        google.maps.event.addDomListener(document.getElementById('hide'), 'click', function(evt) {
            document.getElementById('right-panel').style.display = "none";
            document.getElementById('mode').style.display = "none";
            document.getElementById('hide').style.display = "none";

            infowindow = new google.maps.InfoWindow();
            var service = new google.maps.places.PlacesService(map);
            directionsDisplay.setMap();
            map.setZoom(14);
            map.setCenter(oslo);
        });


        google.maps.event.addDomListener(document.getElementById('butikk'), 'click', function(evt) {
            document.getElementById('right-panel').style.display = "none";
            document.getElementById('mode').style.display = "none";
            infowindow = new google.maps.InfoWindow();
            var service = new google.maps.places.PlacesService(map);
            directionsDisplay.setMap();
            map.setZoom(14);
            map.setCenter(oslo);
            service.nearbySearch({
                location: oslo,
                radius: 500,
                type: ['store']
            }, callback)

        });

        google.maps.event.addDomListener(document.getElementById('trening'), 'click', function(evt) {

            infowindow = new google.maps.InfoWindow();
            var service = new google.maps.places.PlacesService(map);
            directionsDisplay.set('directions', null);
            map.setZoom(14);
            map.setCenter(oslo);
            service.nearbySearch({
                location: oslo,
                radius: 500,
                type: ['gym']
            }, callback)
        });

        google.maps.event.addDomListener(document.getElementById('bike'), 'click', function(evt) {
            infowindow = new google.maps.InfoWindow();
            var service = new google.maps.places.PlacesService(map);
            directionsDisplay.setMap();
            map.setZoom(14);
            map.setCenter(oslo);
            //Prøve å legge markers med en array, prøve å få til en JSON hvis du kan
            getBysykkelJS("stations", (response) => {
                infowindow = new google.maps.InfoWindow();

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
                        map : map, 
                        position : position, 
                        animation : google.maps.Animation.DROP
                    });
                    console.log(position); 

                    marker.setMap(map); 
                }
                
            })
        });


        function createMarker(place) {
            var placeLoc = place.geometry.location;
            var marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location,
                draggable: true,
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
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(null);
                }
                markers = [];
                for (var i = 0; i < results.length; i++) {
                    createMarker(results[i]);
                }
            }
        }
        var markerCampus = new google.maps.Marker({
            map: map,
            position: oslo,
            draggable: true,
            animation: google.maps.Animation.DROP,
        });
        
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }
</script>

<body scroll="no">
    <div id="container">

        <div id="left-element">

            <button type="button" id="posisjon">Vis veien</button>
            <button type="button" id="hide" style="display:none">Skjul</button>
            <div id="right-panel">
                <select id="mode" style="display:none">
                <option value="DRIVING">Driving</option>
                <option value="WALKING">Walking</option>
                <option value="BICYCLING">Bicycling</option>
                <option value="TRANSIT">Transit</option>
            </select>
            </div>


            <button type="button" id="butikk">Nærbutikker</button>

            <button type="button" id="trening">Trening</button>
            <button type="button" id="bike">Bysykkel</button>

        </div>

        <div id="right-element">
            <div id="map" style="height:500px;"></div>
        </div>
    </div>



<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoaG4FMY_Iwo0xS2aQIp8sb6eGp7RnVT0&libraries=places&callback=initMap" />

</body>

