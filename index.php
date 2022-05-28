<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
      <?php
          if(isset($_SESSION["username"])){
            echo 'Bentornato '. $_SESSION["username"];
          }else{
            echo 'Benvenuto su Effectopic';
          }
        ?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@200;300;400;600&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="base.css"/>
    <script src="index.js" defer></script>
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
      <div class="flex_cont flex_column welcome">
        <h1>Benvenuto su EffecTopic!</h1>
        <p>Il primo forum per musicisti a supporto delle fasi creative,
          di missaggio e mastering<br>Cerca qua sotto il topic che ti
          interessa!</p>
        <?php
          if(isset($_SESSION["username"])){
            echo '<p>Bentornato '. $_SESSION["username"] . '!</p>';
          }
        ?>
        <div id="searchform">
          <form class="flex_cont"name="search" action="search.php" method="get">
            <input type="text" name="querytext" id="querytextbox" placeholder="Cerca">
            <input type="image" name="submit" src="magnifying-glass-solid.svg" id="sub" disabled>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>