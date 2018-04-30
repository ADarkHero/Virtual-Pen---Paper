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

    

