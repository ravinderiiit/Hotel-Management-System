<?php
@session_start();
@ob_start();
include "AdvBooking_view.php";
$objCoreFO->Advcustomer_Account();
?>
<script>
$(document).ready(function(){
	$("#pay_mode").change(function(){
		var selected=$(this).prop('selectedIndex');
		if(selected!="")
		{
			if(selected==1){$("#cardno").hide();};
			if(selected==2){$("#cardno").show();};
		}
		else
		{
		$("#cardno").hide();
		}
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
		<strong> Customer Account</strong>
	</h4>
</div>
<div class="entry-content">
<form method="post" enctype="multipart/form-data" id="FORMNAME1">
<?php if(isset($_SESSION["pmtmsg"])){echo $_SESSION["pmtmsg"];unset($_SESSION["pmtmsg"]);}?>
	
	<?php 	$discharged=1;
			$where=" md5(customer_mas_id)='".$_SESSION["custid"]."' and chkout_status=1";
			$row=$objCoreFO->getNumRows("tbl_cust_dtls",$where);
			if($row<1){$discharged=0;}
	?>
	
	<!-------Customer payment new ----------->
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
	
	
	<!-------Customer payment details ----------->
		<div class="innerBody">
			<p></p>
			<table width="100%" class="table table-bordered">
				<tr>
					<th width="3%" style="background:#009966;color:#FFFFFF">#</th>
					<th width="10%" style="background:#009966;color:#FFFFFF">Date</th>
					<th width="13%" align="left" style="background:#009966;color:#FFFFFF"> Voucher No.</th>
					<th width="45%" align="left" style="background:#009966;color:#FFFFFF">Narration</th>
					<th width="9%" style="background:#009966;color:#FFFFFF">Trns. Type</th>
                    <th width="7%" style="background:#009966;color:#FFFFFF">Pay Mode</th>
					<th width="7%" style="background:#009966;color:#FFFFFF">Cr.</th>
					<th width="7%" style="background:#009966;color:#FFFFFF">Dr.</th>
					<th width="5%" style="background:#009966;color:#FFFFFF">Receipt</th>
			    </tr>
				<?php 
				$sql="select * from tbl_adv_account where sysdept='3' and md5(trns_id)='".$_SESSION["custid"]."'";
				$res=mysql_query($sql);
				if(mysql_num_rows($res)>0)
				{$count=1;$cr=0;$dr=0;
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
					<td align="center"><div align="right"><?php echo $data["amtcr"];$cr+=$data["amtcr"]?></div></td>
					<td align="center"><div align="right"><?php echo $data["amtdr"];$dr+=$data["amtdr"]?></div></td>
					<td align="center">
					<a onClick="PopupCenter('Advreceipt.php?cid=<?=md5($data["id"])?>', 'Receipt','800','500')" style="cursor:pointer" class="btn btn-warning">Get</a>	</td>
				</tr>
		  <?php $count++;}
		  ?>
		  		<tr>
					<td align="right" colspan="6"><strong>Total</strong></td>
					<td align="right"><div align="right"><strong><?=number_format($cr,2)?></strong></div></td>
					<td align="center"><div align="right"><strong><?=number_format($dr,2)?></strong></div></td>
					<td align="center">&nbsp;</td>
				</tr>
		  		<tr>
		  		  <td align="right" colspan="8"><span style="color:red"><strong>Balance :</strong></span></td>
		  		  <td align="right"><span style="color:red"><strong><?=number_format(($dr-$cr),2);?></strong></span></td>
	  		  </tr>
				<?php }?>
			</table>	
			<p></p>
		</div>
	<!--------------End----------------->
	
</form>	
<?php include "footer.php"?>
</div>
</div>