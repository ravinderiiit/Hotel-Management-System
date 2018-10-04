<?php
@session_start();
@ob_start();
include "Customer_view.php";
include "function.ini.php";
$objCoreFO->customer_roomdtl();
?>
<?php 


?>

<style>
.innerBody{
margin-left:10px;margin-right:10px;padding-top:5px;padding-left:5px;padding-right:5px;margin-bottom:10px;padding-bottom:-30px;border:#CCCCCC 1px solid;height:auto;
}
</style>
<script>
$(document).ready(function(){

	
	$("#arv_date,#dep_date,#arrv_time,#dep_time").blur(function(){
		$("#room_type").prop("selectedIndex",0);
		$("#room_no").empty();
		$("<option value=''>Please Select</option>").appendTo($("#room_no"));
		$("#rate").html("<strong>Auto</strong>");
	});
	
	$("#room_type").change(function(){
		var text=$(this).val();
		if(text!="")
		{
		var arv_date=$("#arv_date").val();
		var dep_date=$("#dep_date").val();
		var arv_time=$("#arrv_time").val();
		var dep_time=$("#dep_time").val();
		var room_type=$("#room_type").val()
			//for room no append in dropdown
			$.post("../ProgramFile/auto/FO_room_no.php",{'room_type':room_type,'arv_date':arv_date,'dep_date':dep_date,'arv_time':arv_time,'dep_time':dep_time},function(response){
				//alert(response);
				if(response!="")
				{
						var jsonVal=JSON.parse(response);	
						var jsonLength=jsonVal.length;
						$("#rate").html("Rs."+jsonVal[0].rate + ".00 INR");
						$("#room_no").empty();
						$("#room_no").append("<option value=''>Please Select</option>");
						for(var i=0;i<=jsonLength;i++)
						{
						$("<option value=" + jsonVal[i]["val"] + ">" + jsonVal[i]["room_no"] +"</option>").appendTo($("#room_no"));
						}
				}
				else
				{
				$("#room_no").empty();
				$("<option value=''>Not Aval.</option>").appendTo($("#room_no"));
				$("#rate").html("<strong>Not Aval.</strong>");
				}
					
			});
			
		}
		else
		{
			$("#room_no").empty();
			$("<option value=''>Please Select</option>").appendTo($("#room_no"));
			$("#rate").html("<strong>Auto</strong>");
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
		<strong> Customer Room Details</strong>
	</h4>
</div>
<div class="entry-content">
<form method="post" enctype="multipart/form-data">
<?php if(isset($_SESSION["message"])){echo $_SESSION["message"];unset($_SESSION["message"]);}?>

	<!------------Booking Details------------>
	<p></p>
	<div class="content-container">
		<div class="entry-head"><h4><strong>Booking Details</strong>
        
        <div style="color:#FFFFFF; float:right">
				<a onClick="PopupCenter('nonoccupancy_details.php','Occupancy List','1000px','500px')" style="cursor:pointer">
				<img src="<?php echo IMAGE_PATH?>view.jpg" style="width:20px" title="Go Back"/>
				</a>
		</div>
        </h4></div>
		<p></p>
			<div class="innerBody">
			<?php if(isset($_SESSION["bkngMsg"])){echo $_SESSION["bkngMsg"];unset($_SESSION["bkngMsg"]);}?>
			<table width="100%" class="table">
				<!--<tr>
				  <td >&nbsp;</td>
				  <td width="8%">Guest Name</td>
				  <td><strong>:</strong></td>
				  <td colspan="2"><input type="text" name="guest_name" id="guest_name" style="width:80%" /></td>
				  <td width="3%">Age</td>
				  <td width="1%"><strong>:</strong></td>
				  <td width="12%"><input type="text" name="guest_age" id="guest_age" style="width:100%" /></td>
				  <td>&nbsp;</td>
				  <td width="9%">Gender</td>
				  <td><strong>:</strong></td>
				  <td colspan="2">
				  <select name="guest_gender" id="guest_gender" style="width:100%">
					<option value="">Please select</option>
					<option value="MALE" >MALE</option>
					<option value="FEMALE" >FEMALE</option>
				  </select></td>
				
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td width="13%">			  </td>
				  </tr>-->
				<tr>
				  <td>&nbsp;</td>
				  <td> In. Date </td>
				  <td><strong>:</strong></td>
				  <td width="16%"><input required type="text" name="arv_date" id="arv_date" 
				  value="<?php if(isset($_POST["arv_date"])){echo $_POST["arv_date"];}else {echo date('d-m-Y');}?>" style="width:100%" class="tcal"/></td>
				  <td width="5%">&nbsp;</td>
				  <td>Time</td>
				  <td><strong>:</strong></td>
				  <td>
					<div class="input-append bootstrap-timepicker">
					<input  name="arrv_time" type="text" class="input-small" id="arrv_time" value="<?=@$_POST["arrv_time"]?>" readonly>
					<span class="add-on" style="height:15px;"><i class="icon-time"></i></span></div>
					<script type="text/javascript">
					$('#arrv_time').timepicker();
					</script>			  </td>
				  <td>&nbsp;</td>
				  <td> Out  Date </td>
				  <td><strong>:</strong></td>
				  <td width="12%"> <?php $Date = date('d-m-Y');$Date=date('d-m-Y', strtotime($Date. ' + 1 days'))?>
				  <input required type="text" name="dep_date" id="dep_date" class="tcal" value="<?=$Date;?>" style="width:100%"/></td>
				  <td width="8%">&nbsp;</td>
				  <td>Time</td>
				  <td><strong>:</strong></td>
				  <td>
				   <div class="input-append bootstrap-timepicker">
					<input id="dep_time" name="dep_time" type="text" class="input-small" value="<?=@$_POST["dep_time"]?>" readonly>
					<span class="add-on" style="height:15px;"><i class="icon-time"></i></span></div>
					<script type="text/javascript">
					$('#dep_time').timepicker();
					</script>			  </td>
			    </tr>  
				<tr>
				  <td width="1%" >&nbsp;</td>
				  <td width="8%">Room Type</td>
				  <td width="2%"><strong>:</strong></td>
				  <td colspan="2">
				  <select name="room_type" id="room_type" style="width:85%">
				  <option value="">Please Select</option>
				  <?php $res=mysql_query("select * from tbl_room_type_mstr");
				  if(mysql_num_rows($res)>0){
				  while($roomData=mysql_fetch_array($res)){?>
				  <option value="<?=$roomData["id"]?>"><?=$roomData["room_type"]?></option>
				  <?php }}?>
				  </select>				  </td>
				   <td>Rate</td>
				   <td><strong>:</strong></td>
				  <td><p id="rate"><strong>Auto</strong><p></td> 
					
				  <td width="0%">&nbsp;</td>
				  <td width="9%">Room No.</td>
				  <td width="1%"><strong>:</strong></td>
				  <td colspan="2"><select name="room_no" id="room_no" style="width:100%;height:25px">
					<option value="">Please Select</option>
				  </select></td>
				  <td width="3%">&nbsp;</td>
				  <td width="1%">&nbsp;</td>
				  <td align="right"><input type="submit" name="Save" id="Save" value="Add" class="btn btn-warning btn-sm" /></td>
				  </tr>
			</table>
			</div>
			
			<?php 
			$discharged=1;
			$where=" md5(customer_mas_id)='".$_SESSION["custid"]."' and chkout_status=1";
			$row=$objCoreFO->getNumRows("tbl_cust_dtls",$where);
			if($row<1){$discharged=0;}
			?>
			<!--------guest DETAILS----------->
		
			<?php 
			$res=mysql_query("select * from tbl_cust_dtls where md5(customer_mas_id)='".$_SESSION["custid"]."' order by id asc");
			if(mysql_num_rows($res)>0)
			{$count=1;$tot=0;$sum=0;
			?>
				<div class="innerBody">
				<?php if(isset($_SESSION["msgreport"])){echo $_SESSION["msgreport"];unset($_SESSION["msgreport"]);}?>
				
				<table width="100%" class="table table-bordered">
					<tr>
						<th width="12%" align="center" style="background-color:#006633;color:#FFFFFF">Room Type</th>
						<th width="6%" align="center" style="background-color:#006633;color:#FFFFFF">Room No.</th>
						<th width="7%" align="center" style="background-color:#006633;color:#FFFFFF">In.Date</th>
						<th width="5%" align="center" style="background-color:#006633;color:#FFFFFF">In Time</th>
						<th width="7%" align="center" style="background-color:#006633;color:#FFFFFF">Out Date</th>
						<th width="6%" align="center" style="background-color:#006633;color:#FFFFFF">Out Time</th>
						<th width="8%" align="center" style="background-color:#006633;color:#FFFFFF">Room Rate</th>
						<th width="7%" align="center" style="background-color:#006633;color:#FFFFFF">Duration</th>
						<th width="8%" align="center" style="background-color:#006633;color:#FFFFFF">Amount</th>
						<th width="2%" align="center" style="background-color:#006633;color:#FFFFFF">
						<?php if($discharged>0){?>
						<input type="checkbox" name="selectAll" id="selectAll" value="selectAll" title="Select All"/>
						<?php }?>
						</th>
					</tr>
					
					 <!-------Guest Details.-------->
					<?php while($guestData=mysql_fetch_array($res)){
					$bgcolor="";$out=1;
					if($guestData["chkout_status"]==0){$bgcolor="#FF0000";$out=0;}
					$row=$objCoreFO->getRows("view_room_type_floor_dtl_wise","id='".$guestData["room_dtl_id"]."'");?>
					<tr>
						<!--<td bgcolor="<?=$bgcolor;?>" align="left">
						<?=$guestData["guest_name"]?>						
						</td>
						<td bgcolor="<?=$bgcolor;?>" align="center"><?=$guestData["age"]?></td>
						<td bgcolor="<?=$bgcolor;?>" align="center"><?=$guestData["gender"]?>
                        </td>-->
						<td bgcolor="<?=$bgcolor;?>" align="center"><?=$row["room_type"]?>
                        <input type="hidden" name="custDtlId_<?=$count?>" id="custDtlId_<?=$count?>" value="<?=$guestData["id"]?>">
						<input type="hidden" name="room_dtl_id_<?=$count?>" id="room_dtl_id_<?=$count?>" value="<?=$guestData["room_dtl_id"]?>"></td>
						<td bgcolor="<?=$bgcolor;?>" align="center"><?=$row["room_no"]?></td>
						<td bgcolor="<?=$bgcolor;?>" align="center"><?=$inDate=date('d-m-Y',$guestData["check_in_dt"]);?></td><!----InDate----->
						<td bgcolor="<?=$bgcolor;?>" align="center"><?php echo IntToTimeAMPM($guestData["check_in_dt"]);?></td><!----InTime----->
						
						<td bgcolor="<?=$bgcolor;?>" align="center" width="8%"><!----OutDate----->
						<?php $outDate=date('d-m-Y',$guestData["check_out_dt"]);if($out==1){?>
						<input type="text" class="tcal" name="outDate_<?=$count?>" id="outDate_<?=$count?>" value="<?=$outDate?>" style="width:75%">
						<?php }else{echo $outDate;}?>
						</td>
						
						<td bgcolor="<?=$bgcolor;?>" align="center"><!----OutTime----->
						<?php if($out==1){?>
						<div class="input-append bootstrap-timepicker">
						<input name="outTime_<?=$count?>" type="text" class="input-small" id="outTime_<?=$count?>" 
                        value="<?=IntToTimeAMPM($guestData["check_out_dt"]);?>"  style="width:56%">
						<span class="add-on" style="height:15px;"><i class="icon-time"></i></span></div>
						<script type="text/javascript">
						$('#outTime_<?=$count?>').timepicker();
						</script>
						<?php }else{echo IntToTimeAMPM($guestData["check_out_dt"]);}?>						
						</td>
 						
						<td bgcolor="<?=$bgcolor;?>" align="center"><?=$row["rate"]?></td>
						<td bgcolor="<?=$bgcolor;?>" align="center">
						<?php 
						/*$days=((strtotime($guestData["check_out_dt"])-strtotime($guestData["check_in_dt"]))/(60*60)/24). "  Days";
                        if($days==0){$days=1;}*/
						
						$inTime=$guestData["check_in_dt"];//in date time
						$outTime=$guestData["check_out_dt"];//out date time
						if($out==1)
						{					
						$days=calcDays($inTime,$graceHourF,$graceMinuteF);
						$nw=strtotime(date('d-m-Y H:i'));
						$diff=dateTimeDiff($nw,$inTime);
	
						
							$day=$diff[1];
							$hr=$diff[2];
							$min=$diff[3];
							
							echo $day." D ".$hr." hr. ".$min." min.";
						}
						else
						{
						$days=calcDaysOnCheckOut($inTime,$outTime,$graceHour,$graceMinute);
						
						$diff=dateTimeDiff($inTime,$outTime);
							$day=$diff[1];
							$hr=$diff[2];
							$min=$diff[3];
							
							echo $day." D ".$hr." hr. ".$min." min.";
						}
						?>
						</td>
						<td bgcolor="<?=$bgcolor;?>" align="right"><?php echo number_format(($row["rate"]*$days),2);$sum=$row["rate"]*$days;?></td>
						<td bgcolor="<?=$bgcolor;?>" align="center">
						<?php if($out==1){?>
						<input type="checkbox" name="chk_<?=$count;?>" id="chk_<?=$count;?>" value="<?=$guestData["id"]?>" title="Clikc me"/>
						<?php }?>						</td>
						<?php $count++;$tot+=$sum;}?>
				  </tr>
				  	 <!-------End Guest details-------->
				  
				 <!-------Total Roomss & Rs.-------->
				  <tr>
						  <td colspan="6" align="left"><input type="hidden" name="total" id="total" value="<?=$tot;?>"></td>
						  <td align="center"><strong><?=$count-1;?> Rooms</strong></td>
						  <td align="center">Total Rs. </td>
						  <td align="right"><strong><?=number_format($tot,2);?></strong></td>
						  <td align="center">&nbsp;</td>
				  </tr>
				 <!-------End rooms & rs.-------->
		
				  <?php if($discharged>0){?>
				  <!-----Buttons-------->
				  <tr> 
					<td colspan="13" align="right">
					<input type="hidden" name="counter" id="counter" value="<?=$count;?>"/>
					<input type="submit" name="Save" id="Save" value="Extend" class="btn btn-inverse" onclick="return confirm('Are you sure to Extend Date / Time?')"/></td>
				  </tr>
				  <!-------end buttons-------->
					<?php }?>
				  </table>
				</div>		
			<?php }	?>
			<!--------guest DETAILS END------->
	</div>
	
	
	<!-------------Booking End------------->
</form>	
<?php include "footer.php"?>
</div>
</div>