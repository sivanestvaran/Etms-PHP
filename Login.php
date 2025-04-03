<?php
include_once('bo/tms.php');

$bo = new Employee();

$email = trim($_POST["email"]);
$password = trim($_POST["password"]);

$sanitizeemail = filter_var($email, FILTER_SANITIZE_STRING);
$sanitizepassword = filter_var($password, FILTER_SANITIZE_STRING);

$dt = $bo->userlogin($email,$password);

if ($dt->num_rows > 0) {
    $dr = $dt->fetch_assoc();

        if ($dr["email"] == $sanitizeemail && $dr['password'] == $sanitizepassword) {
            session_start();
            $_SESSION["email"] = $dr["email"];
            $_SESSION["role"] = $dr["emprole"];
            $_SESSION["empid"] = $dr["empid"]; //check this line if error throw

            $role =  $dr["emprole"];
            //http_response_code(200);
            echo json_encode(["status"=> true,"role"=>$role]);
            return;
        } else {
            http_response_code(401);
            echo false;
        }


}else{

    unset($email);
    unset($password);
    http_response_code(401);
    echo false;
}




?>