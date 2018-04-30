<?php
session_start();
require_once("inc/config.inc.php");
require_once("inc/functions.inc.php");
require_once("inc/character/character.inc.php");
include("templates/header.inc.php");
?>
<div class="container-fluid">
    <?php
        if(!isset($user['id'])){
            $user = "";
        }
        $readonly = checkViewRights("characters", $pdo, $user);
        $statement = databaseFun("characters", $pdo);

        while ($row = $statement->fetch()) {
    ?>


        <form action="" method="post" enctype="multipart/form-data">
            <!-- PICTURES -->
            <div class="form-group row">
                <div class="col-md-2 form" data-toggle="tooltip" title="It's your character!">
                    <?php
                    if ($row['mainPicture'] !== "") {
                        echo '<span class="characterpicture"><center><img src="img/characters/' . $row['mainPicture'] . '" data-toggle="tooltip"></img></center></span>';
                    }
                    ?>
                </div>
                <div class="col-md-2 form" data-toggle="tooltip" title="It's your character!">
                    <?php
                    if ($row['secondaryPicture'] !== "") {
                        echo '<span class="characterpicture"><center><img src="img/characters/' . $row['secondaryPicture'] . '" data-toggle="tooltip" title="It\'s your character!"></img></center></span>';
                    }
                    ?>
                </div>
                <div class="col-md-2 form" data-toggle="tooltip" title="It's your character!">
                    <?php
                    if ($row['tertiaryPicture'] !== "") {
                        echo '<span class="characterpicture"><center><img src="img/characters/' . $row['tertiaryPicture'] . '" data-toggle="tooltip" title="It\'s your character!"></img></center></span>';
                    }
                    ?>
                </div>
                <div class="col-md-1 form">
                    <?php
                    if ($row['weapon'] !== "") {
                        echo '<span id="weapon" class="weaponimage"><center><img src="img/weapon/' . $row['weapon'] . '" data-toggle="tooltip" title="Weapon: ' . substr($row['weapon'], 0, -4) . '"></img></center></span>';
                    }
                    echo '<br />';
                    if ($row['subweapon'] !== "") {
                        echo '<span id="subweapon" class="weaponimage"><center><img src="img/weapon/' . $row['subweapon'] . '" data-toggle="tooltip" title="Subweapon: ' . substr($row['subweapon'], 0, -4) . '"></img></center></span>';
                    }
                    ?>
                </div>
                <div class="col-md-1 form" data-toggle="tooltip" title="">
                </div>
                <div class="col-md-1 form" data-toggle="tooltip" title="Maximum/Current Lifepoints">
                    <input class="form-control" value="LP" disabled>
                    <input type="text" name="lpmax" class="form-control" value="<?php echo $row['lpmax']; ?>"  autofocus>
                    <input class="form-control" value="CLP" disabled>
                    <input type="text" name="lpcurrent" class="form-control" value="<?php echo $row['lpcurrent']; ?>"  autofocus>
                </div>
                <div class="col-md-1 form" data-toggle="tooltip" title="Maximum/Current Mana">
                    <input class="form-control" value="MP" disabled>
                    <input type="text" name="manamax" class="form-control" value="<?php echo $row['manamax']; ?>"  autofocus>
                    <input class="form-control" value="CMP" disabled>
                    <input type="text" name="manacurrent" class="form-control" value="<?php echo $row['manacurrent']; ?>"  autofocus>
                </div>
                <div class="col-md-2 form" data-toggle="tooltip" title="Collected/Current Experience">
                    <input class="form-control" value="EXP" disabled>
                    <input type="text" name="experience" class="form-control" value="<?php echo $row['experience']; ?>"  autofocus>
                    <input class="form-control" value="NOT used EXP" disabled>
                    <input type="text" name="unusedExperience" class="form-control" value="<?php echo $row['unusedExperience']; ?>"  autofocus>
                </div>
            </div>

            <!-- Stats -->
            <div class="form-group row">
                <div class="col-md-1 form" data-toggle="tooltip" title="Courage">
                    <input class="form-control" value="CO" disabled>
                    <input type="text" name="courage" class="form-control" value="<?php echo $row['courage']; ?>"  autofocus>
                </div>
                <div class="col-md-1 form" data-toggle="tooltip" title="Wisdom">
                    <input class="form-control" value="WI" disabled>
                    <input type="text" name="wisdom" class="form-control" value="<?php echo $row['wisdom']; ?>"  autofocus>
                </div>
                <div class="col-md-1 form" data-toggle="tooltip" title="Intuition">
                    <input class="form-control" value="IN" disabled>
                    <input type="text" name="intuition" class="form-control" value="<?php echo $row['intuition']; ?>"  autofocus>
                </div>
                <div class="col-md-1 form" data-toggle="tooltip" title="Charisma">
                    <input class="form-control" value="CH" disabled>
                    <input type="text" name="charisma" class="form-control" value="<?php echo $row['charisma']; ?>"  autofocus>
                </div>
                <div class="col-md-1 form" data-toggle="tooltip" title="Dexterity">
                    <input class="form-control" value="DE" disabled>
                    <input type="text" name="dexterity" class="form-control" value="<?php echo $row['dexterity']; ?>"  autofocus>
                </div>
                <div class="col-md-1 form" data-toggle="tooltip" title="Agility">
                    <input class="form-control" value="AG" disabled>
                    <input type="text" name="agility" class="form-control" value="<?php echo $row['agility']; ?>"  autofocus>
                </div>
                <div class="col-md-1 form" data-toggle="tooltip" title="Physique">
                    <input class="form-control" value="PH" disabled>
                    <input type="text" name="physique" class="form-control" value="<?php echo $row['physique']; ?>"  autofocus>
                </div>
                <div class="col-md-1 form" data-toggle="tooltip" title="Strenght">
                    <input class="form-control" value="ST" disabled>
                    <input type="text" name="strenght" class="form-control" value="<?php echo $row['strenght']; ?>"  autofocus>
                </div>
            </div>



            <!-- NAME -->
            <div class="form-group row">
                <div class="col-md-4 form" data-toggle="tooltip" title="First Name">
                    <input class="form-control" value="First Name" disabled>
                    <input type="text" name="firstName" class="form-control" placeholder="First Name" value="<?php echo $row['firstName']; ?>"  autofocus>
                </div>

                <div class="col-md-4 form" data-toggle="tooltip" title="Title">
                    <input class="form-control" value="Title" disabled>
                    <input type="text" name="title" class="form-control" placeholder="Title" value="<?php echo $row['title']; ?>"  >
                </div>

                <div class="col-md-4 form" data-toggle="tooltip" title="Last Name">
                    <input class="form-control" value="Last Name" disabled>
                    <input type="text" name="lastName" class="form-control" placeholder="Last Name" value="<?php echo $row['lastName']; ?>"  >
                </div>
            </div>



            <!-- GENDER, BIRTHDAY, AGE -->	
            <?php
            $statement = $pdo->prepare("SELECT * FROM sex");
            $result = $statement->execute();
            $gender = $statement->fetchAll();
            ?>

            <div class="form-group row">
                <div class="col-md-4 form" data-toggle="tooltip" title="Sex">
                    <input class="form-control" value="Sex" disabled>
                    <select name="sex" id="sex" class="form-control" >
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
                <div class="col-md-4 form" data-toggle="tooltip" title="Birthday">
                    <input class="form-control" value="Birthday" disabled>
                    <input type="text" name="birthday" class="form-control" placeholder="Birthday"  value="<?php echo $row['birthday']; ?>"  >
                </div>

                <div class="col-md-4 form" data-toggle="tooltip" title="Age">
                    <input class="form-control" value="Age" disabled>
                    <input type="text" name="age" class="form-control" placeholder="Age" value="<?php echo $row['age']; ?>"  >
                </div>
            </div>



            <!-- WEIGHT, SIZE, EYES, HAIR -->	
            <div class="form-group row">
                <div class="col-md-3 form" data-toggle="tooltip" title="Weight">
                    <input class="form-control" value="Weight" disabled>
                    <input type="text" name="weight" class="form-control" placeholder="Weight" value="<?php echo $row['weight']; ?>"  >
                </div>

                <div class="col-md-3 form" data-toggle="tooltip" title="Size">
                    <input class="form-control" value="Size" disabled>
                    <input type="text" name="size" class="form-control" placeholder="Size" value="<?php echo $row['size']; ?>"  >
                </div>

                <div class="col-md-3 form" data-toggle="tooltip" title="Eyecolor">
                    <input class="form-control" value="Eyecolor" disabled>
                    <input type="text" name="eyes" class="form-control" placeholder="Eyecolor"  value="<?php echo $row['eyes']; ?>"  >
                </div>

                <div class="col-md-3 form" data-toggle="tooltip" title="Hairstyle">
                    <input class="form-control" value="Hairstyle" disabled>
                    <input type="text" name="hair" class="form-control" placeholder="Hairstyle"  value="<?php echo $row['hair']; ?>"  >
                </div>
            </div>



            <!-- RACE -->			
            <?php
            $statement = $pdo->prepare("SELECT * FROM races ORDER BY id");
            $result = $statement->execute();
            $races = $statement->fetchAll();
            ?>
            <div class="form-group row">
                <div class="col-md-3 form" data-toggle="tooltip" title="Race">
                    <input class="form-control" value="Race" disabled>
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
                <div class="col-md-3 form" data-toggle="tooltip" title="Subrace">
                    <input class="form-control" value="Subrace" disabled>
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



                <!-- CLASS -->			
                <?php
                $statement = $pdo->prepare("SELECT * FROM classes ORDER BY id");
                $result = $statement->execute();
                $classes = $statement->fetchAll();
                ?>
                <div class="col-md-3 form" data-toggle="tooltip" title="Class">
                    <input class="form-control" value="Class" disabled>
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
                <div class="col-md-3 form" data-toggle="tooltip" title="Subclass">
                    <input class="form-control" value="Subclass" disabled>
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



            <!-- WEAPON -->
            <div class="form-group row">
                <div class="col-md-6 form" data-toggle="tooltip" title="Weapon">
                    <input class="form-control" value="Weapon" disabled>
                    <select name="weapon" class="form-control" onchange='changeWeapon(this.value, "weapon")'>
                        <?php
                        weapongenerator($row, "weapon");
                        ?>
                    </select>
                </div>
                <div class="col-md-6 form" data-toggle="tooltip" title="Subweapon">
                    <input class="form-control" value="Subweapon" disabled>
                    <select name="subweapon" class="form-control" onchange='changeWeapon(this.value, "subweapon")'>
                        <?php
                        weapongenerator($row, "subweapon");
                        ?>
                    </select>
                </div>
            </div>  

            <!-- DESCRIPTION -->
            <div class="form-group row">
                <div class="col-md-12 form" data-toggle="tooltip" title="Description">
                    <input class="form-control" value="Description" disabled>
                    <textarea class="form-control" rows="5" name="description" placeholder="Description" ><?php echo $row['description']; ?></textarea>
                </div>    
            </div>



            <!-- TALENTS -->
            <div class="form-group row">
                <div class="col-md-4 form" data-toggle="tooltip" title="Fighting talents">
                    <input class="form-control" value="Fighting talents" disabled>
                    <textarea class="form-control" rows="10" name="fightingTalents" placeholder="Fighting talents" ><?php echo $row['fightingTalents']; ?></textarea>
                </div>    
                <div class="col-md-4 form" data-toggle="tooltip" title="Body talents">
                    <input class="form-control" value="Body talents" disabled>
                    <textarea class="form-control" rows="10" name="bodyTalents" placeholder="Body talents" ><?php echo $row['bodyTalents']; ?></textarea>
                </div>
                <div class="col-md-4 form" data-toggle="tooltip" title="Society talents">
                    <input class="form-control" value="Society talents" disabled>
                    <textarea class="form-control" rows="10" name="societyTalents" placeholder="Society talents" ><?php echo $row['societyTalents']; ?></textarea>
                </div> 
            </div>

            <div class="form-group row">
                <div class="col-md-4 form" data-toggle="tooltip" title="Nature talents">
                    <input class="form-control" value="Nature talents" disabled>
                    <textarea class="form-control" rows="10" name="natureTalents" placeholder="Nature talents" ><?php echo $row['natureTalents']; ?></textarea>
                </div>    
                <div class="col-md-4 form" data-toggle="tooltip" title="Knowledge talents">
                    <input class="form-control" value="Knowledge talents" disabled>
                    <textarea class="form-control" rows="10" name="knowledgeTalents" placeholder="Knowledge talents" ><?php echo $row['knowledgeTalents']; ?></textarea>
                </div>
                <div class="col-md-4 form" data-toggle="tooltip" title="Craft talents">
                    <input class="form-control" value="Craft talents" disabled>
                    <textarea class="form-control" rows="10" name="craftTalents" placeholder="Craft talents" ><?php echo $row['craftTalents']; ?></textarea>
                </div> 
            </div>

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
                    <?php } else {?>
                    <div class="col-md-12 form" data-toggle="tooltip" title="Please save your character, before uploading pictures.">
                        <input class="form-control" value="Please save your character, before uploading pictures." disabled>
                    </div>
                    <?php }?>
                </div>

                <!-- PUBLIC CHARACTER? -->
                <div class="form-group row">
                    <div class="col-md-12 form" data-toggle="tooltip" title="Public character?">
                        <input class="form-control" value="Is your character public?" disabled>      
                        <fieldset>
                            <input class="form-check-input" type="radio" id="publicEntry" name="publicEntry" value="true" <?php                            
                if ($row['publicEntry'] === "true") {
                    echo " checked";
                }
                ?>>
                            <label class="form-check-label" for="publicEntry">Public character (you can share your character with other persons and in groups)</label><br />
                            <input class="form-check-input" type="radio" id="publicEntryFalse" name="publicEntry" value="false" <?php
                    if ($row['publicEntry'] === "false") {
                        echo " checked";
                    }
                ?>>
                            <label class="form-check-label" for="publicEntryFalse">NON public character</label>
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
                    <div class="col-md-12 form" data-toggle="tooltip" title="DANGER ZONE! (Type BANANA to delete character)">
                        <input class="form-control" value="DANGER ZONE! (Type BANANA to delete character)" disabled>
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

    </div>

    <?php
}
?>



<script src="js/character/character.js" type="text/javascript"></script>
<?php
include("templates/footer.inc.php")
?>