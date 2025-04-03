<?php
include_once("tms.php");
function taskCreateEdit()
{
    $arr = [
        'projid' => 1,
        'taskname' => 'Create Site Map',
        'tasktarget' => 10,
        'startdate' => '',
        'enddate' => '',
        'completeflag' => 'N'

    ];

    $arr2 = [
        'projid' => 2,
        'taskname' => 'Prototyping',
        'tasktarget' => 5,
        'completeflag' => 'N'

    ];

    $arr3 = [
        'projid' => 1,
        'taskname' => 'Web design',
        'tasktarget' => 4,
        'startdate' => '01-09-2024',
        'enddate' => '01-10-2024',
        'completeflag' => 'N'

    ];

    $modifyarr = [
        'projid' => 2,
        'taskname' => 'Design Mockups',
        'tasktarget' => 11,
        'startdate' => '',
        'enddate' => '',
        'completeflag' => 'N',

    ];

    $bo = new Task();
    // $id = 2;
    // $bo->task_id = $id;
    $res = $bo->createTask($arr2);
    if ($res) {
        echo " Sucessfully Added";
    } else {
        echo "Something went wrong";
    }
}

function taskGetAllData()
{

    $bo = new Task();
    $res = $bo->getTaskData();
    print_r($res->fetch_all(MYSQLI_ASSOC));
}

function taskGetById()
{
    $bo = new Task();
    $id = 1;
    $bo->task_id = $id;
    $res = $bo->getTaskRow();
    print_r($res->fetch_all(MYSQLI_ASSOC));
}

function taskDeleteRow()
{
    $bo = new Task();
    $id = 3;
    $bo->task_id = $id;
    $res = $bo->deleteTask();

    if ($res['affected_rows'] == 1) {
        echo "Succefully deleted";
    } else {
        echo "Something went wrong";
    }
}

function TaskReport(){
    $bo = new Task();
    $bo->proj_id = 1;
    $res = $bo->generatereport("ProjectTasks");
    print_r($res->fetch_all(MYSQLI_ASSOC));
}

//Call and test function one by one

            //taskCreateEdit();
            //taskGetAllData();
            //taskGetById();
            //taskDeleteRow();
            //TaskReport();
?>