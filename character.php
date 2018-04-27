<?php
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");

//Check if user is logged in
$user = check_user_read("1");

include("templates/header.inc.php");

$readonly = true;

if (isset($user['id'])) { //User logged in?
    if (isset($_GET['id'])) {     //User wants to view/edit a character
        $id = $_GET['id'];
        $statement = $pdo->prepare("SELECT account FROM characters WHERE id = $id");
        $result = $statement->execute();
        while ($row = $statement->fetch()) {
            if ($row['account'] == $user['id']) { //User can only edit his own characters
                $readonly = false;
                break;
            }
        }
    } else {
        $readonly = false;
    }
}

if ($readonly == true) {
    echo "Read only mode.";
}
?>

<div class="container main-container">
    <?php
//Is a new character created?		
    if (isset($_GET["new"])) {
        echo "<p>Creating new character.</p>";
        $id = 0;
    }

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    }

//Was the formular used?
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//Let's build an sql statement!

        $sql = "";

        // Build insert into statement	
        if ($id == 0) {
            $sql = $sql . "INSERT INTO characters (account, ";

            foreach ($_POST as $key => $value) {
                $sql = $sql . "" . $key . ", ";
            }

            $sql = substr($sql, 0, -10); //Cut of the last comma and the submit

            $sql = $sql . ") VALUES (" . $_SESSION['userid'] . ", ";

            foreach ($_POST as $key => $value) {
                $sql = $sql . "'" . $value . "', ";
            }

            $sql = substr($sql, 0, -12); //Cut of the last comma and the 'Submit'

            $sql = $sql . ")";
        }
        //Build update statement
        else {
            $sql = $sql . "UPDATE characters SET ";
            foreach ($_POST as $key => $value) {
                $sql = $sql . $key . " = '" . $value . "', ";
            }
            $sql = substr($sql, 0, -21); //Cut of the last comma and the submit stuff

            $sql = $sql . " WHERE ID = " . $id;
        }


        $statement = $pdo->prepare($sql);
        $result = $statement->execute();
    }

