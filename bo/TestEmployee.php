<?php
    include_once("tms.php");
    function empCreateEdit()
    {
        //Create and modify 
        $arr = [
            "empname" => "siva",
            "empno" => "emp001",
            "empposition" => "engineer",
            "emprole" => "admin",
            "email" => "ss@gmail.com",
            "password" => "123456"
        
        ];
        
        $arr2 = [
        
            "empname" => "mages",
            "empno" => "emp002",
            "empposition" => "sales",
            "emprole" => "manager",
            "email" => "mages@gmail.com",
            "password" => "test"
        
        ];
        
        $arr3 = [
        
            "empname" => "joseph",
            "empno" => "emp003",
            "empposition" => "HR",
            "emprole" => "employee",
            "email" => "hr@gmail.com",
            "password" => "hrtest"
        
        ];
        $modifyarr2 = [
        
            "name" => "rajes",
            "empno" => "emp002",
            "position" => "finance",
            "role" => "employee",
            "email" => "rajsesh@gmail.com",
            "password" => "666666"
        
        ];
        
        $bo = new Employee();
        $id = 0;
        $bo->emp_id = $id;
         $res = $bo->createEmployee($arr2);

         if($res['affected_rows'] == 1)
         {
            echo "success";
         }else{
            echo "sumthing wrrong";
         }

    }

    function empGetAllData()
    {
       
        $bo = new Employee();
        $res = $bo->getEmpData();
        print_r($res->fetch_all(MYSQLI_ASSOC));
    }

    function empGetById()
    {
        $bo = new Employee();
        $id = 1;
        $bo->emp_id = $id;
        $res = $bo->getEmpRow();
        print_r($res->fetch_all(MYSQLI_ASSOC));
    }

    function empDeleteRow(){
        $bo = new Employee();
        $id = 3;
        $bo->emp_id = $id;
        $res = $bo->deleteEmp();

        if($res['affected_rows']==1){
            echo "Succefully deleted";
        }else{
            echo "Something went wrong";
        }
    }
        
    
    //empCreateEdit()
    //empGetAllData();
    //empGetById();
    //empDeleteRow();

?>