<?php

define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT'] . '/etms/');

include_once(ROOT_PATH . 'includes/Mysql.php');

abstract class TMS
{

    protected $id;
    protected $table_name;

    function __construct($table_name)
    {
        $this->table_name = $table_name;

    }

    protected function save($id, $types, $data)
    {
        $this->id = $id ?? 0;

        $fields = implode(', ', array_keys($data));
        $placeholder = implode(', ', array_fill(0, count($data), '?'));
        $db = new MYSQL();
        if ($id == 0) {
            $sql = "INSERT INTO $this->table_name ($fields) VALUES ($placeholder) ";


        } else {
            $sql = "UPDATE $this->table_name SET ";
            $sql .= implode(", ", array_map(fn($field) => "$field = ?", array_keys($data)));
            $sql .= " WHERE id = ?";
            $data["id"] = $this->id;
        }

        try {
            $result = $db->Execute($sql, $types, ...array_values($data));
            unset($db);
            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }




    } //if id==0 (create) else (update)
    protected function delete($id)
    {

        $db = new MYSQL();
        $sql = "DELETE FROM $this->table_name WHERE id=?";

        $result = $db->Execute($sql, "i", $id);
        unset($db);
        return $result;
    }


    protected function get_alldata()
    {
        if ($this->table_name == "Tasks") {
            $db = new MYSQL();
            $sql = "SELECT b.projname,a.* FROM $this->table_name a , projects b WHERE a.projid = b.id";
            $dt = $db->GetTableData("DT", $sql);
            unset($db);
            return $dt;
        } else {
            $db = new MYSQL();
            $sql = "SELECT * FROM $this->table_name ";
            $dt = $db->GetTableData("DT", $sql);
            unset($db);
            return $dt;
        }

    }
    protected function get_by_id($id, $column = "id")
    {
        $db = new MYSQL();
        $sql = "SELECT * FROM $this->table_name WHERE $column= ?";
        $dt = $db->GetTableData("DR", $sql, "i", $id);
        unset($db);
        return $dt;
    }
    abstract public function generatereport($reporttype);

}

class Employee extends TMS
{

    public $emp_id;
    public $emp_name;
    public $emp_email;
    public $emp_password;
    public $emp_no;
    public $emp_role;
    public $emp_position;




    function __construct()
    {
        $table = "Employees";
        parent::__construct($table);
    }

    function userlogin($email, $password)
    {
        $db = new MYSQL();
        $sql = "Select * from employees where email=? and password=?";
        $dt = $db->GetTableData("DR", $sql, "ss", $email, $password);

        unset($db);
        return $dt;
    }
    function createEmployee($data)
    {
        // return $this->emp_id;
        return $this->save($this->emp_id, $this->emp_id > 0 ? "ssssssi" : "ssssss", $data);
    }

    function getEmpData()
    {
        return $this->get_alldata();
    }

    function getEmpRow()
    {
        return $this->get_by_id($this->emp_id);
    }

    function deleteEmp()
    {

        return $this->delete($this->emp_id);
    }

    function generatereport($reporttype)
    {
        switch ($reporttype) {

            default:
                break;
        }
        ;
    }

}

class Project extends TMS
{
    public $proj_id;
    public $proj_name;
    public $proj_details;
    public $proj_startdate;
    public $proj_enddate;
    public $proj_completeflag;

    function __construct()
    {
        $table = "Projects";
        parent::__construct($table);
    }

    function createProject($data)
    {
        return $this->save($this->proj_id, $this->proj_id > 0 ? "sssssi" : "sssss", $data);
    }

    function getProjData()
    {
        return $this->get_alldata();
    }

    function getProjRow()
    {
        return $this->get_by_id($this->proj_id);
    }

