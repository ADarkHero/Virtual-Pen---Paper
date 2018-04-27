<?php error_reporting(-1); ?>

<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ADarkHero RPG</title>

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    
      <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        
        <script src="js/header/dice.js" type="text/javascript"></script>
        
        <!-- Script for tooltips -->
  <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
  </head>
  <body>
  
  <nav class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><i class="glyphicon glyphicon-leaf logo"></i> Logo Stuff</a>
        </div>
        <?php if(!is_checked_in()): ?>
        <div id="navbar" class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" action="login.php" method="post">
			<table class="login" role="presentation">
				<tbody>
					<tr>
						<td>							
							<div class="input-group">
								<div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
								<input class="form-control" placeholder="Username" name="username" type="text" required>								
							</div>
						</td>
						<td><input class="form-control" placeholder="Password" name="password" type="password" value="" required></td>
						<td><button type="submit" class="btn btn-success">Login</button></td>
					</tr>
					<tr>
						<td><label style="margin-bottom: 0px; font-weight: normal;"><input type="checkbox" name="stay_signed_in" value="stay_signed_in" title="Stay signed in"  checked="checked" style="margin: 0; vertical-align: middle;" /> <small>Stay signed in</small></label></td>
						<td><small><a href="passwortvergessen.php">Forgot your password?</a></small></td>
						<td></td>
					</tr>					
				</tbody>
			</table>		
          
            
          </form>         
        </div><!--/.navbar-collapse -->
        <?php else: ?>
        <div id="navbar" class="navbar-collapse collapse">
         <ul class="nav navbar-nav navbar-right">  
            <li><a href="#"><span id="diceroll"></span></a></li>
            <li><a onclick="rolld6()" href="#"><img id="d6" class="headerdice" onclick="$(this).addClass('rotated');"src="img/dice/rolling-dices.svg"></img></a></li>
            <li><a onclick="rolld20()" href="#"><img id="d20" class="headerdice" src="img/dice/dice-twenty-faces-twenty.svg"></img></a></li>
            <li><a href="internal.php"><?php $user = check_user_read("1"); echo htmlentities($user['username']); ?></a></li> 
            <li><a href="internal.php">Character Overview</a></li>       
            <li><a href="settings.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>   
        </div><!--/.navbar-collapse -->
        <?php endif; ?>
      </div>
    </nav>
      
      <div class="container main-container">