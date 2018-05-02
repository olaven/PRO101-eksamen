
<div class="campus">
    <img src="<?php echo $settings->bilde_src; ?>" />
    <?php echo $settings->navn; ?>
    <br/>
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
    <br/>
    <button onClick="alert('ikke implementert -@olaven')">Vis veien</button> 
    <hr>
</div>

