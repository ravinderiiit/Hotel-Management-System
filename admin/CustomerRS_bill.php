<?php
@session_start();
@ob_start();
include "Customer_view.php";
include "function.ini.php";
$objCoreFO->CustomerRS_final(); 


  $cid=$_REQUEST["uid"];

 $master=mysql_query("SELECT * FROM `view_order_room` WHERE md5(id)='".$cid."'");
	while($master_data=mysql_fetch_array($master)){
		 $discount=$master_data["discount"];
		 $kot=$master_data["kot"];
		 $id=$master_data["id"];
		 $date=$master_data["date"];
		 $name=$master_data["cust_no_name"];
		 $room_no=$master_data["room_no"];
		}



?>

<script type="text/javascript">
$(document).ready(function() {                
$("#FORMNAME1").validate({
rules: {

},
messages: {
			paymentmode:""



},
});                



$("#P").click(function(){

var originalContent=$("body").html();
$(this).hide();
$("#Pay").hide();
$("#paymode").hide();
var pArea=$("#printableArea").html();
$("body").html(pArea);
window.print();
$("body").html(originalContent);
$(this).show();
});
});		   
//---auto search-----
</script>


<style>
.retailInvoice{
font-weight:bold;text-align:center;border:1px solid black;background-color:black;color:white;border-radius:8px;
margin-left:40%;margin-right:40%;margin-top:-10px;
}
.innerBody{
margin-left:10%;margin-right:10%;padding-top:1px;padding-left:10px;padding-right:10px;margin-bottom:10px;padding-bottom:-30px;border:2px solid black;height:auto;
margin-top:20px;
}
</style>

<div class="content">
	
<div class="content-container">
<div class="entry-head">
	<h4>
		<strong> ROOM SERVICE </strong><div style="float:right"><a href="CustomerRS_list.php"><img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"/></a></div>
	</h4>
</div>

