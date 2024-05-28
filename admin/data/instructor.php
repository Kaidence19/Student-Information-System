<?php  

// Get Instructor by ID
function getInstructorById($instructor_id, $conn){
   $sql = "SELECT * FROM instructors
           WHERE instructor_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$instructor_id]);

   if ($stmt->rowCount() == 1) {
     $instructor = $stmt->fetch();
     return $instructor;
   }else {
    return 0;
   }
}

// All Teachers 
function getAllInstructors($conn){
   $sql = "SELECT * FROM instructors";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     $instructors = $stmt->fetchAll();
     return $instructors;
   }else {
   	return 0;
   }
}

// Check if the username Unique
function unameIsUnique($uname, $conn, $instructor_id=0){
   $sql = "SELECT username, instructor_id FROM instructors
           WHERE username=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$uname]);
   
   if ($instructor_id == 0) {
     if ($stmt->rowCount() >= 1) {
       return 0;
     }else {
      return 1;
     }
   }else {
    if ($stmt->rowCount() >= 1) {
       $instructor = $stmt->fetch();
       if ($instructor['instructor_id'] == $instructor_id) {
         return 1;
       }else {
        return 0;
      }
     }else {
      return 1;
     }
   }
   
}

// DELETE
function removeInstructor($id, $conn){
   $sql  = "DELETE FROM instructors
           WHERE instructor_id=?";
   $stmt = $conn->prepare($sql);
   $re   = $stmt->execute([$id]);
   if ($re) {
     return 1;
   }else {
    return 0;
   }
}

// Search 
function searchInstructors($key, $conn){
   $key = preg_replace('/(?<!\\\)([%_])/', '\\\$1',$key);

   $sql = "SELECT * FROM instructors
           WHERE instructor_id LIKE ? 
           OR fname LIKE ?
           OR lname LIKE ?
           OR username LIKE ?
           OR employee_number LIKE ?
           OR contact_number LIKE ?
           OR qualification LIKE ?
           OR email_address LIKE ?
           OR address LIKE ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$key, $key, $key, $key, $key,$key, $key, $key, $key]);

   if ($stmt->rowCount() == 1) {
     $instructors = $stmt->fetchAll();
     return $instructors;
   }else {
    return 0;
   }
}