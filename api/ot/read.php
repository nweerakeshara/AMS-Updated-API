<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../model/Ot.php';

    $database = new Database();
    $db = $database->connect();

    $post = new Post($db);
    $post -> searchInput = isset($_GET['searchInput']) ? $_GET['searchInput'] : die();
    $post -> searchClock = isset($_GET['searchClock']) ? $_GET['searchClock'] : die();

    $result = $post->readbranch();

    $num = $result->rowCount();

    if($num > 0){
        $posts_arr = array();
        $posts_arr['data'] = array();

        while($row = $result -> fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $post_item = array(
               
                'userId'=> $userId,
                'userName'=> $userName,
                'clockIn' => $clockIn,
                'clockOut' => $clockOut,
                'dateo' => $dateo,
                'OT_or_LC_hrs' => $OT_or_LC_hrs,
                'branchName' => $branchName,
            );

            array_push($posts_arr['data'], $post_item);
        }

        echo json_encode($posts_arr);
;    }else{
            echo json_encode(array('message' => 'No Records Found'));
    }
