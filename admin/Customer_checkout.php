<?php
@session_start();
@ob_start();
include "Customer_view.php";
include "function.ini.php";
$objCoreFO->customer_checkout();
$objCoreFO->customer_Account();

$uid=$_SESSION["custid"];
$where="md5(id)='$uid'";
$data1=$objCoreFO->getRows("tbl_customer_master",$where);
	//this section will hide all options when all rooms are checked out
	$discharged=1;
	$where=" md5(customer_mas_id)='$uid' and chkout_status=1";
	$row=$objCoreFO->getNumRows('tbl_cust_dtls',$where);
	if($row==0){$discharged=0;}
	//end
?>
<script>
$(document).ready(function() { 
	$("#SelectAll").click(function(){
	var check=$(this);
		if(check.is(":checked"))
		{
		$("input[type='checkbox']").attr("checked",true);
		}
		else
		{
		$("input[type='checkbox']").attr("checked",false);
		}
	});
$("#payAmt").keyup(function(){
		var dis=eval($("#disc").val());
		var payAmt=eval($("#payAmt").val());
		var total=eval($("#total").val());
		var netTotal=eval($("#netTotal").val());
		$("#Checkout").attr('disabled','true');
		var totDisc=0;
		//alert(payAmt);
			if(payAmt<netTotal)
			{
				if(payAmt!=0)
				{
				totDisc=netTotal-payAmt;
				totDisc=totDisc*100/total;
				$("#disc").val(totDisc);
				}
				else
				{
				$("#disc").val('100.00');	
				}
			}
			else
			{
			$("#disc").val('0.00');
			}
		});	
$("#payAmt").blur(function()	{
	$(this).val($(this).val() + ".00");
	});
$("#disc").keyup(function(){
		$("#Checkout").attr('disabled','true');
		$("#payAmt").val("0.00");
		});	

});
	
</script>
<style>
.innerBody{
margin-left:10px;margin-right:10px;padding-top:5px;padding-left:5px;padding-right:5px;margin-bottom:10px;padding-bottom:-30px;border:#CCCCCC 1px solid;height:auto;
}
</style>
<div class="content">
	
<div class="content-container">
<div class="entry-head">
	<h4>
		<strong>Check out</strong>
	</h4>