<div class="entry-content">
<form method="post">
<div id="printableArea" >
    <div class="innerBody">
    <table width="100%">
        <tr height="30">
        	<td colspan="11">
                <table width="100%" align="center">
                        <tr>
                                <td colspan="2" nowrap="nowrap" >
                                <p class="retailInvoice">RETAIL INVOICE</p>
                                <span style="float:left"><img src="../common/images/hga_logo.png" align="absmiddle" width="70"></span>
                                
                                <div  style="margin-right:6%;text-align:center"><strong>
                                <span style="font-size:large">
                                <?php $str="SELECT * FROM `tbl_company_detl` where dept_id=3 && suspended_status=0";
									  $query=mysql_query($str);
									  $row_bill=mysql_fetch_array($query); ?>
                                
                                &nbsp;&nbsp;<?php echo $row_bill['unit_name']; ?></span></strong> 
                                <br />   
                                <p><strong>( A Unit of Ganga Ashram Private Limited )</strong></p>
                                <p><?php echo $row_bill['building_no'].", ".$row_bill['street'].", ".$row_bill['city'].", ".$row_bill['state']."-".$row_bill['pincode'];  ?></p>
                                <p>Tele: <?php echo $row_bill['contact_no']; ?></p>
                                </div>
                                </td>
                        </tr>
                        <tr height="10">
                                <td colspan="2" nowrap="nowrap">
                                <div style="border-top:2px dotted grey;line-height:3">
                                
                                <div style="float:left;"><strong>Tin No. : <?php echo $row_bill['vat_tin_no']; ?></strong></div>
                                <div align="center" style="float:left;margin-left:38%;font-weight:bold;text-decoration:underline"><strong>BILL DETAILS</strong></div>
                                <div style="float:right;"><strong>Bill Date : <?php echo date('d-m-Y')?></strong></div>
                                
                                </div>
                                </td>
                        <tr>
                                <td colspan="2" nowrap="nowrap">
                                <div style="border-top:2px dotted grey;">      
                                </div>
                                </td>
                        </tr>
                        </table>
            </td>
        </tr>
        
        <tr height="30">
          <td width="8%">Room No. </td>
          <td width="1%"><strong>:</strong></td>
          <td width="75%" colspan="5"><?php echo $room_no ; ?></td>
          <td width="8%" align="right">Bill No. </td>
          <td width="1%" align="center"><strong>:</strong></td>
          <td width="7%" align="right">
		  <?php echo "RETO"."00".(($id+175)*3); ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <input type="hidden" name="bill_no" value="<?php echo "RETO"."00".(($id+175)*3); ?>" />
            </td>
        </tr>
        <tr height="30">
          <td colspan="11"> 
          <p style="border-top:2px dotted black"></p>
        </td>
        </tr>
       
    </table>
    
    <table width="100%" class="table table-condensed">
     <?php $query_titem=mysql_query("SELECT * FROM `view_order_details` where md5(order_mastid)='".$cid."' and suspended_status=0 ");{
     if(mysql_num_rows($query_titem)>0){ $count=1
      ?>
    <tr>
      <th width="2%" style="background-color:#030;color:#FFF">#</th>
      <th width="5%" style="background-color:#030;color:#FFF">Date</th>
      <th width="8%" style="background-color:#030;color:#FFF">KOT No.</th>
      <th width="70%" style="background-color:#030;color:#FFF">Item Name </th>
      <th width="5%" style="background-color:#030;color:#FFF">Rate(INR)</th>
      <th width="5%" style="background-color:#030;color:#FFF">Qty</th>
      <th width="5%" style="background-color:#030;color:#FFF">Total</th>  
    </tr>
     <?php while($data_titem=mysql_fetch_array($query_titem)){ ?>
    <tr>
      <td align="center"><?php echo $count; ?></td>
      <td align="center"><?php echo date('d-m-Y ',$data_titem["order_datetime"]);  ?></td>
      <td align="center"><?php echo $data_titem["kot"];  ?></td>
    <?php  $taxes=0; 
   $str="SELECT * FROM `tbl_tax_mstr`";
  $query=mysql_query($str);
  while($row2=mysql_fetch_array($query)){
	  $tax[]=array('tax'=>$row2['tax_percentage']);
	  $tax_name[]=array('tax_name'=>$row2['tax_name']);
	  
	}
	
	
	 $vat_tax_name=$tax_name[0]['tax_name'];
	  $s_tax_name=$tax_name[1]['tax_name'];
	
	
  
  if($data_titem['vat_tax']==1){ 
  $vat_tax=$tax[0]['tax'];
   } 
   	else
	  {
		$vat_tax=0; 
	 } 
 if($data_titem['s_tax']==1){ 
  $s_tax=$tax[1]['tax']; } 
  	else
	  {
		$s_tax=0;  
		} 
		$total_vat+=$vat_onitem;
  		$total_s+=$s_onitem; ?>  
	
      
      <td>&nbsp;<?php echo $data_titem["item_name"]; ?> </td>
      <td align="center"><?php echo $unit_price=number_format($data_titem["rate"],2,'.','');   ?></td>
      <td align="center"><?php echo $data_titem["qty"];  ?></td>
      <?php $tqty+=$data_titem["qty"]; ?>
      <?php $total=$unit_price*$data_titem["qty"];
      $ftotal+=$total;?>
      <td align="center"><div align="right"><?php echo number_format($total,2) ;  $vat_onitem=(($total* $vat_tax)/100); $s_onitem=(($total* $s_tax)/100);?></div></td>
      </tr><?php $count++; } ?>
     <?php $total_vat+=$vat_onitem;
  		$total_s+=$s_onitem; ?>
    <tr>
      <td colspan="4">
      <input type="hidden" name="counter" value="<?=$count;?>"/>
      <div align="center"><strong>[No. Of Item &nbsp;<?php echo $count-1; ?>] </strong></div></td>
      <td><div align="center"><strong>Total</strong></div></td>
      <td align="center"><?php echo $tqty; ?></td>
      <td align="center"> <div align="right"><?php echo number_format($ftotal,2); ?> </div></td>
      </tr>
      <?php if($discount!=0){?>
    <tr>
      <td colspan="6"><div align="right">Discount(%)&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
      <td align="center"><div align="right"><?php echo number_format($discount,2); ?></div></td>
       </tr>
       
    <tr>
    <?php } $tot_af_dis=($ftotal-($ftotal*($discount/100)));?>
    <?php if($discount!=0){ ?>
      <td colspan="6"><div align="right">Total After Discount &nbsp;&nbsp;&nbsp;&nbsp;</div></td>
      <td align="center"><div align="right">
        <?php   echo number_format($tot_af_dis,2);  ?>
      </div></td>
      </tr>
     <?php } ?>
     
     
   <?php if($total_vat>0){ ?>
<tr>
  <td colspan="6"><div align="right"><?php echo  $vat_tax_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
  <td align="right">
    <?php  echo number_format($total_vat,2,'.',''); ?> 
  </td>
  <td>&nbsp; </td>
</tr>
<?php }?>
<?php if($total_s>0){ ?>
<tr>
  <td colspan="6"><div align="right"><?php echo $s_tax_name;  ?>&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
  <td align="right">
    <?php  echo number_format($total_s,2,'.',''); ?> 
  </td>
  <td>&nbsp; </td>
</tr>
<?php } ?>
    
    <tr>
      <td colspan="6"><div align="right"><strong>Total (Including Tax)&nbsp;&nbsp;&nbsp;&nbsp;</strong> </div></td>
      <td align="center"><div align="right">
        <strong>
        <?php $ft= ($tot_af_dis+$total_vat+$total_s); echo number_format($ft,2); ?>
        </strong>
    <input type="hidden" name="grandtotal" value="<?php echo  $ft  ?>" />
      </div></td>
      </tr>
    <tr>
      <td colspan="6">&nbsp;</td>
      <td align="center">&nbsp;</td>
    </tr>
    <?php }}?>
    </table>
    
    <p style="border-top:2px dotted grey"></p>
    <p><strong>Rupees (in words):</strong> 
                    <span style="font-size:12px">
                    <?php 
                    $net=$totfac+$totRoom;
                    echo strtoupper(int_to_words($ft)." only.");?>
                    </span>
     </p>
    <p style="border-bottom:2px dotted grey;padding:10"></p>
    <br /><br />
                <div style="border:1px solid grey;height:120px">
                            <div style="float:left;margin-left:30px;line-height:2;padding:10px"><br>
    <br>
    <br>
    <p></p>
                            <p><strong>Customer Signature</strong></p>
                            </div>
                            
                            <div style="float:right;padding:10px">
                            <p style="font-size:16px;"><strong>For HOTEL GANGA ASHRAM</strong></p>
                            <br />
                            <br /><br /><p></p>
                            <p><span style="margin-left:90px;"><strong>Authorised Signatory</strong></span></p>
                            </div>
                </div>
                <br />
                <p></p>
    </div>
    </div><br>

<div align="center"><input type="button" name="Save" value="Print" id="P" class="btn btn-info"/></div>
</form>

<?php include "footer.php"?>
</div>
</div>