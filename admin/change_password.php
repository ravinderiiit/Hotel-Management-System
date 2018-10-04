<?php
@session_start();
@ob_start();

include "header.php"; 
$objCoreAdmin->change_password();
?>
<script type="text/javascript">
	$(document).ready(function() {                
				$("#FORMNAME1").validate({
                    rules: {
                   
					},
		messages: {
			
					 old_password: "",
					 new_password:"",
					 confirm_password:""
					 
					 
								
				},
		  });                
            });
//---auto search-----
</script>
<div class="content">
<div class="content-header">
<h3 class="head-dashboard">Change Password </h3>
</div><?php if($_SESSION["message"]!=""){echo  $_SESSION["message"]; unset($_SESSION["message"]);} ?>
<div class="content-container">
<div class="entry-head">
<h4><strong></strong>

  <div style="color:#FFFFFF; float:right"><a href="index.php"><img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"   /></a></div> </h4>

</div>

<div class="entry-content">
<form method="post" id="FORMNAME1">
<table width="100%" class="table table-striped">
	<tr>
	  <td height="39">Old Password </td>
	  <td><strong>:</strong></td>
	  <td><input required="required" type ="password" name="old_password" id="old_password" value="" /></td>
    </tr>
	<tr>
	  <td height="39">New Password </td>
	  <td><strong>:</strong></td>
	  <td><input required="required" type ="password" name="new_password" id="new_password" value="" /></td>
    </tr>
	<tr>
		<td width="8%" height="39">Confirm Password </td>
		<td width="3%"><strong>:</strong></td>
		<td width="89%"><input required type ="password" name="confirm_password" id="confirm_password" value="" /></td>
	</tr>
	<tr>
		
		<td></td>
		<td>
		<input type="hidden" name="uid" id="uid" value="<?php echo $_REQUEST["uid"];?>" />
          <input type="hidden" name="wid" id="wid" value="<?php echo $_REQUEST["wid"];?>" />
		 
          <input type="hidden" id="ButtonOperation" name="ButtonOperation" class="btn btn-info" value="New" />
          <?php if($objCoreAdmin->ButtonOperation=="View"){ $SaveCaption="Close";} else {$SaveCaption="Save";}?>		</td>
        <td width="88%"><input type="submit" id="Save" name="Save" class="btn btn-info" value="<?php echo $SaveCaption;?>" /></td>
	</tr>
</table>
</form>
<?php include "footer.php"?>
