<?php
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");

//Check if user is logged in
$user = check_user();

include("templates/header.inc.php");
?>

Hi <?php echo htmlentities($user['username']); ?>,<br>
Welcome, dude!<br><br>

<h1>Your groups:</h1>

<div class="panel panel-default">
 
<table class="table">
<tr>
	<th>#</th>
	<th>Group Name</th>
	<th>View</th>
</tr>
<?php 
$id =  $user['id'];
$sql = "SELECT id FROM characters  WHERE account = '".$id."' ORDER BY id";
$statement = $pdo->prepare($sql);
$result = $statement->execute();
$sql = "SELECT id, groupname FROM groups  WHERE ";
while($raw = $statement->fetch()) {
	$sql = $sql."members LIKE '%".$raw['id']."%' OR ";
}
$sql = $sql." account = '".$id."' ORDER BY id";
$statement = $pdo->prepare($sql);
$result = $statement->execute();
while($row = $statement->fetch()) {
	echo "<tr>";
	echo "<td>".$row['id']."</td>";
	echo "<td>".$row['groupname']."</td>";
	echo '<td><a href="group.php?id='.$row['id'].'">View</a></td>';
	echo "</tr>";
}
?>
</table>
</div>

<p><center><a class="btn btn-primary btn-lg" href="group.php?new=true" role="button">Create new Group!</a></center></p>

<?php 

    include("templates/footer.inc.php")
?>
