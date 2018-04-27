<?php
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");
include("templates/header.inc.php")
?>





<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <h1>The Last Engine Core</h1>
        <p>
            Working title.
        </p>
        <p><a class="btn btn-primary btn-lg" href="register.php" role="button">Start your character now!</a></p>
    </div>
</div>

<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-4">
            <h2>Features</h2>
            <ul>
                <li>Pen&amp;Paper Role Playing Game</li> 
                <li>Post-Modern Setting</li>
                <li>Cloud Character Saving</li>
                <li>Access from Anywhere</li>
                <li>FREE</li>
            </ul>

        </div>    
        <div class="col-md-4">
            <h2>Start now</h2>
            <p>It's time to start your first character, right? Our online generator offers simple character creation and is easy to use for everyone, even if you never played a Pen&amp;Paper before!</p>
            <p><a class="btn btn-default" href="register.php" role="button">Register Account &raquo;</a></p>
        </div>
        <div class="col-md-4">
            <h2>You like it oldschool?</h2>
            <p>You don't like cloud saving? You love the classic Pen&amp;Paper feeling? Nice! You can simply download a blank sheet here, and use your pen to rule the world!</p>
            <p><a class="btn btn-default" href="#" target="_blank" role="button">Download blank sheet &raquo;</a></p>
        </div>
    </div>
</div> <!-- /container -->



<?php
include("templates/footer.inc.php")
?>
