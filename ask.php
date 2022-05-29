<?php
  session_start();
  if(!isset($_SESSION["username"])){
    header("Location: login.php");
  }
  if(isset($_POST["titolo"]) && isset($_POST["bodytext"])){
    $conn = mysqli_connect(
        "localhost",
        "root",
        "YouShouldRootPass",
        "hm1_1000001861"
    ) or die("Errore: ".mysqli_connect_error());
    
    $titolo = mysqli_real_escape_string($conn,$_POST["titolo"]);
    $text   = mysqli_real_escape_string($conn,$_POST["bodytext"]);
    
    if(strlen($titolo) >= 256){
      $_error = "Titolo troppo lungo";
    }else{
      $id = $_SESSION["id"];

      $query = "CALL createTopic('$titolo', '$text', $id);";
      
      $res = mysqli_query($conn, $query);
      $query = "SELECT id_th FROM Thread WHERE titolo = '$titolo' AND id_creatore = $id ORDER BY id_th DESC LIMIT 1";
      
      $res = mysqli_query($conn, $query);
      $id_th = mysqli_fetch_assoc($res)["id_th"];

      header("Location: thread.php?thread=" . $id_th);
    }
    mysqli_close($conn);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crea Topic - Effectopic</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@200;300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="base.css"/>
    <script src="ask.js" defer></script>
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
            echo '<a href="ask.php"><h3>Crea Topic</h3></a><a href="logout.php"><h3>Logout</h3></a>';
          }
        ?>
      </div>
    </header>
    <div class="flex_cont center_content container">
      <form id="askform" class="flex_cont flex_column  ac_content center_content distance-top" action="ask.php" method="post">
        <h2>
          Chiedi qualcosa...
        </h2>
        <input type="text" name="titolo" placeholder="Titolo" required>
        <textarea id="bodytext" placeholder="Contenuto" class="not-resizable" name="bodytext" form="askform" rows="8" cols="80" required></textarea>
        <input type="submit" value="Invia">
        <?php
          if(isset($_error)){
            echo "<p class='error'>" . $_error . "</p>";
          }
        ?>
      </form>
    </div>
  </body>
</html>
