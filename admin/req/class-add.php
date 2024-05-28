<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
    	

if (isset($_POST['class_code']) &&
    isset($_POST['class'])) {
    
    include '../../DB_connection.php';

    $class_code = $_POST['class_code'];
    $class = $_POST['class'];
    
    $data = 'class_code='.$class_code.'&class='.$class;

  if (empty($class_code)) {
		$em  = "Program is required";
		header("Location: ../class-add.php?error=$em&$data");
		exit;
	}else if (empty($class)) {
		$em  = "Year is required";
		header("Location: ../class-add.php?error=$em&$data");
		exit;
	}else {
        $sql  = "INSERT INTO
                 classes(class, class_code)
                 VALUES(?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$class, $class_code]);
        $sm = "New Class created successfully";
        header("Location: ../class-add.php?success=$sm");
        exit;
	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../class-add.php?error=$em");
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
