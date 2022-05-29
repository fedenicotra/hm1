<?php
    session_start();
    if(isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["pwd"])){
      if(strlen($_POST["pwd"]) > 256){
        $_error = "Password troppo lunga";
      }

      if(strlen($_POST["username"]) > 256){
        $_error = "Username troppo lungo";
      }

      if(strlen($_POST["email"]) > 256){
        $_error = "Email troppo lunga";
      }

      if(!preg_match('/^.*(?=.{8,255})(?=.*[a-z])(?=.*\W).*$/i', $_POST["pwd"])){
        $_error = "La password non rispetta i criteri";
      }

      if(strcmp($_POST["pwd"], $_POST["pwd_v"]) != 0){
        $_error = "I campi password non coincidono";
      }

      if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $_error = "Formato email non valido";
      }

      if(!isset($_error)){
        $conn = mysqli_connect(
            "localhost",
            "root",
            "YouShouldRootPass",
            "hm1_1000001861"
        ) or die("Errore: ".mysqli_connect_error());
        $email = mysqli_real_escape_string($conn,$_POST["email"]);
        $user = mysqli_real_escape_string($conn,$_POST["username"]);
        $pass = mysqli_real_escape_string($conn,$_POST["pwd"]);
        $h_pass = password_hash($pass, PASSWORD_BCRYPT);
        $reg_date = date("Y-m-d");
        $d = date('Y-m-d H:i:s', time());

        $query = "INSERT INTO `account` (`id_acc`, `email`, `username`, `hashed_p`, `reg_date`, `last_access`) VALUES (NULL, '$email', '$user', '$h_pass', '$reg_date', '$d')";
        
        mysqli_begin_transaction($conn);
        try{
          $res = mysqli_query($conn,$query);
          $_SESSION["username"] = $user;
          $_SESSION["id"] = mysqli_insert_id($conn);
          mysqli_commit($conn);
          header("Location: index.php");
        }
        catch(Exception $e){
          mysqli_rollback($conn);
          $_error_ = $e->getMessage();
          $key = explode("key", $_error_);
          $loc = substr($key[1], 2, -1);
          if(strcmp($loc, "account.email") == 0){
            $_error = "L'email è già stata utilizzata";
          }
          elseif(strcmp($loc, "account.username") == 0){
            $_error = "L'username fornito è già in uso";
          }
          else{
            $_error = $_error_;
          }
        }
        mysqli_close($conn);
      }
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrati</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@200;300;400;600&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="base.css"/>
    <script src="signup.js" defer></script>
    <script src="dark.js" defer></script>
  </head>
  <body>
  <header>
      <a href="index.php"><h1 class="title"></h1></a>
      <div class="liso">
        <?php
          if(!isset($_SESSION["username"])){
            echo '<a href="login.php"><h3>Login</h3></a><a href="signup.php"><h3>Sign up</h3></a>';
          }
          else{
            echo '<a href="logout.php"><h3>Logout</h3></a>';
          }
        ?>
      </div>
    </header>
    <div class="container">
      <div class="freg">
        <h3 id="h3_r"></h3>
        <form name="signup" class="freg" action="signup.php" method="post">
          <input type="email" name="email" id="emailtext" placeholder="Email" required>
          <input type="password" name="pwd" id="pwd" placeholder="Password" required>
          <span>La password deve contenere almeno 8 caratteri ed avere un carattere speciale</span>
          <input type="password" name="pwd_v" id="pwd_v" placeholder="Conferma Password" required>
          <input type="text" name="username" id="username" placeholder="Username" required>
          <input type="submit" id="subreg" value="Registrati">
          <?php
            if(isset($_error)){
              echo "<p class='error'>" . $_error . "</p>";
            }
          ?>
        </form>
      </div>
    </div>
  </body>
</html>