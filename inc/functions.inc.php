<?php

include_once("password.inc.php");

/**
 * Checks that the user is logged in. 
 * @return Returns the row of the logged in user
 */
function check_user() {
    return check_user_read("0");
}

function check_user_read($allowread) {
    global $pdo;

    if (!isset($_SESSION['userid']) && isset($_COOKIE['identifier']) && isset($_COOKIE['securitytoken'])) {
        $identifier = $_COOKIE['identifier'];
        $securitytoken = $_COOKIE['securitytoken'];

        $statement = $pdo->prepare("SELECT * FROM securitytokens WHERE identifier = ?");
        $result = $statement->execute(array($identifier));
        $securitytoken_row = $statement->fetch();

        if (sha1($securitytoken) !== $securitytoken_row['securitytoken']) {
            //Token stolen
            //Insert warning
        } else { //Token correct
            //Set new token
            $neuer_securitytoken = random_string();
            $insert = $pdo->prepare("UPDATE securitytokens SET securitytoken = :securitytoken WHERE identifier = :identifier");
            $insert->execute(array('securitytoken' => sha1($neuer_securitytoken), 'identifier' => $identifier));
            setcookie("identifier", $identifier, time() + (3600 * 24 * 365)); //1 year
            setcookie("securitytoken", $neuer_securitytoken, time() + (3600 * 24 * 365)); //1 year
            //Log user in
            $_SESSION['userid'] = $securitytoken_row['user_id'];
        }
    }


    if (!isset($_SESSION['userid']) && $allowread === "0") {
        die('Please <a href="login.php">login</a> first.');
    }


    $statement = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    error_reporting(0);
    $result = $statement->execute(array('id' => $_SESSION['userid']));
    $user = $statement->fetch();
    error_reporting(-1);
    return $user;
}

/**
 * Returns true when the user is checked in, else false
 */
function is_checked_in() {
    return isset($_SESSION['userid']);
}

/**
 * Returns a random string
 */
function random_string() {
    if (function_exists('openssl_random_pseudo_bytes')) {
        $bytes = openssl_random_pseudo_bytes(16);
        $str = bin2hex($bytes);
    } else if (function_exists('mcrypt_create_iv')) {
        $bytes = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
        $str = bin2hex($bytes);
    } else {
        //Replace your_secret_string with a string of your choice (>12 characters)
        $str = md5(uniqid('your_secret_string', true));
    }
    return $str;
}

/**
 * Returns the URL to the site without the script name
 */
function getSiteURL() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/';
}

/**
 * Outputs an error message and stops the further exectution of the script.
 */
function error($error_msg) {
    include("templates/header.inc.php");
    include("templates/error.inc.php");
    include("templates/footer.inc.php");
    exit();
}

function checkViewRights($dbname, $pdo, $user) {
    $readonly = false;
    $notPublic = false;

    if (isset($_GET['id'])) {     //User wants to view/edit a character
        $id = $_GET['id'];
        $owncharacters = "";
        
        if($dbname == "groups"){            
            $sql = "SELECT id FROM characters WHERE account = " . $user['id'];
            $statement = $pdo->prepare($sql);
            $result = $statement->execute();
            while ($raw = $statement->fetch()) {
                $owncharacters = $owncharacters.$raw['id'].",, ";
            }
            $owncharacters = substr($owncharacters, 0, -3); //Cut last comma
            $owch = explode(", ", $owncharacters);  
            
            
            $sql = "SELECT publicEntry, account, members FROM " . $dbname . " WHERE id = " . $id;
        }else{
            $sql = "SELECT publicEntry, account FROM " . $dbname . " WHERE id = " . $id;
        }
        
        $statement = $pdo->prepare($sql);
        $result = $statement->execute();
                  

        while ($row = $statement->fetch()) {
            if (isset($user['id']) && $row['account'] == $user['id']) { //The logged in user owns the entry
                $readonly = false;
                break;
            } else if ($row['publicEntry'] === "true") { //Is the character public?
                $readonly = true;
                break;
            } else if(strpos_arr($row['members'], $owch) !== false){ //Is the character part of the group?
                $readonly = true;
                break;
            } 
            else {
                $notPublic = true;
                break;
            }
        }
    } else {
        $readonly = false;
    }


    if ($notPublic) {
        exit("Not public!");
    }
    if ($readonly) {
        echo "Read only mode.";
    }
    return $readonly;
}

function databaseFun($dbname, $pdo) {
    //Is a new character/group created?
    if (isset($_GET["new"])) {
        echo "<p>Creating something new...</p>";
        $id = 0;
    }
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    }
    

    

//Was the formular used?
    //User wants to delete his character
    if (isset($_POST['deleteEntry'])) {
        if ($_POST['deleteEntry'] === "BANANA") {
            $sql = "DELETE FROM ".$dbname." WHERE id = ".$id;
            $statement = $pdo->prepare($sql);
            $result = $statement->execute();
            echo "You just deleted something!";
        } else {
            echo "If you really want to delete something, type the right words. BANANA - in capslock!";
        }
    }
    //User wants to change something
    else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//Let's build an sql statement!

        $sql = "";

        // Build insert into statement	
        if ($id == 0) {
            $sql = $sql . "INSERT INTO ".$dbname." (account, ";

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
            $sql = $sql . "UPDATE ".$dbname." SET ";
            foreach ($_POST as $key => $value) {
                $sql = $sql . $key . " = '" . $value . "', ";
            }
            $sql = substr($sql, 0, -21); //Cut of the last comma and the submit stuff

            $sql = $sql . " WHERE ID = " . $id;
        }

//        var_dump($sql);


        $statement = $pdo->prepare($sql);
        $result = $statement->execute();

        if($id == 0){
            header('Location: '.$dbname.'.php');
            exit;
        }
        
        updatePictures("mainPicture", $pdo, $id, $dbname);
        updatePictures("secondaryPicture", $pdo, $id, $dbname);
        updatePictures("tertiaryPicture", $pdo, $id, $dbname);
    }
    
//Read data from database
    $sql = "SELECT * FROM ".$dbname." WHERE id = ".$id;
    $statement = $pdo->prepare($sql);
    $result = $statement->execute();
    return $statement;
}

function updatePictures($pictoupdate, $pdo, $id, $dbname) {
        //Update pictures
        $target_dir = "img/".$dbname."/";
        $target_file = $target_dir . basename($_FILES[$pictoupdate]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        error_reporting(0);
        $check = getimagesize($_FILES[$pictoupdate]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES[$pictoupdate]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES[$pictoupdate]["name"]) . " has been uploaded.";
                $sql = "UPDATE ".$dbname." SET " . $pictoupdate . " = '" . basename($_FILES[$pictoupdate]["name"]) . "' WHERE ID = " . $id;
                $statement = $pdo->prepare($sql);
                $result = $statement->execute();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
            error_reporting(-1);
        }
    }
    
    
    
    
    
    
/* strpos that takes an array of values to match against a string
 * note the stupid argument order (to match strpos)
 */
function strpos_arr($haystack, $needle) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $what) {
        if(($pos = strpos($haystack, $what))!==false) return $pos;
    }
    return false;
}
