<?php
@session_start();
@ob_start();
include "header.php";
?>
<div class="content">
	<div class="content-header">
	<h3 class="head-dashboard">Menu Master </h3>
	
	
	</div>
<div class="content-container">
<div class="entry-head">
<h4><strong>Menu List</strong>

  <div style="color:#FFFFFF; float:right">
  <div id="ShowHideAddv" style="float:right">
  <a href="Menu_alter.php"><img src="<?php echo IMAGE_PATH?>add.png" title="Add New Record" width="18" height="18" /></a></div> 
  </div>
</h4>
</div>



<div class="entry-content">
<?php
if(isset($_SESSION["message"])){echo $_SESSION["message"];unset($_SESSION["message"]);}
$objCoreAdmin->menu_list();
?>

<?php include "footer.php"?>
</div>
</div>
</div>
		