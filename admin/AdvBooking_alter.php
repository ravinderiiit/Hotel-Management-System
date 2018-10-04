<?php
@session_start();
@ob_start();

include "header.php"; 
$objCoreFO->advBooking_alter();
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
margin-left:20px;margin-right:20px;padding-top:5px;padding-left:5px;padding-right:5px;margin-bottom:10px;padding-bottom:-30px;border:#CCCCCC 1px solid;height:auto;
}
</style>
<script type="text/javascript">
$(document).ready(function() {                
	$("#FORMNAME1").validate({
                    rules: {
             
					},
		messages: {
						cust_age:"",
					 cust_name:"",
					 gender:"",
					 purpose:"",
					 contact_no:"",
					 email:"",
					 room_type:"",
					 arv_date:"",
					 arrv_time:"",
					 arrv_am_pm:"",
					 room_type:"",
					 room_no:"",
					 dep_date:"",
					 dep_time:"",
					 dep_am_pm:"",
					 rate:"",
					 floor_no:"",
					 room_no:"",
					 mode:"",
					 card_no:"",
					 discount:"",
					
				},
		  }); 
 
	$("#cust_name").autocomplete({
		source:"../ProgramFile/auto/FO_suggest_customerName.php",
		minlength:1,
		select:function(event,ui)
			{
				$("#father_name").val(ui.item.father_name);	
				$("#contact_no").val(ui.item.mobile);
				$("#alt_no").val(ui.item.alt_no);
				$("#address").val(ui.item.address);	
				$("#pincode").val(ui.item.pincode);
				
				if((ui.item.gender)=="MALE"){				
				$("select#gender").val("Male");
				}else{
					$("select#gender").val("Female");
					}
				$("select#nationality").val(ui.item.nation);
				$("#cust_age").val(ui.item.age);
				
			}
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
			$.post("../ProgramFile/auto/FO_room_no.php",{'room_type':room_type,'arv_date':arv_date,'dep_date':dep_date,'arv_time':arv_time,'dep_time':dep_time},
			function(response){
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
	
	$("#arv_date,#dep_date,#arrv_time,#dep_time").blur(function(){
		$("#room_type").prop("selectedIndex",0);
		$("#room_no").empty();
		$("<option value=''>Please Select</option>").appendTo($("#room_no"));
		$("#rate").html("<strong>Auto</strong>");
		//alert("response");
	});
	
	$("#deleteAll").click(function(){
		if($(this).is(":checked"))
		{
		$("input[type='checkbox']").attr("checked",true);
		}
		else
		{
		$("input[type='checkbox']").attr("checked",false);
		}
	});
	
	$("#mode").change(function(){
		if(($(this).prop('selectedIndex'))>1)
		{
		$("#card_no").show();
		}
		else
		{
		$("#card_no").hide();
		}
	});
	
	$("#pay").keyup(function(){
		var recv=eval($(this).val());
		var total=$("#netpay").val();
		//alert(total);
		if(total!="")
		{
			if(recv>total)
			{
			$("#pay").val(total);
			alert("Warning! The amount cannot be exceed than Rs." + total + ".00");
			}
		}
		else
		{
		$("#pay").val("");
		alert("Warning! Please press calculate button first");
		}
	});
              
});
//---auto search-----
</script>
<script>
//calculation of amount
function cal()
{
var total=eval($("#total").val());//text box
var dis=eval($("#discount").val());//text box
var totTax=$("#totTax").val();//text box
if(totTax==null || totTax==""){eval(totTax=0);}else{totTax=eval(totTax);}
var netpayble=0;
	if(dis!=0)
	{
	total=(total*(100-dis))/100;
	}
	
	var netpayble=total+totTax;
	netpayble=Math.round(netpayble);
	$("#netpayble").html("<strong>" + netpayble +" .00</strong>");
	$("#pay").val(netpayble);
	$("#netpay").val(netpayble);
}
//end
//*****************city*********************
function showcity_a(str)
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url="cityhint1.php";
	url=url+"?q="+str;
	url=url+"&sid="+Math.random();
	xmlhttp.onreadystatechange=stateChanged100;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
	function stateChanged100()
	{
	if (xmlhttp.readyState==4)
	  {
	  document.getElementById("txt_city").innerHTML=xmlhttp.responseText;
	  }
	}
}
//*****************End city********************* 
</script>
<div class="content">
	<div class="content-header">
	<h3 class="head-dashboard">Reservation</h3>
 	</div>
<div class="content-container">
<div class="entry-head">
	<h4>
		<strong>Advance Booking </strong>
			<div style="color:#FFFFFF; float:right">
				<a href="AdvBooking_list.php">
				<img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"/>
				</a>
		</div>
	</h4>
</div>
<div class="entry-content">

	<form method="post">
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
				  <select name="room_no" id="room_no" style="width:68%;height:25px">
				  <option value="">Please Select</option>
				  </select></td>
				  <td width="3%">&nbsp;</td>
				  <td width="1%">&nbsp;</td>
				  <td align="right"><input type="submit" name="Save" id="Save" value="Add" class="btn btn-warning btn-sm" /></td>
				  </tr>
			</table>
			</div>
			
			
			<!--------TEMPROARY BOOKING DETAILS----------->
			<?php 
			$res=mysql_query("select * from view_temp_fo_book_dtls where userid='".$_SESSION["userid"]."' order by id asc");
			if(mysql_num_rows($res)>0)
			{$count=1;$tot=0;$sum=0;
			?>
				<div class="innerBody">
				<?php if(isset($_SESSION["delmsg"])){echo $_SESSION["delmsg"];unset($_SESSION["delmsg"]);}?>
				<table width="100%" class="table table-bordered">
					<tr>
						<th width="9%" align="center" style="background-color:#006633;color:#FFFFFF">In.Date</th>
						<th width="9%" align="center" style="background-color:#006633;color:#FFFFFF">In Time</th>
						<th width="9%" align="center" style="background-color:#006633;color:#FFFFFF">Out Date</th>
						<th width="9%" align="center" style="background-color:#006633;color:#FFFFFF">Out Time</th>
						<th width="23%" align="center" style="background-color:#006633;color:#FFFFFF">Room Type</th>
						<th width="7%" align="center" style="background-color:#006633;color:#FFFFFF">Room No.</th>
						<th width="8%" align="center" style="background-color:#006633;color:#FFFFFF">Room Rate</th>
						<th width="8%" align="center" style="background-color:#006633;color:#FFFFFF">Days</th>
						<th width="8%" align="center" style="background-color:#006633;color:#FFFFFF">Amount</th>
						<th width="3%" align="center" style="background-color:#006633;color:#FFFFFF">
						<input type="checkbox" name="deleteAll" id="deleteAll" value="deleteAll" title="Delete All"/></th>
					</tr>
					<?php 
					$taxDataSet=array();
					while($tempData=mysql_fetch_array($res)){?>
					<tr>
						<!--<td align="center"><?=$tempData["guest"]?></td>
						<td align="center"><?=$tempData["age"]?></td>
						<td align="center"><?=$tempData["gender"]?></td>-->
						
						<td align="center"><?php echo $inDate=$objCoreFO->IntToDate($tempData["arrv_date"]);?></td>
						<td align="center"><?=date('h:i A',$tempData["arrv_date"]);?></td>
						<td align="center"><?php echo $outDate=$objCoreFO->IntToDate($tempData["dep_date"]);?></td>
						<td align="center"><?=date('h:i A',$tempData["dep_date"]);?>
                        <?php 
						$days=(strtotime($outDate)-strtotime($inDate))/(60*60)/24;
						$sum=$tempData["room_rate"]*$days;
						?>
                        </td>
						<td align="left">
						<?=$tempData["room_type"]?>
                        <input type="hidden" name="grpid_<?=$count?>" value="<?=$tempData["group_mstr_id"]."@".$tempData["under_group"];?>" style="width:95%">
                        </td>
                        <td align="center"><?=$tempData["room_no"]?></td>
                        <td align="center">
						<?=$tempData["room_rate"]?>
                        <?php $taxres=mysql_query("select * from  view_room_tax_mstr_dtl_wise where suspended_status=0 and group_mstr_id='".$tempData["group_mstr_id"]."' and (`min_range`<='".$tempData["room_rate"]."' and `max_range`>='".$tempData["room_rate"]."')");
						  if(mysql_num_rows($taxres)>0)
						  {$taxCount=1;$tota=0;
						  
							  while($taxData=mysql_fetch_array($taxres))
							  {
								  $tota=$sum*$taxData["calc_val"]/100;?>
								  <input type="hidden" name="taxType<?=$taxCount?>" 
								  value="<?=$taxData["tax_mstr_id"]." || ".$taxData["taxname"]." || ".$taxData["calc_val"]." || ".$tota?>"/>
								  <?php
								 $flag=0;$updateRow=0;
								 $arrLen=sizeof($taxDataSet);
								 
								 if($arrLen==0)
								 {
									$taxDataSet[0][0]=$taxData["tax_mstr_id"];
									$taxDataSet[0][1]=$taxData["taxname"];
									$taxDataSet[0][2]=$tota;	
								 }
								 else
								 {
										for($row=0;$row<$arrLen;$row++)
										{
											if($taxDataSet[$row][0]==$taxData["tax_mstr_id"])
											{
												$flag=1;
												$updateRow=$row;
											}
										}
										if($flag==0)
										{
										$taxDataSet[$arrLen][0]	= $taxData["tax_mstr_id"];
										$taxDataSet[$arrLen][1]	= $taxData["taxname"];
										$taxDataSet[$arrLen][2]	= $tota;
										}
										else if($flag==1)
										{
										$taxDataSet[$updateRow][2]+=$tota;
										}
								 }
								  $taxCount++;
							 }
							 
						  }?>
                        </td>
						<td align="center">
						<?php echo $days;?>
						</td>
						<td align="right"><?=number_format($sum,2);?></td>
						<td align="center">
						<input type="checkbox" name="delete_<?=$count;?>" id="delete_<?=$count;?>" value="<?=$tempData["id"]?>" title="Delete One"/></td>
						<?php $count++;$tot+=$sum;}?>
				  </tr>
				  <tr>
						  <td colspan="5" align="left"><span style="float:left">
					      <input type="hidden" name="count" id="count" value="<?=$count;?>"/>
                          <input type="hidden" name="total" id="total" value="<?=$tot;?>">
					      </span>
						    </td>
						  <td align="center"><strong><?=$count-1;?> Rooms </strong></td>
						  <td align="right">&nbsp;</td>
						  <td align="center">Total Rs. </td>
						  <td align="right"><strong><?=number_format($tot,2);?></strong></td>
						  <td align="center">&nbsp;</td>
				  </tr>
				  <tr>
						  <td colspan="8" align="right">Discount(<strong>%</strong>)</td>
						  <td align="right">
						  <input required type="text" name="discount" id="discount" style="width:60%;text-align:right" 
						  value="<?php if(isset($_POST["discount"])){echo $_POST["discount"];}else{echo 0;}?>" onkeyup="cal()"/></td>
						  <td align="center">&nbsp;</td>
				</tr>
				  <?php 
				  $len= sizeof($taxDataSet);
			      $taxcount=1;$totTax=0;
				  for($i=0;$i<$len;$i++){?>
                <tr>
                	<td colspan="8" align="right">
                    <span style="float:left">
					<input type="hidden" name="taxid_<?=$taxcount;?>" id="taxnm_<?=$count;?>" value="<?=$taxDataSet[$i][0];?>">
					<input type="hidden" name="taxprntg_<?=$taxcount;?>" id="taxprntg_<?=$count;?>" value="<?=$taxDataSet[$i][2];?>">
                    </span>
                    <em><?=$taxDataSet[$i][1]?></em>
                    </td>
                    <td align="right"><?php $totTax+=$taxDataSet[$i][2]; echo number_format($taxDataSet[$i][2],2);?></td>
                    <td align="center">&nbsp;</td>
                </tr>
                <?php $taxcount++;}?>
				 
				  <tr>
					<td colspan="8" align="right">
					<div align="left">
					  <input type="hidden" name="taxcount" id="taxcount" value="<?=$taxcount?>"/>
					  <input type="hidden" name="totTax" id="totTax" value="<?=$totTax?>"/>
                      <input type="hidden" name="netpay" id="netpay" value="<?php if(isset($_POST["netpay"])){echo $_POST["netpay"];}?>"/>
					</div>
					
					<strong>Total</strong> (<em>including TAX & round off</em>)</td>
					<td align="right"><span id="netpayble"><strong>Auto</strong></span></td>
					<td align="center">&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan="13" align="right">
                    <input type="button" name="calculate" id="calculate" value="Calculate" class="btn"  onclick="cal()"/>
                    <input type="hidden" name="count" id="count" value="<?=$count;?>"/>
                    <input type="submit" name="Save" id="Save" value="Delete" class="btn btn-danger" onclick="return confirm('Are you sure to delete?')"/>
                    </td>
				  </tr>
				  </table>
				</div>
				
			
			<?php }?>
            <!--------TEMPROARY BOOKING DETAILS END------->
	</div>
	<p></p>
	<!-------------Booking End------------->
    </form>
    
    <form method="post" id="FORMNAME1">
	<!-------Customer Details----------->
	<div class="content-container">
	<div class="entry-head"><h4><strong>Customer Details</strong></h4></div>
	<p></p>
		<div class="innerBody">
			<table width="100%" class="table">
				<tr>
					<td width="18%">Customer Name </td>
					<td width="1%"><strong>:</strong></td>
				  <td colspan="9">
				  <input required type="text" name="cust_name" id="cust_name"  value="<?=@$_POST["cust_name"]?>" placeholder="John\Marry etc..." style="width:99%"/>	  </td>
			    </tr>
				<tr>
				  <td>Gender</td>
				  <td><strong>:</strong></td>
				  <td colspan="5">
				  <select required name="gender" id="gender">
					<option value="">Select</option>
					<option value="Male" <?php if(@$_POST["gender"]=="Male"){?>selected="selected" <?php }?>>Male</option>
					<option value="Female" <?php if(@$_POST["gender"]=="Female"){?>selected="selected" <?php }?>>Female</option>
				  </select>				  </td>
				  <td width="2%">&nbsp;</td>
				  <td width="13%">Age</td>
				  <td width="1%"><strong>:</strong></td>
				  <td><input type="text" name="cust_age" id="cust_age" value="<?=@$_POST["cust_age"]?>"/></td>
				  </tr>
				<tr>
				  <td>Contact No. </td>
				  <td><strong>:</strong></td>
				  <td colspan="5">
				  <input required type="text" name="contact_no" id="contact_no" class="required digits" value="<?=@$_POST["contact_no"]?>"/>		  </td>
				  <td>&nbsp;</td>
				  <td>Alternate No. </td>
				  <td><strong>:</strong></td>
				  <td><input type="text" name="alt_no" id="alt_no" value="<?=@$_POST["alt_no"]?>" /></td>
				  </tr>
				<tr>
				  <td valign="top">Address</td>
				  <td valign="top"><strong>:</strong></td>
				  <td colspan="9" valign="top">
		<textarea name="address" id="address"  style="width:99%;height:40px;resize:none" placeholder="Please enter complete address such as Street\Ho.No\Landmark etc.."><?php echo $_POST["address"];?></textarea>				  </td>
				  </tr>
				
				<tr>
				  <td>Pin Code</td>
				  <td><strong>:</strong></td>
				  <td width="17%"><input type="text" name="pincode" id="pincode"  value="<?=@$_POST["pincode"]?>" placeholder="Enter Digits only"/></td>
				  <td width="2%">&nbsp;</td>
				  <td width="14%">Male</td>
				  <td width="1%"><strong>:</strong></td>
				  <td width="12%"><input required type="text" name="male_no" id="male_no" placeholder="No. of male"  value="<?=@$_POST["male_no"]?>"/></td>
				  <td>&nbsp;</td>
				  <td>Female</td>
				  <td><strong>:</strong></td>
				  <td><input required type="text" name="female_no" id="female_no" placeholder="No. of female"  value="<?=@$_POST["female_no"]?>"/></td>
				  </tr>
				<tr>
				  <td>Comming From</td>
				  <td><strong>:</strong></td>
				  <td><input type="text" name="comming_from" id="comming_from" value="<?=@$_POST["comming_from"]?>"/></td>
				  <td>&nbsp;</td>
				  <td>Purpose</td>
				  <td><strong>:</strong></td>
				  <td><?php $objCoreAdmin->CreateSelect("purpose","tbl_purpose_mstr","purpose_name","purpose_name",1,@$_POST["purpose"]);?></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  </tr>
			</table>
				
		</div>
	</div>
	<!--------------End----------------->

	<!-------Payment Details----------->
	<p></p>
	<div class="content-container">
		<div class="entry-head"><h4><strong>Payment Details</strong></h4></div>
			<p></p>
			<div class="innerBody">
			<p></p>
			<table width="100%" class="table">
				<tr>
					<td width="11%">Payment Mode</td>
					<td width="1%"><strong>:</strong></td>
					<td width="88%">
					<select name="mode" id="mode" >
					<option value="">Please Select</option>
					<option value="Cash" <?php if(@$_POST["mode"]=="Cash"){?>selected="selected" <?php }?>>Cash</option>
					<option value="Other" <?php if(@$_POST["mode"]=="Other"){?>selected="selected" <?php }?>>Other</option>
					</select>				
					</td>
				</tr>
				<?php $display="none";
				if(isset($_POST["mode"])){if($_POST["mode"]=="Other"){$display="runin";}}
				?>
				<tr id="card_no" style="display:<?=$display?>">
				  <td>Card No. </td>
				  <td><strong>:</strong></td>
				  <td><input type="text" name="card_no" id="card_no" value="<?=@$_POST["card_no"]?>"/></td>
				</tr>
				<tr>
				  <td>Payble amount </td>
				  <td><strong>:</strong></td>
				  <td>
				  <input type="text" name="recv_amount" id="pay" value="<?php if(isset($_POST["recv_amount"])){echo $_POST["recv_amount"];}else{"Auto";}?>"/>
				  </td>
				</tr>
			</table>
			</div>
	</div>
	<!-------Payment Details End---------->
	
		

<p></p>
<!------Book Now------------->
<div align="center">
<input type="submit" id="Save" name="Save" class="btn btn-primary" value="Book Now" />
</div>
<!------Book Now End------------->

</form>	


<?php include "footer.php"?>
</div>
</div>
