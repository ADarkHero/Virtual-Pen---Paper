<?php
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");

//Check if user is logged in
$user = check_user();

include("templates/header.inc.php");

if(isset($_GET['save'])) {
	$save = $_GET['save'];
	
	if($save == 'personal_data') {
		$username = trim($_POST['username']);
		
		if($username == "") {
			$error_msg = "Please input your username.";
		} else {
			$statement = $pdo->prepare("UPDATE users SET username = :username, updated_at=NOW() WHERE id = :userid");
			$result = $statement->execute(array('username' => $username, 'userid' => $user['id'] ));
			
			$success_msg = "Daten erfolgreich gespeichert.";
		}
	} else if($save == 'email') {
		$passwort = $_POST['password'];
		$email = trim($_POST['email']);
		$email2 = trim($_POST['email2']);
		
		if($email != $email2) {
			$error_msg = "Your e-mail adresses are different.";
		} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error_msg = "Please input a valid e-mail.";
		} else if(!password_verify($password, $user['password'])) {
			$error_msg = "Your password is incorrect.";
		} else {
			$statement = $pdo->prepare("UPDATE users SET email = :email WHERE id = :userid");
			$result = $statement->execute(array('email' => $email, 'userid' => $user['id'] ));
				
			$success_msg = "E-Mail adress saved successfully.";
		}
		
	} else if($save == 'password') {
		$passwordAlt = $_POST['passwordOld'];
		$passwordNew = trim($_POST['passwordNew']);
		$passwordNew2 = trim($_POST['passwordNew2']);
		
		if($passwordNew != $passwordNew2) {
			$error_msg = "Your passwords are different.";
		} else if($passwortNeu == "") {
			$error_msg = "Your password can't be empty.";
		} else if(!password_verify($passwortAlt, $user['passwort'])) {
			$error_msg = "Please input a correct password.";
		} else {
			$passwort_hash = password_hash($passwortNeu, PASSWORD_DEFAULT);
				
			$statement = $pdo->prepare("UPDATE users SET password = :password WHERE id = :userid");
			$result = $statement->execute(array('password' => $passwort_hash, 'userid' => $user['id'] ));
				
			$success_msg = "Passwort saved successfully.";
		}
		
	}
}

$user = check_user();

?>


<h1>Settings</h1>

<?php 
if(isset($success_msg) && !empty($success_msg)):
?>
	<div class="alert alert-success">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  	<?php echo $success_msg; ?>
	</div>
<?php 
endif;
?>

<?php 
if(isset($error_msg) && !empty($error_msg)):
?>
	<div class="alert alert-danger">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	  	<?php echo $error_msg; ?>
	</div>
<?php 
endif;
?>

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#data" aria-controls="home" role="tab" data-toggle="tab">Personal Data</a></li>
    <li role="presentation"><a href="#email" aria-controls="profile" role="tab" data-toggle="tab">E-Mail</a></li>
    <li role="presentation"><a href="#passwort" aria-controls="messages" role="tab" data-toggle="tab">Password</a></li>
  </ul>

  <!-- Persönliche Daten-->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="data">
    	<br>
    	<form action="?save=personal_data" method="post" class="form-horizontal">
    		<div class="form-group">
    			<label for="inputVorname" class="col-sm-2 control-label">Username</label>
    			<div class="col-sm-10">
    				<input class="form-control" id="inputUsername" name="username" type="text" value="<?php echo htmlentities($user['username']); ?>" required>
    			</div>
    		</div>
    		
    		<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="submit" class="btn btn-primary">Save</button>
			    </div>
			</div>
    	</form>
    </div>
    
    <!-- Änderung der E-Mail-Adresse -->
    <div role="tabpanel" class="tab-pane" id="email">
    	<br>
    	<p>To change your mail adress, you need to input your password again.</p>
    	<form action="?save=email" method="post" class="form-horizontal">
    		<div class="form-group">
    			<label for="inputPasswort" class="col-sm-2 control-label">Password</label>
    			<div class="col-sm-10">
    				<input class="form-control" id="inputPassword" name="password" type="password" required>
    			</div>
    		</div>
    		
    		<div class="form-group">
    			<label for="inputEmail" class="col-sm-2 control-label">E-Mail</label>
    			<div class="col-sm-10">
    				<input class="form-control" id="inputEmail" name="email" type="email" value="<?php echo htmlentities($user['email']); ?>" required>
    			</div>
    		</div>
    		
    		
    		<div class="form-group">
    			<label for="inputEmail2" class="col-sm-2 control-label">E-Mail (again)</label>
    			<div class="col-sm-10">
    				<input class="form-control" id="inputEmail2" name="email2" type="email"  required>
    			</div>
    		</div>
    		
    		<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="submit" class="btn btn-primary">Save</button>
			    </div>
			</div>
    	</form>
    </div>
    
    <!-- Änderung des Passworts -->
    <div role="tabpanel" class="tab-pane" id="passwort">
    	<br>
    	<p>To change your password, please input your old and your new one.</p>
    	<form action="?save=passwort" method="post" class="form-horizontal">
    		<div class="form-group">
    			<label for="inputPasswort" class="col-sm-2 control-label">Old Password</label>
    			<div class="col-sm-10">
    				<input class="form-control" id="inputPassword" name="passwordOld" type="password" required>
    			</div>
    		</div>
    		
    		<div class="form-group">
    			<label for="inputPasswortNeu" class="col-sm-2 control-label">New Password</label>
    			<div class="col-sm-10">
    				<input class="form-control" id="inputPasswordNew" name="passwordNew" type="password" required>
    			</div>
    		</div>
    		
    		
    		<div class="form-group">
    			<label for="inputPasswortNeu2" class="col-sm-2 control-label">New Password (again)</label>
    			<div class="col-sm-10">
    				<input class="form-control" id="inputPasswordNew2" name="passwordNew2" type="password"  required>
    			</div>
    		</div>
    		
    		<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="submit" class="btn btn-primary">Save</button>
			    </div>
			</div>
    	</form>
    </div>
  </div>

</div>
<?php 
include("templates/footer.inc.php")
?>
