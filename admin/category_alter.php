<?php
@session_start();
@ob_start();

include "header.php"; 
$objCoreRes->category_alter();
?>
<script type="text/javascript">
	$(document).ready(function() {                
				$("#FORMNAME1").validate({
                    rules: {
                   
					},
		messages: {
			
					 category_name: ""
					 
								
				},
		  });                
            });
//---auto search-----
</script>
<div class="content">
<div class="content-header">
<h3 class="head-dashboard">Category Master </h3>
</div><?php if(isset($_SESSION["message"])){ echo $_SESSION["message"]; unset($_SESSION["message"]);} ?>
<div class="content-container">
<div class="entry-head">
<h4><strong>Add Category</strong>
  <div style="color:#FFFFFF; float:right"><a href="category_list.php"><img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"   /></a></div> </h4>

</div>

<div class="entry-content">
<form method="post" id="FORMNAME1">
<table width="100%" class="table table-striped">
	<tr>
		<td width="14%" height="39">Category Name </td>
		<td width="2%"><strong>:</strong></td>
	  <td width="84%"><input required type ="text" name="category_name" id="category_name" value="<?php echo $objCoreRes->category_name?>" <?php echo $objCoreRes->disbableit;?>/></td>
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
