<?php 
@session_start();
@ob_start();
include "../common/inc/config.inc.php";
if(!isset($_GET["uid"]))
{
header("location:AdvBooking_view.php?page=1&cmd=Clear");
}
else
{
$uid=$_GET["uid"];
mysql_query("update tbl_adv_booking_dtls set status=0 where md5(adv_booking_id)='$uid'")or die("Error! 10 contact to admin");
mysql_query("update tbl_adv_booking_mstr set suspended_status=0 where md5(id)='$uid'")or die("Error! 11 contact to admin");

$_SESSION["message"]='<div class=alert alert-danger><strong>Success!</strong> One new Record successfully rejected</div>';
header("location:AdvBooking_list.php?page=1&cmd=Clear");
//echo "hi";
}
?>