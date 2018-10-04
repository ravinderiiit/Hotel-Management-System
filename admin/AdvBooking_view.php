<?php
@session_start();
@ob_start();
include "header.php";
if(!isset($_SESSION["custid"]))
{//echo "m here";
	if(!isset($_GET["uid"]))
	{
	header("location:AdvBooking_list.php?page=1&cmd=Clear");
	}
	else
	{
	$_SESSION["custid"]=$_GET["uid"];
	}
}

function IntToTimeAMPM($para=null)
{
$time=date('H:i',$para);
$time=explode(":",$time);
$hh=$time[0];
$mm=$time[1];	

if($hh==00){$AMPM="AM";$hh=12;}
elseif(($hh>00)&&($hh<12)){$AMPM="AM";}
elseif(($hh>=12)&&($hh<24)){$AMPM="PM";}

return date('h:i',$para)." ".$AMPM;
}
?>
<?php 
$uid=$_SESSION["custid"];
$res1=mysql_query("select * from tbl_adv_booking_mstr where md5(id)='$uid'");
$data1=mysql_fetch_array($res1);
if($data1["suspended_status"]==0 || $data1["suspended_status"]==2){header("location:AdvBooking_list.php?page=1&cmd=Clear");}
?>

<style>
.innerBody{
margin-left:5px;
margin-right:5px;
padding-top:20px;padding-left:20px;padding-right:5px;
padding-bottom:20px;
border:#CCCCCC 1px solid;
height:180px;
}
.style1{
border:1px solid #CCCCCC;margin-left:5px;margin-right:5px;padding:10px;
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
				<a href="AdvBooking_list.php?page=1&cmd=Clear">
				<img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"/>
				</a>
		    </div>
	</h4>
</div>
<div class="entry-content">
<form method="post">	
	<p></p>
	<!-----------------Header--------------------->
	<div style="border:1px solid #CCCCCC;padding:10px;height:190px">		
		<div style="float:left;width:30%;height:45%;padding:5px">
		<table width="100%">
					<tr height="30"> 
						<td colspan="3">
						  <h2 style="color:#000000;font-style:italic"><?=$data1["name"]?></h2>
						</td>
				  </tr>
					<tr height="30">
					  <td width="22%">Gender</td>
					  <td width="3%"><strong>:</strong></td>
					  <td width="82%"><?=$data1["gender"]?></td>
				  </tr>
				  <tr height="30">
					  <td>Contact No. </td>
					  <td><strong>:</strong></td>
					  <td>
					  <?=$data1["mobile"]?></td>
				  </tr>
				  <tr height="30">
					  <td>Address</td>
					  <td><strong>:</strong></td>
					  <td><?=$data1["address"]?></td>
				 </tr>
				 <tr height="30">
					  <td>Pin Code</td>
					  <td><strong>:</strong></td>
					  <td><?=$data1["pincode"]?></td>
				 </tr>
			</table>
		</div>
		<div style="float:right; width:35%; height:43%; padding:15px; line-height:50px;">
		<a href="AdvCustomer_profile.php" class="btn"  style="height:35px;width:120px;line-height:35px"><strong>Profile</strong></a>
        <a href="AdvCustomer_roomdtl.php" class="btn"  style="height:35px;width:120px;line-height:35px"><strong>Occupancy</strong></a>
        <a href="AdvCustomer_account.php" class="btn" style="height:35px;width:120px;line-height:35px"><strong>Account</strong></a>
        <a href="AdvReject.php?uid=<?=$_SESSION["custid"];?>" class="btn btn-danger" style="height:35px;width:120px;line-height:35px" onClick="return confirm('Are you sure?')"><strong>Reject</strong></a>
        <a href="AdvCheckin.php?uid=<?=$_SESSION["custid"];?>" class="btn btn-success" style="height:35px;width:120px;line-height:35px" onClick="return confirm('Are you sure?')"><strong>Check In</strong></a>
        </div>
	</div>
	<!---------------End Header------------------->
	<p></p>
	
</form>			
<div class="debug"></div></div>
<div class="footer"></div>
</div>
</div>
