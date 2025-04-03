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
                            <h4 class="  text-center"><span class="rounded-3">Register Employee</span></h4>
                            <div class="line"></div>
                            <div class="row "><!--bg-light-subtle-->
                                <div class=" d-flex justify-content-center flex-wrap ">
                                    <div class="col-md-8 col-12 rounded-4 p-1"> <!--bg-white-->
                                        <div class="alert alert-success alert-dismissible fade show d-none" role="alert"
                                            id="alert">
                                            Employee succesfully created
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        <form id="empform">
                                            <input type="hidden" id="id" name="id" value="0">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 mb-3">
                                                    <label class="form-label">Employee Name :</label>
                                                    <input type="text" name="empname" id="empname" value=""
                                                        class="form-control form-control-sm" placeholder="Emp name"
                                                        required>
                                                </div>
                                                <div class="col-sm-12 col-md-6 mb-3">
                                                    <label class="form-label">Employee No :</label>
                                                    <input type="text" name="empno" id="empno"
                                                        class="form-control form-control-sm" placeholder="Emp No">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 mb-3">
                                                    <label class="form-label">Position :</label>
                                                    <input type="text" name="empposition" id="empposition"
                                                        class="form-control form-control-sm" placeholder="Emp Position">
                                                </div>
                                                <div class="col-sm-12 col-md-6 mb-3">
                                                    <label class="form-label">Role :</label>
                                                    <select class="form-select form-select-sm" name="emprole"
                                                        id="emprole">
                                                        <option value='Manager'>Manager</option>
                                                        <option value='Employee'>Employee</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 mb-3">
                                                    <label class="form-label">Email :</label>
                                                    <input type="text" name="email" id="email"
                                                        class="form-control form-control-sm" placeholder="Email"
                                                        required>
                                                </div>
                                                <div class="col-sm-12 col-md-6 mb-3">
                                                    <label class="form-label">Password :</label>
                                                    <input type="password" name="password" id="password"
                                                        class="form-control form-control-sm" placeholder="Password"
                                                        required>
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
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Emp no</th>
                                                        <th scope="col">Position</th>
                                                        <th scope="col">Email</th>
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

    <script src="js/Employee.js"></script>


    <script>

        $(document).ready(function () {


            EmpAllData(); //Load all employees data

            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));



            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            $('tbody').on('click', '.btnEdit', function (e) {

                e.preventDefault();

                $('.submitbtn').text('Update');
                let empid = $(this).closest('tr').find('.empid').text();
                $('#id').val(empid);

                //console.log(empid);
                EmpGetRow(empid, function (response) {

                    $("#empname").val(response.empname);
                    $("#empno").val(response.empno);
                    $("#empposition").val(response.empposition);
                    $("#emprole").val(response.emprole);
                    $("#email").val(response.email);
                    $("#password").val(response.password);
                });
            });

            $('tbody').on('click', '.btnDelete', function (e) {
                e.preventDefault();
                let empid = $(this).closest('tr').find('.empid').text();
                //console.log(empid);
                if (confirm("Are you sure to delete?")) {
                    EmpDeleteRow(empid);
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