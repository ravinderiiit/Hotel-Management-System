<?php
@session_start();
@ob_start();
include "Customer_view.php";
date_default_timezone_set('Asia/Calcutta');

?>

<style>
.innerBody{
margin-left:10px;margin-right:10px;padding-top:5px;padding-left:5px;padding-right:5px;margin-bottom:10px;padding-bottom:-30px;border:#CCCCCC 1px solid;height:auto;
}
</style>

<div class="content">
	
<div class="content-container">
<div class="entry-head">
	<h4>
		<strong> ROOM SERVICE </strong><div style="float:right"><a href="CustomerRS_alter.php"><strong><img src="<?php echo IMAGE_PATH?>add.png" title="Add New Record" width="18" height="18" /></strong></a></div>
	</h4>
</div>

<div class="entry-content">
<form method="post" enctype="multipart/form-data">
<?php if(isset($_SESSION["message"])){echo $_SESSION["message"];unset($_SESSION["message"]);}?>
	<!-------Customer facility add ----------->
		<div class="innerBody">
			
	<table width="100%" class="table table-stripped">
		<tr>
		  <td width="5%" align="center" ><strong>Sl. No. </strong></td>
		  <td width="22%" align="center"><strong>Room No. </strong></td>
		  <td width="32%" align="center"><strong>Date</strong></td>
		  <td width="29%" align="center"><strong>Time</strong></td>
		  <td width="12%" align="center"><strong>View</strong></td>
		  </tr>
		 <?php $str="SELECT * FROM `view_order_room` where md5(rpt_id)='".$_SESSION['custid']."'";$count=1;
		 	$query=mysql_query($str);
			while($row=mysql_fetch_array($query)){?> 
		<tr>
		  <td align="center"><?php echo $count; ?></td>
		  <td align="center"><?php echo $row['room_no']; ?></td>
		  <td align="center"><?php echo date('d-m-Y',$row['date']); ?></td>
		  <td align="center"><?php echo $row['p_time']; ?></td>
          <?php if($row['status']==1){ ?>
		  <td align="center"><a href="CustomerRS_view.php?uid=<?php echo md5($row['id']); ?>&wid=<?php echo md5(1); ?>">View</a></td>
          <?php }else{?>
          <td align="center"><a href="CustomerRS_bill.php?uid=<?php echo md5($row['id']); ?>&wid=<?php echo md5(1); ?>">Bill</a></td>
          <?php }?>
		  </tr>
		 <?php $count++;}?>
	</table>
	
			
		</div>
	<!--------------End----------------->
	

	
	
</form>	
<?php include "footer.php"?>
</div>
</div>