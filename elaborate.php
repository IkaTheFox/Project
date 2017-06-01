<?php
/**
 * Created by PhpStorm.
 * User: IKA
 * Date: 2017-05-30
 * Time: 23:40
 */
include_once('../../commons/header.php');
require_once("../../commons/db.php");


if (isset($_GET["chooseStory"]) && isset($_SESSION['ID'])): ?>
    <?php


    $authorized = false;
    $story = $_GET["chooseStory"];
    $db = connect();

    $getpermission = $db->prepare("SELECT Admin FROM customers WHERE ID=:ID");
    $getpermission->bindParam(":ID", $_SESSION['ID']);
    $getpermission->execute();
    $permission = $getpermission->fetchAll();
    $admin = false;
    if (isset($permission[0])) {
        $permission = $permission[0];
        $admin = $permission["Admin"];
    }
    $getowner = $db->prepare("SELECT Owner FROM storydiv WHERE StoryID=:Story");
    $getowner->bindParam(":Story", $story);
    $getowner->execute();
    $result = $getowner->fetchAll();
    foreach ($result as $row) {
        if (($row['Owner'] === $_SESSION['ID']) || $admin) {
            $authorized = true;
        }
    }
    if ($authorized):?>
        <div class="container"><h1>Working on it...</h1>

            <h2>
                Create a new page !
            </h2>
            <p>
            <form class="form-horizontal newStory" id="newpage" role="form" action="elaborate.php" method="POST">
            <textarea form="newStory" id="description" name="description" placeholder="You are ..." required="required"
                      style="width:80%;height:8em;"></textarea> <br>
                <input type="submit" value="New Page !">
            </form>
            </p>

            <h2>Modify a page !</h2>
            <?php
            $getpages = $db->prepare("SELECT * FROM storymain WHERE StoryID=:story");
            $getpages->bindParam(":story", $story);
            $getpages->execute();
            $pages = $getpages->fetchAll();
            ?>
            <form action="javascript:showPage()" name="Pageholder" method="POST"></form>
            <label for="pagebrowser">Choose a page :</label>
            <select name="pagebrowser" id="pagebrowser" onchange="showPage()">
                <option disabled selected value> -- select a page --</option>
                <?php foreach ($pages as $page): ?>
                    <option name="<?= $page['PageID'] ?>" value="<?= $page['PageID'] ?>"><?= $page['PageID'] ?></option>
                <?php endforeach; ?>
            </select>
            <?php foreach ($pages as $page): ?>
                <div id="<?= $page['PageID'] ?>" class="pageview" style="display:none;">
                    <div class="container"><?= $page["Description"] ?></div>
                    <br><br>
                    Link to a page : <br>
                    <form action="javascript:alteroption(1)" method="post">
                        <label for="">First Option</label>
                        <input type="number" name="link" id="link">
                        <input type="hidden" name="page" id="page" value="<?= $page[0] ?>">
                        <button class="btn btn-default">Link</button>
                    </form>
                    <br>
                    <form action="javascript:alteroption(2)" method="post">
                        <label for="">Second Option</label>
                        <input type="number" name="link" id="link">
                        <input type="hidden" name="page" id="page" value="<?= $page[0] ?>">
                        <button class="btn btn-default">Link</button>
                    </form>
                    <br>
                    <form action="javascript:alteroption(3)" method="post">
                        <label for="">Third Option</label>
                        <input type="number" name="link" id="link">
                        <input type="hidden" name="page" id="page" value="<?= $page[0] ?>">
                        <button class="btn btn-default">Link</button>
                    </form>
                    <br>
                    <form action="javascript:alteroption(4)" method="post">
                        <label for="">Fourth Option</label>
                        <input type="number" name="link" id="link">
                        <input type="hidden" name="page" id="page" value="<?= $page[0] ?>">
                        <button class="btn btn-default">Link</button>
                    </form>
                    <br>
                    <form action="javascript:alteroption(5)" method="post">
                        <label for="">Fifth Option</label>
                        <input type="number" name="link" id="link">
                        <input type="hidden" name="page" id="page" value="<?= $page[0] ?>">
                        <button class="btn btn-default">Link</button>
                    </form>
                    <br>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <h1>Oops !</h1>
        Looks like you are not authorized to edit this.
    <?php endif; ?>


<?php else: ?>
    <h1>Oops !</h1>
    Looks like you came to the wrong neighborhood !
<?php endif;


include_once('../../commons/footer.html'); ?>

<script type="text/javascript">
    function showPage() {
        $('.pageview').hide();
        var page = $('#pagebrowser').val();
        //alert(page);
        $('#' + page).show();
    }
    function alteroption(option) {
        var target = $('#page').val();

        // String to create JSON object
        var text = '{' +
            '"Page":"' + page + '",' +
            '"ID":"' + ID + '"' +
            '}';
        //alert(text);
        var jsonData = JSON.parse(text);
        $.post("http://localhost/Project/save.php", JSON.stringify(jsonData),
            function (data, status) {
                //alert(data);
                var jsonData = JSON.parse(data);
                if (jsonData.status === "valid") {
                    $('div#saved').show();
                } else {
                    $('div#nsave').show();
                }

            });
    }
</script>
