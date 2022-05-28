<?php
    if(!isset($_GET["q"])){
        echo json_encode(array('error' => "not set"));
        die;
    }
    
    if(preg_match("/^\s*$/", $_GET["q"])){
        $return = array("Lenght" => 0);
        echo json_encode($return);
        die;
    }

    $conn = mysqli_connect(
        "localhost",
        "root",
        "YouShouldRootPass",
        "hm1_1000001861"
    ) or die("Errore: ".mysqli_connect_error());
    
    $search = mysqli_real_escape_string($conn, $_GET["q"]);
    $query = "  SELECT T.id_th as ID, titolo, contenuto
                  FROM thread T join
                (
                    SELECT P.id_th as id_th, P.contenuto as contenuto
                      FROM posts P
                     WHERE P.n_ordine = 0
                ) as S ON S.id_th = T.id_th
                 WHERE T.titolo like '%$search%'
                    OR S.contenuto like '%$search%';";
    
    $res = mysqli_query($conn, $query);
    $len = mysqli_num_rows($res);
    $return = array("Lenght" => "$len");

    if($len == 0){
        mysqli_free_result($res);
        mysqli_close($conn);
        echo json_encode($return);
        die;
    }

    while($row = mysqli_fetch_assoc($res))
    {   
        $threads[] = $row;
    }

    $return["Threads"] = $threads;
    mysqli_free_result($res);
    mysqli_close($conn);
    echo json_encode($return);
?>