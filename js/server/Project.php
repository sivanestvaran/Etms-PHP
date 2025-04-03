<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/etms/bo/tms.php");
//getall - Allrows
//getbyid - one rows

$set = $_POST['set'];

if($set == 'getall')
{
    $bo = new Project();
    $dr = $bo->getProjData();
    $dt = $dr->fetch_all(MYSQLI_ASSOC);
    unset($bo);
    unset($dr);

    echo json_encode($dt);
}

if($set == 'getbyid')
{
    $bo = new Project();
    $bo->proj_id = (int) $_POST['id'];
    $dt = $bo->getProjRow(); 
    $dr = $dt->fetch_assoc();
    unset($bo);
    
    echo json_encode($dr);

}

if($set == 'submit')
{
    $bo = new Project();

    $data = [
        "projname" => $_POST['projname'],
        "projdetails" => $_POST['projdetails'],
        "startdate" => $_POST['startdate'],
        "enddate" => $_POST['enddate'],
        "completeflag" => $_POST['completeflag']
    ];

     $bo->proj_id = (int) $_POST['id'];  
    $dt = $bo->createProject($data);

    echo json_encode($dt);
}

if($set == 'projdelete'){
    $bo = new Project();
    $bo->proj_id = $_POST['id'];
    $dt = $bo->deleteProj();
    unset($bo);
    echo json_encode($dt);
}




?>