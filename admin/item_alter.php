<?php
@session_start();
@ob_start();
include "header.php"; 
$objCoreRes->item_alter();
?>
<script type="text/javascript">
	$(document).ready(function() {                
				$("#FORMNAME1").validate({
                    rules: {
					 
					},
		messages: {
			
					 categorylist_id: "",
					 item_name: "",
					 unit_id: "",
					 rate: ""
					 
								
				},
		  });                
            });
//---auto search-----
</script>
<div class="content">
<div class="content-header">
<h3 class="head-dashboard">Item Master </h3>
</div><?php if(isset($_SESSION["message"])){ echo $_SESSION["message"]; unset($_SESSION["message"]);} ?>
<div class="content-container">
<div class="entry-head">
<h4><strong>Add Item</strong>
  <div style="color:#FFFFFF; float:right" ><a href="item_list.php"><img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"   /></a></div> </h4>

</div>

<div class="entry-content">
<form method="post" id="FORMNAME1">
<table width="100%" class="table table-striped">
	<tr>
	  <td height="39">Category</td>
	  <td><strong>:</strong></td>
	  <td><select name="categorylist_id"  required id="categorylist_id" <?php echo $objCoreRes->disbableit;?>>
	  <option value="">--Select--</option>
	  <?php $varcid=mysql_query("SELECT * FROM `tbl_categorylist_mstr` where suspended_status=0"); 
	  while($datacid=mysql_fetch_array($varcid)){ ?>
	  <option value="<?php echo $datacid["id"] ?>" <?php if ($datacid["id"]==$objCoreRes->categorylist_id){?> selected<?php }?>><?php echo $datacid["category_name"]; }?></option></select></td>
    </tr>
	<tr>
		<td width="14%" height="39">Item Name </td>
		<td width="2%"><strong>:</strong></td>
	  <td width="84%"><input required type ="text" name="item_name" id="item_name" value="<?php echo $objCoreRes->item_name?>" <?php echo $objCoreRes->disbableit;?>/></td>
	</tr>
	<tr>
	  <td>Unit Symbol </td>
	  <td><strong>:</strong></td>
	  <td><select required name="unit_id" id="unit_id" <?php echo $objCoreRes->disbableit;?>>
	  <option value="">--Select--</option>
	  <?php $varunit=mysql_query("SELECT * FROM `tbl_unit_mstr` where suspended_status=0"); 
	  while($dataunit=mysql_fetch_array($varunit)){ ?>
	  <option value="<?php echo $dataunit["id"] ?>" <?php if ($dataunit["id"]==$objCoreRes->unit_id){?> selected<?php }?>><?php echo $dataunit["unit_name"]; }?></option></select></td>
    </tr>
	<tr>
	  <td>Rate</td>
	  <td><strong>:</strong></td>
	  <td><input required type ="number" name="rate" id="rate" min="0" value="<?php echo $objCoreRes->rate?>" <?php echo $objCoreRes->disbableit;?>/></td>
    </tr>
	<tr>
	  <td>Service Tax Applicable</td>
	  <td><strong>:</strong></td>
	  <td><input type="checkbox" name="s_tax" id="s_tax" <?php if(isset($objCoreRes->s_tax)){if($objCoreRes->s_tax==1){?>checked<?php }} else{?> checked <?php }?> ></td>
    </tr>
	<tr>
	  <td>VAT Applicable</td>
	  <td><strong>:</strong></td>
	  <td><input type="checkbox" name="vat_tax" id="vat_tax" <?php if(isset($objCoreRes->s_tax)){if($objCoreRes->s_tax==1){?>checked<?php }} else{?> checked <?php }?>  ></td>
    </tr>
	<tr>
		
		<td></td>
		<td></td>
		<input type="hidden" name="uid" id="uid" value="<?php echo $_REQUEST["uid"];?>" />
          <input type="hidden" name="wid" id="wid" value="<?php echo $_REQUEST["wid"];?>" />
          <input type="hidden" id="ButtonOperation" name="ButtonOperation" class="btn btn-info" value="<?php echo $objCoreRes->ButtonOperation;?>" />
          <?php if($objCoreRes->ButtonOperation=="View"){ $SaveCaption="Close";} else {$SaveCaption="Save";}?>
      <td width="84%"><input type="submit" id="Save" name="Save" class="btn btn-info" value="<?php echo $SaveCaption;?>" /></td>
	</tr>
</table>
</form>
<?php include "footer.php"?>
