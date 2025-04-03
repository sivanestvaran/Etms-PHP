<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/etms/bo/tms.php");
//getall - Allrows
//getbyid - one rows

$set = $_POST['set'];

if($set == 'getall')
{
    $bo = new Employee();
    $dr = $bo->getEmpData();
    $dt = $dr->fetch_all(MYSQLI_ASSOC);
    unset($bo);
    unset($dr);

    echo json_encode($dt);
}

if($set == 'getbyid')
{
    $bo = new Employee();
    $bo->emp_id = (int) $_POST['id'];
    $dt = $bo->getEmpRow(); 
    $dr = $dt->fetch_assoc();
    unset($bo);
    
    echo json_encode($dr);

}

if($set == 'submit')
{
    $bo = new Employee();

    $data = [
        "empname" => $_POST['empname'],
        "empno" => $_POST['empno'],
        "empposition" => $_POST['empposition'],
        "emprole" => $_POST['emprole'],
        "email" => $_POST['email'],
        "password" => $_POST['password']
    ];

     $bo->emp_id = (int) $_POST['id'];  
    $dt = $bo->createEmployee($data);

    echo json_encode($dt);
}

if($set == 'empdelete'){
    $bo = new Employee();
    $bo->emp_id = $_POST['id'];
    $dt = $bo->deleteEmp();
    unset($bo);
    echo json_encode($dt);
}




?>