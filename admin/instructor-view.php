<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
       include "../DB_connection.php";
       include "data/instructor.php";
       include "data/subject.php";
       include "data/class.php";

       if(isset($_GET['instructor_id'])){

       $instructor_id = $_GET['instructor_id'];

       $instructor = getInstructorById($instructor_id,$conn);    
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin - Instructors</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="../logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        include "inc/navbar.php";
        if ($instructor != 0) {
     ?>
     <div class="container mt-5">
         <div class="card" style="width: 22rem;">
          <img src="../img/instructor-<?=$instructor['gender']?>.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title text-center">@<?=$instructor['username']?></h5>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">First name: <?=$instructor['fname']?></li>
            <li class="list-group-item">Last name: <?=$instructor['lname']?></li>
            <li class="list-group-item">Username: <?=$instructor['username']?></li>

            <li class="list-group-item">Employee number: <?=$instructor['employee_number']?></li>
            <li class="list-group-item">Address: <?=$instructor['address']?></li>
            <li class="list-group-item">Date of birth: <?=$instructor['date_of_birth']?></li>
            <li class="list-group-item">Contact number: <?=$instructor['contact_number']?></li>
            <li class="list-group-item">Qualification: <?=$instructor['qualification']?></li>
            <li class="list-group-item">Email address: <?=$instructor['email_address']?></li>
            <li class="list-group-item">Gender: <?=$instructor['gender']?></li>
            <li class="list-group-item">Date of joined: <?=$instructor['date_joined']?></li>

            <li class="list-group-item">Subject Teaching: 
                <?php 
                   $s = '';
                   $subjects = str_split(trim($instructor['subjects']));
                   foreach ($subjects as $subject) {
                      $s_temp = getSubjectById($subject, $conn);
                      if ($s_temp != 0) 
                        $s .=$s_temp['subject_code'].', ';
                   }
                   echo $s;
                ?>
            </li>
            <li class="list-group-item">Handled Class: 
                 <?php 
                   $g = '';
                   $classes = str_split(trim($instructor['classes']));
                   foreach ($classes as $class) {
                      $g_temp = getClassById($class, $conn);
                      if ($g_temp != 0) 
                        $g .=$g_temp['class_code'].'-'.
                             $g_temp['class'].', ';
                   }
                   echo $g;
                  ?>
            </li>
            
          </ul>
          <div class="card-body">
            <a href="instructor.php" class="card-link">Go Back</a>
          </div>
        </div>
     </div>
     <?php 
        }else {
          header("Location: instructor.php");
          exit;
        }
     ?>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>	
    <script>
        $(document).ready(function(){
             $("#navLinks li:nth-child(2) a").addClass('active');
        });
    </script>

</body>
</html>
<?php 

    }else {
        header("Location: instructor.php");
        exit;
    }

  }else {
    header("Location: ../login.php");
    exit;
  } 
}else {
	header("Location: ../login.php");
	exit;
} 

?>