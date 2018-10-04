<?php
@session_start();
@ob_start();

include "header.php"; 
$objCoreAdmin->designation_alter();
?>
<script type="text/javascript">
	$(document).ready(function() {                
				$("#FORMNAME1").validate({
                    rules: {
                   
					},
		messages: {
			
					department: ""
					
					 
								
				},
		  });                
            });
//---auto search-----
</script>
<div class="content">
<div class="content-header">
<h3 class="head-dashboard">employee Setup  Master </h3>
</div>
<div class="content-container">
<div class="entry-head">
<h4><strong>Add employee </strong>
  <div style="color:#FFFFFF; float:right"><a href="designation_list.php"><img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"   /></a></div> </h4>

</div><?php if($_SESSION['message']!=""){echo $_SESSION['message'];unset($_SESSION['message']);} ?>
 
<div class="entry-content">
<form method="post" id="FORMNAME1">

<table width="100%" class="table table-striped">
	<tr>
	  <td width="17%" height="39">Designation</td>
	  <td width="2%"><strong>:</strong></td>
	  <td><input type="text" required name="designation" id="designation" value="<?php echo $objCoreAdmin->designation;?>"<?php echo $objCoreAdmin->disbableit;?> /> </td>
    </tr>
	<tr>
		
		<td></td>
		<td>
		<input type="hidden" name="uid" id="uid" value="<?php echo $_REQUEST["uid"];?>" />
          <input type="hidden" name="wid" id="wid" value="<?php echo $_REQUEST["wid"];?>" />
          <input type="hidden" id="ButtonOperation" name="ButtonOperation" class="btn btn-info" value="<?php echo $objCoreAdmin->ButtonOperation;?>" />
          <?php if($objCoreAdmin->ButtonOperation=="View"){ $SaveCaption="Close";} else {$SaveCaption="Save";}?>		</td>
        <td width="81%"><input type="submit" id="Save" name="Save" class="btn btn-info" value="<?php echo $SaveCaption;?>" /></td>
	</tr>
</table>
</form>
<?php include "footer.php"?>
