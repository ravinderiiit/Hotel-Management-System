<?php
@session_start();
@ob_start();
include "AdvBooking_view.php";
$objCoreFO->AdvRoomDtl();
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
		<strong> Room Details</strong>
        <div style="color:#FFFFFF; float:right">
				<a onClick="PopupCenter('nonoccupancy_details.php','Occupancy List','1000px','500px')" style="cursor:pointer">
				<img src="<?php echo IMAGE_PATH?>view.jpg" style="width:20px" title="Go Back"/>
				</a>
		</div>
	</h4>
</div>
<div class="entry-content">
<form method="post">
	<!-------Customer Personal Details----------->
	
         <div style="margin-left:10px;margin-right:10px;padding-top:20px;padding-left:20px;padding-right:5px;padding-bottom:20px;border:#CCCCCC 1px solid;">
		<?php 
		if(isset($_SESSION["delmsg"])){echo $_SESSION["delmsg"];unset($_SESSION["delmsg"]);}
		if(isset($_SESSION["extndmsg"])){echo $_SESSION["extndmsg"];unset($_SESSION["extndmsg"]);}?>
		<table width="100%" class="table">
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
				  <td colspan="2">
				  <select name="room_no" id="room_no" style="width:68%">
					<option value="">Please Select</option>
				  </select></td>
				  <td width="3%">&nbsp;</td>
				  <td width="1%">&nbsp;</td>
				  <td align="right"><input type="submit" name="Save" id="Save" value="Add" class="btn btn-warning btn-sm" /></td>
				  </tr>
			</table>
		</div>
		<p></p>
        <div class="innerBody">
        <p></p>
        <table width="100%" class="table table-bordered">
        <tr>
        <th width="3%" align="center" style="background-color:#006633;color:#FFFFFF">#</th>
        <th width="19%" align="center" style="background-color:#006633;color:#FFFFFF">Room Type</th>
        <th width="8%" align="center" style="background-color:#006633;color:#FFFFFF">Room No.</th>
        <th width="12%" align="center" style="background-color:#006633;color:#FFFFFF">In.Date</th>
        <th width="12%" align="center" style="background-color:#006633;color:#FFFFFF">In Time</th>
        <th width="12%" align="center" style="background-color:#006633;color:#FFFFFF">Out Date</th>
        <th width="12%" align="center" style="background-color:#006633;color:#FFFFFF">Out Time</th>
        <th width="9%" align="center" style="background-color:#006633;color:#FFFFFF">Room Rate</th>
        <th width="8%" align="center" style="background-color:#006633;color:#FFFFFF">Days</th>
        <th width="9%" align="center" style="background-color:#006633;color:#FFFFFF">Amount</th>
        <th width="4%" align="center" style="background-color:#006633;color:#FFFFFF">
        <input type="checkbox" name="selectAll" id="selectAll" value="selectAll" title="Select All"/>						</th>
        </tr>
        <?php 
        $res=mysql_query("select * from tbl_adv_booking_dtls where md5(adv_booking_id)='".$_SESSION["custid"]."'order by id asc");
        if(mysql_num_rows($res)>0)
        {$count=1;$tot=0;$sum=0;
        ?>
        <!-------Guest Details.-------->
        <?php while($roomData=mysql_fetch_array($res))
        {
        if($roomData["status"]==0){$canc=1;$bgcolor="#CC0033";}else{$canc=0;$bgcolor="";}
        $row=$objCoreFO->getRows("view_room_type_floor_dtl_wise","id='".$roomData["room_dtl_id"]."'");?>
        <tr>
        <td bgcolor="<?=$bgcolor;?>" align="center"><?=$count;?></td>
        <td bgcolor="<?=$bgcolor;?>" align="center">
		<?=$row["room_type"]?>
        <input type="hidden" name="room_type_mstr_id_<?=$count?>" id="room_type_mstr_id_<?=$count?>" value="<?=$row["room_type_mstr_id"]?>" style="width:75%">
        </td>
        <td bgcolor="<?=$bgcolor;?>" align="center"><?=$row["room_no"]?></td>
        <!----InDate----->
        <td bgcolor="<?=$bgcolor;?>" align="center">
		<?php $inDate=date('d-m-Y',$roomData["check_in_dt"]);if($canc==0){?>
        <input type="text" class="tcal" name="inDate_<?=$count?>" id="inDate_<?=$count?>" value="<?=$inDate?>" style="width:75%">
        <?php }else{echo $inDate;}?>
        </td>
        <!----InTime----->
        <td bgcolor="<?=$bgcolor;?>" align="center">
		<?php $inTime=IntToTimeAMPM($roomData["check_in_dt"]);?>
        <?php if($canc==0){?>
        <div class="input-append bootstrap-timepicker">
        <input name="inTime_<?=$count?>" type="text" class="input-small" id="inTime_<?=$count?>" value="<?=IntToTimeAMPM($roomData["check_out_dt"]);?>" 
        readonly style="width:56%">
        <span class="add-on" style="height:15px;"><i class="icon-time"></i></span></div>
        <script type="text/javascript">
        $('#inTime_<?=$count?>').timepicker();
        </script>
        <?php }else{echo IntToTimeAMPM($roomData["check_in_dt"]);}?>
        
        </td>
        
        <!----OutDate----->
        <td bgcolor="<?=$bgcolor;?>" align="center" width="12%">
        <?php $outDate=date('d-m-Y',$roomData["check_out_dt"]);if($canc==0){?>
        <input type="text" class="tcal" name="outDate_<?=$count?>" id="outDate_<?=$count?>" value="<?=$outDate?>" style="width:75%">
        <?php }else{echo $outDate;}?>						</td>
        
        <!----OutTime----->
        <td bgcolor="<?=$bgcolor;?>" align="center">
        <?php if($canc==0){?>
        <div class="input-append bootstrap-timepicker">
        <input name="outTime_<?=$count?>" type="text" class="input-small" id="outTime_<?=$count?>" value="<?=IntToTimeAMPM($roomData["check_out_dt"]);?>" 
        readonly style="width:56%">
        <span class="add-on" style="height:15px;"><i class="icon-time"></i></span></div>
        <script type="text/javascript">
        $('#outTime_<?=$count?>').timepicker();
        </script>
        <?php }else{echo IntToTimeAMPM($roomData["check_out_dt"]);}?>						</td>
        
        <td bgcolor="<?=$bgcolor;?>" align="center"><?=$row["rate"]?></td>
        <td bgcolor="<?=$bgcolor;?>" align="center">
        <?php 
        $inTime=$roomData["check_in_dt"];//in date time
        $outTime=$roomData["check_out_dt"];//in date time
        echo $days=((strtotime($outDate)-strtotime($inDate))/(60*60)/24). "  Days";
        ?>						</td>
        <td bgcolor="<?=$bgcolor;?>" align="right"><?php echo number_format(($row["rate"]*$days),2);$sum=$row["rate"]*$days;?></td>
        <td bgcolor="<?=$bgcolor;?>" align="center">
        <?php if($canc!=1){?>
        <input type="checkbox" name="chk_<?=$count;?>" id="chk_<?=$count;?>" value="<?=$roomData["id"]?>" title="Clikc me"/>						
        <?php }?>
        </td>
        </tr>
        <?php $count++;$tot+=$sum;
        }?>
        <!-------End Guest details-------->
        
        <!-------Total Roomss & Rs.-------->
        <tr>
              <td align="left" colspan="7"><input type="hidden" name="total" id="total" value="<?=$tot;?>" /></td>
              <td align="center"><strong><?=$count-1;?> Rooms</strong></td>
              <td align="center"><strong>Total Rs.</strong> </td>
              <td align="right"><strong><?=number_format($tot,2);?></strong></td>
              <td align="center">&nbsp;</td>
        </tr>
        <tr>
        <td align="right" colspan="11">
        <input type="hidden" name="counter" id="counter" value="<?=$count?>">
        <input type="submit" name="Save" id="Save" value="Extend" class="btn-inverse">
        <input type="submit" name="Save" id="Save" value="Cancel" class="btn-danger">
       
        </td>
        </tr>
        <!-------End rooms & rs.-------->
        <?php 
        }?>	
        </table>	
        </div>

</form>
	<!--------------End----------------->
<?php include "footer.php"?>
</div>
</div>