<?php
require_once 'auth.php';

if (checkAuth()) {
    header('Location: home.php');
    exit;
}

if (
    !empty($_POST['name']) && !empty($_POST['surname']) &&
    !empty($_POST['username']) && !empty($_POST['email']) && 
    !empty($_POST['password']) && !empty($_POST['confirm_password'])
) {
    $error = [];
    $conn = mysqli_connect(
        $db_config["host"],
        $db_config['user'],
        $db_config['password'],
        $db_config['name']
    ) or die(mysqli_error($conn));


    #username

    if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $_POST['username'])) {
        $error[] = "Formato username invalido";
    } else {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $query = "SELECT * FROM ACCOUNTS WHERE USERNAME = '$username'";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {
            $error[] = "Username gia preso!";
        }
    }

    #password

    if (!preg_match('/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/', $_POST['password'])) {
        $error[] = "Password min. 8 caratteri, che contenga almeno una maiuscola e un numero ";
    }

    if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
        $error[] = "Le password non coincidono";
    }

    #email

    if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST['email'])) {
        $error[] = "Formato e-mail invalido";
    } else {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $query = "SELECT * FROM ACCOUNTS WHERE EMAIL = '$email'";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {
            $error[] = "e-mail gia registrata!";
        }
    }

    #nome

    if (!preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $_POST['name'])) {
        $error[] = "Formato nome invalido";
    }

    #cognome

    if (!preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $_POST['surname'])) {
        $error[] = "Formato cognome invalido";
    }



    if (count($error) == 0) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $surname = mysqli_real_escape_string($conn, $_POST['surname']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $password = password_hash($password, PASSWORD_BCRYPT);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $query = "INSERT INTO ACCOUNTS(NAME, SURNAME, USERNAME, EMAIL, PASSWORD) VALUES ('"
            . $name . "', '" . $surname . "', '" . $username . "', '"
            . $email . "', '" . $password . "')";

        if (mysqli_query($conn, $query)) {
            $_SESSION["username"] = $_POST['username'];
            $_SESSION['user_id'] = mysqli_insert_id($conn);
            mysqli_close($conn);
            header("Location: home.php");
            exit;
        } else {
            $error[] = "Errore di connessione al database";
        }
    }
}
?>

<html>

<head>
    <title>Gamefrog - Signup</title>

    <link rel="stylesheet" href='stylesheets/form_style.css'>
    <link rel="stylesheet" href='stylesheets/main.css'>
    <script src='scripts/signup.js' defer></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="assets/favicon.png">

</head>

<body>
    <div class="logo">
            <img src="assets/site_logo.png">
            <h1>Gamefrog</h1>
        </div>
    <div id="container">            

        <form method="post" name="credentials">

            <div class="name">
                <label for="name">Name</label>
                <input type="text" name="name" <?php if(isset($_POST["name"])){echo "value=".$_POST["name"];} ?> >
                <div id = "name_err"><img src="./assets/close.svg"/><span></span></div>
            </div>

            <div class="surname">
                <label for="surname">Surname</label>
                <input type="text" name="surname" <?php if(isset($_POST["surname"])){echo "value=".$_POST["surname"];} ?> >
                <div id= "surname_err"><img src="./assets/close.svg"/><span></span></div>
            </div>

            <div class="username">
                <label for="username">Username</label>
                <input type="text" name="username"<?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?> >
                <div id= "username_err"><img src="./assets/close.svg"/><span></span></div>
            </div>

            <div class="email">
                <label for="email">e-mail</label>
                <input type="text" name="email" <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?> >
                <div id= "email_err"><img src="./assets/close.svg"/><span></span></div>
            </div>

            <div class="password">
                <label for="password">Password</label>
                <input type="password" name="password">
                <div id= "password_err"><img src="./assets/close.svg"/><span></span></div>
            </div>

            <div class="confirm_password">
                <label for="confirm_password"> Confirm Password</label>
                <input type="password" name="confirm_password">
                <div id= "confirm_err"><img src="./assets/close.svg"/><span></span></div>
            </div>

            <div class="submit_container">
                <div class="submit_btn">
                    <input type='submit' value="registrati" name="registrazione">
                </div>
            </div>
        </form>

        <div class="redirect"><h4>Have an account already?</h4></div>
        <div class="redirect_btn_container"><a class="redirect_btn" href="login.php">Access Gameco here</a></div>
    </div>
</body>

</html>