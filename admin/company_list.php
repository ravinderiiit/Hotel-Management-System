<?php
@session_start();
@ob_start();
include "header.php";
?>
<div class="content">
	<div class="content-header">
	<h3 class="head-dashboard">Company Master </h3>
	
	
	</div>
<div class="content-container">
<div class="entry-head">
<h4><strong>Company List</strong>

  <div style="color:#FFFFFF; float:right">
  <div id="ShowHideAddv" style="float:right">
  <a href="company_alter.php"><img src="<?php echo IMAGE_PATH?>add.png" title="Add New Record" width="18" height="18" /></a></div> 
  </div>
</h4>
</div>



<div class="entry-content">
<?php

	$objCoreAdmin->company_list();
?>
<!--<table width="100%" class="border table-stripped">
	<tr>
    	<td width="25%"><strong>Company Name</strong></td>
        <td width="19%"><strong>Street</strong></td>
        <td width="17%"><strong>Road</strong></td>
        <td width="15%"><strong>City</strong></td>
        <td width="8%" align="center"><strong>Edit</strong></td>
        <td width="8%" align="center"><strong>Delete</strong></td>
        <td width="8%" align="center"><strong>View</strong></td>
    </tr>
   
    <tr>
    	<td width="25%"><strong>Company Name</strong></td>
        <td width="19%"><strong>Street</strong></td>
        <td width="17%"><strong>Road</strong></td>
        <td width="15%"><strong>City</strong></td>
        <td width="8%" align="center"><strong>Edit</strong></td>
        <td width="8%" align="center"><strong>Delete</strong></td>
        <td width="8%" align="center"><strong>View</strong></td>
    </tr>
   
</table>-->


<?php include "footer.php"?>
</div>
</div>
</div>
		