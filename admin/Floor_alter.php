<?php
@session_start();
@ob_start();

include "header.php"; 
$objCoreAdmin->floor_alter();
?>
<script type="text/javascript">
	$(document).ready(function() {                
				$("#FORMNAME1").validate({
                    rules: {
                   
					},
		messages: {
			
					 floor_name: ""
					 
								
				},
		  });                
            });
//---auto search-----
</script>
<div class="content">
<div class="content-header">
<h3 class="head-dashboard">Floor Master </h3>
</div>
<div class="content-container">
<div class="entry-head">
<h4><strong>Add Floor</strong>
  <div style="color:#FFFFFF; float:right"><a href="floor_list.php"><img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"   /></a></div> </h4>

</div>

<div class="entry-content">
<form method="post" id="FORMNAME1">
<table width="100%" class="table table-striped">
	<tr>
		<td width="8%" height="39">Floor Name </td>
		<td width="3%"><strong>:</strong></td>
		<td width="89%"><input required type ="text" name="floor_name" id="floor_name" value="<?php echo $objCoreAdmin->floor_name?>" <?php echo $objCoreAdmin->disbableit;?>/></td>
	</tr>
	<tr>
		
		<td></td>
		<td>
		<input type="hidden" name="uid" id="uid" value="<?php echo $_REQUEST["uid"];?>" />
          <input type="hidden" name="wid" id="wid" value="<?php echo $_REQUEST["wid"];?>" />
          <input type="hidden" id="ButtonOperation" name="ButtonOperation" class="btn btn-info" value="<?php echo $objCoreAdmin->ButtonOperation;?>" />
          <?php if($objCoreAdmin->ButtonOperation=="View"){ $SaveCaption="Close";} else {$SaveCaption="Save";}?>
		</td>
        <td width="88%"><input type="submit" id="Save" name="Save" class="btn btn-info" value="<?php echo $SaveCaption;?>" /></td>
	</tr>
</table>
</form>
<?php include "footer.php"?>
