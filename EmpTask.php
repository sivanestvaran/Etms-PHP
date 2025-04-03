<!DOCTYPE html>
<html lang="en">

<?php include_once("includes/headsection.php"); ?>

<!-- <?php
// include_once ("bo/tms.php");

// $db = new MYSQL();
// $sql ="select b.empname, c.projname, d.id,d.taskname,d.startdate,d.tasktarget from assignments a , employees b, projects c , tasks d where a.emp_id = b.id and a.proj_id=c.id and a.task_id=d.id and b.id=? order by c.projname";
// $session_id = (int) $_SESSION["id"];
// $dt = $db->GetTableData('DR',$sql,'i',$session_id);
?> -->
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
                            <h4 class="  text-center"><span class="rounded-3">Tasks List</span></h4>
                            <div class="line"></div>
                            <div class="row "><!--bg-light-subtle-->
                                <div class=" d-flex justify-content-center flex-wrap ">
                                    <div class="col-md-8 col-12 rounded-4 p-1"> <!--bg-white-->

                                        <form id="empform">
                                            <div class="table-responsive mt-4">
                                                <table id="dataload" class="table table-striped p-2 text-center">
                                                    <thead>
                                                        <tr>
                                                            <!-- <th scope="col">No</th> -->
                                                            <th scope="col">Project</th>
                                                            <th scope="col">Task Name</th>
                                                            <th scope="col">Task Target</th>
                                                            <th scope="col">Action</th>
                                                            <!-- <th scope="col">Target</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tdata" class="d-none">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
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

            let sid = $('#sessionid').text();
            EmployeeTask(sid);

            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));

            $('tbody').on('click', '.btntask', function (e) {

                e.preventDefault();
                let btntext = $(this).text();
                if (btntext == 'Start') {
                    let taskid = $(this).closest('tr').find('.taskid').text();

                    UpdateDate(sid,taskid,'Start');
                }else
                {
                    let taskid = $(this).closest('tr').find('.taskid').text();
                    UpdateDate(sid,taskid,'Stop');

                }



                // console.log(taskid);
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            

            $('form').submit(function (e) {

                e.preventDefault();

                let data = $(this).serialize();

                FormSubmit(data);
                $('.submitbtn').text('Submit');
                $("#id").val(0);
                $('form')[0].reset();
            });


        });


    </script>
</body>

</html>