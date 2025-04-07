<?php session_start();?>
<?php  require_once('connection.php');?>
<?php
if(!isset($_SESSION['user_id']));{
  header('Location:index.php');
}
$user_list = '';
$query = "SELECT*FROM user WHERE is_deleted=0 ORDER BY first_name";
$users=mysqli_query($connection,$query);

if($users){
  while ($user = mysqli_fetch_assoc($users));{
    $user_list.="<tr>";
    $user_list.="<td?>{$user['first_name']}</td>";
    $user_list.="<td?>{$user['last_name']}</td>";
    $user_list.="<td?>{$user['last_login']}</td>";
    $user_list.="<td?><a href= \"modify_user.php?user_id={$user['id']}\">Edit</a></td>";
    $user_list.="<td?><a href= \" delete_user.php?user_id={$user['id']}\"</a>Delete</td>";

    $user_list.="</td>";

    }

}else{
  echo "Databse query failed";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>Users</title>
</head>
<body>
  <header>
  <div class="appname">User mangement system</div>
  <div class="loggedin">Welcome usename!<a href="logout.php"></a></div>
</header>
<main>
 <h1>Users<span><a href="add_user.php">  +Add new</a></span></h1>

 <table class="masterlist">
<tr>
  <th>first name</th>
  <th>last name</th>
  <th>last login</th>
  <th>edit</th>
  <th>delete</th>
</tr>



 </table>

</main>
</body>
</html>
<?php mysqli_close($connection);?>