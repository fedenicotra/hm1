<?php
    $conn = mysqli_connect(
        "localhost",
        "root",
        "YouShouldRootPass",
        "hm1_1000001861"
    ) or die("Errore: ".mysqli_connect_error());
    $user = mysqli_real_escape_string($conn, $_GET["username"]);
    $query = "SELECT username FROM account WHERE username = '$user'";
    $res = mysqli_query($conn,$query);
    $userret = array();
    while($row = mysqli_fetch_assoc($res))
    {
        $userret[] = $row;
    }
    mysqli_free_result($res);
    mysqli_close($conn);
    echo json_encode($userret);
?>