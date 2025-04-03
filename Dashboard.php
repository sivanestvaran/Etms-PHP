<?php
include_once("bo/tms.php");

$employee = new Employee();
$totalemp = $employee->getEmpData();

$project = new Project();
$totalproj = $project->getProjData();
$completedproj = $project->generatereport('TotalProjects')->fetch_assoc();
$ongoingproj = $project->generatereport('PendingProjects')->fetch_assoc();


?>


<!DOCTYPE html>
<html lang="en">

<?php include_once("includes/headsection.php"); ?>

<body>
    <div class="wrapper d-flex">
        <!-- Sidebar  -->
        <?php include_once("includes/sidebar.php") ?>

        <!-- Page Content  -->
        <div id="content" class="p-4">

            <?php include_once("includes/header.html") ?>


            <div class="container rounded-4 shadow bg-body-tertiary">
                <div class="row d-flex flex-wrap p-2">
                    <div class="col-12 flex-column rounded-4  p-3 m-1"> <!--bg-light-->
                        <div class=" ">
                            <h4 class="  text-center"><span class="rounded-3">Dashboard</span></h4>
                            <div class="line"></div>
                            <div class="row "><!--bg-light-subtle-->
                                <div class=" d-flex justify-content-center flex-wrap ">
                                    <div class="col-md-3 col-12 rounded-4 "> <!--bg-white-->
                                        <div class="card m-2">
                                            <p class="card-header text-center btn-theme" style="font-size:14px">Total
                                                Employee</p>
                                            <div class="d-flex p-2">
                                                <div class="img border-end border-secondary p-2">
                                                    <span class="material-symbols-outlined btn btn-theme"
                                                        style="font-size:48px">
                                                        group
                                                    </span>
                                                </div>
                                                <div class="content mx-auto my-auto text-center">
                                                    <h1 class=""><?= $totalemp->num_rows ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 rounded-4"> <!--bg-white-->
                                        <div class="card m-2">
                                            <p class="card-header text-center btn-theme" style="font-size:14px">Total
                                                Projects</p>
                                            <div class="d-flex flex-wrap p-2">
                                                <div class="img border-end border-secondary p-2">
                                                    <span class="material-symbols-outlined btn btn-theme"
                                                        style="font-size:48px">
                                                        document_scanner
                                                    </span>
                                                </div>
                                                <div class="content mx-auto my-auto text-center ">
                                                    <h1 class=""><?= $totalproj->num_rows ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 rounded-4"> <!--bg-white-->
                                        <div class="card m-2">
                                            <p class="card-header text-center btn-theme" style="font-size:14px">
                                                Completed Projects</p>
                                            <div class="d-flex p-2">
                                                <div class="img border-end border-secondary p-2">
                                                    <span class="material-symbols-outlined btn btn-theme"
                                                        style="font-size:48px">
                                                        check_circle
                                                    </span>
                                                </div>
                                                <div class="content mx-auto my-auto text-center">
                                                    <h1 class=""><?= $completedproj['complete'] ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 rounded-4"> <!--bg-white-->
                                        <div class="card m-2">
                                            <p class="card-header text-center btn-theme" style="font-size:14px">Ongoing
                                                Projects</p>
                                            <div class="d-flex p-2">
                                                <div class="img border-end border-secondary p-2">
                                                    <span class="material-symbols-outlined btn btn-theme"
                                                        style="font-size:48px">
                                                        schedule
                                                    </span>
                                                </div>
                                                <div class="content mx-auto my-auto text-center">
                                                    <h1 class=""><?= $ongoingproj['ongoing'] ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <form action="" class="">
                                        <div class="d-flex text-center align-items-center mb-3">
                                            <label for="" class=" w-100"> Select Project : </label>
                                            <select class="form-select form-select-sm"
                                                id="projid">
                                              <?php foreach($totalproj as $proj) { ?>
                                                <option value=<?= $proj['id'] ?>><?= $proj['projname'] ?></option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </form>

                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-12 p-2 border-end border-opacity-50">
                                        <h5 class="text-center btn-theme p-1 rounded-3">Project Info</h5>
                                        <div class="row">
                                            <div class="d-flex justify-content-center">
                                                <div class="card m-2">
                                                    <h6 class="card-header btn-theme">Total Employee</h6>
                                                    <div class="card-body text-center">
                                                        <h3 id="totalemployee"></h3>
                                                    </div>
                                                </div>
                                                <div class="card m-2">
                                                    <h6 class="card-header btn-theme">Total Task</h6>
                                                    <div class="card-body text-center">
                                                    <h3 id="totaltask"></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="d-flex justify-content-center">
                                                <div class="card m-2">
                                                    <h6 class="card-header btn-theme">Completed Task</h6>
                                                    <div class="card-body text-center">
                                                    <h3 id="completetask"></h3>
                                                    </div>
                                                </div>
                                                <div class="card m-2">
                                                    <h6 class="card-header btn-theme">Pending Task</h6>
                                                    <div class="card-body text-center">
                                                    <h3 id="pendingtask"></h3>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="d-flex justify-content-center">
                                                <div class="card m-2">
                                                    <h6 class="card-header btn-theme">Project Duration</h6>
                                                    <div class="card-body text-center">
                                                    <h3 id="duration"></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6 col-12 p-2">
                                        <h5 class="text-center btn-theme p-1 rounded-3">Project Task Info</h5>
                                        <table class="table table-striped" id="dataload">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Task</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tdata" class="d-none">
                                               

                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php include_once("includes/scripts.html") ?>

    <script src="js/Task.js"></script> 


    <script>

        $(document).ready(function () {

            let projid = $('#projid').val();
           ProjectTaskGetRow(projid);

            $('#projid').change(function(){
                let projid = $('#projid').val();
                ProjectTaskGetRow(projid);
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });




           // new DataTable('#dataload');
        });
    </script>
</body>

</html>