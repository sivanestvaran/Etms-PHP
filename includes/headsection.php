<?php

session_start();
    if(!isset($_SESSION['email']))
    {
        header('location:index.php');
    }

?>
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="assets/fav.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ETMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="css/navbar.css">

    </style>
</head>