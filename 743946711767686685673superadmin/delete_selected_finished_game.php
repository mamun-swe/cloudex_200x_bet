<?php
    ob_start();
    session_start();
    include("inc/config.php");

    for($count = 0; $count < count($_POST["myArray"]); $count++) {  
        $statement = $pdo->prepare("DELETE FROM tbl_game WHERE game_id=? AND game_status = 5");
        $statement->execute(array($_POST["myArray"][$count]['id']));
        $response=array(
            "success" => 1
        );
    }
    echo json_encode($response);

?>