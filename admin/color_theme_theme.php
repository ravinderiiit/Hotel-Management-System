<?php include "../common/inc/config.inc.php";?>

<?php

$name = $_POST["code"];
$insert="update tbl_theme_color set color_code_theme='$name'";
$result = mysql_query($insert) or die($insert);

?>

