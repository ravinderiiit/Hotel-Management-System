<?php
@session_start();
@ob_start();
include "Customer_view.php";
$objCoreFO->customer_facility();
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

<style>
.innerBody{
margin-left:10px;margin-right:10px;padding-top:5px;padding-left:5px;padding-right:5px;margin-bottom:10px;padding-bottom:-30px;border:#CCCCCC 1px solid;height:auto;
}
</style>
<script>
$(document).ready(function(){
	
	$("#roomNo").change(function(){
	var roomdtlid=$(this).val();
		if(roomdtlid!="")
		{
			$.post("../ProgramFile/auto/FO_room_facility.php",{'roomdtlid':roomdtlid},function(response){
			//alert(response);
			var slicename=response.split("@");
			$("#custDtlId").val(slicename[1]);
					
			var jsonVal=JSON.parse(slicename[0]);
			var jsonLen=jsonVal.length;
				if(jsonLen>0)
				{
				$("#facilityType").empty().append("<option value=''>Please Select</option>");
					for(var i=0;i<=jsonLen;i++)
					{
					var option="<option value='" + jsonVal[i]["val"] + "'>" + jsonVal[i]["fac_name"] + "</option>";
					$("#facilityType").append(option);
					}
				}
			});
			
			
		}
		else
		{
		$("#facilityType").empty().append("<option value=''>Please Select</option>");
		}
	});
	
	$("#selectAll").click(function(){
			if($(this).is(":checked"))
			{
			$("input[type='checkbox']").attr("checked",true);
			}
			else
			{
			$("input[type='checkbox']").attr("checked",false);
			}
	});

});
</script>
<div class="content">
	
<div class="content-container">
<div class="entry-head">
	<h4>
		<strong> Customer Facilities</strong>
	</h4>
</div>
<div class="entry-content">
<form method="post" enctype="multipart/form-data">
<?php if(isset($_SESSION["message"])){echo $_SESSION["message"];unset($_SESSION["message"]);}?>
	<!-------Customer facility add ----------->
		<div class="innerBody">
			
<table width="100%" border="1x solid silver">
 <?php $query_titem=mysql_query("SELECT * FROM `view_order_details` where md5(order_mastid)='".$cid."' ");{
 if(mysql_num_rows($query_titem)>0){ $count=1
  ?>
<tr>
  <th width="2%" >#</th>
  <th width="14%" >Room No. </th>
  <th width="13%" >Date</th>
  <th width="47%" >Item Name </th>
  <th width="5%" >Rate(INR)</th>
  <th width="9%" >Qty</th>
  <th width="10%" >Total</th>  
</tr>
 <?php while($data_titem=mysql_fetch_array($query_titem)){ ?>
<tr>
  <td align="center"><?php echo $count; ?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;<?php echo $data_titem["item_name"];  ?> </td>
  <td align="center"><?php echo $unit_price=number_format((100*$data_titem["rate"])/(100+$taxes),2,'.','');   ?></td>
  <td align="center"><?php echo $data_titem["qty"];  ?></td>
  <?php $tqty+=$data_titem["qty"]; ?>
  <?php $total=$unit_price*$data_titem["qty"];
  $ftotal+=$total;?>
  <td align="center"><div align="right"><?php echo number_format($total,2) ?></div></td>
  </tr><?php $count++; } ?>

<tr>
  <td colspan="4">
  <input type="hidden" name="counter" value="<?=$count;?>"/>
  <div align="center">[No. Of Item &nbsp;<?php echo $count-1; ?>] </div></td>
  <td><div align="center"><strong>Total</strong></div></td>
  <td align="center"><?php echo $tqty; ?></td>
  <td align="center"> <div align="right"><?php echo number_format($ftotal,2); ?> </div></td>
  </tr>
<tr>
  <td colspan="6"><div align="right">Discount(%)&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
  <td align="center"><div align="right"><?php echo number_format($discount,2); ?></div></td>
   </tr>
<tr>
  <td colspan="6"><div align="right">Total After Discount &nbsp;&nbsp;&nbsp;&nbsp;</div></td>
  <td align="center"><div align="right">
    <?php  $tot_af_dis=($ftotal-($ftotal*$discount)); echo number_format($tot_af_dis,2);  ?>
  </div></td>
  </tr>
<?php $total_tax=0;$tax=mysql_query("SELECT * FROM tbl_order_tax where  md5(order_mastid)='".$cid."'");{
while ($data_tax=mysql_fetch_array($tax)){?>

<tr>
  <td colspan="6"><div align="right"><?php echo $data_tax["tax_name"]."(".$data_tax["percentage"]."%)"; ?>&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
  <td align="center"><div align="right">
    <?php $t_tax=$ftotal*($data_tax["percentage"]/100); echo number_format($t_tax,2);$total_tax+=$t_tax; ?> 
  </div></td>
  </tr>
<?php }}?>

<tr>
  <td colspan="6"><div align="right"><strong>Total (Including Tax)&nbsp;&nbsp;&nbsp;&nbsp;</strong> </div></td>
  <td align="center"><div align="right">
    <?php $ft= round(($tot_af_dis+$total_tax),0); echo number_format($ft,2,'.',''); ?>
	<input type="hidden" name="grandtotal" value="<?php echo  $ft  ?>" />
  </div></td>
  </tr>
<?php }}?>
</table>
			<p></p>
		</div>
	<!--------------End----------------->
	
	<?php 
	$sql="select * from view_cust_facility_full_dtl where cust_dtls_id in (select id from tbl_cust_dtls where md5(customer_mas_id)='".$_SESSION["custid"]."') order by id asc";
	$res=mysql_query($sql);
	if(mysql_num_rows($res)>0){$count=1;$tot=0;?><!-------Customer facility Details ----------->
	  <p></p>
	  <div class="innerBody">
			<p></p>
			<p></p>
	  </div>
	<!--------------End----------------->
	<?php }?>	
</form>	
<?php include "footer.php"?>
</div>
</div>