<?php
    require_once '../auth.php';
    if(!$userid = checkAuth()) exit;

    header('Content-Type: application/json');

    saveGame();

    function saveGame(){

        global $db_config, $userid;

        $conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']);

        $userid = mysqli_real_escape_string($conn, $userid);
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $score = mysqli_real_escape_string($conn, $_POST['score']);
        $image = mysqli_real_escape_string($conn, $_POST['image']);



        $query = "SELECT * FROM FAVOURITES WHERE USER = '$userid' AND ID = '$id'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

        if (mysqli_num_rows($res) > 0){
            echo json_encode(array('ok' => false));
            exit;
        }


        $query ="INSERT INTO FAVOURITES(ID, USER, CONTENT) VALUES ('$id', '$userid', JSON_OBJECT('id', '$id', 'name', '$name', 'score', '$score', 'image', '$image'))";



        if (mysqli_query($conn, $query) or die(mysqli_error($conn))){
            echo json_encode(array('ok' => false));
            exit;
        }

        mysqli_close($conn);
        echo json_encode(array('ok' => true));
    }

?>