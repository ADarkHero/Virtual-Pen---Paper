<?php
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");
include("templates/header.inc.php");
?>
<div class="container-fluid">
    <?php
    if (!isset($user['id'])) {
        $user = "";
    }
    $readonly = checkViewRights("groups", $pdo, $user);
    $statement = databaseFun("groups", $pdo);

    while ($row = $statement->fetch()) {
        ?>
        <form action="" method="post" enctype="multipart/form-data">

            <div class="form-group row">
                <div class="col-md-4 form" data-toggle="tooltip" title="It's your group pic!">
                    <?php
                    if ($row['mainPicture'] !== "") {
                        echo '<a href="img/groups/' . $row['mainPicture'] . '" target="_blank" class="characterpicture"><center><img src="img/groups/' . $row['mainPicture'] . '" data-toggle="tooltip" title="It\'s your group pic!"></img></center></a>';
                    }
                    ?>
                </div>
                <div class="col-md-4 form" data-toggle="tooltip" title="It's your character!">
                    <?php
                    if ($row['secondaryPicture'] !== "") {
                        echo '<a href="img/groups/' . $row['secondaryPicture'] . '" target="_blank" class="characterpicture"><center><img src="img/groups/' . $row['secondaryPicture'] . '" data-toggle="tooltip" title="It\'s your group pic!"></img></center></a>';
                    }
                    ?>
                </div>
                <div class="col-md-4 form" data-toggle="tooltip" title="It's your character!">
                    <?php
                    if ($row['tertiaryPicture'] !== "") {
                        echo '<a href="img/groups/' . $row['tertiaryPicture'] . '" target="_blank" class="characterpicture"><center><img src="img/groups/' . $row['tertiaryPicture'] . '" data-toggle="tooltip" title="It\'s your group pic!"></img></center></a>';
                    }
                    ?>
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-md-12 form" data-toggle="tooltip" title="Groupname">
                    <input class="form-control" value="Groupname" disabled>
                    <input type="text" name="groupname" class="form-control" placeholder="Groupname" value="<?php echo $row['groupname']; ?>"  >
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-md-12 form" data-toggle="tooltip" title="Add member to group">
                    <input class="form-control" value="Member character IDs (seperated with comma)" disabled>
                    <input type="text" name="members" class="form-control" placeholder="Members" value="<?php echo $row['members']; ?>"  >
                </div>
            </div>
            <?php if (isset($_GET["id"])) { ?>
            <table class="table">
            <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Class</th>
                    <th>Race</th>
                    <th>View</th>
            </tr>
            <?php 
            $id =  $user['id'];
            $sql = "SELECT id, firstName, lastName, class, subclass, race, subrace FROM characters WHERE ";
            $characterList = explode(", ", $row['members']);
            foreach($characterList as &$value){
                $sql = $sql."id = '".$value."' OR ";
            }
            $sql = substr($sql, 0, -3); //Cut last OR
            $sql = $sql."ORDER BY lastName";
            $statement = $pdo->prepare($sql);
            $result = $statement->execute();
            while($raw = $statement->fetch()) {
                    echo "<tr>";
                    echo "<td>".$raw['id']."</td>";
                    echo "<td>".$raw['firstName']."</td>";
                    echo "<td>".$raw['lastName']."</td>";
                    echo "<td>".$raw['race']." ".$raw['subrace']."</td>";
                    echo "<td>".$raw['class']." ".$raw['subclass']."</td>";
                    echo '<td><a href="character.php?id='.$raw['id'].'">View</a></td>';
                    echo "</tr>";
            }
            ?>
            </table>
            <?php } ?>
            
            <?php if ($readonly == false) { ?>

                <!-- PICTURE UPLOAD -->
                <div class="form-group row">
                    <?php if (isset($_GET["id"])) { ?>
                        <div class="col-md-12 form" data-toggle="tooltip" title="Picture upload">
                            <input class="form-control" value="Picture upload" disabled>
                        </div>
                        <div class="col-md-4 form" data-toggle="tooltip" title="Main picture">
                            <input class="form-control" type="file" name="mainPicture">
                        </div>
                        <div class="col-md-4 form" data-toggle="tooltip" title="Secondary picture">
                            <input class="form-control" type="file" name="secondaryPicture">
                        </div>
                        <div class="col-md-4 form" data-toggle="tooltip" title="Tertiary picture">
                            <input class="form-control" type="file" name="tertiaryPicture">
                        </div>     
                    <?php } else { ?>
                        <div class="col-md-12 form" data-toggle="tooltip" title="Please save your group, before uploading pictures.">
                            <input class="form-control" value="Please save your group, before uploading pictures." disabled>
                        </div>
                    <?php } ?>
                </div>
                <!-- PUBLIC GROUP? -->
                <div class="form-group row">
                    <div class="col-md-12 form" data-toggle="tooltip" title="Public group?">
                        <input class="form-control" value="Is your group public?" disabled>      
                        <fieldset>
                            <input class="form-check-input" type="radio" id="publicEntry" name="publicEntry" value="true" <?php
                if ($row['publicEntry'] === "true") {
                    echo " checked";
                }
                ?>>
                            <label class="form-check-label" for="publicEntry">Public group (you can share your group with other persons and in groups)</label><br />
                            <input class="form-check-input" type="radio" id="publicEntryFalse" name="publicEntry" value="false" <?php
                    if ($row['publicEntry'] === "false") {
                        echo " checked";
                    }
                ?>>
                            <label class="form-check-label" for="publicEntryFalse">NON public group (Only members can see the group)</label>
                        </fieldset>
                    </div>   
                </div>
                <!-- Only Admin Mode? -->
                <div class="form-group row">
                    <div class="col-md-12 form" data-toggle="tooltip" title="Admin Mode?">
                        <input class="form-control" value="Who can edit your group?" disabled>      
                        <fieldset>
                            <input class="form-check-input" type="radio" id="onlyAdminMode" name="onlyAdminMode" value="true" <?php
                if ($row['onlyAdminMode'] === "true") {
                    echo " checked";
                }
                ?>>
                            <label class="form-check-label" for="onlyAdminMode">Only the creator</label><br />
                            <input class="form-check-input" type="radio" id="onlyAdminModeFalse" name="onlyAdminMode" value="false" <?php
                    if ($row['onlyAdminMode'] === "false") {
                        echo " checked";
                    }
                ?>>
                            <label class="form-check-label" for="onlyAdminModeFalse">Every member</label>
                        </fieldset>
                    </div>   
                </div>
                
                
                <!-- SUBMIT BUTTON -->	

                <div class="form-group row">
                    <div class="col-md-12">
                        <input type="submit" id="submit" name="submit" class="form-control btn-primary" value="Submit">
                    </div>
                </div>

            </form>

            <br /><br /><br />


            <form action="" method="post">
                <!-- DELETE BUTTON -->
                <div class="form-group row">
                    <div class="col-md-12 form" data-toggle="tooltip" title="DANGER ZONE! (Type BANANA to delete group)">
                        <input class="form-control" value="DANGER ZONE! (Type BANANA to delete group)" disabled>
                    </div>    
                    <div class="col-md-6">
                        <input type="text" id="submit" name="deleteEntry" class="form-control" placeholder="Type BANANA to delete" value="">
                    </div>
                    <div class="col-md-6">
                        <input type="submit" id="delete" name="submit" class="form-control btn-danger" value="DELETE">
                    </div>
                </div>
            </form>

        <?php } ?>

        <?php
        include("templates/footer.inc.php")
        ?>
    <?php } ?>
