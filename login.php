<?php
    session_start();
    if(isset($_POST["email"]) && isset($_POST["pwd"])){

        if(strlen($_POST["pwd"]) > 256){
            $_error = "Password troppo lunga";
        }

        if(strlen($_POST["email"]) > 256){
            $_error = "Email troppo lunga";
        }

        if(!isset($_error)){
            $conn = mysqli_connect(
                "localhost",
                "root",
                "YouShouldRootPass",
                "hm1_1000001861"
            ) or die("Errore: ".mysqli_connect_error());
            if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $_error = "Formato email non valido";
                return;
            }
            $email = mysqli_real_escape_string($conn,$_POST["email"]);
            $pwd = mysqli_real_escape_string($conn,$_POST["pwd"]);
            $query = "SELECT * FROM account WHERE email = '$email';";
            $res = mysqli_query($conn,$query);
            
            if(mysqli_num_rows($res) == 0){
                $_error = "Credenziali errate";
            }else{
                $row = mysqli_fetch_assoc($res);
                if(!password_verify($pwd, $row["hashed_p"])){
                    $_error = "Credenziali errate";
                }else{
                    $_SESSION["username"] = $row["username"];
                    $_SESSION["id"] = $row["id_acc"];
                    $d = date('Y-m-d H:i:s', time());
                    $update = "UPDATE Account SET last_access = '$d' WHERE email = '$email';";
                    mysqli_free_result($res);
                    mysqli_query($conn,$update);
                    mysqli_close($conn);
                    if(isset($_POST["th"]) && is_int((int)$_POST["th"]) && (int)$_POST["th"] > 0){
                        header("Location: thread.php?thread=" . $_POST["th"]);
                    }else{
                        header("Location: index.php");
                    }
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Effectopic</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@200;300;400;600&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="base.css"/>
    <script src="login.js" defer></script>
    <script src="dark.js" defer></script>
  </head>
  <body>
    <header>
        <a href="index.php"><h1 class="title"></h1></a>
    </header>
    <div class="container c-login">
        <div class="flogin">
            <h3 id="h3_1"></h3>
            <form name="loginform" class="flogin" action="login.php" method="post">
                <input type="email" name="email" id="emailtext" placeholder="Email" required>
                <input type="password" name="pwd" id="pwd" placeholder="Password" required>
                <?php
                    if(isset($_GET["th"]) && is_int((int)$_GET["th"]) && (int)$_GET["th"] > 0){
                        echo '<input name="th" type="hidden" value="'. $_GET["th"] . '">';
                    }
                ?>
                <?php
                    if(isset($_error)){
                        echo "<span class='error'>" . $_error . "</span>";
                    }
                ?>
                <input type="submit" value="Entra">
            </form>
            <p id="p1"></p>
            <a href="signup.php"><button>Registrati</button></a>
        </div>
    </div>
  </body>
</html>