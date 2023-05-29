<?php 
    require_once 'auth.php';

    if (!checkAuth()) {
        header("Location: login.php");
        exit;
    }

    $conn = mysqli_connect( 
        $db_config['host'], 
        $db_config['user'], 
        $db_config['password'], 
        $db_config['name']
        );

    $userid = $_SESSION['user_id'];
    $query = "SELECT * FROM ACCOUNTS WHERE ID = $userid";
    $res_1 = mysqli_query($conn, $query);
    $userinfo = mysqli_fetch_assoc($res_1);
?>

<html>

    
    <head>
        <title>Gamefrog - Profilo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="assets/favicon.png">

        <script src="./scripts/favourites.js" defer></script>
        <link rel="stylesheet" href='./stylesheets/main.css'>
        <link rel="stylesheet" href='./stylesheets/profile.css'>
        <link rel="stylesheet" href='./stylesheets/nav_bar.css'>
        <link rel="stylesheet" href='./stylesheets/game_card.css'>
    </head>

    <body>
    <header>
            <nav>
                <div>
                    <a href="home.php" id= "home_btn" class="icons"><img src="assets/home-button.png"></a>
                    <a href="news.php" class="icons"><img src="assets/newspaper.png"></a>
                </div>
                <div>
                    <a href="logout.php" class="icons"><img src="assets/logout.png"></a>
                </div>
            </nav>
        </header>
        <div class="logo">
            <img src="assets/site_logo.png">
            <h1>Gamefrog</h1>
        </div>
        <h1 class="subtitle">Profilo personale</h1>

        <div class="user_info">

            <div class="info_box">
                <h2>Username</h2>
                <div>Nome registrato</div>
                <div>e-mail</div>
            </div>

            <div class="info_box">
                <h2><?php echo $userinfo['USERNAME']?></h2>
                <div><?php echo $userinfo['NAME']." ".$userinfo['SURNAME']?></div>
                <div><?php echo $userinfo['EMAIL']?></div>
            </div>

        </div>
        <h1 class="subtitle">Lista preferiti</h1>
        <div class="cards"></div>


    </body>

</html>