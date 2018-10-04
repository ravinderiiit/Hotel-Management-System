<?php 
include "../common/inc/config.inc.php";
include "function.ini.php";
$res=mysql_query("select * from tbl_adv_account where md5(id)='".$_GET["cid"]."'");
if(mysql_num_rows($res)>0)
{
$data=mysql_fetch_array($res);
$custData=mysql_fetch_array(mysql_query("select * from  tbl_adv_booking_mstr  where id='".$data["trns_id"]."'"));
 
 $cust_name=$custData["name"];
 $voucher_no=$data["voucherno"];
 $pay_mode=$data["pay_mode"];
 $trans_date=date('d-m-Y',$data["trans_date"]);
 $amtdr=ceil($data["amtdr"]);
 $amtcr=ceil($data["amtcr"]);
 $narration=$data["narration"];
 
 $amt=0;
 if($amtdr>0){$amt=$amtdr;}else if($amtcr>0){$amt=$amtcr;}
}
?>
<style type="text/css">
.header{width:500px; height:109px;
background:url(../LIBRARY/images/header.png) no-repeat;
margin:auto;
}
.page_back{ width:500px; height:auto; margin:auto}

.bill_no{width:130px; height:15px;

margin:auto;
margin-top:50px;
float:right;color:#16335F;
font-family: Arial, Helvetica, sans-serif;
font-size:12px;
font-weight:bold;
}


.date{width:130px; height:15px;
margin-top:70px;
float:right;
margin-right:-131px;
color:#16335F;
font-family: Arial;
font-size:12px;
font-weight:bold;}

.details{width:500px; height:200px;
margin:auto;}



body {
	background-color: #fff;
}
.style5 {font-family: Monotype Corsiva; color: #16335F; font-size: 24px; }

.style7 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 15px;
	color: #16335F;
	font-weight: bold;
}
.style8 {
	font-size: 24px;
	font-weight: bold;
	color: #FFFFFF;
}
</style>

<script type="text/javascript">
 
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}


	</script>

<div id="printableArea">
<table width="95%" align="center" border="0" style="margin:20px auto">
    <tr>
      <td colspan="2" nowrap="nowrap"><div align="center"><strong><img src="../common/images/hga_logo.png" align="absmiddle" width="40"> &nbsp;&nbsp;HOTEL GANGA ASHRAM</strong> 
          <br />    
    Kutchery Road, Ranchi - 834001, Jharkhand,India Phone: +(91)-651-2215514 , 2215602 , 6570349</div></td>
    </tr>
    <tr>
      <td colspan="2" nowrap="nowrap">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" nowrap="nowrap"><table width="100%" border="0" cellpadding="2" cellspacing="1">
        <tr>
          <td>Receipt No <strong>: &nbsp;
            <?=$voucher_no?></strong>
            </td>
          <td><div align="right">Date:
            <?=$trans_date?>
          </div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2" nowrap="nowrap"><div align="center"><strong>Money Receipt</strong> </div></td>
    </tr>
    <tr>
      <td height="49" colspan="2" nowrap="nowrap"><span class="style17">Received with thanks from</span>
      <input name="bill_no" type="text" disabled="disabled" style=" border:none; border-bottom:#16335F dotted 2px; width:75%; box-shadow:none; height:20px; background:none; margin-top:2px;" value="<?= $cust_name;?>" /></td>
    </tr>
    <tr>
      <td height="28" colspan="2" nowrap="nowrap"><span class="style17">An Amount of Rs.</span><span class="style19">&nbsp;
        <input type="text" name="bill_no" style=" border:none; border-bottom:#16335F dotted 2px; width:82%; box-shadow:none; height:20px; background:none; margin-top:2px;" 
		value="<?php echo ucwords(int_to_words($amt));?> <?=Only?>" disabled="disabled"/>
		<?php ?>
      </span></td>
    </tr>
    <tr>
      <td height="31" colspan="2" nowrap="nowrap"><span class="style17">Against the <strong>:</strong> </span><span class="style19">&nbsp;
        <input type="text" name="bill_no" style=" border:none; border-bottom:#16335F dotted 2px; box-shadow:none; width:50%; font-size:14px; height:20px; background:none; margin-top:2px;text-wrap:normal" value="<?php echo $narration?>" />
        
       Payment Mode <strong>:</strong>
      <input type="text" name="bill_no" style=" border:none; border-bottom:#16335F dotted 2px; box-shadow:none; width:20%; font-size:14px; height:20px; background:none; margin-top:2px;" value="<?php echo $pay_mode?>" />

        
      </span></td>
    </tr>
    <tr>
      <td width="48%" height="93"><table width="90%" border="0" cellpadding="0" cellspacing="0" style="border:#16335F 1px solid;">
        <tr>
          <td width="26%" height="37" align="center" bgcolor="#16335F"><span class="style8">Rs. </span></td>
          <td width="74%">&nbsp;&nbsp;<?=number_format(($amt),2)?></td>
        </tr>
      </table>	  </td>
      <td width="52%" align="right" valign="middle">&nbsp;</td>
    </tr>
  </table>
  
<table width="100%" border="0">
  <tr>
    <td>For Hotel Ganga Ashram </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td> Autorised Signature</td>
  </tr>
</table></div>

<div align="center">
<input type="submit" name="Save" value="Print" class="btn btn-info" onClick="printDiv('printableArea')" style="margin:auto" />
</div>

