<?php session_start(); ?>
<?php require_once('connection.php'); ?>
<?php require_once('funtions.php'); ?>
<?php
if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	$errors = array();
	$first_name = '';
	$last_name = '';
	$email = '';
	$password = '';

	if (isset($_POST['submit'])) {
		
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		// checking required fields
		$req_fields = array('first_name', 'last_name', 'email', 'password');
    foreach ($req_fields as $field) {
			if (empty(trim($_POST[$field]))) {
				$errors[] = $field . ' is required';
			}
		}
		// checking max length
		$max_len_fields = array('first_name' => 50, 'last_name' =>100, 'email' => 100, 'password' => 40);
    foreach ($max_len_fields as $field => $max_len) {
			if (strlen(trim($_POST[$field])) > $max_len) {
				$errors[] = $field . ' must be less than ' . $max_len . ' characters';
			}
		
		// checking email address
		if (!is_email($_POST['email'])) {
			$errors[] = 'Email address is invalid.';
		}

		// checking if email address already exists
		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$query = "SELECT * FROM user WHERE email = '{$email}' LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				$errors[] = 'Email address already exists';
			}
		}

		if (empty($errors)) {
			// no errors found... adding new record
			$first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
			$last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
			$password = mysqli_real_escape_string($connection, $_POST['password']);
			// email address is already sanitized
			$hashed_password = sha1($password);

			$query = "INSERT INTO user ( ";
			$query .= "first_name, last_name, email, password, is_deleted";
			$query .= ") VALUES (";
			$query .= "'{$first_name}', '{$last_name}', '{$email}', '{$hashed_password}', 0";
			$query .= ")";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// query successful... redirecting to users page
				header('Location: users.php?user_added=true');
			} else {
				$errors[] = 'Failed to add the new record.';
			}


		}

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
		<h1>Add New User<span> <a href="users.php">< Back to User List</a></span></h1>

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
				<input type="text" name="first_name" <?php echo 'value="' . $first_name . '"'; ?> >
			</p>

			<p>
				<label for="">Last Name:</label>
				<input type="text" name="last_name" <?php echo 'value="' . $last_name . '"'; ?>>
			</p>

			<p>
				<label for="">Email Address:</label>
				<input type="email" name="email" <?php echo 'value="' . $email . '"'; ?>>
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