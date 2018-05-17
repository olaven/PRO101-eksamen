<?php 
    echo getBysykkel('https://oslobysykkel.no/api/v1/stations', 'a16d4b4514e7fe7adaf1522b2843b26f'); 
?>

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
        
        echo json_encode($result);

        curl_close ($ch);
        

        //HER ER ALLE STASJONER 
        return $result; 
    }
?> 