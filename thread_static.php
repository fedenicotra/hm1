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
    <script src="dark.js" defer></script>
    <!-- <script src="thread.js" defer></script> -->
    <script src="thread_s.js" defer></script>

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
    <div class="container main-content">
        <div class="flex_cont flex_column center_content ac_content">
            <div class="post thread-title">
                Mellotron Genesis
            </div>
            <div id="post-0" class="post">
                <div class="flex_cont head-post">
                    <p class="author">ASD</p>
                    <p class="author date">10-10-2022</p>
                </div>
                <p class="post-content">
                    Vorrei ottenere lo stesso suono di Watcher of the Skies, avete qualche VST da consigliarmi? Grazie...
                </p>
                <div class="spotdiv">
                  <a href="#1">
                    Artista - Canzone
                  </a><br>
                  <a href="#2">
                    Artista - Canzone 2
                  </a>
                </div>
                <div class="flex_cont foot-post">
                    <div class="flex_cont button-like">
                        <p>0</p>
                        <img data-id="0" class="heart-reg" src="heart-regular.svg" alt="">
                    </div>
                </div>
            </div>
            <div id="post-1" class="post">
                <div class="flex_cont head-post">
                    <p class="author">Krunker</p>
                    <p class="author date">13-10-2022</p>
                </div>
                <p class="post-content">
                    Prova il mellotron dell'Arturia. E' molto valido.
                </p>
                <div class="flex_cont foot-post">
                    <div class="flex_cont button-like">
                        <p>0</p>
                        <img data-id="1" class="heart-reg" src="heart-regular.svg" alt="">
                    </div>
                </div>
            </div>
            <div id="post-2" class="post">
                <div class="flex_cont head-post">
                    <p class="author">ASD</p>
                    <p class="author date">16-10-2022</p>
                </div>
                <p class="post-content">
                    Molto interessante! Solo che ero alla ricerca di una soluzione free. Esiste qualcosa di simile?
                </p>
                <div class="flex_cont foot-post">
                    <div class="flex_cont button-like">
                        <p>0</p>
                        <img data-id="2" class="heart-reg" src="heart-regular.svg" alt="">
                    </div>
                </div>
            </div>
            <div id="post-3" class="post">
                <div class="flex_cont head-post">
                    <p class="author">xXx_LaPloppa_xXx</p>
                    <p class="author date">16-10-2022</p>
                </div>
                <p class="post-content">
                    Puoi provare il vst Redtron. E' gratis!
                </p>
                <div class="flex_cont foot-post">
                    <div class="flex_cont button-like">
                        <p>0</p>
                        <img data-id="3" class="heart-reg" src="heart-regular.svg" alt="">
                    </div>
                </div>
            </div>
            <div id="post-4" class="post">
                <div class="flex_cont head-post">
                    <p class="author">ASD</p>
                    <p class="author date">17-10-2022</p>
                </div>
                <p class="post-content">
                    Grazie!! Era quello che cercavo!
                </p>
                <div class="flex_cont foot-post">
                    <div class="flex_cont button-like">
                        <p>0</p>
                        <img data-id="4" class="heart-reg" src="heart-regular.svg" alt="">
                    </div>
                </div>
            </div>
            <div class="flex_cont br-container">
                <button id="br">Rispondi</button>
            </div>
            <div class="post reply-container hidden" id="repcont">
                <div class="flex_cont head-post">
                    <p class="author">IL MIO USERNAME</p>
                    <p class="author date">LA DATA DI OGGI</p>
                </div>
                <div class="flex_cont flex_column ac_content center_content">
                    <textarea class="main-content not-resizable" placeholder="Rispondi qui" name="replybody" id="replybody" rows="3"></textarea>
                </div>
                <div class="flex_cont br-container">
                    <button id="subreply">Invia</button>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>
