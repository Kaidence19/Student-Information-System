<?php 
session_start();
if (isset($_SESSION['instructor_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Instructor') {
       include "../DB_connection.php";
       include "data/class.php";
       include "data/instructor.php";
       
       $instructor_id = $_SESSION['instructor_id'];
       $instructor = getInstructorById($instructor_id, $conn);
       $classes = getAllClasses($conn);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructors - Classes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
        include "inc/navbar.php";
        if ($classes != 0) {
     ?>
     <div class="container mt-5">

           <div class="table-responsive">
              <table class="table table-bordered mt-3 n-table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Class</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $class_ids = str_split(trim($instructor['classes']));
                  $i = 0;
                  foreach ($class_ids as $class_id) { 
                    $i++;
                    $class_info = getClassById($class_id, $conn);
                    if ($class_info != 0) { ?>
                      <tr>
                        <th scope="row"><?=$i?></th>
                        <td><?=$class_info['class_code'].'-'.$class_info['class']?></td>
                      </tr>
                  <?php }
                  } ?>
                </tbody>
              </table>
            </div>
         <?php }else{ ?>
             <div class="alert alert-info .w-450 m-5" 
                  role="alert">
                Empty!
              </div>
         <?php } ?>
     </div>
     
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
    header("Location: ../login.php");
    exit;
  } 
}else {
    header("Location: ../login.php");
    exit;
} 

?>