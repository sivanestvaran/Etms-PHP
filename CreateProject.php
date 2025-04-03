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
                            <h4 class="  text-center"><span class="rounded-3">Add Project</span></h4>
                            <div class="line"></div>
                            <div class="row "><!--bg-light-subtle-->
                                <div class=" d-flex justify-content-center flex-wrap ">
                                    <div class="col-md-8 col-12 rounded-4 p-1"> <!--bg-white-->
                                        <div class="alert alert-success alert-dismissible fade show d-none" role="alert"
                                            id="alert">
                                            Project succesfully added
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        <form id="empform">
                                            <input type="hidden" id="id" name="id" value="0">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 mb-3">
                                                    <label class="form-label">Project Name :</label>
                                                    <input type="text" name="projname" id="projname" value=""
                                                        class="form-control form-control-sm" placeholder="Project Name" required>
                                                </div>
                                                <div class="col-sm-12 col-md-6 mb-3">
                                                    <label class="form-label">Details` :</label>
                                                    <input type="text" name="projdetails" id="projdetails"
                                                        class="form-control form-control-sm" placeholder="Details">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 mb-3">
                                                    <label class="form-label">Start Date :</label>
                                                    <input type="date" name="startdate" id="startdate"
                                                        class="form-control form-control-sm" placeholder="Start Date" >
                                                </div>
                                                <div class="col-sm-12 col-md-6 mb-3">
                                                    <label class="form-label">End Date :</label>
                                                    <input type="date" name="enddate" id="enddate"
                                                        class="form-control form-control-sm" placeholder="End Date" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 mb-3">
                                                    <label class="form-label">Status :</label>
                                                    <input type="text" name="completeflag" id="completeflag"
                                                        class="form-control form-control-sm" placeholder="Status" value="N" required>
                                                </div>
                                                
                                            </div>

                                            <div class="text-center d-md-none">
                                                <button type="submit"
                                                    class="w-100 btn btn-theme text-center submitbtn">Submit</button>

                                            </div>
                                            <div class="text-center  d-md-block d-none">
                                                <button type="submit"
                                                    class="w-50 btn btn-theme text-center submitbtn">Submit</button>

                                            </div>
                                        </form>
                                        <div class="table-responsive mt-4">
                                            <table id="dataload" class="table table-striped p-2 text-center">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Project</th>
                                                        <th scope="col">Start Date</th>
                                                        <th scope="col">End Date</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Action</th>
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

    </div>

    <?php include_once("includes/scripts.html") ?>
    <script src="js/Project.js"></script>
    <script>
          
        $(document).ready(function () {

        
            ProjAllData(); //Load all employees data

            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
            


            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            $('tbody').on('click', '.btnEdit', function (e) {

                e.preventDefault();

                $('.submitbtn').text('Update');
                let projid = $(this).closest('tr').find('.empid').text();
                $('#id').val(projid);

                //console.log(empid);
                ProjGetRow(projid, function (response) {

                    $("#projname").val(response.projname);
                    $("#projdetails").val(response.projdetails);
                    $("#startdate").val(response.startdate);
                    $("#enddate").val(response.enddate);
                    $("#completeflag").val(response.completeflag);
                    $("#password").val(response.password);
                });
            });

            $('tbody').on('click', '.btnDelete', function (e) {
                e.preventDefault();
                let projid = $(this).closest('tr').find('.empid').text();
                //console.log(projid);
                if (confirm("Are you sure to delete?")) {
                    ProjDeleteRow(projid);
                };
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