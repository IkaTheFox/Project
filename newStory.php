<?php
/**
 * Created by PhpStorm.
 * User: IKA
 * Date: 2017-05-28
 * Time: 20:14
 */
require_once('../../commons/db.php');
include_once('../../commons/header.php');
$db = connect();


if (isset($_POST["description"]) && isset($_SESSION['ID'])) {


    $getstories = $db->prepare("SELECT StoryID FROM storydiv WHERE Owner=" . $_SESSION['user'] . ";");

    if (isset($_POST["title"])) {
        $add_div = $db->prepare("INSERT INTO `storydiv`(`Owner`, `title`) VALUES (:ID,:title)");
        $add_div->bindParam(":title", $_POST['title']);
    } else {

        $add_div = $db->prepare("INSERT INTO `storydiv`(`Owner`) VALUES (:ID)");
    }
    if(isset($_POST["Option1"])){

    }
    $add_div->bindParam(':ID', $_SESSION["ID"]);
    $add_div->execute();

    $add_page = $db->prepare("INSERT INTO `storymain`( `StoryID`, `Description`,`OptionA`,`OptionB`,`OptionC`,`OptionD`,`OptionE`) VALUES ( :storyID , :Text, :A,:B,:C,:D,:E)");
    $storyID = $db->lastInsertId();
    $add_page->bindParam(":storyID", $storyID);
    $add_page->bindParam(":Text", $_POST["description"]);
    if(isset($_POST["Option1"])){
        $A = $_POST["Option1"];
    }else{
        $A = NULL;
    }
    $add_page->bindParam(":A", $A);
    if(isset($_POST["Option2"])){
        $B = $_POST["Option2"];
    }else{
        $B = NULL;
    }
    $add_page->bindParam(":B", $B);
    if(isset($_POST["Option3"])){
        $C = $_POST["Option3"];
    }else{
        $C = NULL;
    }
    $add_page->bindParam(":C", $C);
    if(isset($_POST["Option4"])){
        $D = $_POST["Option4"];
    }else{
        $D = NULL;
    }
    $add_page->bindParam(":D", $D);
    if(isset($_POST["Option5"])){
        $E = $_POST["Option5"];
    }else{
        $E = NULL;
    }
    $add_page->bindParam(":E", $E);
    $add_page->execute();

    $mod_div = $db->prepare("UPDATE `storydiv` SET `FirstPage`=:firstpage WHERE `StoryID`=:ID");
    $pageID = $db->lastInsertId();
    $mod_div->bindParam(":firstpage", $pageID);
    $mod_div->bindParam(":ID", $storyID);
    $mod_div->execute();

    notify('success', "Story created !");

}
?>

<?php if (isset($_SESSION["ID"]) && isset($_SESSION["user"])): ?>
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
            <textarea form="newStory" id="description" name="description" placeholder="You are ..." required="required"
                      style="width:80%;height:8em;"></textarea> <br>
            <label for="Option1">First Option</label>
            <input type="text" id="Option1" name="Option1">
            <label for="Option2">Second Option</label>
            <input type="text" id="Option2" name="Option2"><br>
            <label for="Option3">Third Option</label>
            <input type="text" id="Option3" name="Option3">
            <label for="Option4">Fourth Option</label>
            <input type="text" id="Option4" name="Option4"><br>
            <label for="Option5">Fifth Option</label>
            <input type="text" id="Option5" name="Option5">
            <input type="submit" value="Begin !">
        </form>
        </p>
        <h2>Elaborate your story.</h2>
        <p>
        <form name="elaborate" action="elaborate.php" method="GET">
            <label for="chooseStory">
                Choose which story to modify :
            </label><select name="chooseStory" id="chooseStory" >
                <?php
                $SQLCommand = "SELECT `StoryID`, `title` FROM `storydiv` WHERE Owner=:ID";
                $ret_stories = $db->prepare($SQLCommand);
                $ret_stories->bindParam(":ID", $_SESSION['ID']);
                $ret_stories->execute();
                $fetched = $ret_stories->fetchAll();
                foreach ($fetched as $story): ?>
                    <option name="choose" value="<?= $story['StoryID'] ?>"><?= $story['title'] ?></option>
                <?php endforeach; ?>
            </select><br>
            <button class="btn btn-primary" type="submit">Elaborate !</button>
        </form>
        </p>
    </div>
<?php else: ?>
    <h1 align="center"> Denied!</h1>
    <div class='container'>You need to be logged-in to access this page.</div>
<?php endif ?>


<?php
include_once('../../commons/footer.html');