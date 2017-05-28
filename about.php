<!DOCTYPE html>
<html lang="en">
   <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <script src="https://use.fontawesome.com/767fac0b09.js"></script>


    <title>Project.html home page</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/index.css">
  </head>
  <body>
  <?php
    require_once ('../../commons/header.php');
  ?>
    <div class="container">
      <p>
      <br>
        Welcome to project.php ! This is a storytelling environment made as a web project for a Concordia introduction to web programming. Actually it's more like an interactive web story, so...<br>
        By the way this is my very first html/CSS and php project so please be nice, alright?<br>
          The original plan was only to offer my base story, but it evolved as a framework to build and share your own stories !
      </p>
    </div>


  <?php
    require_once ('../../commons/footer.html');
  ?>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>