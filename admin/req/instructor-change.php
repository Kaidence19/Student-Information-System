<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
        

if (isset($_POST['admin_pass']) &&
    isset($_POST['new_pass'])   &&
    isset($_POST['c_new_pass']) &&
    isset($_POST['instructor_id'])) {
    
    include '../../DB_connection.php';
    include "../data/instructor.php";
    include "../data/admin.php";

    $admin_pass = $_POST['admin_pass'];
    $new_pass = $_POST['new_pass'];
    $c_new_pass = $_POST['c_new_pass'];

    $instructor_id = $_POST['instructor_id'];
    $id = $_SESSION['admin_id'];
    
    $data = 'instructor_id='.$instructor_id.'#change_password';

    if (empty($admin_pass)) {
        $em  = "Admin password is required";
        header("Location: ../instructor-edit.php?perror=$em&$data");
        exit;
    }else if (empty($new_pass)) {
        $em  = "New password is required";
        header("Location: ../instructor-edit.php?perror=$em&$data");
        exit;
    }else if (empty($c_new_pass)) {
        $em  = "Confirmation password is required";
        header("Location: ../instructor-edit.php?perror=$em&$data");
        exit;
    }else if ($new_pass !== $c_new_pass) {
        $em  = "Password does not match";
        header("Location: ../instructor-edit.php?perror=$em&$data");
        exit;
    }else if (!adminPasswordVerify($admin_pass, $conn, $id)) {
        $em  = "Incorrect admin password";
        header("Location: ../instructor-edit.php?perror=$em&$data");
        exit;
    }else {
        // hashing the password
        $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);

        $sql = "UPDATE instructors SET
                password = ?
                WHERE instructor_id=?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$new_pass, $instructor_id]);
        $sm = "The password has been changed successfully!";
        header("Location: ../instructor-edit.php?psuccess=$sm&$data");
        exit;
    }
    
  }else {
    $em = "An error occurred";
    header("Location: ../instructor-edit.php?error=$em&$data");
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
