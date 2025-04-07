<?php session_start() ;?>
<?php require_once ('connection.php');?>

<?php 

	$errors = array();

	if (isset($_POST['submit'])) {
		

		// checking required fields
		$req_fields = array('first_name', 'last_name', 'email', 'password');
    $errors = array_merge($errors, check_req_fields($req_fields));

		foreach ($req_fields as $field) {
			if (empty(trim($_POST[$field]))) {
				$errors[] = $field . ' is required';
			}
		}
    $max_len_fields= array('first_name'=>50,'last_name'=> 100, 'email'=>100, 'password'=>40);
		foreach ($max_len_fields as $field => $max_len){
			if (strlen(trim($_POST[$field]))>$max_len){
				$errors[] = $field  .  '   must be less than   '   .$max_len  .  '  charcters';
			}
		}
		if (!is_email($_POST['email'])) {
			$errors[] = 'Email address is invalid.';
		}
	}



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add New User</title>
	<link rel="stylesheet" href="main.css">
</head>
<body>
	<header>
		<div class="appname">User Management System</div>
		<div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?>! <a href="logout.php">Log Out</a></div>
	</header>

	<main>
		<h1>View/modify User<span> <a href="users.php">< Back to User List</a></span></h1>

		<?php 

			if (!empty($errors)) {
				echo '<div class="errmsg">';
				echo '<b>There were error(s) on your form.</b><br>';
				foreach ($errors as $error) {
					echo '- ' . $error . '<br>';
				}
				echo '</div>';
			}

		 ?>

		<form action="adduser.php" method="post" class="userform">
			
			<p>
				<label for="">First Name:</label>
				<input type="text" name="first_name" >
			</p>

			<p>
				<label for="">Last Name:</label>
				<input type="text" name="last_name" >
			</p>

			<p>
				<label for="">Email Address:</label>
				<input type="email" name="email" >
			</p>

			<p>
				<label for="">New Password:</label>
				<input type="password" name="password" >
			</p>

			<p>
				<label for="">&nbsp;</label>
				<button type="submit" name="submit">Save</button>
			</p>

		</form>

		
		
	</main>
</body>
</html>


