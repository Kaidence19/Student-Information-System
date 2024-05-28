<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
    	

if (isset($_POST['course_name']) &&
    isset($_POST['course_code']) && 
    isset($_POST['class'])) {
    
    include '../../DB_connection.php';

    $course_name = $_POST['course_name'];
    $course_code = $_POST['course_code'];
    $class = $_POST['class'];

  if (empty($course_name)) {
		$em  = "course name is required";
		header("Location: ../course-add.php?error=$em");
		exit;
	}else if(empty($course_code)) {
    $em  = "course code is required";
    header("Location: ../course-add.php?error=$em");
    exit;
  }else if (empty($class)) {
		$em  = "Grade is required";
		header("Location: ../course-add.php?error=$em");
		exit;
	}else {
        // check if the class already exists
        $sql_check = "SELECT * FROM courses 
                      WHERE class=? AND course_code=?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->execute([$class, $course_code]);
        if ($stmt_check->rowCount() > 0) {
           $em  = "The course is already exists";
           header("Location: ../course-add.php?error=$em");
           exit;
        }else {
          $sql  = "INSERT INTO
                 courses(class, course_name, course_code)
                 VALUES(?,?,?)";
          $stmt = $conn->prepare($sql);
          $stmt->execute([$class, $course_name, $course_code]);
          $sm = "New course created successfully";
          header("Location: ../course-add.php?success=$sm");
          exit;
        } 
	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../course-add.php?error=$em");
    exit;
  }

  }else {
    header("Location: ../../logout.php");
    exit;
  } 
}else {
	header("Location: ../../logout.php");
	exit;
} 
