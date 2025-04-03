<?php
    include_once("tms.php");
function projCreateEdit()
{
    //Create and modify 
    $arr = [
        'projname' => 'Website Redesign',
        'projdetails' => 'Redesign the company website',
        'startdate' => '2024-01-15',
        'enddate' => '2024-03-30',
        'completeflag' => 'N'
    
    ];
    
    $arr2 = [
    
       'projname' => 'Mobile App Development',
        'projdetails' => 'Develop a cross-platform mobile app',
        'startdate' => '2024-02-01',
        'enddate' => '2024-06-15',
        'completeflag' => 'N',
    
    ];
    
    $arr3 = [
    
       'projname' => 'Cloud Migration',
        'projdetails' => 'Migrate infrastructure to the cloud',
        'startdate' => '2024-03-10',
        'enddate' => '2024-08-01',
        'completeflag' => 'Y',
    
    ];
    $modifyarr2 = [
    
        'projname' => 'SEO Optimization',
        'projdetails' => 'Improve search engine optimization',
        'startdate' => '2024-04-20',
        'enddate' => '2024-05-30',
        'completeflag' => 'Y',
    
    ];
    
    $bo = new Project();
    $id = 3;
    $bo->proj_id = $id;
     $res = $bo->createProject($modifyarr2);

     if( $res ['affected_rows'] == 1)
     {
        echo "Project Succefully Modified";
     }else
     {
        echo "Something went wrong";
     }

}

function projGetAllData()
{
   
    $bo = new Project();
    $res = $bo->getProjData();
    print_r($res->fetch_all(MYSQLI_ASSOC));
}

function projGetById()
{
    $bo = new Project();
    $id = 1;
    $bo->proj_id = $id;
    $res = $bo->getProjRow();
    print_r($res->fetch_all(MYSQLI_ASSOC));
}

function projDeleteRow(){
    $bo = new Project();
    $id = 3;
    $bo->proj_id = $id;
    $res = $bo->deleteProj();

    if($res['affected_rows']==1){
        print_r( "Succefully deleted");
    }else{
        print_r( "Something went wrong");
    }
}



//projCreateEdit();
//projGetAllData();
//projGetById() ;
//projDeleteRow();


?>