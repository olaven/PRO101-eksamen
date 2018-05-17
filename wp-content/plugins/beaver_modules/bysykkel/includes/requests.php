<?php 
    function getBysykkel($url, $identifier)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        $headers = [
            'Client-Identifier: ' . $identifier 
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec ($ch);

        curl_close ($ch);

        //HER ER ALLE STASJONER 
        echo $result; 
    }
?> 