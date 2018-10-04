<?php
@session_start();
@ob_start();
include "header.php";
$graceHour=2;$graceMinute=30;
$graceHourF=2;$graceMinuteF=30;
?>
<?php 
if(!isset($_SESSION["custid"]))
{
	if(!isset($_GET["uid"]))
	{
	header("location:Customer_list.php?page=1&cmd=Clear");
	}
	else
	{
	$_SESSION["custid"]=$_GET["uid"];
	}
}
$uid=$_SESSION["custid"];
$res1=mysql_query("select * from tbl_customer_master where md5(id)='$uid'");
$data1=mysql_fetch_array($res1);
?>

<style>
.innerBody{
margin-left:20px;margin-right:20px;padding-top:5px;padding-left:5px;padding-right:5px;margin-bottom:10px;padding-bottom:-30px;border:#CCCCCC 1px solid;height:auto;
}
</style>

<div class="content">
	<div class="content-header">
	<h3 class="head-dashboard">Reservation</h3>
 	</div>
<div class="content-container">
<div class="entry-head">
	<h4>
		<strong> Booking Details </strong>
			<div style="color:#FFFFFF; float:right">
				<a href="Customer_list.php?page=1&cmd=Clear">
				<img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"/>
				</a>
		    </div>
	</h4>
</div>
<div class="entry-content">
	<div style="border:1px solid #CCCCCC;padding:10px;height:200px">	
		<div style="float:left;width:30%;height:45%;padding:5px">	
		<table width="100%">
					<tr height="30"> 
						<td colspan="3">
						  <h2 style="color:#000000;font-style:italic"><?=$data1["name"]?></h2>
						</td>
				  </tr>
					<tr height="30">
					  <td width="22%" valign="top">Gender</td>
					  <td width="6%" valign="top"><strong>:</strong></td>
					  <td width="72%" valign="top"><?=$data1["gender"]?></td>
				  </tr>
				  <tr height="30">
					  <td valign="top" valign="top">Contact No. </td>
					  <td valign="top"><strong>:</strong></td>
					  <td valign="top">
					  <?=$data1["mobile"]?></td>
				  </tr>
				  <tr height="30">
					  <td valign="top">Address</td>
					  <td valign="top"><strong>:</strong></td>
					  <td valign="top"><?=$data1["address"]?></td>
				 </tr>
				 <tr height="30">
					  <td valign="top">Pin Code</td>
					  <td valign="top"><strong>:</strong></td>
					  <td valign="top"><?=$data1["pincode"]?></td>
				 </tr>
			</table>
		</div>
		
		<div style="float:right; width:35%; height:43%; padding:15px; line-height:50px;">
    <a href="Customer_profile.php" class="btn" style="height:35px;width:120px;line-height:35px"><strong>Profile</strong></a>
    <a href="Customer_idproof.php" class="btn" style="height:35px;width:120px;line-height:35px"><strong>Id Proof</strong></a>
    <a href="Customer_roomdtl.php" class="btn" style="height:35px;width:120px;line-height:35px"><strong>Room Details</strong></a>
    <a href="Customer_facility.php" class="btn" style="height:35px;width:120px;line-height:35px"><strong>Facility</strong></a>
    <a href="Customer_payments.php" class="btn" style="height:35px;width:120px;line-height:35px"><strong>Account</strong></a>
	<a href="CustomerRS_list.php" class="btn" style="height:35px;width:120px;line-height:35px"><strong>Room Service </strong></a>
    <a href="Customer_checkout.php" class="btn btn-warning" style="height:35px;width:120px;line-height:35px"><strong>Check Out</strong></a>
	<a href="#" class="btn btn-danger" style="height:35px;width:120px;line-height:35px"><strong>Cancel Booking</strong></a>			
	
		</div>
        <br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />

	</div>
<div class="debug">
</div>
</div>

<div class="footer"></div>
</div>
</div>
