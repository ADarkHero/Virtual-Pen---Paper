<?php 
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");

include("templates/header.inc.php")
?>
<div class="container main-container registration-form">
<h1>Registration</h1>
<?php
$showFormular = true; //Shall the formular be displayed?
 
if(isset($_GET['register'])) {
	$error = false;
	$username = trim($_POST['username']);
	$email = trim($_POST['email']);
	$password = $_POST['password'];
	$password2 = $_POST['password2'];
	
	if(empty($username) || empty($email)) {
		echo 'Please fill out every column!<br>';
		$error = true;
	}
  
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo 'Your mail adress seems false.<br>';
		$error = true;
	} 	
	if(strlen($password) == 0) {
		echo 'Please select a password!<br>';
		$error = true;
	}
	if($password != $password2) {
		echo 'Your passwords seem different.<br>';
		$error = true;
	}
	
	//Check, if E-Mail was not registered before
	if(!$error) { 
		$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
		$result = $statement->execute(array('email' => $email));
		$user = $statement->fetch();
		
		if($user !== false) {
			echo 'Your e-mail adress is already used!<br>';
			$error = true;
		}	
	}
	
	//No errors, register the User
	if(!$error) {	
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		$sql = "INSERT INTO users (email, password, username) VALUES ('".$email."', '".$password_hash."', '".$username."')";
		$statement = $pdo->prepare($sql);
		$result = $statement->execute();

		if($result) {		
			echo 'You were successfully registered. <a href="login.php"> Login</a>';
			$showFormular = false;
		} else {
			echo 'Error, while writing the user into the database.<br>';
		}
	} 
}
 
if($showFormular) {
?>

<form action="?register=1" method="post">

<div class="form-group">
<label for="inputusername">Username:</label>
<input type="text" id="inputusername" size="40" maxlength="250" name="username" class="form-control" required>
</div>

<div class="form-group">
<label for="inputEmail">E-Mail:</label>
<input type="email" id="inputEmail" size="40" maxlength="250" name="email" class="form-control" required>
</div>

<div class="form-group">
<label for="inputPassword">Password:</label>
<input type="password" id="inputPassword" size="40"  maxlength="250" name="password" class="form-control" required>
</div> 

<div class="form-group">
<label for="inputPassword2">Password (again):</label>
<input type="password" id="inputPassword2" size="40" maxlength="250" name="password2" class="form-control" required>
</div> 
<button type="submit" class="btn btn-lg btn-primary btn-block">Register</button>
</form>
 
<?php
} //Ende von if($showFormular)
	

?>
</div>
<?php 
include("templates/footer.inc.php")
?>