<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/etms/bo/tms.php");
//getall - Allrows
//getbyid - one rows

$set = $_POST['set'];



if ($set == 'getbyid') {
    $bo = new Task();
    $bo->proj_id = (int) $_POST['id'];
    $dt = $bo->generatereport('ProjectTasksList');
    $dr = $dt->fetch_all(MYSQLI_ASSOC);
    unset($bo);

    $bo2 = new Employee();
    $dt2 = $bo2->getEmpData();
    $dr2 = $dt2->fetch_all(MYSQLI_ASSOC);
    unset($bo2);

    $arr = [$dr, $dr2];

    echo json_encode($arr);

}

if ($set == 'submit') {
    $bo = new Assignment();

    $empids = $_POST['emp_id'];
    $taskids = $_POST['task_id'];
    $project_id = $_POST['proj_id'];

    for ($i = 0; $i < count($taskids); $i++) {

        $data = [
            "proj_id" => $project_id,
            "task_id" => $taskids[$i],
            "emp_id" => $empids[$i],
        ];
        $dt = $bo->AssignTask($data);

    }
    

    echo json_encode($dt);
}





?>