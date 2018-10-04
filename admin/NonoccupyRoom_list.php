<?php
@session_start();
@ob_start();
include "header.php";
?>


<div class="content">
	<div class="content-header">
	<h3 class="head-dashboard">Non-Occupied Rooms</h3>
	
	
	</div>
<div class="content-container">
<div class="entry-head">
<h4><strong>Room List</strong>
<div style="color:#FFFFFF; float:right">
   
</h4>

</div>

<div class="entry-content">
<?php $objCoreFO->NonoccupyRoom_list();?>
<?php include "footer.php"?>
</div>
</div>
</div>
		