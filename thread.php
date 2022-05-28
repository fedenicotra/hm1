<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Benvenuto su Effectopic</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@200;300;400;600&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="base.css"/>
    <script src="thread.js" defer></script>
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
                    echo '<div class="hidden" id="loggedas">'. $_SESSION["username"] . '</div>';
                    echo '<div class="hidden" id="loggedID">'. $_SESSION["id"] . '</div>';
                }
            ?>
        </div>
    </header>
    <div class="container main-content">
        <div id="parentN" class="flex_cont flex_column center_content ac_content">
            <img class="loading-image" src="ajax-loader.gif" alt="Caricamento in corso...">
        </div>
    </div>
  </body>
</html>