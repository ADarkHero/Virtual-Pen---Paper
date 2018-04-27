<?php 
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");

$error_msg = "";
if(isset($_POST['username']) && isset($_POST['password'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
	$result = $statement->execute(array('username' => $username));
	$user = $statement->fetch();

	//Check password
	if ($user !== false && password_verify($password, $user['password'])) {
		$_SESSION['userid'] = $user['id'];

		//Does the user want to stay signed in?
		if(isset($_POST['stay_signed_in'])) {
			$identifier = random_string();
			$securitytoken = random_string();
				
			$insert = $pdo->prepare("INSERT INTO securitytokens (user_id, identifier, securitytoken) VALUES (:user_id, :identifier, :securitytoken)");
			$insert->execute(array('user_id' => $user['id'], 'identifier' => $identifier, 'securitytoken' => sha1($securitytoken)));
			setcookie("identifier",$identifier,time()+(3600*24*365)); //Valid for 1 year
			setcookie("securitytoken",$securitytoken,time()+(3600*24*365)); //Valid for 1 year
		}

		header("location: internal.php");
		exit;
	} else {
		$error_msg =  "E-Mail or password were wrong.<br><br>";
	}

}

$email_value = "";
if(isset($_POST['email']))
	$email_value = htmlentities($_POST['email']); 

include("templates/header.inc.php");
?>
 <div class="container small-container-330 form-signin">
  <form action="login.php" method="post">
	<h2 class="form-signin-heading">Login</h2>
	
<?php 
if(isset($error_msg) && !empty($error_msg)) {
	echo $error_msg;
}
?>
	<label for="inputUsername" class="sr-only">Username</label>
	<input type="text" name="username" id="inputEmail" class="form-control" placeholder="Username" value="<?php echo $email_value; ?>" required autofocus>
	<label for="inputPassword" class="sr-only">Password</label>
	<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
	<div class="checkbox">
	  <label>
		<input type="checkbox" value="stay_signed_in" name="stay_signed_in" value="1" checked> Stay signed in
	  </label>
	</div>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
	<br>
	<a href="passwordvergessen.php">Forget your password?</a>
  </form>

</div> <!-- /container -->
 

<?php 
include("templates/footer.inc.php")
?>