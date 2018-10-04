<?php
@session_start();
@ob_start();
include "employesetup_main.php";
?>
<div class="span10">
<div class="panel"><div class="panel-heading"><strong>Employee List<div style="float:right"><a href="#">Add</a></div></strong></div>
<?php $objCoreAdmin->employesetup_list();?>
</div></div>

<?php include "footer.php"?>
</div>
</div>
</div>
		