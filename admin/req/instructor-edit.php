<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
        

if (isset($_POST['fname'])      &&
    isset($_POST['lname'])      &&
    isset($_POST['username'])   &&
    isset($_POST['instructor_id']) &&
    isset($_POST['address'])  &&
    isset($_POST['employee_number']) &&
    isset($_POST['contact_number'])  &&
    isset($_POST['qualification']) &&
    isset($_POST['email_address']) &&
    isset($_POST['gender'])        &&
    isset($_POST['date_of_birth']) &&
    isset($_POST['subjects'])   &&
    isset($_POST['classes'])) {
    
    include '../../DB_connection.php';
    include "../data/instructor.php";

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['username'];

    $address = $_POST['address'];
    $employee_number = $_POST['employee_number'];
    $contact_number = $_POST['contact_number'];
    $qualification = $_POST['qualification'];
    $email_address = $_POST['email_address'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];

    $instructor_id = $_POST['instructor_id'];
    
    $classes = "";
    foreach ($_POST['classes'] as $class) {
        $classes .=$class;
    }

    $subjects = "";
    foreach ($_POST['subjects'] as $subject) {
        $subjects .=$subject;
    }

    $data = 'instructor_id='.$instructor_id;

    if (empty($fname)) {
        $em  = "First name is required";
        header("Location: ../instructor-edit.php?error=$em&$data");
        exit;
    }else if (empty($lname)) {
        $em  = "Last name is required";
        header("Location: ../instructor-edit.php?error=$em&$data");
        exit;
    }else if (empty($uname)) {
        $em  = "Username is required";
        header("Location: ../instructor-edit.php?error=$em&$data");
        exit;
    }else if (!unameIsUnique($uname, $conn, $instructor_id)) {
        $em  = "Username is taken! try another";
        header("Location: ../instructor-edit.php?error=$em&$data");
        exit;
    }else if (empty($address)) {
        $em  = "Address is required";
        header("Location: ../instructor-edit.php?error=$em&$data");
        exit;
    }else if (empty($employee_number)) {
        $em  = "Employee number is required";
        header("Location: ../instructor-edit.php?error=$em&$data");
        exit;
    }else if (empty($contact_number)) {
        $em  = "Contact number is required";
        header("Location: ../instructor-edit.php?error=$em&$data");
        exit;
    }else if (empty($qualification)) {
        $em  = "Qualification is required";
        header("Location: ../instructor-edit.php?error=$em&$data");
        exit;
    }else if (empty($email_address)) {
        $em  = "Email address is required";
        header("Location: ../instructor-edit.php?error=$em&$data");
        exit;
    }else if (empty($gender)) {
        $em  = "Gender address is required";
        header("Location: ../instructor-edit.php?error=$em&$data");
        exit;
    }else if (empty($date_of_birth)) {
        $em  = "Date of birth address is required";
        header("Location: ../instructor-edit.php?error=$em&$data");
        exit;
    }else {
        $sql = "UPDATE instructors SET
                username = ?, fname=?, lname=?, subjects=?, classes=?,
                address = ?, employee_number=?, date_of_birth = ?, contact_number = ?, qualification = ?, gender = ?, email_address = ?
                WHERE instructor_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname,$fname, $lname, $subjects, $classes, $address, $employee_number, $date_of_birth, $contact_number, $qualification, $gender, $email_address, $instructor_id]);
        $sm = "successfully updated!";
        header("Location: ../instructor-edit.php?success=$sm&$data");
        exit;
    }
    
  }else {
    $em = "An error occurred";
    header("Location: ../instructor.php?error=$em");
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
