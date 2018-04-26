<?php
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");

//Check if user is logged in
$user = check_user();

include("templates/header.inc.php");
?>

<div class="container main-container">


Hi <?php echo htmlentities($user['username']); ?>,<br>
Welcome, dude!<br><br>

<h1>Your characters:</h1>

<div class="panel panel-default">
 
<table class="table">
<tr>
	<th>#</th>
	<th>First Name</th>
	<th>Last Name</th>
	<th>Class</th>
	<th>Race</th>
	<th>Edit</th>
</tr>
<?php 
$id =  $user['id'];
$statement = $pdo->prepare("SELECT id, firstName, lastName, class, subclass, race, subrace
							FROM characters
							WHERE account = $id ORDER BY id");
$result = $statement->execute();
$count = 1;
while($row = $statement->fetch()) {
	echo "<tr>";
	echo "<td>".$count++."</td>";
	echo "<td>".$row['firstName']."</td>";
	echo "<td>".$row['lastName']."</td>";
	echo "<td>".$row['race'].$row['subrace']."</td>";
	echo "<td>".$row['class'].$row['subclass']."</td>";
	echo '<td><a href="character.php?id='.$row['id'].'">Edit</a></td>';
	echo "</tr>";
}
?>
</table>
</div>

<p><a class="btn btn-primary btn-lg" href="character.php?new=true" role="button">Create new Character!</a></p>

</div>
<?php 
include("templates/footer.inc.php")
?>
