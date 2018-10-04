<?php
@session_start();
@ob_start();

include "header.php"; 
$objCoreRes->client_alter();
?>
<script type="text/javascript">
	$(document).ready(function() {                
				$("#FORMNAME1").validate({
                    rules: {
                   
					},
		messages: {
			
					 table_id: "",
					 client_no: ""
					 
								
				},
		  });                
            });
//---auto search-----
</script>
<div class="content">
<div class="content-header">
<h3 class="head-dashboard">Client Master </h3>
</div><?php if(isset($_SESSION["message"])){ echo $_SESSION["message"]; unset($_SESSION["message"]);} ?>
<div class="content-container">
<div class="entry-head">
<h4><strong>Add Client </strong>
  <div style="color:#FFFFFF; float:right"><a href="client_list.php"><img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"   /></a></div> </h4>

</div>

<div class="entry-content">
<form method="post" id="FORMNAME1">
<table width="100%" class="table table-striped">
	<tr>
		<td width="14%" height="39">Table Number </td>
		<td width="2%"><strong>:</strong></td>
	  <td width="84%"><select required name="table_id" id="table_id" <?php echo $objCoreRes->disbableit;?>>
	  <option value="">--Select--</option>
	  <?php $vart=mysql_query("SELECT * FROM `tbl_table_mstr` where suspended_status=0"); 
	  while($datat=mysql_fetch_array($vart)){ ?>
	  <option value="<?php echo $datat["id"] ?>" <?php if ($datat["id"]==$objCoreRes->table_id){?> selected<?php }?>><?php echo $datat["table_no"]; }?></option></select>
	  
	 </td>
	</tr>
	<tr>
	  <td>Client Number </td>
	  <td><strong>:</strong></td>
	  <td><input required="required" type ="text" name="client_no" id="client_no" value="<?php echo $objCoreRes->client_no?>" <?php echo $objCoreRes->disbableit;?>/></td>
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
