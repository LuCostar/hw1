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
        <title>Gamefrog - News</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="assets/favicon.png">

        <script src="./scripts/news.js" defer></script>
        <link rel="stylesheet" href='./stylesheets/main.css'>
        <link rel="stylesheet" href='./stylesheets/nav_bar.css'>
        <link rel="stylesheet" href="./stylesheets/news.css">
    </head>
    <body>
        <header>
            <nav>
                <div id="left">
                    <a href="home.php" id= "home_btn" class="icons"><img src="assets/home-button.png"></a>
                </div>
                <div id="right">
                    <div>Hello, <?php
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
        <h1 class="subtitle">The latest videogame-related news!</h1>

        <main class="articles">

        </main>
    </body>
</html>
