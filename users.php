<?php session_start(); ?>
<?php require_once('connection.php');?>
<?php require_once('funtions.php');?>
<?php
     if(!isset($_SESSION['user_id'])){
      header('location:index.php');
     }
     
   $user_list="";
   $query="SELECT * FROM user WHERE is_deleted=0 ORDER BY first_name";
   $users=mysqli_query($connection,$query);

   verify_query($users);   
    while ($user = mysqli_fetch_assoc($users)){
      $user_list.="<tr>";
      $user_list.="<td>{$user['first_name']}</td>";
      $user_list.="<td>{$user['last_name']}</td>";
      $user_list.="<td>{$user['last_login']}</td>";
      $user_list.="<td><a href=\"modify-user.php?user_id={$user['id']}\">Edit</a></td>";
      $user_list.="<td><a href=\"delete-user.php?user_id={$user['id']}\">Delete</a></td>";
      $user_list.="</tr>";
      

    }
    
   ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width , initial-scale=1.0">
  <link rel="stylesheet" href="main.css">
  <title>Users</title>
</head>
<body>
  <header>
  
    <div class="appname">User manngement system</div>
    <div class="loggedin">Welcome <?php echo $_SESSION['first_name']?>!<a href="logout.php">  Log out</a></div>
</header>
<main>
<h1>Users<span><a href="adduser.php">  + Add New</a></span></h1>
<table class="masterlist">
  <tr>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Last Login</th>
    <th>Edit</th>
    <th>Delete</th>
  </tr>
  
  <?php echo $user_list; ?>
  
  
 
</table>
</main> 

</body>
</html>
<?php mysqli_close($connection);?>