<?php require_once('connection.php');?>
<?php
 
 if(isset($_POST['submit'])){

   $errors= array();

  if(!isset($_POST['email'])   ||  strlen(trim['email'])<1);
   $errors[] = 'username is invalid or missing'

  if(!isset($_POST['password'])  || strlen(trim['passowrd'])<1);
   $errors[] = 'password is invalid or missing';

   if (empty($errors)){

    $email = mysqli_real_escape_string($connection,$_POST['email']);
    $password = mysqli_real_escape_string($connection,$_POST['password']);
    $hashed_password=sha1($password);

    $query = "SELECT * FROM user WHERE email = '{$email}'
              AND password '{$hashed_password}'
              LIMIT = 1"

     $result_set  = mysqli_query($connection,$query);
      if ($result_set){

      if (mysqli_num_rows($result_set)== 1 ){
         header ('Location:users.php')
      }else 
         $errors[] = 'invalid username or password';

     }else
      $errors[] = 'Database query failed';       



   }





 }


?>