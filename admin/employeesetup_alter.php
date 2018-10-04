<?php
@session_start();
@ob_start();

include "header.php"; 
$objCoreAdmin->employeesetup_alter();
?>
<script type="text/javascript">
	$(document).ready(function() {                
				$("#FORMNAME1").validate({
                    rules: {
                   
					},
		messages: {
			
					employee_type: "",
					sysdept_id: "",
					empid: "",
					preveledge: "",
					
					password: "",
					cpassword: ""
					
					 
								
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
</script>
<div class="content">
<div class="content-header">
<h3 class="head-dashboard">employee Setup  Master </h3>
</div>
<div class="content-container">
<div class="entry-head">
<h4><strong>Add employee </strong>
  <div style="color:#FFFFFF; float:right"><a href="employeesetup_list.php"><img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"   /></a></div> </h4>

</div><?php if($_SESSION['message']!=""){echo $_SESSION['message'];unset($_SESSION['message']);} ?>
 
<div class="entry-content">
<form method="post" id="FORMNAME1" enctype="multipart/form-data">

<table width="100%" class="table table-striped">
	<tr>
	  <td height="39">Employee Code </td>
	  <td><strong>:</strong></td>
	  <td><input required type="text" name="emp_code" id="emp_code" value="<?php echo $objCoreAdmin->emp_code ;?>" <?php echo $objCoreAdmin->disbableit ;?>  /></td>
	  <td>Employee Image</td>
	  <td rowspan="4" style="border: 1px solid black;"><img src="../common/resource/employee/<?php echo $objCoreAdmin->emp_image ; ?>" style="width:200px;height:25s0px" id="logo"/></td>
    </tr>
	<tr>
	  <td height="39">Employee Name </td>
	  <td><strong>:</strong></td>
	  <td><input required type="text" name="emp_name" id="emp_name" value="<?php echo $objCoreAdmin->emp_name ;?>" <?php echo $objCoreAdmin->disbableit ;?>></td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td height="39">Department</td>
	  <td><strong>:</strong></td>
	  <td><select name="dept_id" id="dept_id" required <?php echo $objCoreAdmin->disbableit ;?>>
	    <option value="">--Select--</option>
	    <?php  $str="SELECT * FROM  sysdept"; 
	  		 $query=mysql_query($str) ;
	 	while($row=mysql_fetch_array($query)){ ?>
	    <option value="<?php echo $row['id']; ?>" <?php if($row['id']==$objCoreAdmin->dept_id){ ?>selected <?php }?>><?php echo $row['name'];?></option>
	    <?php }?>
	    </select></td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td height="39">Designation</td>
	  <td><strong>:</strong></td>
	  <td><select name="desg_id" id="desg_id" required <?php echo $objCoreAdmin->disbableit ;?>>
	    <option value="">--Select--</option>
	    <?php  $str="SELECT * FROM  tbl_desg_mstr"; 
	  		 $query=mysql_query($str) ;
	 	while($row=mysql_fetch_array($query)){ ?>
	    <option value="<?php echo $row['id']; ?>" <?php if($row['id']==$objCoreAdmin->desg_id){ ?>selected <?php }?> ><?php echo $row['designation'];?></option>
	    <?php }?>
	    </select></td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td height="39">Date of Joining  </td>
	  <td><strong>:</strong></td>
	  <td><input required type="text" name="doj" id="doj" value="<?php echo date('d-m-Y') ;?>" <?php echo $objCoreAdmin->disbableit ;?> class="tcal" style="width:195px"/></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <?php if($objCoreAdmin->doj==""){$objCoreAdmin->doj=date('d-m-Y'); } ?>
    </tr>
	<tr>
	  <td height="39">Contact No. </td>
	  <td><strong>:</strong></td>
	  <td><input required type="text" name="contact_no" id="contact_no" value="<?php echo $objCoreAdmin->contact_no ;?>" <?php echo $objCoreAdmin->disbableit ;?> /></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
		<td width="9%" height="39">Email Id </td>
		<td width="1%"><strong>:</strong></td>
		<td width="66%"><input  type="text" name="email" id="email" value="<?php echo $objCoreAdmin->email ;?>" <?php echo $objCoreAdmin->disbableit ;?> /></td>
		<td width="10%">&nbsp;</td>
		<td width="14%">&nbsp;</td>
    </tr>
	<tr>
	  <td>Date of Birth </td>
	  <td><strong>:</strong></td>
	  <td><input required type="text" name="dob" id="dob" value="<?php echo $objCoreAdmin->dob ;?>" <?php echo $objCoreAdmin->disbableit ;?> class="tcal" style="width:195px"/></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	   <?php //if($objCoreAdmin->dob==""){$objCoreAdmin->dob=date('d-m-Y'); } ?>
    </tr>
	<tr>
	  <td>Employee Image</td>
	  <td><strong>:</strong></td>
	  <td><input  type="file" name="emp_image" id="emp_image" onChange="readURL(this)" <?php echo $objCoreAdmin->disbableit ;?>/></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
		
		<td></td>
		<td>
		<input type="hidden" name="uid" id="uid" value="<?php echo $_REQUEST["uid"];?>" />
          <input type="hidden" name="wid" id="wid" value="<?php echo $_REQUEST["wid"];?>" />
          <input type="hidden" id="ButtonOperation" name="ButtonOperation" class="btn btn-info" value="<?php echo $objCoreAdmin->ButtonOperation;?>" />
          <?php if($objCoreAdmin->ButtonOperation=="View"){ $SaveCaption="Close";} else {$SaveCaption="Save";}?>		</td>
		<td width="66%"><input type="submit" id="Save" name="Save" class="btn btn-info" value="<?php echo $SaveCaption;?>" /></td>
		<td width="10%">&nbsp;</td>
		<td width="14%">&nbsp;</td>
    </tr>
</table>
</form>
<?php include "footer.php"?>
