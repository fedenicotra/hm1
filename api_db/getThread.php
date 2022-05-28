<?php
    if(!isset($_GET["thread"])){
        echo json_encode(array('error' => "not set" ));
        die;
    }
    
    $id_th = (int)$_GET["thread"];
    //id_th sarà 0 se la get[thread] non sarà un intero. Fortunatamente non può essere presente
    //un thread con id 0 grazie a come il database è stato gestito

    if($id_th == 0){
        echo json_encode(array('error' => "invalid format" ));
        die;
    }
    
    $conn = mysqli_connect(
        "localhost",
        "root",
        "YouShouldRootPass",
        "hm1_1000001861"
    ) or die("Errore: ".mysqli_connect_error());

    $querytitle = "SELECT titolo FROM thread WHERE id_th = $id_th";
    $queryposts = " SELECT P.n_ordine, A.username, P.data_creazione, P.contenuto, P.likes
                    FROM posts P JOIN account A ON A.id_acc = P.id_autore
                    WHERE id_th = $id_th
                    ORDER BY P.n_ordine;";
    $res = mysqli_query($conn, $querytitle);
    if(mysqli_num_rows($res) == 0){
        echo json_encode(array('error' => "Thread not found" ));
        mysqli_close($conn);
        die;
    }
    $return[] = mysqli_fetch_assoc($res)["titolo"];
    mysqli_free_result($res);

    $res = mysqli_query($conn, $queryposts);
    $sp_id   = "b6f246a23345403b983728abf9228d4b";
	$sp_scrt = "f1fed0810faa4a1d9007221c37a695d9";
    $spoty = [];
    $n_post = 0;
    while($row = mysqli_fetch_assoc($res))
    {   
        $spoty_row = [];
        $exp = explode("https://open.spotify.com/track/", $row["contenuto"]);
        for($i = 1; $i < count($exp); $i++){
            $id = substr($exp[$i], 0, 22);
            if(strlen($id) != 22) continue;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "https://accounts.spotify.com/api/token");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.base64_encode($sp_id.':'.$sp_scrt)));
            $result = curl_exec($curl);
            curl_close($curl);
            $token = json_decode($result)->access_token;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "https://api.spotify.com/v1/tracks/".$id);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Accept: application/json", "Content-Type: application/json", "Authorization: Bearer ". $token));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $ret = json_decode(curl_exec($curl));
            curl_close($curl);

            // print_r($ret);

            // $element["artists"] = $ret->artists;
            if($ret == null || !isset($ret->artists[0]->name)) continue;
            $art = $ret->artists;
            $element["artists"] = $art[0]->name;
            for($j = 1; $j < count($art); $j++){
                $element["artists"] = $element["artists"] . ', ' . $art[$j]->name;
            }
            $element["titolo"] = $ret->name;
            $element["link"] = $ret->external_urls->spotify;
            $spoty_row[$i] = $element;
        }
        
        $spoty[] = $spoty_row;
        //print_r($spoty);
        $posts[] = $row;
        $n_post++;
    }

    mysqli_free_result($res);

    $return[] = $posts;
    $return[] = $spoty;
    mysqli_close($conn);

    // print_r($return);
    echo json_encode($return);
?>