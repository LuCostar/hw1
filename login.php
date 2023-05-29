<?php 
    require_once 'auth.php';

    if(CheckAuth()){
        header('Location: home.php');
        exit();
    }

    $isRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

    if(!empty($_POST["username"]) && !empty($_POST["password"]) && $isRefreshed)
    {

        $conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));

        $username = mysqli_real_escape_string($conn, $_POST['username']);

        $query = "SELECT * FROM ACCOUNTS WHERE USERNAME = '$username'";

        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

        if(mysqli_num_rows($res) > 0){

            $entry = mysqli_fetch_assoc($res);

            if (password_verify($_POST['password'], $entry['PASSWORD'])) {
                $_SESSION["username"] = $entry['USERNAME'];
                $_SESSION["user_id"] = $entry['ID'];
                header("Location: home.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit();
            }
        } 
        $error = "Username e/o password errati.";    
    }
    else if (empty($_POST["username"]) || empty($_POST["password"])) {
        
        if($isRefreshed) $error = "Inserisci username e/o password.";
    }
?>

<html>
    <head>
        <link rel='stylesheet' href='stylesheets/form_style.css'>
        <link rel="stylesheet" href='stylesheets/main.css'>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="assets/favicon.png">

        <title>Gamefrog - Accesso</title>
    </head>
    <body>
        <div class="logo">
            <img src="assets/site_logo.png">
            <h1>Gamefrog</h1>
        </div>
        <div id="container">
                <h5>Please, enter your login credentials</h5>

                <form name='credentials' method='post'>

                    <div class="username">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username">
                    </div>

                    <div class="password">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password">
                    </div>

                    <?php
                        if (isset($error)) {
                            echo "<p class='error'>$error</p>";
                        }
                    ?>

                    <div class="submit_container">
                        <div class="submit_btn">
                            <input type='submit' value="accedi" name="accesso">
                        </div>
                    </div>
                </form>
                <div class="redirect"><h4>Not subscribed?</h4>
                <div class="redirect_btn_container"><a class="redirect_btn" href="signup.php">Create an account!</a></div>
                </div>
            </div>
    </body>
</html>