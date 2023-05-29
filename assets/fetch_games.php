<?php
    require_once '../auth.php';
    if (!$userid = checkAuth()) exit;

    header('Content-Type: application/json');

    $conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']);

    $userid = mysqli_real_escape_string($conn, $userid);

    $query = "SELECT ID, USER, CONTENT FROM FAVOURITES WHERE USER = $userid";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $gamearray = array();
    while($entry = mysqli_fetch_array($res)){
        $gamearray[] = array('id' => $entry['ID'], 'user' => $entry['USER'], 'content' => json_decode($entry['CONTENT']));
    }
    echo json_encode($gamearray);

    exit;
?>