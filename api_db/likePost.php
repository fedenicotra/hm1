<?php
    /*
        MELATONINA
        MELATONINA
        MELATONINA
        MELATONINA
        MELATONINA
        MELATONINA
        MELATONINA
        MELATONINA
        MELATONINA
    */

    // body: JSON.stringify({
    //         user_id: login_id.textContent,
    //         lu: "l",
    //         thread: id_th,
    //         n_ordine: buttonlike.dataset.id
    //     })

    header('Content-Type: application/json');
    $PARAMS=json_decode(file_get_contents("php://input"), true);
    if(strlen($PARAMS["lu"]) != 1 || strcmp($PARAMS["lu"], 'l') != 0 && strcmp($PARAMS["lu"], 'u') != 0)
        $_errors[] = "Parameter error: unrecognised request";
    if(!preg_match("/^[0-9]+$/", $PARAMS["user_id"]))
        $_errors[] = "Parameter error: id not a number";
    if(!preg_match("/^[0-9]+$/", $PARAMS["thread"]))
        $_errors[] = "Parameter error: thread not a number";
    if(!preg_match("/^[0-9]+$/", $PARAMS["n_ordine"]))
        $_errors[] = "Parameter error: n_ordine not a number";
    if(isset($_error)){
        echo json_encode($_error);
        die;
    }
    $conn = mysqli_connect(
        "localhost",
        "root",
        "YouShouldRootPass",
        "hm1_1000001861"
    ) or die("Errore: ".mysqli_connect_error());

    $query_post = "SELECT post_id FROM posts WHERE id_th = " . $PARAMS['thread'] . " AND n_ordine = " . $PARAMS['n_ordine'] . ";";

    $res = mysqli_query($conn, $query_post);
    if(mysqli_num_rows($res) == 0){
        $_error[] = "Fatal error on getting post";
        mysqli_close($conn);
        echo json_encode($_error);
        die;
    }

    $id_post = mysqli_fetch_assoc($res)["post_id"];
    
    if(strcmp($PARAMS["lu"], 'l') == 0){
        // LIKE
        $query_like = "INSERT INTO likes(id_acc, post_id) VALUES(" . $PARAMS['user_id'] . ", ".$id_post.");";
        if(!mysqli_query($conn, $query_like)){
            $_error[] = "Fatal error on liking";
            mysqli_close($conn);
            echo json_encode($_error);
            die;
        }
    }else{
        // UNLIKE
        $query_like = "DELETE FROM likes WHERE id_acc = " . $PARAMS['user_id'] . " AND post_id = " . $id_post . ";";
        if(!mysqli_query($conn, $query_like)){
            $_error[] = "Fatal error on unliking";
            mysqli_close($conn);
            echo json_encode($_error);
            die;
        }
    }
    mysqli_close($conn);
    echo json_encode("true");

?>

