<style>
    .campus img, .campus article{
        width: 100%;
    }
    .campus article h2{
        font-size: 2em;
    }
    /*desktop*/
    @media only screen and (min-width : 1224px) {
        .campus img{
            float: left; 
            width: 60%;
        }
        .campus article{
            float: right; 
            width: 40%;
        }
    }
    .campus-navigation{
        display: flex; 
        width: 100%;
    }
    .campus-navigation > div{
        width: 100%; 
        border-style: solid;
        border-color: white;
        color: black;
    }
    .campus-info article{
        position: absolute; 
        display: none; 
        margin-top: 2vh; 
        margin-left: 1.5vw; 
    }
</style>
    
<script>
    window.onload = () => {
        let buttons = document.getElementsByClassName("campus-menu-button"); 
        

        for(button of buttons){
            button.onclick = (event) => {
                let identifier = event.target.className.split(" ")[1].split("-button")[0];
                let articles = document.getElementsByClassName("articles");
                for(article of articles){
                    if(article.id === identifier){
                        article.style.display = "block"; 
                    } else {
                        article.style.display = "none"; 
                    }
                }
            }
        }
    }
</script>
<div class="campus">
    <img src="<?php echo $settings->bilde_src; ?>" />
    <article>
        <h2>
            <?php echo $settings->navn; ?>
        </h2>
        <nav class="campus-navigation">
            <div class="campus-menu-button campus-contact-button">Kontakt</div>
            <div class="campus-menu-button campus-times-button">Åpningstider</div>
            <div class="campus-menu-button campus-cantine-button">Kantine</div>
        </nav>
        <section class="campus-info">
            <article id="campus-contact" class="articles">
                <?php
                    echo $settings->kontakt_telefon;
                    echo "<br/>"; 
                    echo $settings->kontakt_epost;  
                ?> 
                <h4>Du er alltid velkommen</h4>
            </article>
            <article id="campus-times" class="articles">
                <?php 
                    date_default_timezone_set("Europe/Oslo"); 
                    $current_hour = date("G");
                    $opening_hour = ($settings->apent_fra['day_period'] == "am" ? $settings->apent_fra["hours"] : ($settings->apent_fra["hours"] + 12)); 
                    $closing_hour = ($settings->apent_til['day_period'] == "am" ? $settings->apent_til["hours"] : ($settings->apent_til["hours"] + 12)); 

                    if($current_hour > $opening_hour && $current_hour < $closing_hour){
                        echo "Åpent: <span style='color: green'>JA</span>"; 
                    } else {
                        echo "Åpent: <span style='color: red'>NEI</span>"; 
                    }
                ?>
                <?php 
                    echo "</br>"; 
                    echo $settings->apent_fra["hours"] . ":" . $settings->apent_fra["minutes"]; 
                    echo " - "; 
                    echo $settings->apent_til["hours"] . ":" . $settings->apent_til["minutes"]
                ?> 
            </article>
            <article id="campus-cantine" class="articles">
                <h4>Info</h4>
                <?php 
                    echo $settings->info_kantine; 
                ?> 
                <h4>Åpningstider</h4>
                <?php 
                    echo "</br>"; 
                    echo $settings->apent_fra_kantine["hours"] . ":" . $settings->apent_fra_kanine["minutes"]; 
                    echo " - "; 
                    echo $settings->apent_til_kantine["hours"] . ":" . $settings->apent_til_kantine["minutes"]
                ?> 
            </article>
        </section>
    </article>
</div>
