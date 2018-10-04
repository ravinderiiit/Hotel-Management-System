<?php 
@session_start();
@ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
include "localinclude.php";
include "function.ini.php";
if(!isset($_GET["uid"])){header("location:Customer_list.php?page=1&cmd=Clear");}
$uid=$_GET["uid"];
$where="md5(id)='$uid'";
$data1=$objCoreFO->getRows("tbl_customer_master",$where);
$totalA=0;$totalB=0;$totalVAT=0;$totalRS=0;$totalST=0;$totalDis=0;
?>
<style>
.innerBody{margin-left:20px;margin-right:20px;padding-top:5px;padding-left:5px;padding-right:5px;margin-bottom:10px;padding-bottom:-30px;border:#000000 1px solid;height:auto;}
.innerBody1{margin-left:5px;margin-right:5px;padding-top:5px;padding-left:10px;padding-right:10px;margin-bottom:10px;padding-bottom:25px;border:#000000 2px solid;height:auto;}
table tr,td,th{font-size:10px}
.retailInvoice{
font-weight:bold;text-align:center;margin-top:-25px;border:1px solid black;background-color:black;color:white;border-radius:8px;
margin-left:40%;margin-right:40%
}
</style>
<script>
$(document).ready(function(){
$("#Print").click(function(){
$(this).hide();
$("#home").hide();
window.print();
$(this).show();
$("#home").show();
});
});
</script>
<div id="printableArea">
	<p></p>
			<div class="innerBody1">
		<!----------Header Details ----------->	
				
					<p></p>
					<table width="100%" align="center">
						<tr>
						  <td colspan="2" nowrap="nowrap" >
                          <p class="retailInvoice">RETAIL INVOICE</p>
                          <span style="float:left"><img src="../common/images/hga_logo.png" align="absmiddle" width="70"></span>
						  
                          <div  style="margin-right:6%;text-align:center"><strong>
                          <span style="font-size:large">
                          &nbsp;&nbsp;M/S HOTEL GANGA ASHRAM</span></strong> 
						  <br />   
						  <p><strong>( A Unit of Ganga Ashram Private Limited )</strong></p>
                          <p>H.No. : 18/16, Kutchery Road, Ranchi - 834001, Jharkhand,India</p>
						  <p>Tele: +(91)-651-2215602, 2215514, 6570349</p>
						  </div>
						  </td>
						</tr>
                        <tr height="10">
						  <td colspan="2" nowrap="nowrap">
                          <div style="border-top:2px dotted grey;line-height:3">
                              
                                  <div style="float:left;"><strong>Registration No. : RN (W) 44 (LT)</strong></div>
                                  <div style="float:right;"><strong>Bill Date : <?php echo date('d-m-Y')?></strong></div>
                              
                          </div>
                          </td>
                          <tr>
                          	<td colspan="2" nowrap="nowrap">
                          
                          </td>
                          </tr>
						</tr>
                         <tr height="10">
						  <td colspan="2" nowrap="nowrap">
                          <div style="border-top:2px dotted grey;line-height:3">
                              
                                  <div style="float:left;"><strong>Service Tax (RG.). : AABCG5824A5D001</strong></div>
                                 
                              
                          </div>
                          </td>
                          <tr>
                          	<td colspan="2" nowrap="nowrap">
                          
                          </td>
                          </tr>
						</tr>
                        </tr>
                         <tr height="10">
						  <td colspan="2" nowrap="nowrap">
                          <div style="border-top:2px dotted grey;line-height:3">
                              
                                  <div style="float:left;"><strong>Name. : <?=$data1["name"];?></strong></div>
                                  <div style="float:right;"><strong>Address : <?=$data1["address"];?></strong></div>
                                 
                              
                          </div>
                          </td>
                          <tr>
                          	<td colspan="2" nowrap="nowrap">
                          <div style="border-top:2px dotted grey;">      
                          </div>
                          </td>
                          </tr>
						</tr>
                        
					</table>	
				
		<!--------------End----------------->		
		<p></p>
		<!----------Room Details ----------->		
				
					<p></p>
					<?php if(isset($_SESSION["message"])){echo $_SESSION["message"];unset($_SESSION["message"]);}?>
					<table width="100%" class="table table-condensed">
					  <tr>
						<th width="2%" height="15" style="background:#006633;color:#FFFFFF">#</th>
						<th width="15%" height="15" style="background:#006633;color:#FFFFFF">Custromer(s)</th>
						<th width="10%" style="background:#006633;color:#FFFFFF">Room No.</th>
						<th width="20%" align="left" style="background:#006633;color:#FFFFFF">Room Type</th>
						<th width="8%" style="background:#006633;color:#FFFFFF">In Date</th>
						<th width="7%" style="background:#006633;color:#FFFFFF">In Time</th>
						<th width="9%" style="background:#006633;color:#FFFFFF">Out Date</th>
						<th width="9%" style="background:#006633;color:#FFFFFF">Out Time</th> 
						<th width="7%" style="background:#006633;color:#FFFFFF">Rate</th>
						<th width="7%" align="center" style="background:#006633;color:#FFFFFF">Duration</th>
						<th width="12%" style="background:#006633;color:#FFFFFF">Amount</th>
					  </tr>
					 <?php 
					  $sql="select * from view_cus_mstr_dtl_wise where md5(id)='$uid' order by id asc";
					  $res2=mysql_query($sql);
					  $count=1;$tot=0;$netRoom=0;$tm=0;
					  while($data2=mysql_fetch_array($res2))
					  {
					  $where="id='".$data2["room_dtl_id"]."'";
					  $data3=$objCoreFO->getRows("view_room_type_floor_dtl_wise",$where);
					  $guestData=mysql_fetch_array(mysql_query("SELECT GROUP_CONCAT( guest_name SEPARATOR  ' / ' ) AS  'name' FROM  tbl_cust_guest_dtls WHERE cust_dtls_id='".$data2["cust_dtl_id"]."'"));
					  ?>
                      	 <tr>
                                <td align="center"><strong><?=$count;?></strong></td>
                                <td align="left"><?=$guestData["name"]?></td>
                                <td align="center"><?=$data3["room_no"]?></td>
                                <td align="left">
								<?=$data3["room_type"]?>
                                <input type="hidden" name="grpid_<?=$count?>" value="<?=$data2["group_mstr_id"]."@".$data2["group_name"];?>" 
                                style="width:95%">
                                </td>
                                <td align="center"><?=$inDate=$objCoreFO->IntToDate($data2["check_in_dt"]);?></td>
                                <td align="center"><?=date('h:i A',$data2["check_in_dt"])?></td>
                                <td align="center"><?=$outDate=$objCoreFO->IntToDate($data2["check_out_dt"]);?></td>
                                <td align="center"><?=$objCoreFO->IntToTimeAMPM($data2["check_out_dt"]);?></td>
                                <td align="center">
                                <?php  
                                /*$days=((strtotime($outDate)-strtotime($inDate))/(60*60)/24). "  Days";
                                if($days==0){$days=1;}*/
								
								$inTime=$data2["check_in_dt"];//in date time
								$outTime=$data2["check_out_dt"];//out date time
								$days=calcDaysOnCheckOut($inTime,$outTime,$graceHour,$graceMinute);
								
								$diff=dateTimeDiff($inTime,$outTime);
									$day=$diff[1];
									$hr=$diff[2];
									$min=$diff[3];
									
									
								
								
                                echo $rate=$data3["rate"];
                                $amount=($data3["rate"]*$days);
                                $total+=$amount;
                                ?>
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
                                <td align="center"><?=$day." D ".$hr." hr. ".$min." min.";?></td>
                                <td align="right"><?=number_format($amount,2);?></td>
					  </tr>
						<?php 
                      $count++;
                      }?>
					  <!-------Total---------->
					  <tr>
						<td colspan="10" align="right"><strong>Total</strong></td>
						<td align="right"><strong><?php $totalA=$total;echo number_format($total,2)?></strong></td>
					  </tr>
					  <!-------Total End------>
					  
					  <!-------Discount------->
                      <?php if($data1["discount"]!=0){?>
					  <tr>
						<td colspan="10" align="right"><em>Discount</em></td>
						<td align="right"><?php $tm=($total*$data1["discount"]/100);echo $data1["discount"];?>%</td>
					  </tr>
                      <?php }?>
					  <!-------Discount End--->
					 
					   <!-------Taxation------->
					  <?php 
						  $len= sizeof($taxDataSet);
						  $taxcount=1;$totalVAT=0;
						  for($i=0;$i<$len;$i++){
							  if($taxDataSet[$i][2]!=0){?>
						<tr>
							<td colspan="10" align="right">
							<span style="float:left">
							<input type="hidden" name="taxid_<?=$taxcount;?>" id="taxnm_<?=$count;?>" value="<?=$taxDataSet[$i][0];?>">
							<input type="hidden" name="taxprntg_<?=$taxcount;?>" id="taxprntg_<?=$count;?>" value="<?=$taxDataSet[$i][2];?>">
							</span>
							<em><?=$taxDataSet[$i][1]?></em>
							</td>
							<td align="right"><?php $totalVAT+=$taxDataSet[$i][2]; echo number_format($taxDataSet[$i][2],2);?></td>
							
						</tr>
						<?php }$taxcount++;}
					  ?>
                      <!-------End Taxation--->
					 
					 <!-------Net Pay------->
			  <tr>
			    <td colspan="10" align="right">
				<strong>Net Pay (including Tax)</strong>
				</td>
			    <td align="right">
				<strong><?php 
				$totRoom=$totalVAT+($total-$tm);
				$totRoom=round($totRoom);
				echo number_format($totRoom,2);?></strong>
				</td>
			  </tr>
			  <tr>
			    <td colspan="10" align="right">&nbsp;</td>
			    <td align="right">&nbsp;</td>
			    </tr>
			  <!-------End Net Pay--->
					</table>	
					<p></p>
                    
				
		<!--------------End----------------->
		
				
		<!-------Customer facility Details ----------->
		<?php 
				$sql="select * from view_cust_facility_full_dtl where cust_dtls_id in (select id from tbl_cust_dtls where md5(customer_mas_id)='$uid')";
				$res=mysql_query($sql);
				$totfac=0;
				if(mysql_num_rows($res)>0)
				{
				$count=1;?>
				<p></p>
				
					<p></p>
					<table width="100%" class="table table-condensed">
						<tr>
							<th width="2%" height="24" style="background:#006633;color:#FFFFFF">#</th>
							<th width="9%" style="background:#006633;color:#FFFFFF">Room No.</th>
							<th width="15%" align="left" style="background:#006633;color:#FFFFFF">Room Type</th>
							<th width="26%" align="left" style="background:#006633;color:#FFFFFF">Facility Taken</th>
							<th width="8%" style="background:#006633;color:#FFFFFF">In date</th>
							<th width="8%" style="background:#006633;color:#FFFFFF">In time</th>
							<th width="8%" style="background:#006633;color:#FFFFFF">Out date</th>
							<th width="8%" style="background:#006633;color:#FFFFFF">Out time</th>
							<th width="7%" align="center" style="background:#006633;color:#FFFFFF">Rate</th>
							<th width="7%" style="background:#006633;color:#FFFFFF"> Duration</th>
							<th width="5%" style="background:#006633;color:#FFFFFF">Amount</th>
						</tr>
					<?php while($data=mysql_fetch_array($res))
					{
					?>	
						<tr>
						  <td align="center" ><strong><?=$count?></strong></td>
						  <td align="center" ><?=$data["room_no"]?></td>
						  <td align="left" ><?=$data["room_type"]?></td>
						  <td align="left" ><?=$data["fac_name"]?></td>
						  <td align="center" ><?=$objCoreFO->IntToDate($data["checkin_date"]);?></td>
						  <td align="center" ><?=$objCoreFO->IntToTimeAMPM($data["checkin_date"])?></td>
						  <td align="center" >
						  <?=$chkoutDate=$objCoreFO->IntToDate($data["checkout_date"]);?>
						  </td>
						  <td align="center" ><?=$objCoreFO->IntToTimeAMPM($data["checkout_date"]);?></td>
						  <td align="center" ><?php echo number_format($data["rate"],2);?></td>
						  <td align="center" >
						  <?php 
						  $indate=strtotime($objCoreFO->IntToDate($data["checkin_date"]));
						  $outDate=strtotime($chkoutDate);
						  $days=($outDate-$indate)/(60*60*24);
						  if($days>0){echo $days;}else{echo 1;}
						  
						  
						$inTime=$data["checkin_date"];//in date time
						$outTime=$data["checkout_date"];//out date time
						$days=calcDaysOnCheckOut($inTime,$outTime,$graceHourF,$graceMinuteF);
						
						$diff=dateTimeDiff($inTime,$outTime);
							$day=$diff[1];
							$hr=$diff[2];
							$min=$diff[3];
							
							echo $day." D ".$hr." hr. ".$min." min.";
						  
						  ?>
						  </td>
						  <td align="right" >
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
					  <td align="right"><?php $totalB=$totfac; echo number_format($totfac,2);?></td>
					  </tr>
                       <!-------Taxation------->
					  <?php $taxres=mysql_query("select * from tbl_room_tax_tran where md5(cust_mas_id)='$uid'");
                      if(mysql_num_rows($taxres)>0)
                      {/*$tax=0;
                      while($taxdata=mysql_fetch_array($taxres)){?>
                      <!--<tr>
                        <td colspan="10" align="right"><em><?=$taxdata["tax_name"];?></em></td>
                        <td align="right"><?php echo number_format($totfac*$taxdata["percentage"]/100,2);$tax+=$totfac*$taxdata["percentage"]/100;?></td>
                      </tr>-->
                      <?php }
					  $totalVAT+=$tax;
                      */}?>
                      <!-------End Taxation--->
                       <tr>
                      	<td colspan="10" align="right"><strong>Net Pay (including Tax)</strong></td>
                        <td align="right">
						<strong><?php 
						$totfac+=$tax;
						$totfac=round($totfac);
						echo number_format($totfac,2);?></strong>
                        </td>
                      </tr>
					</table>
					<p></p>
			
				<p></p>	
		<?php }?>	
		<!--------------End----------------->
        <p style="border-top:2px dotted grey"></p>
        <p align="center"><strong>BILL SUMMARY</strong></p>
        <p style="border-bottom:2px dotted grey"></p>
        <table width="100%" class="table table-condensed">
            <tr>
                <th width="5%" style="background:#006633;color:#FFFFFF">#</th>
                <th width="90%" align="left" style="background:#006633;color:#FFFFFF">Particulars</th>
                <th width="5%" style="background:#006633;color:#FFFFFF">Amount</th>
            </tr>
            <?php $sumryCount=1;?>
            <tr>
            	<td align="center"><?=$sumryCount++?></td>
                <td>TOTAL ROOM TARIFF</td>
                <td align="right"><?=number_format($totalA,2);?></td>
            </tr>
            <tr>
            	<td align="center"><?=$sumryCount++?></td>
                <td>TOTAL ROOM FACILITY</td>
                <td align="right"><?=number_format($totalB,2);?></td>
            </tr>
            <tr>
            	<td align="center"><?=$sumryCount++?></td>
                <td>TOTAL ROOM SERVICE</td>
                <td align="right"><?=number_format($totalRS,2);?></td>
            </tr>
            <tr>
            	<td align="center"><?=$sumryCount++?></td>
                <td>TOTAL TAX</td>
                <td align="right"><?=number_format($totalVAT,2);?></td>
            </tr>
           <?php if($data1["discount"]!=0){?>
            <tr>
            	<td align="center"><?=$sumryCount++?></td>
                <td>TOTAL DISCOUNT</td>
                <td align="right"><?=number_format($tm,2);?></td>
            </tr>
            <?php }?>
            <tr>
            	<td colspan="2" align="right"><strong>GRAND TOTAL</strong></td>
                <td align="right">
                <span style="border-bottom:2px thick black;font-weight:bold;text-decoration:double">
				<?php 
				$grandTotal=($totalA+$totalB+$totalVAT+$totalRS+$totalST)-$tm;
				$grandTotal=round($grandTotal);
				echo number_format($grandTotal,2)?>
                </span></td>
            </tr>
            <tr>
            	<td colspan="3" align="right"></td>
                
            </tr>
        </table>
        <p style="border-top:2px dotted grey"></p>
        
        
			<p><strong>Rupees (in words):</strong> 
                <span style="font-size:12px">
                <?php 
                $net=$totfac+$totRoom;
                echo strtoupper(int_to_words($net)." only.");?>
                </span>
            </p>
            <p style="border-bottom:2px dotted grey"></p>
			<br /><br />
            <div style="border:1px solid grey;padding:10;height:105px">
            			<div style="float:left;margin-left:30px">
                        <ul>
                            <li> Check out time is 24 hours</li>
                            <li> Dispute are subject to Ranchi Juridiction</li>
                        </ul>
                        <br><br><br>
                        <p><strong>Customer Signature</strong></p>
                        </div>
                        
                        <div style="float:right;">
                        <p style="font-size:16px;"><strong>For HOTEL GANGA ASHRAM</strong></p>
                        <br />
                        <br /><br /><p></p>
						<p><span style="margin-left:90px;"><strong>Authorised Signatory</strong></span></p>
                        </div>
            </div>
		</div>
	<p align="center"><input type="button" name="Print" id="Print" value="Print" class="btn btn-inverse">
    <a id="home" href="Customer_list.php?cmd=Clear" class="btn btn-success" style="text-decoration:none">Home</a></p>
</div>