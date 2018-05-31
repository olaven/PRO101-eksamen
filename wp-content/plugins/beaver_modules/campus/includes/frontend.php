<style>
    .campus{
        text-align: center; 
        margin-top: 20vh; 
        margin-bottom: 20vh; 
    }
    .campus article h2{
        font-size: 2em;
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
    .campus-navigation > div:hover{
        border-bottom: solid 1px; 
    }
    .campus-info article{
        display: none; 
        margin-top: 5vh; 
        margin-left: 1.5vw; 
    }
</style>
    
<script>
    window.onload = () => {
        let buttons = document.getElementsByClassName("campus-menu-button"); 
        

        for(button of buttons){
            button.onclick = (event) => {
                //strek under riktig knapp 
                for(button of buttons){
                    if(button == event.target){
                        button.style.borderBottom = "solid 1px"; 
                    } else {
                        button.style.borderBottom = "none"; 
                    }
                }
                //vis riktig 
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
    <article>
        <h2>
            <?php echo $settings->navn; ?>
        </h2>
        <nav class="campus-navigation">
            <div class="campus-menu-button campus-contact-button">Kontakt</div>
            <div class="campus-menu-button campus-times-button">Åpningstider</div>
            <div class="campus-menu-button campus-cantine-button">Kantine</div>
            <div class="campus-menu-button campus-tips-button">Tips</div>
        </nav>
        <section class="campus-info">
            <article id="campus-contact" class="articles">
                <?php
                    echo "<hr>"; 
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
            <article id="campus-tips" class="articles">
                <h2>TIPS FRA OSS!</h2>
                <?php                 echo strtolower($settings->navn); ?> 
                <?php 
                // the query
                $wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'tag'=>strtolower($settings->navn), 'posts_per_page'=>-1)); ?>
                
                <?php if ( $wpb_all_query->have_posts() ) : ?>
                
                <ul>
                
                    <!-- the loop -->
                    <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
                        <h4><?php the_title(); ?></h4>
                        <p><?php the_content(); ?></p>

                    <?php endwhile; ?>
                    <!-- end of the loop -->
                
                </ul>
                
                    <?php wp_reset_postdata(); ?>
                
                <?php else : ?>
                    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
                <?php endif; ?>
            </article>
        </section>
    </article>
</div>
