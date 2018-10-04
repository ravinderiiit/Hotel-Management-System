<?php
@session_start();
@ob_start();
include "employesetup_main.php";
?>
<div class="span10">
<div class="panel"><div class="panel-heading"><strong>Employee List<div style="float:right"><a href="employeesetup_alter.php">Add</a></div></strong></div>

<?php 
$_SESSION["where"]="suspended_status=0";
if(isset($_POST["Search"])){$_SESSION["where"]=" user_type like('%".$_POST["search"]."%') or preveledge like('%".$_POST["search"]."%') or emailid and suspended_status=0";}
$objCoreAdmin->employeesetup_list()?>
</div></div>

<?php include "footer.php"?>
</div>
</div>
</div>
		