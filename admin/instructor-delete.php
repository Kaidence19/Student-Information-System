<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])     &&
    isset($_GET['instructor_id'])) {

  if ($_SESSION['role'] == 'Admin') {
     include "../DB_connection.php";
     include "data/instructor.php";

     $id = $_GET['instructor_id'];
     if (removeInstructor($id, $conn)) {
        $sm = "Successfully deleted!";
        header("Location: instructor.php?success=$sm");
        exit;
     }else {
        $em = "Unknown error occurred";
        header("Location: instructor.php?error=$em");
        exit;
     }


  }else {
    header("Location: instructor.php");
    exit;
  } 
}else {
    header("Location: instructor.php");
    exit;
} 