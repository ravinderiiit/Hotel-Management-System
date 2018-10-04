<?php
@session_start();
@ob_start();

include "header.php"; 
$objCoreAdmin->company_alter();
?>
<script type="text/javascript">
	$(document).ready(function() {                
				$("#FORMNAME1").validate({
                    rules: {
                   
					},
		messages: {
			
					 company_name: "",
					 regsvtax_no: ""
					
								
				},
		  });                
            });
//---auto search-----

function readURL(input) 
{
	
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$("#logo")
				.attr('src', e.target.result);
				
			

		}

		reader.readAsDataURL(input.files[0]);
	}
}			
//---auto search-----
</script>
<div class="content">
<div class="content-header">
<h3 class="head-dashboard">Company Branch Master </h3>
</div>
<div class="content-container">
<div class="entry-head">
<h4><strong>Add Company Branch</strong>
  <div style="color:#FFFFFF; float:right"><a href="company_list.php"><img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"   /></a></div> </h4>

</div>

<div class="entry-content">
<form method="post" id="FORMNAME1" enctype="multipart/form-data">
<table width="100%" class="table table-striped">
	<tr>
	  <td width="10%" height="39">Company  Name </td>
	  <td width="2%"><strong>:</strong></td>
	  <td ><input required type ="text" name="company_name" id="company_name" value="<?php echo $objCoreAdmin->company_name?>" <?php echo $objCoreAdmin->disbableit;?> style="width:98%"/></td>
	  <td width="17%" rowspan="3" style="border: 1px solid black;"><img src="../common/resource/Companies/logo/<?php echo $objCoreAdmin->logo; ?>" style="width:200px;height:80px" id="logo2"/></td>
	  </tr>
	<tr>
	  <td height="39">Reg. No. / VAT No.</td>
	  <td><strong>:</strong></td>
	  <td><input required type ="text" name="regsvtax_no" id="regsvtax_no" value="<?php echo $objCoreAdmin->regsvtax_no?>" <?php echo $objCoreAdmin->disbableit;?>/></td>
	  </tr>
	<tr>
	  <td height="39">Company Logo </td>
	  <td><strong>:</strong></td>
	  <td><input  type="file" name="logo" id="logo" onChange="readURL(this)"/></td>
	  </tr>
	<tr>
		
		<td></td>
		<td>
		<input type="hidden" name="uid" id="uid" value="<?php echo $_REQUEST["uid"];?>" />
          <input type="hidden" name="wid" id="wid" value="<?php echo $_REQUEST["wid"];?>" />
          <input type="hidden" id="ButtonOperation" name="ButtonOperation" class="btn btn-info" value="<?php echo $objCoreAdmin->ButtonOperation;?>" />
          <?php if($objCoreAdmin->ButtonOperation=="View"){ $SaveCaption="Close";} else {$SaveCaption="Save";}?>		</td>
		<td width="71%"><input type="submit" id="Save" name="Save" class="btn btn-info" value="<?php echo $SaveCaption;?>" /></td>
		<td width="17%">&nbsp;</td>
      </tr>
</table>
</form>
<?php include "footer.php"?>
