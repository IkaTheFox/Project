<?php
/**
 * Created by PhpStorm.
 * User: IKA
 * Date: 2017-05-28
 * Time: 19:19
 */
require_once('../../commons/db.php');
include_once('../../commons/header.php');

$db = connect();
$getstories = $db->prepare("SELECT * FROM storydiv");
$getstories->execute();
$stories = $getstories->fetchAll(); ?>


<?php if (isset($_POST["Page"])): ?>

    <?php
    $getPage = $db->prepare("SELECT * FROM `storymain` WHERE `PageID`=:page");
    $getPage->bindParam(":page", $_POST["Page"]);
    $getPage->execute();
    $currentStory = $getPage->fetchAll();
    if(isset($currentStory[0])) :
        $currentStory = $currentStory[0];
    ?>
        <br>
        <div class="container" align="center">

            <?= $currentStory['Description'] ?>
        </div>
        <div class="jumbotron choice">
            <div class="row">
                <div class="col-md-1 col-md-offset-4">
                    <?php if ($currentStory["Option1"] !== NULL): ?>
                        <form action="explore.php" method="POST">
                            <input type="hidden" name="Page" value="<?=$currentStory["Option1"]?>">
                            <button class="btn btn-default" role=><?= $currentStory["OptionA"] ?></button>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="col-md-1 col-md-offset-2">
                    <?php if ($currentStory["Option2"] !== NULL): ?>
                        <form action="explore.php" method="POST">
                            <input type="hidden" name="Page" value="<?=$currentStory["Option2"]?>">
                            <button class="btn btn-default" role=><?= $currentStory["OptionB"] ?></button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-md-offset-4">
                    <?php if ($currentStory["Option5"] !== NULL): ?>
                        <form action="explore.php" method="POST">
                            <input type="hidden" name="Page" value="<?=$currentStory["Option5"]?>">
                            <button class="btn btn-default" role=><?= $currentStory["OptionE"] ?></button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1 col-md-offset-4">
                    <?php if ($currentStory["Option3"] !== NULL): ?>
                        <form action="explore.php" method="POST">
                            <input type="hidden" name="Page" value="<?=$currentStory["Option3"]?>">
                            <button class="btn btn-default" role=><?= $currentStory["OptionC"] ?></button>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="col-md-1 col-md-offset-2">
                    <?php if ($currentStory["Option4"] !== NULL): ?>
                        <form action="explore.php" method="POST">
                            <input type="hidden" name="Page" value="<?=$currentStory["Option4"]?>">
                            <button class="btn btn-default" role=><?= $currentStory["OptionD"] ?></button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php else:?>
        <div class="container">
        <h1>Oops !</h1><br>
        Looks like the page link went wrong !<br>
        If it's your story, you should modify the page linking. If not, you have to wait for the owner to modify it himself, sorry.</div>
    <?php endif;?>



<?php else: ?>
    <br>
    <div class="container" align="center">
        <form action="explore.php" method="POST">
            <h1><label for="Page">Try the original Story :</label></h1><br>
            <input type="hidden" name="Page" value=4><br>
            <button class="btn btn-primary"> Start the Adventure !</button>
        </form>
    </div>
    <h2>Try one of our user-created stories :</h2>
    <div class="col-lg-6">
        <?php foreach ($stories as $story): ?>
            <form action="explore.php" method="post">
                <label for="Page"><?= $story['title'] ?></label>
                <input type="hidden" name="Page" value="<?= $story["FirstPage"] ?>">
                <button type="btn btn-secondary" role="submit">Try it !</button>
            </form>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php


include_once('../../commons/footer.html');