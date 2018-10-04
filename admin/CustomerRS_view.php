<?php
@session_start();
@ob_start();
include "Customer_view.php";
$objCoreFO->CustomerRS_final(); 


$uid = $_GET['uid'];
$result =  mysql_query("SELECT * FROM `view_order_room` WHERE md5(id) = '$uid' AND suspended_status=0 and status=1");
$row = mysql_fetch_array($result); 


?>
<script type="text/javascript"> 
 		jQuery(document).ready(function(){
			
			$('#item_name').autocomplete({source:'../ProgramFile/auto/item_auto.php', minLength:1,
			select: function (event, ui) {
        	$("#item_id").val(ui.item.id); // display the selected id       		
			$("#rate").html(ui.item.rate);
			$("#item_rate").val(ui.item.rate);			
			
		    }
			});
			
			
			$("#checkAll").click(function(){
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
<script type="text/javascript">
function calc() {
	var discount=document.getElementById("discount").value;
	if(discount<0)
	{
	alert("Discount should not less than zero");
	document.getElementById("discount").value=0;
	}
	else {
    var ftotal=document.getElementById("ftotal").value;
	var tot_s=document.getElementById("s_tax").value;
	var tot_vat=document.getElementById("vat_tax").value;
	var tot_tax=eval(tot_s)+eval(tot_vat);
    var dis_price= ((discount*ftotal)/100);
	var tot_af_dis=ftotal-dis_price;
	var total_after_tax=eval(tot_af_dis)+eval(tot_tax);
	var tot_in_tax=Math.round(total_after_tax);
	document.getElementById("tot_af_dis").innerHTML=tot_af_dis.toFixed(2);
	document.getElementById("tot_in_tax").innerHTML=tot_in_tax.toFixed(2);
	document.getElementById("tot_in_tax_t").value=tot_in_tax.toFixed(2);
	
	
   	//alert(tot_af_dis);
	document.getElementById('submitbutton').disabled = false;
	}

}


</script><script type="text/javascript">
	$(document).ready(function() {                
				$("#FORMNAME1").validate({
                    rules: {
                   
					},
		messages: {
			
					 discount: ""
					 
								
				},
		  });                
            });
//---auto search-----
</script>
<script type="text/javascript"> 
 		jQuery(document).ready(function(){
			
			$('#item_name').autocomplete({source:'../ProgramFile/auto/item_auto.php', minLength:1,
			select: function (event, ui) {
        	$("#item_id").val(ui.item.id); // display the selected id       		
			$("#rate").html(ui.item.rate);
			$("#item_rate").val(ui.item.rate);			
			
		    }
			});
			
			
			$("#checkAll").click(function(){
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
<style>
.innerBody{
margin-left:10px;margin-right:10px;padding-top:5px;padding-left:5px;padding-right:5px;margin-bottom:10px;padding-bottom:-30px;border:#CCCCCC 1px solid;height:auto;
}
</style>

<div class="content">
	
<div class="content-container">
<div class="entry-head">
	<h4>
		<strong> ROOM NO.<?php echo $row["room_no"]; ?></strong>
		<div style="float:right">
        <a href="CustomerRS_list.php"><img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"/></a>
           <div style="float:right">
            <a href="CustomerRSview_alter.php?uid=<?php echo $_GET['uid']; ?>">
                <img src="<?php echo IMAGE_PATH?>add.png" title="Add New Record" width="18"/>
            </a>
            </div>
        </div>
	</h4>
</div>

<div class="entry-content">
<form method="post" enctype="multipart/form-data">
<?php if(isset($_SESSION["message"])){echo $_SESSION["message"];unset($_SESSION["message"]);}?>
	<!-------Customer facility add ----------->
		
			
	<form method="post">
   

<input type="hidden" name="uid" value="<?php echo $_GET['uid']; ?>"/>
<input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>"/>

<div class="panel">
<table width="100%" class="table table-bordered">
 <?php $total_vat=0;$total_s=0; 
 $query_titem=mysql_query("SELECT * FROM `view_order_details` where md5(order_mastid ) = '$uid' && suspended_status=0 ");{
 if(mysql_num_rows($query_titem)>0){ $count=1
  ?>
<tr>
  <th width="10%" style="background-color:#000000;color:#FFFFFF">#</td>
  <th width="7%" style="background-color:#000000;color:#FFFFFF">KOT
  <th width="12%" style="background-color:#000000;color:#FFFFFF">Date  
  <th width="39%" style="background-color:#000000;color:#FFFFFF">Item Name
    </td>
  <th width="6%" style="background-color:#000000;color:#FFFFFF">Rate(INR)</td>
  <th width="9%" style="background-color:#000000;color:#FFFFFF">Qty</td>
  <th width="9%" style="background-color:#000000;color:#FFFFFF">Total</td>
  <th width="8%" style="background-color:#000000;color:#FFFFFF">
    <div align="center">
      <input type="checkbox" name="checkAll" id="checkAll"/>
      
      </td>  
    </div>  </tr>
 <?php while($data_titem=mysql_fetch_array($query_titem)){ ?>
<tr>
  <td align="center"><?php echo $count; ?><input type="hidden" name="id_<?=$count?>" value="<?=$data_titem["id"];?>"/> <input type="hidden" name="mid_<?=$count?>" value="<?=$data_titem["order_mastid"];?>"/></td>
  <td align="center"><?php echo $data_titem["kot"];  ?><input type="hidden" name="kot_<?=$count?>" value="<?php echo $data_titem["kot"];  ?>"/></td>
  <td><?php echo date('d-m-Y h:i A',$data_titem["order_datetime"]);  ?></td>
  
  <td><?php echo $data_titem["item_name"];  ?><input type="hidden" name="item_id_<?=$count?>" value="<?php echo $data_titem["item_id"];  ?>"/></td>
  
  <?php $taxes=0; 
   $str="SELECT * FROM `tbl_tax_mstr`";
  $query=mysql_query($str);
   while($row2=mysql_fetch_array($query)){
	  $tax[]=array('tax'=>$row2['tax_percentage']);
	  $tax_name[]=array('tax_name'=>$row2['tax_name']);
	  $tax_id[]=array('tax_id'=>$row2['id']);
	  
	}
	
	 $vat_id=$tax_id[0]['tax_id'];
	 $vat_tax_name=$tax_name[0]['tax_name'];
	 $vat_per=$tax[0]['tax'];
	 $s_id=$tax_id[1]['tax_id'];
	 $s_tax_name=$tax_name[1]['tax_name'];
	 $s_per=$tax[1]['tax'];
	
	
  
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
	  
	
   
  ?> 
  <td align="right"><?php echo $unit_price=number_format($data_titem["rate"],2,'.','');   ?><input type="hidden" name="rate_<?=$count?>" value="<?php echo$data_titem["rate"];  ?>"/></td>
  <td align="center"><?php if($data_titem['approveby_id']==0){ ?><input type="number" name="qty_<?=$count?>" value="<?php echo $data_titem["qty"];?>" min="1" max="<?php echo $data_titem["qty"];?>" style="width:50px" /><?php } else{ echo $data_titem["qty"];}?></td>
  <?php $tqty+=$data_titem["qty"]; ?>
  <?php $total=$unit_price*$data_titem["qty"];
  $ftotal+=$total;?>
  <td align="right"><?php echo number_format($total,2,'.', '');  $vat_onitem=(($total* $vat_tax)/100); $s_onitem=(($total* $s_tax)/100)?></td>
  <?php $total_vat+=$vat_onitem;
  		$total_s+=$s_onitem; ?>
  <td ><div align="center"><?php if($data_titem['approveby_id']==0){ ?>
    <input type="checkbox" name="Check_<?=$count?>" value="<?=$data_titem["id"];?>">
    <input type="hidden" name="item_<?=$count?>" value="<?=$data_titem["id"];?>" class="btn btn-danger"><?php } else
	echo "Approved"; ?>  
  </div></td>
</tr><?php $count++; } ?>

<tr>
  <td colspan="4">
  <input type="hidden" name="counter" id="counter" value="<?=$count;?>"/>
  <div align="center">[No. Of Item &nbsp;<?php echo $count-1; ?>] </div></td>
  <td><div align="center"><strong>Total</strong></div></td>
  <td align="center"><?php echo number_format($tqty,2,'.',''); ?></td>
  <td align="right"> <?php echo number_format($ftotal,2,'.',''); ?><input type="hidden" name="ftotal" id="ftotal" value="<?php echo $ftotal; ?>" /></td>
  <td><input type="submit" name="Save" value="X" class="btn btn-danger" ></td>
</tr>
<tr>

  <td colspan="6"><div align="right">Discount(%)&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
  <td align="right"><input required type="number" name="discount" id="discount" style="width:50px" value="0" min="0" onKeyUp="calc()" /></td>
   <td>&nbsp;</td>
</tr>
<tr>
  <td colspan="6"><div align="right">Total After Discount &nbsp;&nbsp;&nbsp;&nbsp;</div></td>
  <td align="right"><div id="tot_af_dis">&nbsp;</div></td>
  <td>&nbsp;</td>
</tr>
<input type="hidden" name="vat_tax" id="vat_tax" value="<?php echo $total_vat ?>"/><input type="hidden" name="s_tax" id="s_tax" value="<?php echo $total_s ?>"/>
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
  <td align="right"><div id="tot_in_tax"></div>
    <div align="right">
      <input type="hidden" name="tot_in_tax_t" id="tot_in_tax_t" value="" />
    </div></td>
  <td><input type="hidden" name="tot_tax" id="tot_tax" value="<?php echo round($total_tax,2) ?>" /></td>
</tr>
<tr>
  <td colspan="6" align="right"><input type="submit" name="Save"  value="Approve" class="btn btn-danger" />&nbsp;&nbsp;<input type="submit" name="Save"  value="Update" class="btn btn-danger" />
  </td>
  <td colspan="2"><div style="float:left">
  <?php
  $q2="SELECT count(`approveby_id`) as button FROM `tbl_order_details` WHERE md5(order_mastid)='".$_GET['uid']."' && `approveby_id`=0 && `suspended_status`=0 && item_id!=0";
  $s2=mysql_query($q2);
  $r2=mysql_fetch_array($s2);
; ?>
  <input type="button" value="Calc" onclick="calc()" class="btn btn-info"></div> <?php if($r2['button']==0){?> <div style="float:right"><input type="submit" name="Save" id="submitbutton" value="Gen. Bill" class="btn btn-danger" disabled="disabled"/></div><?php }?></td>
  </tr>
<?php }}?>
</table>
</form>
			
		</div>
	<!--------------End----------------->
	

	
	
</form>	
<?php include "footer.php"?>
</div>
</div>