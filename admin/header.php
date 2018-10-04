<?php
@session_start();
@ob_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
if(!isset($_SESSION["userid"]) || !isset($_SESSION["usertype"])){header("location:../index.php");}
include "../common/inc/config.inc.php"; 
include "localinclude.php";
$varFileName = basename($_SERVER['PHP_SELF']);
$_SESSION["varFileName"]=$varFileName;

$str="SELECT * FROM `tbl_employee_master` where id='".$_SESSION['userid']."'";
$query=mysql_query($str);
$row=mysql_fetch_array($query);

if(isset($_GET["cmd"]))
{
	if($_GET["cmd"]=="Clear")
	{
	unset($_SESSION["custid"]);
	unset($_SESSION["where"]);
	unset($_SESSION["taxdataset"]);
	}
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Hotel Ganga Ashram</title>
<link href="../common/images/hga_logo.ico" rel="shortcut icon" type="image/x-icon">
<style>
a{ text-decoration:none}
.settingmenu{ background:#FFF; border-bottom:#CCC solid 1px;}
.settingmenu:hover{ background:#F8F8F8; }
</style>
 
</head>
<body>
<div class="panel" style="padding-left:5px; background:#425E66; padding-top:0px; border:none; border-radius:0px; margin:0px; height:45px;">
<div class="span5" style="padding:0px; line-height:50px; margin:0; ">
<div  style="font-family:Arial, Helvetica, sans-serif; text-indent:10px; font-weight:bold; line-height:60px; color:#FFF; font-size:20px; text-transform:uppercase"> 
<?php $str="SELECT * FROM `tbl_company_mstr` where suspended_status=0 ";
$query=mysql_query($str);
$row2=mysql_fetch_array($query); ?>
<div style="float:left"><img src=" ../common/resource/Companies/logo/<?php echo $row2['logo'];?>" style="margin-top:10px;" /></div>
<div style="float:left"><?php echo $row2['company_name']; ?></div></div></div>
<div class="span4" style="margin-top:15px">
<form method="post">
<input type="text" name="search" placeholder="Please Search" style="height:18px; margin-right:3px;">
<input type="submit" name="Search" class="btn btn-info" value="Search">
</form>
</div>
<div class="span4" style="float:right;  margin-top:15px; color:#FFF; line-height:50px;">
<ul class="nav pull-right" style="border-bottom:none;">
<li id="fat-menu" class="dropdown" >
<a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown" style="font-family:Calibri; background:none; border-bottom:none; font-weight:normal; color:#fff; text-shadow:none; font-size:14px">
<div style="float:left">
<img img src="../common/resource/employee/<?php echo $row['emp_image'] ; ?>" width="30" style="border-radius:17px;background-color:#FFF" /></div>
<div style="float:left; line-height:30px;">
&nbsp;&nbsp;<?=$_SESSION["emailid"];?></div>
<span class="caret" style="margin-top:14px;"></span></a>
<ul class="dropdown-menu" role="menu" aria-labelledby="drop3" style="margin-top:25px;">

<div class="settingmenu">
<a href="emp_profile.php" style="color:#333; font-family:Arial, Helvetica, sans-serif; font-size:12px"><div style="float:left">
<img src="<?php echo IMAGE_PATH?>user2.png" width="14" /> </div>&nbsp;&nbsp; My Profile</a></div>


<div class="settingmenu">
<a href="change_password.php?cmd=Clear" style="color:#333; font-family:Arial, Helvetica, sans-serif; font-size:12px">
<div style="float:left"><img src="<?php echo IMAGE_PATH?>password.png" width="16"/></div> 
&nbsp;&nbsp; Change Password</a></div>

<div class="settingmenu">
<a href="logout.php?cmd=Clear" style="color:#333; font-family:Arial, Helvetica, sans-serif; font-size:12px"><div style="float:left"><img src="<?php echo IMAGE_PATH?>setting.png" width="12" /></div>&nbsp;&nbsp; Settings</a></div>

<div class="settingmenu" style="border-bottom:none">
<a href="logout.php?cmd=Clear" style="color:#333; font-family:Arial, Helvetica, sans-serif; font-size:12px"><div style="float:left"><img src="<?php echo IMAGE_PATH?>logout1.png" width="12" /></div>&nbsp;&nbsp; Logout</a></div>




</ul>
</li>
</ul>
</div>


</div>
<div class="panel" style="background:#E7AC00; border-radius:0px; padding:0px; height:40px; margin:0px; border:none">
<nav>
<ul>
	<li><a href="index.php?page=1&cmd=Clear" style="background:none; border-left:none">Dashboard  </a></li>
		<!------------menu 2-------------->
	<li><a href="#" style="background:none">Master Setup</a>
		<ul>
			<li><a href="company_list.php?page=1&cmd=Clear">Company setup</a></li>
            <li><a href="companybranch_list.php?page=1&cmd=Clear">Company Branch setup</a></li>
            <li><a href="sysdept_list.php?page=1&cmd=Clear">System Department</a></li>
            <li><a href="UserType_list.php?page=1&cmd=Clear">User Type setup</a></li>
            <li><a href="employeesetup_list.php?page=1&cmd=Clear">Employee setup</a></li>
        	<li><a href="usersetup_list.php?page=1&cmd=Clear">User-Id setup</a></li>
            
			<!---<li><a href="systime_setup.php?page=1&cmd=Clear">Time Setup</a></li>-->
		</ul>
	</li>
     <!------------menu 2-------------->
	<li><a href="#" style="background:none">Taxation Setup</a>
		<ul>
       		<li><a href="sysFinancialYear_list.php?page=1&cmd=Clear">Financial year</a></li>
            <li><a href="RoomTaxMaster_list.php?page=1&cmd=Clear">Room Tax Master</a> </li>
             <li><a href="RoomTaxDtl_list.php?page=1&cmd=Clear">Room Tax Details</a> </li>
            <li><a href="tax_list.php?page=1&cmd=Clear">Restaurant Tax</a></li>
		</ul>
	</li>
    <!------------menu 2-------------->
	<li><a href="#" style="background:none">Reception Setup</a>
		<ul>
			<li><a href="Floor_list.php?page=1&cmd=Clear">Floor Details</a></li>
            <li><a href="Group_list.php?page=1&cmd=Clear">Group Details</a></li>
			<li><a href="RoomType_list.php?page=1&cmd=Clear">Room Type Details</a></li>
			<li><a href="RoomDtl_list.php?page=1&cmd=Clear">Room Details</a> </li>
          	<li><a href="Purpose_list.php?page=1&cmd=Clear">Purpose</a></li>
			<li><a href="RoomFacilty_list.php?page=1&cmd=Clear">Room Facility</a></li>
		</ul>
	</li>
	<!------------menu 4-------------->
	<li><a href="#" style="background:none"> Restaurant setup </a>
		<ul>
			<li><a href="category_list.php?page=1&cmd=Clear">Category Details</a></li>
			<li><a href="unit_list.php?page=1&cmd=Clear">Unit Details</a></li>
			<li><a href="item_list.php?page=1&cmd=Clear">Item Details</a> </li>
			<li><a href="table_list.php?page=1&cmd=Clear">Table Details</a></li>
			<li><a href="client_list.php?page=1&cmd=Clear">Client Details</a></li>
			
			
			
		</ul>
	</li>
	<!------------menu 3-------------->
	<li><a href="Customer_list.php?page=1&cmd=Clear" style="background:none">Front Office</a>
		<ul>
			<li ><a href="Customer_list.php?page=1&cmd=Clear">New Booking</a></li>
			<li ><a href="AdvBooking_list.php?page=1&cmd=Clear">Advance Booking</a></li>
			<li ><a href="OccupyRoom_list.php?page=1&cmd=Clear">Occupied Rooms</a></li>
			<li ><a href="NonoccupyRoom_list.php?page=1&cmd=Clear">Non-Occupied Rooms</a></li>
            <li ><a onclick="PopupCenter('RoomTarrif_list.php','rate chart','900px','500px')">Room Tarrif</a></li>
            
		</ul>
	</li>
    <!------------menu 3-------------->
	<li><a href="tableorder_list.php?page=1&cmd=Clear" style="background:none">Restaurant</a>
		<ul>
			<li><a href="tableorder_list.php">Orders</a></li>
		</ul>
	</li>
    <!------------menu 3-------------->
	<li><a href="#" style="background:none">Accounts</a>
		<ul>
			<li><a href="PaymentsVoucher_alter.php?cmd=Clear&page=1">Payment Voucher</a></li>
            <li><a href="ReceiptVoucher_alter.php?cmd=Clear&page=1">Receipt Voucher</a></li>
<li><a href="collection_report.php?page=1&cmd=Clear">Collection Report</a></li>
            <li><a href="Advcollection_report.php?page=1&cmd=Clear">Advance Collection Report</a></li>
            <li><a href="#">Dues Maintenance</a></li>
		</ul>
	</li>
    <!------------menu 3-------------->
	<li><a href="#" style="background:none">Reports</a>
		<ul>
			
            <li><a href="#">Dues Report</a></li>
			<li><a href="roomhistory_report.php?page=1&cmd=Clear">Room History Report</a></li>
			<li><a href="roomtax_report.php?page=1&cmd=Clear">Tax Report</a>
            <li><a href="bookingstatus_report.php?page=1&cmd=Clear">Booking Status Report</a></li>
<li><a href="advcnf_report.php?page=1&cmd=Clear">Advance Confirm Status</a></li>
            <li><a href="advcancel_report.php?page=1&cmd=Clear">Advance Cancel Status Report</a></li>
            <li><a href="reprint_bill.php?page=1&cmd=Clear">Reprint Bill</a></li>
		</ul>
	</li>		
		
		
		
		
				
	
</ul></nav>

</div>


