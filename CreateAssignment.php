<?php
include_once("bo/tms.php");

$bo = new Project();
$dt = $bo->getProjData();
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
                            <h4 class="  text-center"><span class="rounded-3">Assign Task</span></h4>
                            <div class="line"></div>
                            <div class="row "><!--bg-light-subtle-->
                                <div class=" d-flex justify-content-center flex-wrap ">
                                    <div class="col-md-8 col-12 rounded-4 p-1"> <!--bg-white-->
                                        <div class="alert alert-success alert-dismissible fade show d-none" role="alert"
                                            id="alert">
                                            Succesfully assgned!
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        <form id="empform">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 mb-3">
                                                    <label class="form-label">Select Project :</label>
                                                    <select class="form-select form-select-sm" name="proj_id"
                                                        id="proj_id">
                                                        <option value="001" selected disabled>--Select Project--</option>
                                                        <?php foreach ($dt as $dr) { ?>
                                                            <option value=<?= $dr['id'] ?>><?= $dr['projname'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="table-responsive mt-4">
                                                <table id="dataload" class="table table-striped p-2 text-center">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">No</th>
                                                            <th scope="col">Task Name</th>
                                                            <th scope="col">Employee Name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tdata" class="d-none">


                                                    </tbody>
                                                </table>
                                            </div>
                                           
                                            <div class="text-center d-none" id="displaybtn">
                                                <button type="submit"
                                                    class="w-50 btn btn-theme text-center submitbtn">Submit</button>

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
    <script src="js/Assignment.js"></script>
    <script>

        $(document).ready(function () {


            //TaskAllData(); //Load all employees data

            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));



            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });



            $('#proj_id').change(function () {
                let id = $(this).val();

                $('#dataload').fadeIn("slow").show();


                AssignGetRow(id, function (response) {

                    let opt = response[1].map((e) => {

                        return "<option value=" + e.id + ">" + e.empname + "</option>";
                    }).join();

                    let dropdown = "<select class='form-select form-select-sm' id='emp_id' name='emp_id[]'>" + opt + "</select>";

                    let no = 1;
                    let rows = response[0].map((e) => {

                        return "<tr><td> <input type='hidden' id='task_id' name='task_id[]' value="+e.id+">" + no++ + "</td><td>" + e.taskname + "</td><td>" + dropdown + "</td></tr>";
                    }).join('');

                    $('#tdata').empty();

                    $('#tdata').append(rows);

                    $('#tdata').removeClass('d-none').hide().fadeIn("slow");

                    $('#displaybtn').removeClass('d-none');

                })
            });

            $('form').submit(function (e) {

                e.preventDefault();

                let data = $(this).serialize();
                //console.log(data);
                FormSubmit(data);
                 $('#proj_id').val("001");
                 $('#dataload').fadeOut("slow").hide();
            });


        });
    </script>
</body>

</html>