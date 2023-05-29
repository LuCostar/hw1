<?php 
    require_once 'auth.php';

    if (!checkAuth()) {
        header("Location: login.php");
        exit;
    }

    $username = $_SESSION['username'];
?>

<html>

    
    <head>
        <title>Gamefrog</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="assets/favicon.png">

        <script src="./scripts/home.js" defer></script>
        <link rel="stylesheet" href='./stylesheets/main.css'>
        <link rel="stylesheet" href='./stylesheets/nav_bar.css'>
        <link rel="stylesheet" href='./stylesheets/search_bar.css'>
        <link rel="stylesheet" href='./stylesheets/game_card.css'>
    </head>
    <body>
        <header>
            <nav>
                <div>
                    <a href="home.php" id= "home_btn" class="icons"><img src="assets/site_logo.png"></a>
                    <a href="news.php" class="icons"><img src="assets/newspaper.png"></a>
                </div>
                <div>
                    <div>Ciao, <?php
                        echo $username;
                        ?>
                    </div>
                    <a href="profile.php" id= "profile" class="icons"><img src="assets/profile.png"></a>
                    <a href="logout.php" class="icons"><img src="assets/logout.png"></a>
                </div>
            </nav>
        </header>
        <div class="logo">
            <img src="assets/site_logo.png">
            <h1>Gamefrog</h1>
        </div>

        <div id="search_container">
            <form autocomplete="off">
                <div id="search_box">
                    <label for="search"></label>
                    <input type="text" name="search" id="search_bar">
                    <input type="submit" value="Cerca" id="submit_btn">
                </div>
            </form>
        </div>
        <div class= "cards">

        </div>
        <footer>
            <div></div>
        </footer>
    </body>
</html>