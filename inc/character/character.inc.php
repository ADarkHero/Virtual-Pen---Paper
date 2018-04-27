<?php

function weapongenerator($row, $currentrow) {
        $weapons = scandir("img/weapon"); //Path with all weapons
        foreach ($weapons as &$weapon) {
            echo "<option";
            if ($row[$currentrow] == $weapon) {
                echo " selected";
            }
            echo " value='" . $weapon . "'>" . substr($weapon, 0, -4) . "</option>";    //Cut .svg away
        }
    }

    function updatePictures($pictoupdate, $pdo, $id) {
        //Update pictures
        $target_dir = "img/character/";
        $target_file = $target_dir . basename($_FILES[$pictoupdate]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        error_reporting(0);
        $check = getimagesize($_FILES[$pictoupdate]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES[$pictoupdate]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES[$pictoupdate]["name"]) . " has been uploaded.";
                $sql = "UPDATE characters SET " . $pictoupdate . " = '" . basename($_FILES[$pictoupdate]["name"]) . "' WHERE ID = " . $id;
                $statement = $pdo->prepare($sql);
                $result = $statement->execute();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
            error_reporting(-1);
        }
    }

