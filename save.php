<?php
/**
 * Created by PhpStorm.
 * User: IKA
 * Date: 2017-05-31
 * Time: 15:41
 */

// Retrive the Request Data
$reqRaw = file_get_contents('php://input');
if ($reqRaw !== false) {
    // Convert Request JSON data to associative Object
    $reqJson = json_decode($reqRaw, true);

    // Extract Username from JSON Request
    $ID = $reqJson["ID"];
    $page = $reqJson["Page"];

    require_once('../../commons/db.php');
    $db = connect();
    $getStory = $db->prepare("SELECT StoryID FROM storymain WHERE PageID=:page");
    $getStory->bindParam(":page", $page);
    $getStory->execute();
    $storyID = $getStory->fetchAll();
    if (isset($storyID[0])) {
        $checksave = $db->prepare("SELECT * FROM savestate WHERE Player=:player");
        $checksave->bindParam(":player", $ID);
        $checksave->execute();
        $existing_save = $checksave->fetchAll();
        if (isset($existing_save[0])) {
            $changesave = $db->prepare("UPDATE savestate SET State=:page WHERE Player=:player");
            $changesave->bindParam(":page", $page);
            $changesave->bindParam(":player", $ID);
            $status = $changesave->execute();
        } else {
            $storyID = $storyID[0];
            $createsave = $db->prepare("INSERT INTO `savestate`(`Player`, `State`, `Story`) VALUES (:ID,:page,:story)");
            $createsave->bindParam(":ID",$ID);
            $createsave->bindParam(":page",$page);
            $createsave->bindParam(":story",$storyID[0]);
            $status = $createsave->execute();

        }
    }else{
        $status = false;
    }

    if ($status) {
        echo '{';
        echo '   "status":"valid"';
        echo '}';
    } else {
        echo '{';
        echo '   "status":"invalid"';
        echo "   \"Player\":\"$ID\"";
        echo "   \"State\":\"$page\"";
        echo '}';
    }
}