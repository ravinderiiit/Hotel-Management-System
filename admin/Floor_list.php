<?php
@session_start();
@ob_start();
include "header.php";
?>
<div class="content">
	<div class="content-header">
	<h3 class="head-dashboard">Floor Master </h3>
	
	
	</div>
<div class="content-container">
<div class="entry-head">
<h4><strong>Floor List</strong>

  <div style="color:#FFFFFF; float:right">
  <div id="ShowHideAddv" style="float:right">
  <a href="Floor_alter.php"><img src="<?php echo IMAGE_PATH?>add.png" title="Add New Record" width="18" height="18" /></a></div> 
  </div>
</h4>
</div>



<div class="entry-content">
<?php

$objCoreAdmin->floor_list();
?>

<?php include "footer.php"?>
</div>
</div>
</div>
		