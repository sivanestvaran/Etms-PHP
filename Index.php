<?php
session_start();

session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="assets/fav.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="css/navbar.css">


</head>

<body>

    <div class="container mt-2">
        <div class="row d-flex flex-column justify-content-center align-items-center vh-100 ">
            <div class="text-center d-none" id="gifunlock">
                <img src="assets/unlock.gif" style="max-width:200px" alt="">
                <p class="text-success fw-bold">Login Success!!</p>
            </div>
            <div class="text-center d-none" id="failmsg">
                <img src="assets/unauthorised.gif" style="max-width:140px" alt="">
                <p class="text-danger fw-bold">Login Failed!!</p>
            </div>


            <div
                class="col-md-6 col-12 p-3 rounded-5 bg-light-subtle shadow border border-2 border-warning-subtle border-opacity-25">
                <div class="text-center p-2">
                    <img src="assets/lock.png" class="p-2 shadow-sm rounded-5" style="max-width:200px" alt="">
                </div>
                <form id="loginform" class=" p-3">
                    <div class="row g-3 align-items-center justify-content-center mb-3">
                        <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label">Email :</label>
                        </div>
                        <div class="col-auto">
                            <input type="email" name="email"  class="form-control form-control-sm"
                                aria-describedby="passwordHelpInline" required>
                        </div>

                    </div>
                    <div class="row g-3 align-items-center justify-content-center  mb-3">
                        <div class="col-auto">
                            <label for="inputPassword6" class="col-form-label">Password :</label>
                        </div>
                        <div class="col-auto">
                            <input type="password" name="password"
                                class="form-control form-control-sm" aria-describedby="passwordHelpInline" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-warning">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>



    <script>
        $(document).ready(function () {


            window.history.forward();
            function noBack() {
                window.history.forward();
            }
            $('#loginform').submit(function (e) {
                e.preventDefault();
                //console.log($(this).serialize);

                $.ajax({
                    type: "POST",
                    url: "Login.php",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {

                        if (response.status) {

                            $('#gifunlock').removeClass('d-none').hide().fadeIn();;
                            $('#failmsg').addClass('d-none');

                            if (response.role == "Employee") {
                                setTimeout(function () {
                                    window.location.href = "EmpTask.php";
                                }, 1000);

                            } 
                            
                            
                            if(response.role == "Manager"){
                                setTimeout(function () {
                                    window.location.href = "CreateEmployee.php";
                                }, 1000);
                            }


                        }

                    },
                    error: function (jqxhr, response, errorThrown) {
                        //console.log(response);

                        $('#failmsg').removeClass('d-none').hide().fadeIn();
                    }
                });

                //$('#gifunlock').toggleClass('d-none');
            });
        });
    </script>
</body>

</html>