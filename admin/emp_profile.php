<?php
@session_start();
@ob_start();

include "header.php"; 
//$objCoreAdmin->employeesetup_alter();
echo $_SESSION['userid'];
$str="SELECT * FROM `tbl_employee_master` where id='".$_SESSION['userid']."'";
$query=mysql_query($str);
$row=mysql_fetch_array($query);

?>
<script type="text/javascript">
	$(document).ready(function() {                
				$("#FORMNAME1").validate({
                    rules: {
                   
					},
		messages: {
			
					
								
				},
		  });                
            });
//---auto search-----


</script>
<div class="content">
<div class="content-header">
<h3 class="head-dashboard">Employee Profile</h3>
</div>
<div class="content-container">
<div class="entry-head">
<h4><strong>Employee Details </strong>
   </h4>

</div><?php if($_SESSION['message']!=""){echo $_SESSION['message'];unset($_SESSION['message']);} ?>
 
<div class="entry-content">
<form method="post" id="FORMNAME1" enctype="multipart/form-data">

<table width="100%" class="table table-striped">
	<tr>
	  <td height="39">Employee Code </td>
	  <td><strong>:</strong></td>
	  <td><?php echo $row['emp_code'] ?></td>
	  <td>Employee Image</td>
	  <td rowspan="4" style="border: 1px solid black;"><img src="../common/resource/employee/<?php echo $row['emp_image'] ; ?>" style="width:200px;height:25s0px" id="logo"/></td>
    </tr>
	<tr>
	  <td height="39">Employee Name </td>
	  <td><strong>:</strong></td>
	  <td><?php echo $row['emp_name'] ?></td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td height="39">Department</td>
	  <td><strong>:</strong></td>
	  <td><select name="dept_id" id="dept_id" disabled>
	    <option value="">--Select--</option>
	    <?php  $str="SELECT * FROM  sysdept"; 
	  		 $query=mysql_query($str) ;
	 	while($row2=mysql_fetch_array($query)){ ?>
	    <option value="<?php echo $row2['id']; ?>" <?php if($row2['id']==$row['dept_id']){ ?>selected <?php }?>><?php echo $row2['name'];?></option>
	    <?php }?>
	    </select></td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td height="39">Designation</td>
	  <td><strong>:</strong></td>
	  <td><select name="desg_id" id="desg_id" disabled>
	    <option value="">--Select--</option>
	    <?php  $str="SELECT * FROM  tbl_desg_mstr"; 
	  		 $query=mysql_query($str) ;
	 	while($row2=mysql_fetch_array($query)){ ?>
	    <option value="<?php echo $row2['id']; ?>" <?php if($row2['id']==$row['desg_id']){ ?>selected <?php }?> ><?php echo $row2['designation'];?></option>
	    <?php }?>
	    </select></td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td height="39">Date of Joining  </td>
	  <td><strong>:</strong></td>
	  <td><?php echo date('d-m-Y',$row['doj']) ;?></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  
    </tr>
	<tr>
	  <td height="39">Contact No. </td>
	  <td><strong>:</strong></td>
	  <td><?php echo $row['contact_no'] ?></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
		<td width="9%" height="39">Email Id </td>
		<td width="1%"><strong>:</strong></td>
		<td width="66%"><?php echo $row['email'] ?></td>
		<td width="10%">&nbsp;</td>
		<td width="14%">&nbsp;</td>
    </tr>
	<tr>
	  <td>Date of Birth </td>
	  <td><strong>:</strong></td>
	  <td><?php echo date('d-m-Y',$row['dob']) ;?></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	   <?php if($objCoreAdmin->dob==""){$objCoreAdmin->dob=date('d-m-Y'); } ?>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><a href="index.php" class="btn btn-info">Close</a></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	
</table>
</form>
<?php include "footer.php"?>