</div>
<div class="entry-content">
<form method="post">
	<!-------Customer Room Details----------->
	<div class="content-container">
	<div class="entry-head">
	<h4>
		<strong>Room Details</strong>
	</h4>
	</div>
	<div class="entry-content">
	
		<div class="innerBody">
			<p></p>
			<?php if(isset($_SESSION["message"])){echo $_SESSION["message"];unset($_SESSION["message"]);}?>
			<table width="100%" class="table table-bordered">
			  <tr>
				<th width="2%" style="background:#006633;color:#FFFFFF">#</th>
				
				<th width="7%" style="background:#006633;color:#FFFFFF">Room No.</th>
				<th width="20%" align="left" style="background:#006633;color:#FFFFFF">Room Type</th>
				<th width="6%" style="background:#006633;color:#FFFFFF">In Date</th>
				<th width="6%" style="background:#006633;color:#FFFFFF">In Time</th>
				<th width="8%" style="background:#006633;color:#FFFFFF">Out Date</th>
				<th width="7%" style="background:#006633;color:#FFFFFF">Out Time</th> 
				<th width="5%" style="background:#006633;color:#FFFFFF">Duration</th>
				<th width="4%" align="center" style="background:#006633;color:#FFFFFF">Rate</th>
				<th width="6%" style="background:#006633;color:#FFFFFF">Amount</th>
				<?php if($discharged>0){?>
				<th width="2%" style="background:#006633;color:#FFFFFF">
				<input type="checkbox" name="SelectAll" id="SelectAll" title="Select All">
				</th> 
				<?php }?>
			  </tr>
			 <?php 
			  $res2=mysql_query("select * from view_cus_mstr_dtl_wise where id='".$data1["id"]."' order by id asc");
			  $count=1;$tot=0;$taxDataSet=array();
			  while($data2=mysql_fetch_array($res2))
			  {
			  if($data2["chkout_status"]==0){$bgcolor="#FF0000";$out=1;}else{$out=0;$bgcolor="";}
			  $where="id='".$data2["room_dtl_id"]."'";
			  $data3=$objCoreFO->getRows("view_room_type_floor_dtl_wise",$where);
			  ?>
						
			  <tr>
			  	<td align="center" bgcolor="<?=$bgcolor;?>">
				<strong><?=$count;?></strong>
				<input type="hidden" name="cust_dtl_id_<?=$count;?>" id="cust_dtl_id_<?=$count;?>" value="<?=$data2["cust_dtl_id"]?>" />
				</td>
				
				<td align="center" bgcolor="<?=$bgcolor;?>"><?=$data3["room_no"]?></td>
				<td align="left" bgcolor="<?=$bgcolor;?>">
				<?=$data3["room_type"]?>
                <input type="hidden" name="grpid_<?=$count?>" value="<?=$data2["group_mstr_id"]."@".$data2["group_name"];?>" style="width:95%">
                </td>
				<td align="center" bgcolor="<?=$bgcolor;?>"><?=$inDate=$objCoreFO->IntToDate($data2["check_in_dt"]);?></td>
				<td align="center" bgcolor="<?=$bgcolor;?>"><?=date('h:i A',$data2["check_in_dt"])?></td>
				<td align="center" bgcolor="<?=$bgcolor;?>">
				<?php if($out!=1){
				$outDate=$objCoreFO->IntToDate($data2["check_out_dt"]);
				?>
				<input type="text" name="chkoutDate_<?=$count?>" id="chkoutDate_<?=$count?>" 
				value="<?php if(isset($_POST["chkoutDate_$count"])){echo $_POST["chkoutDate_$count"];}else{echo $objCoreFO->IntToDate($data2["check_out_dt"]);}?>" 
				style="width:60%" class="tcal"/>
				<?php }else {echo $outDate=$objCoreFO->IntToDate($data2["check_out_dt"]);}?>
				</td>
				<td align="center" bgcolor="<?=$bgcolor;?>">
				<?php if($out!=1){?>
				<div class="input-append bootstrap-timepicker">
				<input name="outTime_<?=$count?>" type="text" class="input-small" id="outTime_<?=$count?>" 
                value="<?=$objCoreFO->IntToTimeAMPM($data2["check_out_dt"]);?>" readonly style="width:56%">
				<span class="add-on" style="height:15px;"><i class="icon-time"></i></span></div>
				<script type="text/javascript">
				$('#outTime_<?=$count?>').timepicker();
				</script>
				<?php }else echo IntToTimeAMPM($data2["check_out_dt"]);?>
				</td>
				<td align="center" bgcolor="<?=$bgcolor;?>">
					<?php 
						/*$days=((strtotime($outDate)-strtotime($inDate))/(60*60)/24). "  Days";
                        if($days==0){$days=1;}*/
					
						$inTime=$data2["check_in_dt"];//in date time
						$outTime=$data2["check_out_dt"];//out date time
						if($out!=1)
						{					
						$days=calcDays($inTime,$graceHour,$graceMinute);
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
							
							
							$rate=$data3["rate"];
							$amount=($data3["rate"]*$days);
					   		$total+=$amount;
					?>
				</td>
				<td align="center" bgcolor="<?=$bgcolor;?>">
				<?=$rate?>
                 <?php 
				 $sql="select * from  view_room_tax_mstr_dtl_wise where suspended_status=0 and group_mstr_id='".$data2["group_mstr_id"]."' and (`min_range`<='".$rate."' and `max_range`>='".$rate."')";
				 $taxres=mysql_query($sql);
						  if(mysql_num_rows($taxres)>0)
						  {$taxCount=1;$tota=0;
						  
							  while($taxData=mysql_fetch_array($taxres))
							  {
								  $tota=$amount*$taxData["calc_val"]/100;?>
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
				<td align="right" bgcolor="<?=$bgcolor;?>"><?=number_format(($amount),2);?></td>
				<?php if($discharged>0){?>
				<td align="center" bgcolor="<?=$bgcolor;?>">
				<?php if($out!=1){?>
				<input type="checkbox" name="chk_<?=$count?>" id="chk_<?=$count?>" title="Click Me">
				<?php }?>
				</td>
				<?php }?>
			  
			  </tr>
			<?php $count++;}?>
			  <!-------Total---------->
			  <tr>
			  	<td colspan="9" align="right">
				<div style="float:left;text-align:left">
				<input type="hidden" name="counter" id="counter" value="<?=$count?>" style="width:10%">
				<input type="hidden" name="total" id="total" value="<?=$total?>" style="width:50%">
				</div>
				<strong>Total</strong>
				</td>
				<td align="right"><strong><?=number_format($total,2)?></strong></td>
				<?php if($discharged>0){?><td></td><?php }?>
			  </tr>
			  <!-------Total End------>
			  
			  <!-------Discount------->
			  <tr>
			    <td colspan="9" align="right"><em>Discount (%) </em></td>
			    <td align="right">
				<?php $tm=($total*$data1["discount"]/100);?>
                <input type="text" name="disc" id="disc" value="<?php echo number_format($data1["discount"],2);?>" style="width:50%;text-align:right">
				</td>
			   <?php if($discharged>0){?> <td></td><?php }?>
		      </tr>
			  <!-------Discount End--->
			 
			  <!-------Taxation------->
			  <?php 
				  $len= sizeof($taxDataSet);
			      $taxcount=1;$totTax=0;
				  for($i=0;$i<$len;$i++){
					  if($taxDataSet[$i][2]!=0){?>
               	<tr>
                	<td colspan="9" align="right">
                    <span style="float:left">
					<input type="hidden" name="taxid_<?=$taxcount;?>" id="taxnm_<?=$count;?>" value="<?=$taxDataSet[$i][0];?>">
					<input type="hidden" name="taxprntg_<?=$taxcount;?>" id="taxprntg_<?=$count;?>" value="<?=$taxDataSet[$i][2];?>">
                    </span>
                    <em><?=$taxDataSet[$i][1]?></em>
                    </td>
                    <td align="right"><?php $totTax+=$taxDataSet[$i][2]; echo number_format($taxDataSet[$i][2],2);?></td>
                    <?php if($discharged>0){?>
                    <td align="center">&nbsp;</td>
                    <?php }?>
                </tr>
                <?php }$taxcount++;}?>
			  <!-------End Taxation--->
			 
			  <!-------Net Pay------->
			  <tr>
			    <td colspan="9" align="right">
				<div style="float:left;text-align:left">
                <input type="hidden" name="taxcount" id="taxcount" value="<?=$taxcount?>"/>
				<input type="hidden" name="taxTotal" id="taxTotal" value="<?=$totTax?>" >
				<input type="hidden" name="netTotal" id="netTotal" value="<?=round($totTax+$total)?>" >
				</div>
				<strong>Total <em>(including Tax)</em></strong>
				</td>
			    <td align="right">
				<?php 
				$totRoom=$totTax+($total-$tm);
				$totRoom=round($totRoom);
				if($discharged>0){?>
				<strong><?php echo number_format($totRoom,2);?></strong>
				<?php }else{?>
				<input type="text" name="netTotal" id="netTotal" value="<?=number_format($tax+($total-$tm),2)?>" 
				style="width:80%;text-align:right;border:none;box-shadow:none;background-color:transparent;font-weight:bold">
				<?php }?>
				</td>
			   <?php if($discharged>0){?><td></td><?php }?>
		      </tr>
			  <!-------End Net Pay--->
			 <?php 
			 if($discharged>0){
			 ?>
			  <tr>
			    <td colspan="9" align="right"><strong>Payble Amount</strong></td>
			    <td align="right"><input type="text" name="payAmt" id="payAmt" value="<?php if(isset($_POST["payAmt"])){echo $_POST['payAmt'];}else{echo '0.00';}?>" style="width:80%;text-align:right"></td>
			    <td align="right">&nbsp;</td>
			    </tr>
			  <tr>
			    <td colspan="11" align="right">
                <input type="submit" name="Save" id="Save" value="Calculate" class="btn btn-warning"/>
				<input type="submit" name="Save" id="Checkout" value="Checkout" class="btn btn-success" <?php if(!@$_POST['Save']=="Calculate"){?>disabled <?php }?>/>
				</td>
		      </tr>
			  <?php }?>
			</table>	
			<p></p>
           </div>
	
	</div>
	</div>
	<!--------------End---------------------->
	<p></p>
	
	<!-------Customer facility Details ----------->
	<?php 
		$sql="select * from view_cust_facility_full_dtl where cust_dtls_id in (select id from tbl_cust_dtls where md5(customer_mas_id)='".$_SESSION["custid"]."')";
		$res=mysql_query($sql);
		if(mysql_num_rows($res)>0)
		{
		$count=1;$totfac=0;?>
		<div class="content-container">
			<div class="entry-head"><h4><strong>Facility Details</strong></h4></div>
			<div class="entry-content">
			  <p></p>
			  <div class="innerBody">
					<p></p>
					<table width="100%" class="table table-bordered">
						<tr>
							<th width="2%" height="24" style="background:#006633;color:#FFFFFF">#</th>
							<th width="7%" style="background:#006633;color:#FFFFFF">Room No.</th>
							<th width="12%" align="left" style="background:#006633;color:#FFFFFF">Room Type</th>
							<th width="26%" align="left" style="background:#006633;color:#FFFFFF">Facility Taken</th>
							<th width="8%" style="background:#006633;color:#FFFFFF">In date</th>
							<th width="8%" style="background:#006633;color:#FFFFFF">In time</th>
							<th width="8%" style="background:#006633;color:#FFFFFF">Out date</th>
							<th width="8%" style="background:#006633;color:#FFFFFF">Out time</th>
							<th width="7%" align="center" style="background:#006633;color:#FFFFFF">Rate</th>
							<th width="7%" style="background:#006633;color:#FFFFFF">Duration</th>
							<th width="7%" style="background:#006633;color:#FFFFFF">Amount</th>
						</tr>
					<?php while($data=mysql_fetch_array($res))
					{if($data["checkout_status"]==1){$bgcolor="";$out=1;}else{$bgcolor="#FF0000";$out=0;}
					?>	
						<tr>
						  <td align="center" bgcolor="<?=$bgcolor?>"><strong><?=$count?></strong></td>
						  <td align="center" bgcolor="<?=$bgcolor?>"><?=$data["room_no"]?></td>
						  <td align="left" bgcolor="<?=$bgcolor?>"><?=$data["room_type"]?></td>
						  <td align="left" bgcolor="<?=$bgcolor?>"><?=$data["fac_name"]?></td>
						  <td align="center" bgcolor="<?=$bgcolor?>"><?=$objCoreFO->IntToDate($data["checkin_date"]);?></td>
						  <td align="center" bgcolor="<?=$bgcolor?>"><?=IntToTimeAMPM($data["checkin_date"])?></td>
						  <td align="center" bgcolor="<?=$bgcolor?>">
						  <?=$chkoutDate=$objCoreFO->IntToDate($data["checkout_date"]);?>
						  </td>
						  <td align="center" bgcolor="<?=$bgcolor?>"><?=IntToTimeAMPM($data["checkout_date"]);?></td>
						  <td align="center" bgcolor="<?=$bgcolor?>"><?php echo number_format($data["rate"],2);?></td>
						  <td align="center" bgcolor="<?=$bgcolor?>">
						  <?php 
						  /*$indate=strtotime($objCoreFO->IntToDate($data["checkin_date"]));
						  $outDate=strtotime($chkoutDate);
						  $days=($outDate-$indate)/(60*60*24);
						  if($days>0){echo $days;}else{echo 1;}*/
						  
						  
						$inTime=$data["checkin_date"];//in date time
						$outTime=$data["checkout_date"];//out date time
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
						$days=calcDaysOnCheckOut($inTime,$outTime,$graceHourF,$graceMinuteF);
						
						$diff=dateTimeDiff($inTime,$outTime);
							$day=$diff[1];
							$hr=$diff[2];
							$min=$diff[3];
							
							echo $day." D ".$hr." hr. ".$min." min.";
						}
						  
						  ?>
						  </td>
						  <td align="right" bgcolor="<?=$bgcolor?>">
						  <?php 
						  if($days>0)
						  {
						  echo number_format(($data["rate"]*$days),2);
						  $totfac+=$data["rate"]*$days;
						  }
						  else
						  {
						  echo number_format($data["rate"],2);
						  $totfac+=$data["rate"];
						  }?>
						  </td>
					  </tr>
					  <?php $count++;}?>
					  <tr>
					  <td colspan="10" align="right"><strong>Total</strong></td>
					  <td align="right"><strong><?=number_format($totfac,2);?></strong></td>
					  </tr>
                      
                      <!-------Taxation------->
					  <?php $taxres=mysql_query("select * from tbl_room_tax_tran where md5(cust_mas_id)='".$_SESSION["custid"]."' and sysdept='3'");
                      if(mysql_num_rows($taxres)>0)
                      {$tax=0;
                      while($taxdata=mysql_fetch_array($taxres)){?>
                      <tr>
                        <td colspan="10" align="right"><em><?=$taxdata["tax_name"];?></em></td>
                        <td align="right"><?php echo number_format($totfac*$taxdata["percentage"]/100,2);$tax+=$totfac*$taxdata["percentage"]/100;?></td>
                      </tr>
                      <?php }
                      }?>
                      <!-------End Taxation--->
                      <tr>
                      	<td colspan="10" align="right"><strong>Net Pay (including Tax)</strong></td>
                        <td align="right">
                        <strong>
						<?php $totfac+=$tax;
						$totfac=round($totfac);
						echo  number_format($totfac,2);?>
                        </strong></td>
                      </tr>
					</table>
					<p></p>
			  </div>
			  <p></p>
			</div>
		</div>
	
	<?php }?>
	<!--------------End----------------->
	
	<p></p>
	<!-------Customer payment details-------->
	<div class="content-container">
	<div class="entry-head">
	<h4>
		<strong>Payments Details</strong>
        <?php $_SESSION["taxdataset"]=$taxDataSet;?>
	</h4>
	</div>
	<div class="entry-content">
	<?php 
	if(isset($_SESSION["pmtmsg"])){echo $_SESSION["pmtmsg"];unset($_SESSION["pmtmsg"]);}
	$where=" md5(customer_mas_id)='".$_SESSION['custid']."' and chkout_status=1";
	$row=$objCoreFO->getNumRows('tbl_cust_dtls',$where);
	if($discharged>0){
	?>
	<!-------Customer payment new------->
		<div class="innerBody" style="padding:10px">
			<p></p>
			<table width="100%">
				<tr height="40">
					<td width="11%">Transaction Type</td>
					<td width="1%"><strong>:</strong></td>
					<td width="67%">
					<select name="trn_type" id="trn_type">
					<option value="">Please Select</option>
					<option>PAYMENT</option>
					<option>RECEIPT</option>
				    </select>				  
                    </td>
					<td width="8%">&nbsp;</td>
					<td width="8%">&nbsp;</td>
					<td width="7%">&nbsp;</td>
				</tr>
                <tr height="40">
					<td width="9%">Pay Mode</td>
					<td width="1%"><strong>:</strong></td>
					<td width="67%">
					<select name="pay_mode" id="pay_mode">
					<option value="">Please Select</option>
					<option>Cash</option>
					<option>Card / Cheque / Draft</option>
				  </select>				  </td>
					<td width="8%">&nbsp;</td>
					<td width="8%">&nbsp;</td>
					<td width="7%">&nbsp;</td>
				</tr>
				<tr id="cardno" style="display:none" height="40">
				  <td>Card / Cheque / Draft No </td>
				  <td><strong>:</strong></td>
				  <td><input type="text" name="card_no" id="card_no"/></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
			  </tr>
				<tr height="40">
				  <td>Pay Amount</td>
				  <td><strong>:</strong></td>
				  <td><input type="text" name="recv_amt" class="required number" /></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
			  </tr>
			<tr height="40">
				  <td>Narration / Remarks</td>
				  <td><strong>:</strong></td>
				  <td colspan="3">
				  <input type="text" name="naration" id="naration" style="width:98%" placeholder="Please mention the term regarding amount receive (optional)"/></td>
				  <td align="right"><input type="submit" name="Save" id="Save" value="Pay Now" class="btn btn-primary"/></td>
			  </tr>
			</table>	
			<p></p>
		</div>
	<!--------------End----------------->
	<?php }?>	
	<!-------Customer payment Details------->	
        <div class="innerBody">
			<p></p>
			<table width="100%" class="table table-bordered">
				<tr>
					<th width="4%" style="background:#009966;color:#FFFFFF">#</th>
					<th width="9%" style="background:#009966;color:#FFFFFF">Date</th>
					<th width="14%" align="center" style="background:#009966;color:#FFFFFF"> Voucher No.</th>
					<th width="45%" align="center" style="background:#009966;color:#FFFFFF">Narration / Remarks</th>
                    <th width="9%" style="background:#009966;color:#FFFFFF">Trns. Type</th>
                    <th width="7%" style="background:#009966;color:#FFFFFF">Pay Mode</th>
					<th width="6%" style="background:#009966;color:#FFFFFF">CR.</th>
		            <th width="6%" style="background:#009966;color:#FFFFFF">DR.</th>
		            <th width="5%" style="background:#009966;color:#FFFFFF">Receipt</th>
	            </tr>
				
				<?php 
				$sql="select * from tbl_account where sysdept='3' and md5(trns_id)='".$_SESSION["custid"]."' order by id asc";
				$res=mysql_query($sql);
				if(mysql_num_rows($res)>0)
				{$count=1;$dr=0;
					while($data=mysql_fetch_array($res))
					{
				?>
				<tr>
					<td align="center"><?=$count;?></td>
					<td align="center"><?=$objCoreFO->IntToDate($data["trans_date"]);?></td>
					<td><?=$data["voucherno"];?></td>
					<td><?=$data["narration"];?></td>
                    <td align="center"><?=$data["trn_type"];?></td>
					<td align="center"><?=$data["pay_mode"];?></td>
                    <td align="right"><?php echo number_format($data["amtcr"],2);$cr+=$data["amtcr"]?></td>
				    <td align="right"><?php echo number_format($data["amtdr"],2);$dr+=$data["amtdr"]?></td>
				    <td align="center">
					<a onClick="PopupCenter('receipt.php?cid=<?=md5($data["id"])?>', 'Receipt','800','500')" style="cursor:pointer" class="btn btn-warning">Get</a>					</td>
			    </tr>
		  <?php $count++;}
		  ?>	
          		<tr>
		  		  <td colspan="7" align="right"><strong>Balance ( DR - CR )</strong></td>
		  		  <td align="right"><strong>
		  		    <?=number_format(($dr-$cr),2)?>
		  		  </strong></td>
	  		      <td align="right">&nbsp;</td>
  		      </tr>
		  		<tr>
		  		  <td colspan="6" align="right">
		  		    <div align="left" style="float:left">
		  		      <div align="right">
		  		        
		  		        <input type="hidden" name="roomDues" id="roomDues" value="<?=$totRoom;?>" />
	  		          </div>
	  		        </div>
	  		      <div align="right"><em>Room Dues</em> </div></td>
		  		  <td align="left"><div align="right">
		  		    <?=number_format($totRoom,2);?>
	  		      </div></td>
		  		  <td align="center"></td>
	  		      <td align="right">&nbsp;</td>
  		      </tr>
		  		<tr>
		  		  <td colspan="6" align="right">
		  		    <div align="left" style="float:left"><input type="hidden" name="facDues" id="facDues" value="<?=$totfac;?>" /></div>				  
		  		    <div align="right"><em>Room Facilities taken</em> </em></div>
                  </td>
		  		  <td align="left"><div align="right"><?=number_format($totfac,2);?></div></td>
		  		  <td align="center"></td>
	  		      <td align="right">&nbsp;</td>
  		        </tr>
              <?php 
			  $ftotrs=0;$totalst=0;$totalvat=0;
			  $str="SELECT * FROM `tbl_order_master` where `rpt_id`='".$data1['id']."' and order_from='R' and suspended_status=0 and status=1";
			  $query=mysql_query($str);
			  if(mysql_num_rows($query)>0){
				 while($row=mysql_fetch_array($query)){
					 $str2="SELECT * FROM `view_order_details` where order_mastid='".$row['id']."' and suspended_status=0 ";
					 $query2=mysql_query($str2);
					 while($row2=mysql_fetch_array($query2)){
				  		 $ftotrs+=($row2['rate']*$row2['qty']);
						if($row2['s_tax'])
						{
							$totalst+=($row2['rate']*$row2['qty']);
							
						}
						if($row2['vat_tax'])
						{
							$totalvat+=($row2['rate']*$row2['qty']);
							
						}
				  }
				  
				  }}// Tax calculation
				  $str="SELECT * FROM `tbl_tax_mstr`";
				  $query=mysql_query($str);
				  while($row2=mysql_fetch_array($query)){
					  $tax[]=array('tax'=>$row2['tax_percentage']);
					  $tax_name[]=array('tax_name'=>$row2['tax_name']);
	  				  $tax_id[]=array('tax_id'=>$row2['id']);
					 			  
					}
						 $taxRS=array();
					 	 $taxRS[0][0]=$tax_id[0]['tax_id'];
						 $taxRS[0][1]=$tax_name[0]['tax_name'];
						 $taxRS[0][2]=$tax[0]['tax'];
						 $taxRS[0][3]=($tax[0]['tax']*$totalvat)/100;
						 $taxRS[1][0]=$tax_id[1]['tax_id'];
						 $taxRS[1][1]=$tax_name[1]['tax_name'];
						 $taxRS[1][2]=$tax[1]['tax'];
						 $taxRS[1][3]=($tax[1]['tax']*$totalst)/100;
						 $_SESSION['taxRS']=$taxRS;
						 /*$vat=($vat_per*$totalvat)/100;
						 $vat_id=$tax_id[0]['tax_id'];
						 $vat_tax_name=$tax_name[0]['tax_name'];
						 $vat_per=$tax[0]['tax'];
						 $s_id=$tax_id[1]['tax_id'];
						 $s_tax_name=$tax_name[1]['tax_name'];
						 $s_per=$tax[1]['tax'];
						 $st=($s_per*$totalst)/100;
						 $vat=($vat_per*$totalvat)/100;*/
						 
						 $totrs=round($ftotrs+ $taxRS[1][3]+$taxRS[0][3]);
				 
				 
				  ?>
              <tr>
		  		  <td colspan="6" align="right">
		  		    <div align="left" style="float:left"><input type="hidden" name="rmServc" id="rmServc" value="<?=$totrs;?>" /></div>				  
		  		    <div align="right"><em>Room Service taken</em> </div>
                  </td>
		  		  <td align="left"><div align="right"><?php echo number_format($totrs,2);  ?></div></td>
		  		  <td align="center"></td>
	  		      <td align="right">&nbsp;</td>
  		      </tr>
		  		<?php 
				$refund=($dr-$cr)-($totRoom+$totfac+$totrs);
				if($refund>0){
				?>
		  		<tr>
		  		  <td colspan="6" align="right" style="color:#FF0000">
	  		      <input type="hidden" name="refund" id="refund" value="<?=$refund?>"/>		  		    
                  <div align="right"><em>Access Cash refund</em></div></td>
		  		  <td align="right" >(<?php echo number_format($refund,2)?>)</td>
		  		  <td align="center"></td>
		  		  <td align="right">&nbsp;</td>
	  		    </tr>
				<?php }else{$refund=0;}?>
		  		<tr>
		  		  <td colspan="6" align="right" style="color:#FF0000">
				  <div style="float:left">
				  <input type="hidden" name="closingBal" id="closingBal" value="<?=$totRoom+$totfac+$totrs?>"/>
				  <input type="hidden" name="drBal" id="drBal" value="<?=$dr-$cr?>"/>
				  </div>
				  <strong> Closing Balance </strong></td>
		  		  <td align="right">
				  
				  <strong><?php $dues=$totRoom+$totfac+$totrs;echo number_format($dues+$refund,2);?></strong>				  </td>
	  		      <td align="right"><span style="color:#FF0000"><strong>
                    <?php //number_format($dr-$refund,2);?>
                    <?=number_format(($dr-$cr),2)?>
                  </strong></span></td>
	  		      <td align="right">&nbsp;</td>
  		      </tr>
		  		<?php if($refund>=0){?>
				<tr>
		  		  <td colspan="6" align="right" style="color:#FF0000">&nbsp;</td>
		  		  <td align="right" style="color:#FF0000"><strong>Bal.</strong></td>
	  		      <td align="right" style="color:#FF0000"><?=number_format($dues-($dr-$cr),2);?>
                      <input type="hidden" name="amtrecv" id="amtrecv" value="<?=$dr-$cr;?>" />
                      <input type="hidden" name="balance" id="balance" value="<?=($dr-$cr)-$dues;?>" />                  </td>
	  		      <td align="right" style="color:#FF0000">&nbsp;</td>
  		        </tr>
				<?php }}?>
			</table>
           
			<p></p>
		</div>
	<!-------Customer payment Details End------->	
	</div>
	</div>
	<!--------------End---------------------->
	<p></p>
    
</form>
<?php include "footer.php"?>
</div>
</div>