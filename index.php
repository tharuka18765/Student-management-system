<?php session_start(); ?>
<?php require_once('connection.php');?> 
<?php require_once('funtions.php');?>
<?php
//check form subbmition
if(isset ($_POST['submit'])){
  $errors= array();
//check if the username and password has been enterd 
  if (!isset ($_POST['email']) || strlen(trim($_POST['email']))< 1  ){
  $errors[] = 'Username is missing/invalid';
  }
  if (!isset ($_POST['password'])|| strlen(trim($_POST['password']))< 1  ){
  $errors[] = 'password is missing/invalid';
  }
  if(empty($errors)){
  //check if thear are any errors in the form
  //save username and password into variables
  $email   = mysqli_real_escape_string($connection,$_POST['email']);
  $password= mysqli_real_escape_string($connection,$_POST['password']);
  $hashed_password = sha1($password);

  //prepare the database quary
  $query="SELECT * FROM user
  WHERE email='{$email}'
  AND password= '{$hashed_password}'
  LIMIT 1"; 
  $result_set = mysqli_query($connection, $query);
  verify_query($result_set);
    if (mysqli_num_rows($result_set)==1 ){
      $user    =mysqli_fetch_assoc( $result_set);
      $_SESSION['user_id']=$user['id'];
      $_SESSION['first_name']=$user['first_name'];
      // update last login
      $query = "UPDATE user SET last_login = NOW() ";
			$query .= "WHERE id = {$_SESSION['user_id']} LIMIT 1";

				$result_set = mysqli_query($connection, $query);

				verify_query($result_set);
      
      header('location:users.php');
    }else{
      $errors[]= 'invalid username or password';
    }
  }
  //check if the user is valid 
  //redirect t ouser.php
  // if not display the errer
  }




?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login system</title>
  <link rel="stylesheet" href="main.css">
</head>
<body>
  <div class="login">
   <form action="index.php" method="post">
    <fieldset>
     <legend><h1>Login</h1></legend>
     <?php 
					if (isset($errors) && !empty($errors)) {
						echo '<p class="error">Invalid Username / Password</p>';
					}
				?>
      
      <?php 
					if (isset($_GET['logout'])) {
						echo '<p class="info"> successfully logged out </p>';
					}
				?>
        
        
         

     <p>
      <label for="">Username</label>
      <input type="text" name="email" id=""placeholder="Email Address">
     </p>
      <p>
        <label for="">Password</label>
        <input type="password" name="password" id="" placeholder="Password">
      </p> 
      <p>
        <button type="submit" name="submit">Log In</button>
      </p>
  
    </fieldset>
   </form>
  </div>
</body>
</html>
<?php mysqli_close($connection);?>