<?php
/**
 * Created by PhpStorm.
 * User: IKA
 * Date: 2017-05-24
 * Time: 09:58
 */

require_once ('../../commons/Inventory.php');

$myarray = new Inventory(12);
echo "Inventory of " . 12;
echo "<br>";

var_dump($myarray);
echo "Done.";