//Read character data from database
    $statement = $pdo->prepare("SELECT * FROM characters WHERE id = $id");
    $result = $statement->execute();
    $count = 1;

    while ($row = $statement->fetch()) {
        ?>
        <div class="container-fluid">

            <form action="" method="post">

<!-- NAME -->
                <div class="form-group row">
                    <div class="col-md-2 form">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="First Name">
                            <input class="form-control" value="First Name" disabled>
                        </span>
                    </div>
                    <div class="col-md-4"><input type="text" name="firstName" class="form-control" placeholder="First Name" title="First Name" value="<?php echo $row['firstName']; ?>"  autofocus></div>

                    <div class="col-md-2 form">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Last Name">
                            <input class="form-control" value="Last Name" disabled>
                        </span>
                    </div>
                    <div class="col-md-4"><input type="text" name="lastName" class="form-control" placeholder="Last Name" value="<?php echo $row['lastName']; ?>"  ></div>
                </div>


<!-- GENDER, BIRTHDAY, AGE -->	
    <?php
    $statement = $pdo->prepare("SELECT * FROM sex");
    $result = $statement->execute();
    $gender = $statement->fetchAll();
    ?>

                <div class="form-group row">
                    <div class="col-md-1 form">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Sex">
                            <input class="form-control" value="Sex" disabled>
                        </span>
                    </div>
                    <div class="col-md-3"><select name="sex" id="sex" class="form-control" >
    <?php
    foreach ($gender as &$value) {
        echo "<option";
        if ($row['sex'] == $value["name"]) {
            echo " selected";
        }
        echo ">" . $value["name"] . "</option>";
    }
    ?>
                        </select>
                    </div>
                    <div class="col-md-1 form">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Birthday">
                            <input class="form-control" value="Birthday" disabled>
                        </span>
                    </div>
                    <div class="col-md-3"><input type="text" name="birthday" class="form-control" placeholder="Birthday"  value="<?php echo $row['birthday']; ?>"  ></div>
                    
                    <div class="col-md-1 form">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Age">
                            <input class="form-control" value="Age" disabled>
                        </span>
                    </div>
                    <div class="col-md-3"><input type="text" name="age" class="form-control" placeholder="Age" value="<?php echo $row['age']; ?>"  ></div>
                </div>


<!-- WEIGHT, SIZE, EYES, HAIR -->	
                <div class="form-group row">
                    <div class="col-md-1 form">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Weight">
                            <input class="form-control" value="Weight" disabled>
                        </span>
                    </div>
                    <div class="col-md-2"><input type="text" name="weight" class="form-control" placeholder="Weight" value="<?php echo $row['weight']; ?>"  ></div>
                    
                    <div class="col-md-1 form">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Size">
                            <input class="form-control" value="Size" disabled>
                        </span>
                    </div>
                    <div class="col-md-2"><input type="text" name="size" class="form-control" placeholder="Size" value="<?php echo $row['size']; ?>"  ></div>	
                    
                    <div class="col-md-1 form">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Eyecolor">
                            <input class="form-control" value="Eyecolor" disabled>
                        </span>
                    </div>
                    <div class="col-md-2"><input type="text" name="eyes" class="form-control" placeholder="Eyecolor"  value="<?php echo $row['eyes']; ?>"  ></div>
                    
                    <div class="col-md-1 form">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Hairstyle">
                            <input class="form-control" value="Hairstyle" disabled>
                        </span>
                    </div>
                    <div class="col-md-2"><input type="text" name="hair" class="form-control" placeholder="Hairstyle"  value="<?php echo $row['hair']; ?>"  ></div>
                </div>


<!-- RACE -->			
    <?php
    $statement = $pdo->prepare("SELECT * FROM races ORDER BY id");
    $result = $statement->execute();
    $races = $statement->fetchAll();
    ?>
                <div class="form-group row">
                    <div class="col-md-2 form">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Race">
                            <input class="form-control" value="Race" disabled>
                        </span>
                    </div>
                    <div class="col-md-4">
                        <select name="race" id="race" class="form-control" >

    <?php
    foreach (array_slice($races, 1) as $key => $value) { //First option (None) gets cut out
        echo "<option";
        if ($row['race'] == $value["name"]) {
            echo " selected";
        }
        echo ">" . $value["name"] . "</option>";
    }
    ?>
                        </select>
                    </div>
                    <div class="col-md-2 form">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Subrace">
                            <input class="form-control" value="Subrace" disabled>
                        </span>
                    </div>
                    <div class="col-md-4">
                        <select name="subrace" class="form-control" >
    <?php
    foreach ($races as &$value) {
        echo "<option";
        if ($row['subrace'] == $value["name"]) {
            echo " selected";
        }
        echo ">" . $value["name"] . "</option>";
    }
    ?>
                        </select>
                    </div>
                </div>

<!-- CLASS -->			
    <?php
    $statement = $pdo->prepare("SELECT * FROM classes ORDER BY id");
    $result = $statement->execute();
    $classes = $statement->fetchAll();
    ?>
                <div class="row">
                    <div class="col-md-2 form">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Class">
                            <input class="form-control" value="Class" disabled>
                        </span>
                    </div>
                    <div class="col-md-4">
                        <select name="class" id="class" class="form-control" >

    <?php
    foreach (array_slice($classes, 1) as $key => $value) {
        echo "<option";
        if ($row['class'] == $value["name"]) {
            echo " selected";
        }
        echo ">" . $value["name"] . "</option>";
    }
    ?>
                        </select>
                    </div>
                    <div class="col-md-2 form">
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Subclass">
                            <input class="form-control" value="Subclass" disabled>
                        </span>
                    </div>
                    <div class="col-md-4">
                        <select name="subclass" class="form-control" >
    <?php
    foreach ($classes as &$value) {
        echo "<option";
        if ($row['subclass'] == $value["name"]) {
            echo " selected";
        }
        echo ">" . $value["name"] . "</option>";
    }
    ?>
                        </select>
                    </div>
                </div>

                <br />

                <div class="row">
                    <div class="col-md-12">
    <?php if ($readonly == false) { ?><input type="submit" id="submit" name="submit" class="form-control btn-primary" value="Submit"><?php } ?>
                    </div>
                </div>

            </form>
        </div>

    <?php
}
?>
</div>



    <?php
    include("templates/footer.inc.php")
    ?>