<?php
/**
 * Created by PhpStorm.
 * User: IKA
 * Date: 2017-05-28
 * Time: 20:14
 */
require_once ('../../commons/db.php');
include_once ('../../commons/header.php');

/*
 * Print a bootstrap alert
 * @param type : 'success' | 'info' | 'warning' | 'danger'
 * @param message : message to display
 */




if(isset($_POST["description"]) && isset($_SESSION['ID'])) {
    try {
        $db = connect();


        $getstories = $db->prepare("SELECT StoryID FROM storydiv WHERE Owner=".$_SESSION['user'].";");

        if(isset($_POST["title"])) {
            $add_div = $db->prepare("INSERT INTO `storydiv`(`Owner`, `title`) VALUES (:ID,:title)");
            $add_div->bindParam(":title",$_POST['title']);
        }else{

            $add_div = $db->prepare("INSERT INTO `storydiv`(`Owner`) VALUES (:ID)");
        }
        $add_div->bindParam(':ID',$_SESSION["ID"]);
        $add_div->execute();

        $add_page = $db->prepare("INSERT INTO `storymain`( `StoryID`, `Description`) VALUES ( :storyID , :Text)");
        $storyID = $db->lastInsertId();
        $add_page->bindParam(":storyID",$storyID);
        $add_page->bindParam(":Text",$_POST["description"]);
        $add_page->execute();

        $mod_div = $db->prepare("UPDATE `storydiv` SET `FirstPage`=:firstpage WHERE `StoryID`=:ID");
        $pageID = $db->lastInsertId();
        $mod_div->bindParam(":firstpage",$pageID);
        $mod_div->bindParam(":ID",$storyID);
        $mod_div->execute();

        notify('success',"Story created !");


    }catch(PDOException $ex){
        notify('danger',"An error occured : $ex");
    }
}
?>

<?php if(isset($_SESSION["ID"])&& isset($_SESSION["user"])): ?>
    <h1 align="center"> Welcome to your own story creation !</h1>
    <div class="container">
        <h2>
            Create a new story !
        </h2>
        <p>
            <form class="form-horizontal newStory" id="newStory" role="form" action="newStory.php" method="POST">
                <label for="title">Get it a title :</label>
                <input type="text" id="title" name="title" placeholder="My Story"><br>
                <label for="description">Write your first page</label><br>
                <textarea form="newStory" id="description" name="description" placeholder="You are ..." required="required" style="width:80%;height:8em;"></textarea> <br>
                <input type="submit" value="Begin !">
            </form>
        </p>
        <h2>Elaborate your story.</h2>
        <p>

        </p>
    </div>
<?php else: ?>
    <h1 align="center"> Denied!</h1>
    <div class='container'>You need to be logged-in to access this page.</div>
<?php endif ?>



<?php
include_once ('../../commons/footer.html');