<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
    	

if (isset($_POST['class_code']) &&
    isset($_POST['class']) &&
    isset($_POST['class_id'])) {
    
    include '../../DB_connection.php';

    $class_code = $_POST['class_code'];
    $class = $_POST['class'];
    $class_id = $_POST['class_id'];
   
    $data = 'class_code='.$class_code.'&class='.$class.'&class_id='.$class_id;

    if (empty($class_code)) {
        $em  = "Program is required";
        header("Location: ../class-edit.php?error=$em&$data");
        exit;
    }else if (empty($class)) {
        $em  = "Year is required";
        header("Location: ../class-edit.php?error=$em&$data");
        exit;
    }else {

        $sql  = "UPDATE classes SET class=?, class_code=?
                 WHERE class_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$class, $class_code, $class_id]);
        $sm = "Grade updated successfully";
        header("Location: ../class-edit.php?success=$sm&$data");
        exit;
	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../class.php?error=$em");
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
