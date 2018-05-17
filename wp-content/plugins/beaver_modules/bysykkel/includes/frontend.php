<?php include 'requests.php' ?>




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
            } else {
                console.log(this.status); 
            }
        };
        xhttp.open("GET", "wp-content/plugins/beaver_modules/bysykkel/includes/" + type + ".php", true);
        xhttp.send();
    }
</script>

