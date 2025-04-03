<?php

include_once($_SERVER['DOCUMENT_ROOT'] . "/etms/bo/tms.php");
//getall - Allrows
//getbyid - one rows

$set = $_POST['set'];

if ($set == 'getall') {
    $bo = new Task();
    $dr = $bo->getTaskData();
    $dt = $dr->fetch_all(MYSQLI_ASSOC);
    unset($bo);
    unset($dr);

    echo json_encode($dt);
}

if ($set == 'getbyid') {
    $bo = new Task();
    $bo->task_id = (int) $_POST['id'];
    $dt = $bo->getTaskRow();
    $dr = $dt->fetch_assoc();
    unset($bo);

    echo json_encode($dr);

}

if ($set == 'getbyprojid') {
    $bo = new Task();
    $bo->proj_id = (int) $_POST['id'];
    $dttotalproject = $bo->generatereport("ProjectTasks");
    $dtcompletetask = $bo->generatereport("TasksCompletedbyProject");
    $dtpendingtask = $bo->generatereport("PendingTasksbyProject");
    
    $totalproject = $dttotalproject->fetch_all(MYSQLI_ASSOC);
    $completetask = $dtcompletetask->fetch_all(MYSQLI_ASSOC);
    $pendingtask =  $dtpendingtask->fetch_all(MYSQLI_ASSOC);

    unset($bo);

    $bo2 = new Assignment();
    $bo2->proj_id = (int) $_POST['id'];
    $dttotalemployee = $bo2->generatereport("ProjectEmployees");
    $totalemployee = $dttotalemployee->fetch_all(MYSQLI_ASSOC);

    $bo3 = new Project();
    $bo3->proj_id = (int) $_POST['id'];
    $dtproject = $bo3->getProjRow();
    $dtproject = $dtproject->fetch_assoc();

    $startdate = strtotime($dtproject['startdate']);
    $enddate = strtotime($dtproject['enddate']);

    $duration = ($enddate - $startdate) / (60*60*24);

    unset($bo2);
    echo json_encode([$totalproject,$completetask,$pendingtask,$totalemployee,$duration]);

}


if ($set == 'submit') {
    $bo = new Task();

    $data = [
        "projid" => $_POST['projid'],
        "taskname" => $_POST['taskname'],
        "tasktarget" => $_POST['tasktarget'],
    ];

    $bo->task_id = (int) $_POST['id'];
    $dt = $bo->createTask($data);

    echo json_encode($dt);
}

if ($set == 'taskdelete') {
    $bo = new Task();
    $bo->task_id = $_POST['id'];
    $dt = $bo->deleteTask();
    unset($bo);
    echo json_encode($dt);
}

if ($set == 'updatedate') {
    $indication = $_POST['indication'];

    $bo = new Task();
    $bo->task_id = $_POST['taskid'];

    if ($indication == 'Start') {
        $today = (string) date('d-m-Y', strtotime('today'));

        $data = [
            'startdate' => $today
        ];

        $dt = $bo->UpdateTaskDate("si", $data);

    } else {
        $today = (string) date('d-m-Y', strtotime('today'));

        $data = [
            'enddate' => $today,
            'completeflag' => 'Y'
        ];
        $dt = $bo->UpdateTaskDate("ssi", $data);
    }
    echo json_encode($dt);
}

if ($set == 'getemployeetask') {
    $db = new MYSQL();
    $sql = "select b.empname, c.projname, d.id,d.taskname,d.startdate,d.enddate,d.tasktarget from assignments a , employees b, projects c , tasks d where a.emp_id = b.id and a.proj_id=c.id and a.task_id=d.id and b.id=? order by c.projname";
    $emp_id = (int) $_POST["empid"];
    $dt = $db->GetTableData('DR', $sql, 'i', $emp_id);

    $etask = $dt->fetch_all(MYSQLI_ASSOC);

    echo json_encode($etask);
}



?>