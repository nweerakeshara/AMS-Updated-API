<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../model/Attendance.php';

    $database = new Database();
    $db = $database->connect();

    $post = new Post($db);
    $data = json_decode(file_get_contents("php://input")); 


    $post->userId = $data->userId;
    $post->userName = $data->userName;
    $post->clock = $data->clock;
    $post->remarks = $data->remarks;
    $post->branchName = $data->branchName;



   
    if($post->write()){
       echo json_encode(
           array('message' => 'Added')
       );
       
    }else {
        echo json_encode(
            array('message' => 'Not Added')
        );
    }
