<nav id="sidebar" class=""><!--class="border-end"-->
    <div class="sidebar-header">
        <h3 class="text-center"><img src="assets/logo.png" height="100px" alt=""></h3>
    </div>

    <ul class="list-unstyled components">
        <p>Employee Task Management System</p>
        <span id="sessionid" class="d-none" ><?= $_SESSION['id']?></span>
        
        <?php if($_SESSION['role'] == 'Manager') { ?>
        <li>
            <a href="dashboard.php"><i class="fas fa-tachometer-alt mx-2"></i> Dashboard</a>
        </li>
        <li>
            <a href="CreateEmployee.php"><i class="fas fa-users mx-2"></i> Employee</a>
        </li>
          
        <li>
            <a href="CreateProject.php"><i class="fas fa-plus mx-2"></i> Project</a>
        </li>
        <li>
            <a href="CreateTask.php"><i class="fas fa-tasks mx-2"></i> Tasks</a>
        </li>
        <li>
            <a href="CreateAssignment.php"><i class="fas fa-thumbtack mx-2"></i> Assigns Tasks</a>
        </li>
        <li>
            <a href="EmpTask.php"><i class="fas fa-tasks mx-2"></i> My Tasks</a>
        </li>

        <?php } ?>

        <?php if($_SESSION['role'] == 'Employee') { ?>
        <li>
            <a href="#"><i class="fas fa-tachometer-alt mx-2"></i> Dashboard</a>
        </li>
        <li>
            <a href="EmpTask.php"><i class="fas fa-tasks mx-2"></i> Tasks</a>
        </li>
       

        <?php } ?>


        <!-- <li>
            <a href="#">Contact</a>
        </li> -->
    </ul>

    <div class="text-center" style="color:#ADEFD1;"> Copyright © Sivanes 2024.</div>

    
</nav>