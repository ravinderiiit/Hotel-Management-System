<?php
@session_start();
@ob_start();
include "header.php";
?>
<script>
function img1Changed(count)
{
var fileBrowse=$("#image1_" + count);
var ImgTag=$("#img1_" + count);
}
function img2Changed(count)
{
var fileBrowse=$("#image2_" + count);
var ImgTag=$("#img2_" + count);
}
</script>

<div class="content">
	<div class="content-header">
	<h3 class="head-dashboard">Reservation</h3>
	
	
	</div>
<div class="content-container">
<div class="entry-head">
<h4><strong>Customer List</strong>
<div style="color:#FFFFFF; float:right">
  <div id="ShowHideAddv" style="float:right">
  <a href="Customer_alter.php"><img src="<?php echo IMAGE_PATH?>add.png" title="Add New Record" width="18" height="18" /></a></div> 
</h4>

</div>

<div class="entry-content">
<?php if(isset($_SESSION["message"])){echo $_SESSION["message"];unset($_SESSION["message"]);}?>
<form method="post" name="FORM1">
<table width="100%" class="table table-striped">
	<tr>
		<th align="left">Customer Name</th>
		<th>Age</th>
		<th>Gender</th>
		<th>Contact No.</th>
		<th align="left">Comming From</th>
		<th align="left">Purpose</th>
		<th align="center">Booking Date</th>
        <th>Rooms</th>
		<th>Details</th>
		</tr>
	<?php 
	$whr="suspended_status=0 and chkout_stat=1";
	if(isset($_POST["Search"]))
	{
	$stampdate=$objCoreFO->DateToInt($_POST["search"]);
	if($stampdate!=""){
	$whr="(name like ('%".$_POST["search"]."%') or mobile like ('%".$_POST["search"]."%') or coming_frm like ('%".$_POST["search"]."%') or purpose  like ('%".$_POST["search"]."%') or stampdate like ('%".$stampdate."%'))and (suspended_status=0 and chkout_stat=1)";
	}else{
		$whr="(name like ('%".$_POST["search"]."%') or mobile like ('%".$_POST["search"]."%') or coming_frm like ('%".$_POST["search"]."%') or purpose  like ('%".$_POST["search"]."%'))and (suspended_status=0 and chkout_stat=1)";
	}
	}
	$res1=mysql_query("select * from tbl_customer_master");
	if(mysql_num_rows($res1)>0){$count=1;
	while($data1=mysql_fetch_array($res1))
	{
		$rooms=mysql_fetch_array(mysql_query("SELECT GROUP_CONCAT(room_no) AS rooms FROM `view_cus_mstr_dtl_wise` WHERE `id`='".$data1["id"]."'"));
		?>
	<tr>
		<td><?=$data1["name"]?></td>
		<td align="center"><?=$data1["age"]?></td>
		<td align="center"><?=$data1["gender"]?></td>
		<td align="center"><?=$data1["mobile"]?></td>
		<td><?=$data1["coming_frm"]?></td>
		<td><?=$data1["purpose"]?></td>
		<td align="center"><?=$objCoreFO->IntToDate($data1["stampdate"])?></td>
        <td align="center"><?=$rooms["rooms"]?></td>
		<td align="center">
		<a href="Customer_view.php?uid=<?=md5($data1["id"])?>">
		<img src="../common/images/view.jpg" style="height:20px" title="Preview">		</a>		</td>
		</tr>
	<?php $count++;}}?>
</table>
</form>
<?php include "footer.php"?>
</div>
</div>
</div>
		