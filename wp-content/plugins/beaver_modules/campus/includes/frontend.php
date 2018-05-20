<style>
    .campus img, .campus article{
        width: 100%;
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
    .campus-navigation > a{
        width: 100%; 
        border-style: solid;
        border-color: white;
        color: black;
    }
    .campus-info article:target{
        visibility: visible;
    }
    .campus-info article{
        position: absolute; 
        visibility: hidden;
    }
</style>
    
<script>
    window.onload = () => {
        let buttons = document.getElementsByClassName("campus-menu-button"); 
        for(button of buttons){
            button.onclick = (event) => {
                let identifier = event.target.href; 
                for(button of buttons){
                    if(button.href === identifier){
                        button.style.transform = "scaleY(1.4)";
                    } else {
                        button.style.transform = "scaleY(1)";
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
            <a href="#campus-contact" class="campus-menu-button">Kontakt</a>
            <a href="#campus-times" class="campus-menu-button">Åpningstider</a>
            <a href="#campus-cantine" class="campus-menu-button">Kantine</a>
        </nav>
        <section class="campus-info">
            <article id="campus-contact">
                <?php
                    echo $settings->kontakt_telefon;
                    echo "<br/>"; 
                    echo $settings->kontakt_epost;  
                ?> 
                <h4>Du er alltid velkommen</h4>
            </article>
            <article id="campus-times">
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
            <article id="campus-cantine">
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
