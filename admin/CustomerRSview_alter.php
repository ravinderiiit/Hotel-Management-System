<?php
@session_start();
@ob_start();
include "Customer_view.php";
$objCoreFO->CustomerRSview_alter(); 

$uid = $_GET['uid'];
$result =  mysql_query("SELECT * FROM `view_order_room` WHERE md5(id) = '$uid' AND suspended_status=0 and status=1");
$row2 = mysql_fetch_array($result); 


?>
<script type="text/javascript"> 
jQuery(document).ready(function(){

			$("#FORMNAME1").validate({
                    rules: {
                   
					},
		messages: {
			
					 emp_id: ""
					 
								
				},
		  });   
		  
			$('#item_name').autocomplete({
			source:'../ProgramFile/auto/item_auto.php', minLength:1,
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
		<strong> ROOM NO.<?php echo $row2["room_no"]; ?></strong>
		<div style="float:right"><a href="CustomerRS_view.php?uid=<?php echo $_GET['uid']; ?>"><img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"/></a></div>
	</h4>
</div>
<form method="post">
<?php if(isset($_SESSION["message"])){echo $_SESSION["message"];unset($_SESSION["message"]);}?>
 <div class="panel">
	<!--this is an unused section----->
    <!-- <table width="100%" class="table table-condensed" >
 

<tr>
  <td width="6%">Kot</td>
  <td width="13%">Auto Generate </td>
  <td width="4%">Waiter</td>
  <td width="4%"><select name="emp_id" id="emp_id" style="width:150px">
  				<option value="">--Select--</option>
				<?php $str="SELECT * FROM `tbl_employee_master` where dept_id=4";
				$query=mysql_query($str);
				while($row=mysql_fetch_array($query)){ ?>
				<option value="<?=$row['id']; ?>"<?php if($_POST['emp_id']==$row['id']){  ?>selected<?php }?>><?php echo $row['emp_name'];  ?></option>		
				<?php } ?>
  </select></td>
  <td width="4%">&nbsp;</td>
	<td width="15%" height="27">Item Name </td>
	<td width="21%"><input type="text" name="item_name" id="item_name" value="" /><input type="hidden" name="item_id" id="item_id" value=""  /></td>
	<td width="2%">&nbsp;</td>
	<td width="7%">Rate</td>	
	<td width="2%">&nbsp;</td>
	<td width="8%"><div id="rate"></div></td>
	<td width="4%">&nbsp;
	  <input type="hidden" name="item_rate" id="item_rate" value="" style="width:50px"/></td>
	<td width="5%">Qty</td>
	<td width="10%"><input type="number" name="quantity" id="quantity" value="" style="width:50px" min="1"/></td>
	<td width="0%">&nbsp;</td>
	<td width="3%"><input type="submit" name="Save" value="Add"  class="btn btn-danger" /></td>	
</tr>
</table>-->
	<!--END----->
    
    <div class="panel">
    <input type="hidden" name="order_mastid" value="<?php echo $row2['id']; ?>" />
	 <table width="100%">
    			<tr height="40">
                  <td width="5%">KOT</td>
                  <td width="1%"><strong>:</strong></td>
                  <td colspan="19" width="94%"><strong>Auto Genrate </strong></td>
                </tr>
                <tr height="40">
                  <td width="7%">Room No. </td>
                  <td width="1%"><strong>:</strong></td>
                  
                  <td width="10%"><?php echo $row2["room_no"]; ?>
                  <input type="hidden" name="room_details" id="room_details" value="<?php echo $row2['rpt_id']."@".$row2['cust_no_name']; ?>"/>
                            
                  </td>
                  <td width="2%">&nbsp;</td>
                  <td width="4%">Waiter</td>
                  <td width="1%"><strong>:</strong></td>
                  <td width="14%">
                  <select name="emp_id" id="emp_id" required style="width:98%">
                    <option value="">--Select--</option>
                    <?php $str="SELECT * FROM `tbl_employee_master` where dept_id=4 and suspended_status=0";
                    $query=mysql_query($str);
                    while($row=mysql_fetch_array($query)){ ?>
                    <option value="<?=$row['id']; ?>"<?php if($_POST['emp_id']==$row['id']){  ?>selected<?php }?>><?php echo $row['emp_name'];  ?></option>
                    <?php } ?>
                  </select>
                  </td>
                  <td width="2%">&nbsp;</td>
                  <td width="8%">Item Name </td>
                  <td width="1%"><strong>:</strong></td>
                  <td width="18%">
                  <input type="text" name="item_name" id="item_name" value="" style="width:98%"/>
                  <input type="hidden" name="item_id" id="item_id" value=""  style="width:98%"/></td>
                  <td width="2%">&nbsp;</td>
                  <td width="4%">Rate</td>
                  <td width="1%"><strong>:</strong></td>
                  <td width="6%">
                      <div id="rate"><strong>Auto</strong></div>
                      <input type="hidden" name="item_rate" id="item_rate" value="" style="width:98%"/>
                  </td>
                  <td width="2%">&nbsp;</td>
                  <td width="%">Qty</td>
                  <td width="2%" align="center"><strong>:</strong></td>
                  <td width="5%"><input type="number" name="quantity" id="quantity" value="" style="width:98%" min="1"/></td>
                  <td width="2%">&nbsp;</td>
                  <td width="19%"><input type="submit" name="Save" value="Add"  class="btn btn-danger" /></td>
                </tr>
  </table>
    </div>
	<?php $query_titem=mysql_query("SELECT * FROM `view_temp_order` where order_from='R' ");{
     if(mysql_num_rows($query_titem)>0){ $count=1
      ?>
    <div class="panel">
    <table width="100%" class="table table-bordered">
     
    <tr>
      <th width="3%" style="background-color:#000000;color:#FFFFFF">#</td>
      <th style="background-color:#000000;color:#FFFFFF">
      Item Name
        </td>  
      <th width="11%" style="background-color:#000000;color:#FFFFFF">Rate(INR)</td>
      <th width="14%" style="background-color:#000000;color:#FFFFFF">Qty</td>
      <th width="15%" style="background-color:#000000;color:#FFFFFF">Total</td>
      <th width="6%" style="background-color:#000000;color:#FFFFFF">
        <div align="center">
          <input type="checkbox" name="checkAll" id="checkAll"/>
          
          </td>  
        </div>  </tr>
     <?php while($data_titem=mysql_fetch_array($query_titem)){ ?>
    <tr>
      <td align="center"><?php echo $count; ?></td>
      <td align="center"><?php echo $data_titem["item_name"];  ?></td>
      <td align="right"><?php echo $unit_price=number_format((100*$data_titem["rate"])/(100+$taxes),2,'.','');   ?></td>
      <td align="center"><?php echo $data_titem["qty"];  ?></td>
      <?php $tqty+=$data_titem["qty"]; ?>
      <?php $total=$unit_price*$data_titem["qty"];
      $ftotal+=$total;?>
      <td align="right"><?php echo number_format($total,2,'.','') ?></td>
      <td ><div align="center">
        <input type="checkbox" name="Check_<?=$count?>" value="<?=$data_titem["id"];?>">
        <input type="hidden" name="item_<?=$count?>" value="<?=$data_titem["id"];?>" class="btn btn-danger">  
      </div></td>
    </tr><?php $count++; } ?>
    
    <tr>
      <td colspan="2">
      <input type="hidden" name="counter" value="<?=$count;?>"/>
      <div align="center">[No. Of Item &nbsp;<?php echo $count-1; ?>] </div></td>
      <td><div align="center"><strong>Total</strong></div></td>
      <td align="center"><strong><?php echo number_format($tqty,2,'.',''); ?></strong></td>
      <td align="right"><strong> <?php echo number_format($ftotal,2,'.',''); ?></strong><input type="hidden" name="ftotal" id="ftotal" value="<?php echo $ftotal; ?>" /></td>
      <td><input type="submit" name="Save" value="X" class="btn btn-danger" ></td>
    </tr>
    
   
   
   
    <tr>
      <td colspan="4">
        <div style="float:left"></div>    <div style="float:right"> </div></td>
      <td colspan="2"> <div style="float:right"><input type="submit" name="Save" id="submitbutton" value="Save" class="btn btn-info" /></div></td>
      </tr>
    <?php }?>
     
    </table>
    </div>
    <?php }?>
</form>			
			
		
	<!--------------End----------------->
	

	
	

<?php include "footer.php"?>
</div>
</div>