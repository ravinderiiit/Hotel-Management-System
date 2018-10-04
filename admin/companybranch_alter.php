<?php
@session_start();
@ob_start();

include "header.php"; 
$objCoreAdmin->companybranch_alter();
?>
<script type="text/javascript">
	$(document).ready(function() {                
				$("#FORMNAME1").validate({
                    rules: {
                   
					},
		messages: {
			
					 companybranch_name: "",
					 address1: "",
					 address2: "",
					 address3: "",
					 phone_no: "",
					 reg_no: "",
					 tin_no: "",
					 commas_id:""
								
				},
		  });                
            });
//---auto search-----
</script>
<div class="content">
<div class="content-header">
<h3 class="head-dashboard">Company Branch Master </h3>
</div>
<div class="content-container">
<div class="entry-head">
<h4><strong>Add Company Branch</strong>
  <div style="color:#FFFFFF; float:right"><a href="companybranch_list.php"><img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"   /></a></div> </h4>

</div>

<div class="entry-content">
<form method="post" id="FORMNAME1" enctype="multipart/form-data">
<table width="100%" class="table table-condensed">
	<tr>
	  <td height="39">Company</td>
	  <td><strong>:</strong></td>
	  <td><select required name="company_mstr_id" id="company_mstr_id" <?php echo $objCoreAdmin->disbableit;?>>
      <option value="">--Select--</option>
      <?php $str="SELECT * FROM `tbl_company_mstr` where suspended_status=0";
	  		$query=mysql_query($str);
	  while($row=mysql_fetch_array($query)){ ?>
      <option value="<?php echo $row['id'] ?>"<?php if($objCoreAdmin->company_mstr_id==$row['id']){ ?>selected<?php }?>><?php echo $row['company_name']; ?></option>
      <?php  }?></select></td>
	  </tr>
	<tr>
	  <td height="39">Department</td>
	  <td><strong>:</strong></td>
	  <td><select required name="dept_id" id="dept_id" <?php echo $objCoreAdmin->disbableit;?>>
	    <option value="">--Select--</option>
	    <?php $str="SELECT * FROM `sysdept` where suspended_status=0";
	  		$query=mysql_query($str);
	  while($row=mysql_fetch_array($query)){ ?>
	    <option value="<?php echo $row['id'] ?>"<?php if($objCoreAdmin->dept_id==$row['id']){ ?>selected<?php }?>><?php echo $row['name']; ?></option>
	    <?php  }?>
	    </select></td>
	  </tr>
	<tr>
	  <td height="39">Unit  Name </td>
	  <td><strong>:</strong></td>
	  <td><input required type ="text" name="unit_name" id="unit_name" value="<?php echo $objCoreAdmin->unit_name?>" <?php echo $objCoreAdmin->disbableit;?>/></td>
    </tr>
	<tr>
	  <td height="39">Building No.</td>
	  <td><strong>:</strong></td>
	  <td><input required type ="text" name="building_no" id="building_no" value="<?php echo $objCoreAdmin->building_no?>" <?php echo $objCoreAdmin->disbableit;?>/></td>
    </tr>
	<tr>
	  <td height="39">Street</td>
	  <td><strong>:</strong></td>
	  <td><input required type ="text" name="street" id="street" value="<?php echo $objCoreAdmin->street?>" <?php echo $objCoreAdmin->disbableit;?>/></td>
    </tr>
	<tr>
	  <td height="39">District</td>
	  <td><strong>:</strong></td>
	  <td><input required type ="text" name="district" id="district" value="<?php echo $objCoreAdmin->district?>" <?php echo $objCoreAdmin->disbableit;?>/></td>
    </tr>
	<tr>
	  <td height="39">City</td>
	  <td><strong>:</strong></td>
	  <td><input required type ="text" name="city" id="city" value="<?php echo $objCoreAdmin->city?>" <?php echo $objCoreAdmin->disbableit;?>/></td>
    </tr>
	<tr>
	  <td height="39">State</td>
	  <td><strong>:</strong></td>
	  <td><input required type ="text" name="state" id="state" value="<?php echo $objCoreAdmin->state?>" <?php echo $objCoreAdmin->disbableit;?>/></td>
    </tr>
	<tr>
	  <td height="39">Pincode</td>
	  <td><strong>:</strong></td>
	  <td><input required type ="text" name="pincode" id="pincode" value="<?php echo $objCoreAdmin->pincode?>" <?php echo $objCoreAdmin->disbableit;?>/></td>
    </tr>
	<tr>
		<td width="12%" height="39">Contact No. </td>
		<td width="1%"><strong>:</strong></td>
		<td width="87%"><input required type ="text" name="contact_no" id="contact_no" value="<?php echo $objCoreAdmin->contact_no?>" <?php echo $objCoreAdmin->disbableit;?>/></td>
	</tr>
	<tr>
	  <td height="34">Luxury Tax No.</td>
	  <td><strong>:</strong></td>
	  <td><input required type ="text" name="luxury_tax_no" id="luxury_tax_no" value="<?php echo $objCoreAdmin->luxury_tax_no?>" <?php echo $objCoreAdmin->disbableit;?>/></td>
	  </tr>
	<tr>
	  <td height="34">VAT/TIN No.</td>
	  <td><strong>:</strong></td>
	  <td><input required type ="text" name="vat_tin_no" id="vat_tin_no" value="<?php echo $objCoreAdmin->vat_tin_no?>" <?php echo $objCoreAdmin->disbableit;?>/></td>
	  </tr>
	<tr>
		
		<td></td>
		<td>
		<input type="hidden" name="uid" id="uid" value="<?php echo $_REQUEST["uid"];?>" />
          <input type="hidden" name="wid" id="wid" value="<?php echo $_REQUEST["wid"];?>" />
          <input type="hidden" id="ButtonOperation" name="ButtonOperation" class="btn btn-info" value="<?php echo $objCoreAdmin->ButtonOperation;?>" />
          <?php if($objCoreAdmin->ButtonOperation=="View"){ $SaveCaption="Close";} else {$SaveCaption="Save";}?>		</td>
        <td width="87%"><input type="submit" id="Save" name="Save" class="btn btn-info" value="<?php echo $SaveCaption;?>" /></td>
	</tr>
</table>
</form>
<?php include "footer.php"?>
