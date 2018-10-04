<?php
@session_start();
@ob_start();
include "header.php";
$objCoreFO->customer_alter(); 
?>
<?php 
if(!isset($_GET["uid"]))
{
header("location:Customer_list.php?page=1&cmd=Clear");
}
$uid=$_GET["uid"];
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
				<a href="Customer_list.php">
				<img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"/>
				</a>
		</div>
	</h4>
</div>
<div class="entry-content">

	<form method="post" id="FORMNAME1">
	
	<!-------Customer Details----------->
	<div class="content-container">
	<div class="entry-head"><h4><strong>Customer Details</strong></h4></div>
	<p></p>
		<div class="innerBody">
			
			<table width="100%" class="table">
				<tr>
					<td width="13%">Customer Name </td>
					<td width="2%"><strong>:</strong></td>
				  <td>
				  <?=$data1["name"]?></td>
				  <td>&nbsp;</td>
				  <td align="right">Age</td>
				  <td><strong>:</strong></td>
				  <td> <?=$data1["age"]?></td>
				  <td>&nbsp;</td>
				  <td>Father Name</td>
				  <td><strong>:</strong></td>
				  <td width="19%"> <?=$data1["father_name"]?></td>
			  </tr>
				<tr>
				  <td>Gender</td>
				  <td><strong>:</strong></td>
				  <td colspan="5"><?=$data1["gender"]?></td>
				  <td width="2%">&nbsp;</td>
				  <td width="13%">Nationality</td>
				  <td width="1%"><strong>:</strong></td>
				  <td><?=$data1["nation"]?></td>
				  </tr>
				<tr>
				  <td>Contact No. </td>
				  <td><strong>:</strong></td>
				  <td colspan="5">
				  <?=$data1["mobile"]?></td>
				  <td>&nbsp;</td>
				  <td>Alternate No. </td>
				  <td><strong>:</strong></td>
				  <td><?=$data1["alt_no"]?></td>
				  </tr>
				<tr>
				  <td valign="top">Address</td>
				  <td valign="top"><strong>:</strong></td>
				  <td colspan="9" valign="top"><?=$data1["address"]?></td>
				  </tr>
				
				<tr>
				  <td>Pin Code</td>
				  <td><strong>:</strong></td>
				  <td width="21%"><?=$data1["pincode"]?></td>
				  <td width="2%">&nbsp;</td>
				  <td width="14%">Comming From</td>
				  <td width="1%"><strong>:</strong></td>
				  <td width="12%"><?=$data1["coming_frm"]?></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
			  </tr>
				<tr>
				  <td>Male</td>
				  <td><strong>:</strong></td>
				  <td><?=$data1["no_of_male"]?></td>
				  <td>&nbsp;</td>
				  <td>Female</td>
				  <td><strong>:</strong></td>
				  <td><?=$data1["no_of_female"]?></td>
				  <td>&nbsp;</td>
				  <td>Purpose</td>
				  <td><strong>:</strong></td>
				  <td><?=$data1["purpose"]?></td>
				  </tr>
			</table>
				
		</div>
	</div>
	<!--------------End----------------->
	
	
	
	
	<!------------Booking Details------------>
	<p></p>
	<div class="content-container">
		<div class="entry-head"><h4><strong>Booking Details</strong></h4></div>
		<p></p>
			<div class="innerBody">
			<table width="100%" class="table table-bordered">
			  		<tr>
						<th width="4%" align="center" style="background-color:#006633;color:#FFFFFF">#</th>
						<th width="28%" align="center" style="background-color:#006633;color:#FFFFFF">Guest</th>
						<th width="5%" align="center" style="background-color:#006633;color:#FFFFFF">Age</th>
						<th width="9%" align="center" style="background-color:#006633;color:#FFFFFF">Gender</th>
						<th width="6%" align="center" style="background-color:#006633;color:#FFFFFF">In.Date</th>
						<th width="7%" align="center" style="background-color:#006633;color:#FFFFFF">In. Time</th>
						<th width="7%" align="center" style="background-color:#006633;color:#FFFFFF">Out Date</th>
						<th width="8%" align="center" style="background-color:#006633;color:#FFFFFF">Out Time</th>
						<th width="10%" align="center" style="background-color:#006633;color:#FFFFFF">Room Type</th>
						<th width="8%" align="center" style="background-color:#006633;color:#FFFFFF">Room No.</th>
						<th width="8%" align="center" style="background-color:#006633;color:#FFFFFF">Room Rate</th>
					</tr>
			  <?php $res2=mysql_query("select * from tbl_cust_dtls where customer_mas_id='".$data1["id"]."'");
			  $count=1;$tot=0;
			  while($data2=mysql_fetch_array($res2))
			  {
			  ?>
							
					<tr>
						<td align="center"><strong><?=$count;?></strong></td>
						<td align="center"><?=$data2["guest_name"]?></td>
						<td align="center"><?=$data2["age"]?></td>
						<td align="center"><?=$data2["gender"]?></td>
						<td align="center"><?=$data2["check_in_dt"]?></td>
						<td align="center"><?=$data2["check_in_time"]?></td>
						<td align="center"><?=$data2["check_out_dt"]?></td>
						<td align="center"><?=$data2["check_out_time"]?></td>
						<?php $res3=mysql_query("select * from view_room_type_floor_dtl_wise where id='".$data2["room_dtl_id"]."'");
						$data3=mysql_fetch_array($res3);?>
						<td align="center"><?=$data3["room_type"]?></td>
						<td align="center"><?=$data3["room_no"]?></td>
						<td align="center">
						  <div align="right">
						    <?=$data3["rate"].".00";$tot+=$data3["rate"]?>
				          </div></td>
		          </tr>
				   <?php $count++;}?>
				  <tr>
					  <td colspan="9" align="center">&nbsp;</td>
					  <td align="center"><strong><?=$count-1?> Rooms</strong></td>
					  <td align="center"><div align="right"><strong>
				      <?=$tot?>
				      .00</strong></div></td>
		          </tr>
				   <tr>
					  <td colspan="10" align="right">Discount (%)</td>
					  <td align="center">
					    <div align="right">
					      <?=$data1["discount"]?>
			            </div></td>
		          </tr>
				   <?php $taxres=mysql_query("select * from tbl_room_tax_master where status=1");
				  if(mysql_num_rows($taxres)>0)
				  {$taxcount=1;$tax=0;
				  while($taxData=mysql_fetch_array($taxres))
				  {?>
				  <tr>
					<td colspan="10" align="right"><em><?=$taxData["taxname"]."@".$taxData["percentage"]."%"?></em>				</td>
					<td align="center"><div align="right"><span id="tax_<?=$taxcount?>">
					<?php $tax+=($taxData["percentage"]*$tot/100);echo ($taxData["percentage"]*$tot/100);?>
					</span>.00</div></td>
			      </tr>
				  <?php $taxcount++;}
				  }?>
				  <tr>
				    <td colspan="10" align="right"><strong>Net Payble</strong> </td>
				    <td align="right"><strong><?php echo ($tot*(100-$data1["discount"])/100)+$tax?>.00</strong></td>
		      	  </tr>
	   </table>
			
			</div>
 	</div>
	
	<!-------------Booking End------------->

	
	
		<!-------Payment Details----------->
	<p></p>
	<div class="content-container">
		<div class="entry-head"><h4><strong>Payment Details</strong></h4></div>
			<p></p>
			<div class="innerBody">
			<p></p>
			<table width="100%" class="table">
				<tr>
					<td width="9%">Payment Mode</td>
					<td width="2%"><strong>:</strong></td>
					<td><?php echo $data1["pay_mode"]?></td>
				</tr>
				<tr id="card_no" <?php if($data1["pay_mode"]=="CASH"){?>style="display:none" <?php }?>>
				  <td>Card No. </td>
				  <td><strong>:</strong></td>
				  <td><?=$data1["card_no"];?></td>
				  </tr>
				<tr>
				  <td>Payble amount </td>
				  <td><strong>:</strong></td>
				  <td><strong><?php echo ($tot*(100-$data1["discount"])/100)+$tax?>.00</strong></td>
				  </tr>
			
			</table>
			</div>
	</div>
	<!-------Payment Details End---------->
	
		

<p></p>
<!------Book Now------------->
<div align="center">
<input type="submit" id="Save" name="Save" class="btn btn-primary" value="Close" />
</div>
<!------Book Now End------------->

</form>	


<?php include "footer.php"?>
</div>
</div>

<script>
		//calculation of amount
	function cal()
	{
	var total=eval($("#tot").html());//span
	var dis=eval($("#discount").val());//text box
	var taxcount=eval($("#tottax").html());//span tag
	var i,nettax=0,netpayble=0;
		if(dis!=0)
		{
		total=(total*(100-dis))/100;
		}
		
		for (i=1;i<taxcount;i++)
		{
		var currTax=$("#tax_" + i).html();
		nettax=eval(currTax)+nettax;
		}
		
		var netpayble=total+nettax;
		$("#netpayble").html("<strong>" + netpayble + ".00</strong>");
		$("#pay").html("<strong>" + netpayble + ".00</strong>");
	}
	
	//end
</script>
