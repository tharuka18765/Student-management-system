<?php session_start();?>
<?php require_once('connection.php');?>
<?php
//check form submition
   if(isset($_POST['submit'])){
// check if username password has been enterd
   $errors = array();

  if(!isset($_POST['email']) || strlen(trim($_POST['email'])) <  1 ){
     $errors[] = 'username is missing/invalid'; 
     }
  if(!isset($_POST['password'])) || strlen(trim($_POST['password'])) < 1{
    $errors[] = 'passwors is missing / invalid';
 }
 //check if any error in the form
  if (empty($errors)){
    //save username password into variabls
    $email    = mysqli_real_escape_string($connection,$_POST['email']);
    $password = mysqli_real_escape_string($connection,$_POST['password']);
    $hashed_password = sha1($password);
    //prepaire the db query
    $query =   "SELECT * FROM user 
                WHERE email =  '{$email}' 
                AND password = '{$hashed_password}' 
                LIMIT = 1 ";
   $result_set = mysqli_query($connection,$query);
   if ($result_set){
      //query succesful
         if (mysqli_num_rows($result_set)==1){
         header ('Loacation:user.php');
         }else
         // username or password invalid
         $errors [] = 'username or password invalid';
     }else
          $errors[]= 'Databse Query failed';
     }


 
   }
 }




?>


