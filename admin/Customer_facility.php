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
<?php 

$uid=$_SESSION["custid"];
$sql="select tbl_cust_dtls.room_dtl_id,view_room_type_floor_dtl_wise.room_no from tbl_cust_dtls,view_room_type_floor_dtl_wise where view_room_type_floor_dtl_wise.id=tbl_cust_dtls.room_dtl_id and md5(tbl_cust_dtls.customer_mas_id)='$uid' and tbl_cust_dtls.chkout_status=1";
$res1=mysql_query($sql) or die("error!line 11");
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
			<p></p>
			<table width="100%" class="table">
				<tr>
				  <td width="65">Room no.</td>
				  <td width="5"><strong>:</strong></td>
				  <td width="191">
				  <select name="roomNo" id="roomNo" style="width:80%">
					  <option value="">Please Select</option>
					  <?php if(mysql_num_rows($res1)>0){
					  while($data1=mysql_fetch_array($res1))
					  {?>
					  <option value="<?=$data1["room_dtl_id"]?>"><?=$data1["room_no"]?></option>
					  <?php }}?>
				  </select>
				  <input type="hidden" name="custDtlId" id="custDtlId" value="Auto" />				  </td>
			      <td width="53">Facility</td>
			      <td width="9"><strong>:</strong></td>
			      <td width="333" align="left">
				  <select name="facilityType" id="facilityType" style="width:80%">
                    <option value="">Please Select</option>
                  </select></td>
			      <td width="31">&nbsp;</td>
			      <td width="68"> Out Date </td>
			      <td width="10"><strong>:</strong></td>
			      <td width="144">
				  <?php $day=date('d-m-Y',strtotime(date('d-m-Y')." + 1 days"));?>
			      <input type="text" name="outDate" id="outDate" value="<?=$day;?>" class="tcal" style="width:80%" readonly/>
			      </td>
			      <td width="68">Out Time </td>
			      <td width="9"><strong>:</strong></td>
			      <td width="151">
				  <div class="input-append bootstrap-timepicker">
					<input id="outTime" name="outTime" type="text" class="input-small" value="<?=@$_POST["outTime"]?>" readonly>
					<span class="add-on" style="height:15px;"><i class="icon-time"></i></span></div>
					<script type="text/javascript">
					$('#outTime').timepicker();
					</script>
				  </td>
			      <td width="71" align="right"><input type="submit" name="Save" id="Save" value="Add" class="btn btn-danger" /></td>
			  </tr>
			</table>	
			<p></p>
		</div>
	<!--------------End----------------->
	
	<?php 
	$sql="select * from view_cust_facility_full_dtl where cust_dtls_id in (select id from tbl_cust_dtls where md5(customer_mas_id)='".$_SESSION["custid"]."') order by id asc";
	$res=mysql_query($sql);
	if(mysql_num_rows($res)>0){$count=1;$tot=0;?>
	
	<?php 
			$discharged=1;
			$where=" md5(customer_mas_id)='".$_SESSION["custid"]."' and chkout_status=1";
			$row=$objCoreFO->getNumRows("tbl_cust_dtls",$where);
			if($row<1){$discharged=0;}
	?>
	
	<!-------Customer facility Details ----------->
	  <p></p>
	  <div class="innerBody">
			<p></p>
			<?php if(isset($_SESSION["message2"])){echo $_SESSION["message2"];unset($_SESSION["message2"]);}?>
			
			<table width="100%" class="table table-bordered">
				<tr>
				 	<th width="2%" style="background:#006633;color:#FFFFFF">#</th>
					<th width="7%" style="background:#006633;color:#FFFFFF">Room No.</th>
					<th width="14%" align="left" style="background:#006633;color:#FFFFFF">Room Type</th>
					<th width="25%" align="left" style="background:#006633;color:#FFFFFF">Facility Taken</th>
					<th width="6%" style="background:#006633;color:#FFFFFF">In date</th>
					<th width="7%" style="background:#006633;color:#FFFFFF">In time</th>
					<th width="8%" style="background:#006633;color:#FFFFFF">Out date</th>
					<th width="9%" style="background:#006633;color:#FFFFFF">Out time</th>
					<th width="6%" style="background:#006633;color:#FFFFFF">Rate</th>
				  <th width="3%" style="background:#006633;color:#FFFFFF">
				  <?php if($discharge>0){?>
				  <input type="checkbox" name="selectAll" id="selectAll" value="selectAll" title="Select All">
				  <?php }?>
				  </th>
			    </tr>
			<?php while($data=mysql_fetch_array($res)){
			if($data["checkout_status"]==0){$bgcolor="#FF0000"; $out=0;}else{$bgcolor="";$out=1;}?>	
				<tr>
				  <td align="center" bgcolor="<?=$bgcolor?>">
				  <strong><?=$count?></strong>
				  <input type="hidden" name="fac_<?=$count?>" id="fac_<?=$count?>" value="<?=$data["id"]?>">
				  <input type="hidden" name="cust_dtl_id_<?=$count?>" id="cust_dtl_id_<?=$count?>" value="<?=$data["cust_dtls_id"]?>">
				  </td>
				  <td align="center" bgcolor="<?=$bgcolor?>"><?=$data["room_no"]?></td>
				  <td align="left" bgcolor="<?=$bgcolor?>"><?=$data["room_type"]?></td>
				  <td align="left" bgcolor="<?=$bgcolor?>"><?=$data["fac_name"]?></td>
				  <td align="center" bgcolor="<?=$bgcolor?>"><?=$objCoreFO->IntToDate($data["checkin_date"]);?></td>
				  <td align="center" bgcolor="<?=$bgcolor?>"><?=IntToTimeAMPM($data["checkin_date"]);?></td>
				  <td align="center" bgcolor="<?=$bgcolor?>">
				  <?php $outDate=$objCoreFO->IntToDate($data["checkout_date"]);if($out==1){?>
				  <input type="text" class="tcal" name="outDate_<?=$count?>" id="outDate_<?=$count?>" value="<?=$outDate?>" style="width:75%">
				  <?php }else{echo $outDate;}?>				 
				  </td>
				  <td align="center" bgcolor="<?=$bgcolor?>">
				  	<?php if($out==1){?>
						<div class="input-append bootstrap-timepicker">
						<input name="outTime_<?=$count?>" type="text" class="input-small" id="outTime_<?=$count?>" value="<?=IntToTimeAMPM($data["checkout_date"]);?>" 
						readonly style="width:56%">
						<span class="add-on" style="height:15px;"><i class="icon-time"></i></span></div>
						<script type="text/javascript">
						$('#outTime_<?=$count?>').timepicker();
						</script>
						<?php }else{echo IntToTimeAMPM($data["checkout_date"]);}?>	
				  </td>
				  <td align="right" bgcolor="<?=$bgcolor?>"><?php echo number_format($data["rate"],2);$tot+=$data["rate"];?></td>
				  <td align="center" bgcolor="<?=$bgcolor?>">
				  <?php if($out==1){?><input type="checkbox" name="chk_<?=$count?>" id="chk_<?=$count?>" value="<?=$data["id"]?>" title="Click me"/><?php }?>				 
				  </td>
			  </tr>
			  <?php $count++;}?>
			  <tr>
			  	<td colspan="8" align="right"><strong>Total</strong></td>
			    <td align="right"><strong><?=number_format($tot,2)?></strong></td>
		        <td align="right">&nbsp;</td>
			  </tr>
			 <?php if($discharged>0){?>
			  <tr>
			    <td colspan="11" align="right">
				<input type="hidden" name="counter" id="counter" value="<?=$count?>" />
			    <input type="submit" name="Save" id="Save" value="Extend" class="btn btn-inverse" onclick="return confirm('Are you sure to Extend Date / Time?')"/>
				<input type="submit" name="Save" id="Save" value="Check out" class="btn btn-danger"/>			    </td>
		      </tr>
			  <?php }?>
			</table>
			<p></p>
	  </div>
	<!--------------End----------------->
	<?php }?>	
</form>	
<?php include "footer.php"?>
</div>
</div>