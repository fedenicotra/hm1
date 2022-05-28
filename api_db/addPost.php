<?php

  header('Content-Type: application/json');
  $PARAMS=json_decode(file_get_contents("php://input"), true);

  // echo json_encode($test["user_id"]);

  $conn = mysqli_connect(
      "localhost",
      "root",
      "YouShouldRootPass",
      "hm1_1000001861"
  ) or die("Errore: ".mysqli_connect_error());
  $user_id = mysqli_real_escape_string($conn,$PARAMS["user_id"]);
  $content = mysqli_real_escape_string($conn,$PARAMS["content"]);
  $thread = mysqli_real_escape_string($conn,$PARAMS["thread"]);
  if(!preg_match("/^[0-9]+$/", $thread) || !preg_match("/^[0-9]+$/", $user_id)){
    mysqli_close($conn);
    echo json_encode($thread);
    die;
  }
  
  $query_ordine = "SELECT max(n_ordine) as Lst FROM posts WHERE id_th = $thread";
  $res = mysqli_query($conn, $query_ordine);
  $lastN = mysqli_fetch_assoc($res)["Lst"];

  mysqli_free_result($res);
  /////////
  $newN = intval($lastN) + 1;
  /////////
  $insert = "INSERT INTO posts(post_id, id_autore, id_th, n_ordine, data_creazione, contenuto, likes) VALUES(NULL, $user_id, $thread, $newN, CURDATE(), '$content', 0);";

  mysqli_query($conn, $insert);

  $queryCheck = " SELECT contenuto, likes, n_ordine, data_creazione, username FROM posts P JOIN account A on id_autore = id_acc
                  WHERE id_th = $thread
                  AND n_ordine = $newN ";

  $res = mysqli_query($conn, $queryCheck);
  $ret = mysqli_fetch_assoc($res);
  echo json_encode($ret);
 ?>