    function deleteProj()
    {
        return $this->delete($this->proj_id);
    }
    function generatereport($reporttype)
    {
        switch ($reporttype) {
            case "ProjectDuration":
                $start_date = strtotime($this->proj_startdate);
                $end_date = strtotime($this->proj_enddate);
                $dt = ($end_date - $start_date) / (60 * 60 * 24); //sec->min  min->hour  hour->day
                break;

            case "TotalProjects":
                $db = new MYSQL();
                $sql = "SELECT COUNT(*) as complete FROM $this->table_name WHERE completeflag = ?";
                $dt = $db->GetTableData("DR", $sql, 's', 'Y');
                break;

            case "PendingProjects":
                $db = new MYSQL();
                $sql = "SELECT COUNT(*) as ongoing FROM $this->table_name WHERE completeflag = ?";
                $dt = $db->GetTableData("DR", $sql, 's', 'N');
                break;
        }

        return $dt;
    }
}

class Task extends TMS
{
    public $task_id;
    public $proj_id;
    public $task_name;
    public $task_target;
    public $task_startdate;
    public $task_enddate;
    public $task_completeflag;


    function __construct()
    {
        $table = "Tasks";
        parent::__construct($table);
    }

    function createTask($data)
    {
        return $this->save($this->task_id, $this->task_id > 0 ? "isii" : "isi", $data);
    }

    function UpdateTaskDate($types, $data)
    {
        return $this->save($this->task_id, $types, $data);
    }

    function getTaskData()
    {
        return $this->get_alldata();
    }

    function getTaskRow()
    {
        return $this->get_by_id($this->task_id);
    }

    function deleteTask()
    {
        return $this->delete($this->task_id);
    }


    function generatereport($reporttype)
    {
        switch ($reporttype) {
            case "ProjectTasks":
                $dt = $this->get_by_id($this->proj_id, "projid"); //use this array for total no of task by project
                break;
            case "ProjectTasksList":
                $db = new MYSQL();
                $sql = "SELECT * FROM $this->table_name a where not EXISTS (select task_id from assignments b where a.id = b.task_id) AND projid=?";
                $dt = $db->GetTableData("DR", $sql, "i", $this->proj_id);
                unset($db);
                break;
            case "TasksCompletedbyProject":
                $db = new MYSQL();
                $sql = "SELECT count(*) as complete FROM $this->table_name WHERE projid =? AND completeflag = ?";
                $dt = $db->GetTableData("DR", $sql, "is", $this->proj_id, "Y");
                unset($db);
                break;
            case "PendingTasksbyProject":
                $db = new MYSQL();
                $sql = "SELECT count(*) as pending FROM $this->table_name WHERE projid =? AND completeflag = ?";
                $dt = $db->GetTableData("DR", $sql, "is", $this->proj_id, "N");
                break;
            case "TotalTasksCompleted":
                $db = new MYSQL();
                $sql = "SELECT count(*) FROM $this->table_name WHERE projid =? AND completeflag = ?";
                $dt = $db->GetTableData("DR", $sql, "is", $this->proj_id, "Y");
                unset($db);
                break;
            case "TotalPendingTasks":
                $db = new MYSQL();
                $sql = "SELECT count(*) FROM $this->table_name WHERE projid =? AND completeflag = ?";
                $dt = $db->GetTableData("DR", $sql, "is", $this->proj_id, "N");
                break;

            default:
                break;
        }

        return $dt;
    }

}

class Assignment extends TMS
{
    public $assign_id;
    public $task_id;
    public $proj_id;
    public $emp_id;

    function __construct()
    {
        $table = "Assignments";
        parent::__construct($table);
    }

    function AssignTask($data)
    {
        return $this->save(0, "iii", $data);
    }

    function getAssignDetails()
    {
        return $this->get_by_id($this->assign_id);
    }

    function generatereport($reporttype)
    {
        switch ($reporttype) {
            case "ProjectEmployees":
                $db = new MYSQL();
                $sql = "SELECT COUNT(distinct emp_id) as totemployee FROM $this->table_name WHERE proj_id= ?";
                $dt = $db->GetTableData('DR', $sql, "i", $this->proj_id);
                break;

            default:
                break;
        }

        return $dt;
    }
}


?>