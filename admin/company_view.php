<?php
@session_start();
@ob_start();

include "header.php";
if(!isset($_GET['uid'])){
	header("location:company_list.php?page=1&cmd=Clear");
	}
$objCoreAdmin->companyview_alter();
	 
$str="SELECT * FROM `tbl_company_mstr` where md5(id)='".$_GET['uid']."' && suspended_status=0 ";
$query=mysql_query($str);
$row=mysql_fetch_array($query);
$company_name=$row['company_name'];
$regsvtax_no=$row['regsvtax_no'];
$logo=$row['logo'];
$id=$row['id'];



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
<h3 class="head-dashboard">Company Master </h3>
</div>
<div class="content-container"><div class="entry-head">
<h4><strong>Add Company</strong>
  <div style="color:#FFFFFF; float:right"><a href="company_list.php"><img src="<?php echo IMAGE_PATH?>back.png" title="Go Back"   /></a></div> </h4>

</div>
<br/>

<div class="content-container" style="padding:15px;margin-left:10px;margin-right:10px">
			<?php if(isset($_SESSION['message'])){echo $_SESSION['message'];unset($_SESSION['message']);} ?>

			<div class="entry-content">
<form method="post" id="FORMNAME1" enctype="multipart/form-data">
            <div class="content-container" style="padding:15px">
            <table width="100%"  >
                <tr>
                  <td width="10%" height="35">Company  Name </td>
                  <td width="4%" ><div align="center"><strong>:</strong></div></td>
                  <td  width="72%"><?php echo $company_name; ?></td>
                  <td width="14%" rowspan="3"><img src="../common/resource/companies/logo/<?php echo $logo; ?>" style="width:200px;height:80px" id="logo"/></td>
                  </tr>
                <tr>
                  <td height="38"  >Reg. No. / VAT No.</td>
                  <td><div align="center"><strong>:</strong></div></td>
                  <td><?php echo $regsvtax_no; ?></td>
                  </tr>
                <tr>
                  <td height="42" >&nbsp;</td>
                  <td><div align="center"></div></td>
                  <td></td>
                  </tr>
            </table>
            </div>
            <br/>
</form>
<p></p>
<?php if(isset($_POST['Save'])){ ?>
<div class="content-container" style="padding:15px;margin-left:10px;margin-right:10px">

    <form method="POST">
    <?php $str="SELECT * FROM `tbl_company_detl` where company_mstr_id='".$_POST['Check']."'";$count=1;
            $query=mysql_query($str);
            if(mysql_numrows($query)>0){ 
			while($row=mysql_fetch_array($query)){ ?>
    <table width="100%" >
        <tr>
          <td width="10%" height="39">Unit Name</td>
          <td width="1%"><strong>:</strong></td>
          <td width="16%"><input required type ="text" name="unit_name" id="unit_name" value=""/></td>
          <td width="3%">&nbsp;</td>
          <td width="10%" height="39">Building No.</td>
          <td width="1%"><strong>:</strong></td>
          <td width="16%"><input required type ="text" name="building_no" id="building_no" /></td>
          <td width="4%">&nbsp;</td>
          <td width="10%" height="39">Street</td>
          <td width="1%"><strong>:</strong></td>
          <td width="17%"><input required type ="text" name="street" id="street"/></td>
          <td width="6%">&nbsp;</td>
          <td width="5%">&nbsp;</td>
          </tr>
        <tr>
          <td height="39">District</td>
          <td><strong>:</strong></td>
          <td><input required type ="text" name="district" id="district" /></td>
          <td>&nbsp;</td>
          <td height="39">City</td>
          <td><strong>:</strong></td>
          <td><input required type ="text" name="city" id="city" /></td>
          <td>&nbsp;</td>
          <td height="39">State</td>
          <td><strong>:</strong></td>
          <td><input required type ="text" name="state" id="state" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td height="39">Pincode</td>
          <td><strong>:</strong></td>
          <td><input required type ="text" name="pincode" id="pincode" /></td>
          <td>&nbsp;</td>
          <td height="39">Contact No.</td>
          <td><strong>:</strong></td>
          <td><input required type ="text" name="contact_no" id="contact_no" /></td>
          <td>&nbsp;</td>
          <td height="39">Luxury Tax No.</td>
          <td><strong>:</strong></td>
          <td><input required type ="text" name="luxury_tax_no" id="luxury_tax_no" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td height="39">VAT / TIN No.</td>
          <td><strong>:</strong></td>
          <td><input required type ="text" name="vat_tin_no" id="vat_tin_no" /></td>
          <td>&nbsp;</td>
          <td height="39"><input type="submit" name="Save" value="Add" class="btn btn-danger"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td height="39">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
    </table>
    <?php }} ?>
    </form>
   
    </div>
     <?php }?>
</div>

			<?php $str="SELECT * FROM `tbl_company_detl` where company_mstr_id='".$id."'";$count=1;
            $query=mysql_query($str);
            if(mysql_numrows($query)>0){ ?>
                        <div class="content-container" style="padding:10px;margin-left:5px;margin-right:5px">
                        <form method="post">
                        <table width="100%" class="table table-bordered">
                        
                          <tr>
                            <td align="center" style="background-color:#666;color:#FFF" width="2%" ><strong>#</strong></td>
                            <td align="center" style="background-color:#666;color:#FFF" width="30%" ><strong>Unit Name</strong></td>
                            <td align="center" style="background-color:#666;color:#FFF" width="38%"><strong>Address</strong><strong></strong></td>
                            <td align="center" style="background-color:#666;color:#FFF" width="10%"><strong>Contact</strong></td>
                            <td align="center" style="background-color:#666;color:#FFF" width="10%"><strong>Luxury Tax No.</strong></td>
                            <td align="center" style="background-color:#666;color:#FFF" width="10%"><strong>VAT/TIN No.</strong></td>
                            <td align="center" style="background-color:#666;color:#FFF" width="2%"><strong>Delete</strong></td>
                            </tr>
                          <?php while($row=mysql_fetch_array($query)){ ?>
                            <tr>
                              <td align="center"><?php echo $count; ?></td>	
                              <td><?php echo $row['unit_name']; ?></td>
                              <td><?php echo $row['building_no'].", ";  echo $row['street'].", "; echo $row['district'].", ";  echo $row['city'].", ";  echo $row['state'].", ";  echo $row['pincode']; ?></td>
                              <td align="center"><?php echo $row['contact_no']; ?></td>
                              <td align="center"><?php echo $row['luxury_tax_no']; ?></td>
                              <td align="center"> <?php echo $row['vat_tin_no']; ?></td>
                              <td align="center"><input type="checkbox" name="Check"  value="<?php echo $row['id']; ?>" \></td>
                              </tr>
                          <?php $count++;}?>
                          <tr>	<td colspan="6"></td>
                                <td  align="center"><input type="submit" name="Save" value="Edit" class="btn btn-danger"/></td>
                          </tr>
                           
                        </table>
                        <input type="hidden" name="counter" value="<?php echo $count-1; ?>"/>
                        </form>
                        </div>
                        <br/>
            <?php } ?>
</div>

<div class="debug"><?php include "footer.php"?></div>

</div>
</div>


     


