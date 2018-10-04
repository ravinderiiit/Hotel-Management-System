<?php
@session_start();
@ob_start();

include "Customer_view.php";
$objCoreFO->CustomerRS_alter();
?>

<style>
.innerBody{
margin-left:10px;margin-right:10px;padding-top:5px;padding-left:5px;padding-right:5px;margin-bottom:10px;padding-bottom:-30px;border:#CCCCCC 1px solid;height:auto;
}
</style>

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


<div class="content">
	
<div class="content-container">
<div class="entry-head">
	<h4>
		<strong> ROOM SERVICE </strong><div style="float:right">
        <a href="CustomerRS_list.php"><img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"/></a>
	</h4>
</div>

<?php if(isset($_SESSION["message"])){ echo $_SESSION["message"]; unset($_SESSION["message"]);}?>
<form method="post">
<div class="panel">
     <div class="panel">
     <table width="100%">
                    <tr height="40">
                      <td width="5%">KOT</td>
                      <td width="1%"><strong>:</strong></td>
                      <td colspan="19" width="94%"><strong>Auto Genrate </strong></td>
                    </tr>
                    <tr height="40">
                      <td width="7%">Room No. </td>
                      <td width="1%"><strong>:</strong></td>
                      
                      <td width="10%">
                     
                      <select required name="room_details" id="room_details" style="width:98%"  >
                      <option value="">--Select--</option>
                      <?php   $str="SELECT * FROM `view_cus_mstr_dtl_wise` where md5(id)='".$_SESSION['custid']."' and chkout_status=1  ";
                             $query=mysql_query($str);
                             while($row=mysql_fetch_array($query)){ ?>
                      <option value="<?php echo $row['id']."@".$row['cust_dtl_id']; ?>"<?php if($_POST['room_details']==($row['id']."@".$row['cust_dtl_id'])){ ?>selected<?php }?>><?php echo $row['room_no']; ?></option>
                      <?php }?>
                      </select>              
                      </td>
                      <td width="2%">&nbsp;</td>
                      <td width="4%">Waiter</td>
                      <td width="1%"><strong>:</strong></td>
                      <td width="14%">
                      <select required name="emp_id" id="emp_id" style="width:98%">
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
<?php $query_titem=mysql_query("SELECT * FROM `view_temp_order` where order_from='R' ");
 if(mysql_num_rows($query_titem)>0)
 { $count=1
  ?>
    <div class="panel">
    	<table width="100%" class="table table-bordered">
        <tr>
          <th width="1%" style="background-color:#000000;color:#FFFFFF">#</th>
         
          <th width="40%" style="background-color:#000000;color:#FFFFFF">Item Name</th>  
          <th width="10%" style="background-color:#000000;color:#FFFFFF">Rate(INR)</th>
          <th width="10%" style="background-color:#000000;color:#FFFFFF">Qty</th>
          <th width="10%" style="background-color:#000000;color:#FFFFFF">Total</th>
          <th width="1%" style="background-color:#000000;color:#FFFFFF"><input type="checkbox" name="checkAll" id="checkAll"/></th>  
        </tr>
         <?php while($data_titem=mysql_fetch_array($query_titem))
		 { ?>
        <tr>
          <td align="center"><?php echo $count; ?></td>
         
          <td><?php echo $data_titem["item_name"];  ?></td>
          <td align="right"><?php echo $unit_price=number_format((100*$data_titem["rate"])/(100+$taxes),2,'.','');?></td>
          <td align="center"><?php echo $data_titem["qty"];  ?></td>
          <?php $tqty+=$data_titem["qty"]; ?>
          <?php $total=$unit_price*$data_titem["qty"];
          $ftotal+=$total;?>
          <td align="right"><?php echo number_format($total,2,'.','') ?></td>
          <td ><div align="center">
            <input type="checkbox" name="Check_<?=$count?>" value="<?=$data_titem["id"];?>">
            <input type="hidden" name="item_<?=$count?>" value="<?=$data_titem["id"];?>" class="btn btn-danger">  
          </div></td>
        </tr>
         <?php $count++; } ?>
    
        <tr>
          <td colspan="2">
          <input type="hidden" name="counter" value="<?=$count;?>"/>
          <div align="center"><strong>[No. Of Item &nbsp;<?php echo $count-1; ?>] </strong></div></td>
          <td><div align="center"><strong>Total</strong></div></td>
          <td align="center"><strong><?php echo number_format($tqty,2,'.',''); ?></strong></td>
          <td align="right">
          <strong> <?php echo number_format($ftotal,2,'.',''); ?></strong>
          <input type="hidden" name="ftotal" id="ftotal" value="<?php echo $ftotal; ?>" />
          </td>
          <td><input type="submit" name="Save" value="X" class="btn btn-danger"></td>
       </tr>
        <tr>
          <td colspan="4"></td>
          <td colspan="2"><div align="right">
            <input type="submit" name="Save" id="submitbutton" value="Save" class="btn btn-info" /></div>
         </td>
       </tr>
   
    </table>
    </div>
    <?php }?>
</form>			
	<!--------------End----------------->
	

	
	

<?php include "footer.php"?>
</div>
</div>
</div>