<html>
    <head></head>
    <body>
        <?php 
            function say($message){
                echo "<p>$message</p>"; 
            }
        ?> 
        <?php
            $arr = Array("Hei", "Nei", "Okei"); 
            foreach($arr as $item)
            {
                echo "<h2>$item</h2>";
                echo say("Okei");  
            } 
        ?>
        
    </body>
</html>