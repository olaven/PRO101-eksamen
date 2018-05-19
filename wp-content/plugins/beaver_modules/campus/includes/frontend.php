<style>
    .campus img{
        float: left; 
        width: 60%; 
    }
    .campus article{
        float: right; 
        width: 40%; 
    }
    .campus-navigation{
        display: flex; 
        width: 100%; 
    }
    .campus-navigation > a{
        width: 100%; 
        border-style: solid;
    }
    .campus-info article:target{
        visibility: visible; 
    }
    .campus-info article{
        position: absolute; 
        background-color: red; 
        visibility: hidden;
    }
    
</style>
<div class="campus">
    <img src="<?php echo $settings->bilde_src; ?>" />
    <article>
        <h2>
            <?php echo $settings->navn; ?>
        </h2>
        <nav class="campus-navigation">
            <a href="#campus-contact">Kontakt</a>
            <a href="#campus-times">Åpningsider</a>
            <a href="#campus-cantine">Kantine</a>
        </nav>
        <section class="campus-info">
            <article id="campus-contact">
                Kontakt
            </article>
            <article id="campus-times">
                Times
            </article>
            <article id="campus-cantine">
                Kantine
            </article>
        </section>
    </article>
</div>
<?php 
            date_default_timezone_set("Europe/Oslo"); 
            $current_hour = date("G");
            $opening_hour = ($settings->apent_fra['day_period'] == "am" ? $settings->apent_fra["hours"] : ($settings->apent_fra["hours"] + 12)); 
            $closing_hour = ($settings->apent_til['day_period'] == "am" ? $settings->apent_til["hours"] : ($settings->apent_til["hours"] + 12)); 

            if($current_hour > $opening_hour && $current_hour < $closing_hour){
                echo "Åpent: JA"; 
            } else {
                echo "Åpent: NEI"; 
            }
        ?>
