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
					emailid: "",
					password: "",
					cpassword: ""
					
					 
								
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
  <div style="color:#FFFFFF; float:right"><a href="employesetup_list.php"><img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"   /></a></div> </h4>

</div><?php if($_SESSION['message']!=""){echo $_SESSION['message'];unset($_SESSION['message']);} ?>
 
<div class="entry-content">
<form method="post" id="FORMNAME1">

<table width="100%" class="table table-striped">
	<tr>
	  <td height="39">employee Type </td>
	  <td><strong>:</strong></td>
	  <td><select name="employee_type" required id="employee_type">
	   <option value="">--Select--</option>
	   <?php  $str="SELECT * FROM  tbl_employee_type"; 
	  		 $query=mysql_query($str) ;
	 	while($row=mysql_fetch_array($query)){ ?>
	  <option value="<?php echo $row['employee_type']; ?>"><?php echo $row['employee_type'];?></option>
	  <?php }?>
	  </select></td>
    </tr>
	<tr>
	  <td height="39">System Department </td>
	  <td><strong>:</strong></td>
	  <td><select name="sysdept_id" required id="sysdept_id">
	  <option value="">--Select--</option>
	  <?php  $str="SELECT * FROM  sysdept"; 
	  		 $query=mysql_query($str) ;
	 	while($row=mysql_fetch_array($query)){ ?>
	  <option value="<?php echo $row['id']; ?>"><?php echo $row['name'];?></option>
	  <?php }?>
	  </select></td>
    </tr>
	<tr>
	  <td height="39">Employee </td>
	  <td><strong>:</strong></td>
	  <td><select name="empid" id="empid" required>
	  <option value="">--Select--</option>
	  <option value="1">Name</option>
	  </select></td>
    </tr>
	<tr>
	  <td height="39">Previlage </td>
	  <td><strong>:</strong></td>
	  <td><select name="preveledge" id="preveledge" required>
	  <option value="">--Select--</option>
	  <?php  $str="SELECT * FROM  tbl_employee_type"; 
	  		 $query=mysql_query($str) ;
	 	while($row=mysql_fetch_array($query)){ ?>
	  <option value="<?php echo $row['employee_type']; ?>"><?php echo $row['employee_type'];?></option>
	  <?php }?>
	  </select></td>
    </tr>
	<tr>
	  <td height="39">Email ID </td>
	  <td><strong>:</strong></td>
	  <td><input required type="text" name="emailid" id="emailid" value="" /></td>
    </tr>
	<tr>
	  <td height="39">Password</td>
	  <td><strong>:</strong></td>
	  <td><input required="required" type="password" name="password" id="password" value="" /></td>
    </tr>
	<tr>
		<td width="17%" height="39">Confirm Password </td>
		<td width="2%"><strong>:</strong></td>
		<td width="81%"><input required="required" type="password" name="cpassword" id="cpassword" value="" /></td>
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
