<?php
@session_start();
@ob_start();

include "table_order_master.php";
$objCoreRes->search_kot();



?>

<form method="post">

<div class="panel-heading"><strong>TABLE ORDER LIST </strong> <div style="float:right">&nbsp;&nbsp;<a href="tableorder_alter.php"><strong>Add</strong></a></div></div>
<div class="panel">
<table width="100%">
		<tr>
        		<td width="6%" height="37"> KOT No. </td>
                <td width="1%"><strong>:</strong></td>
                <td width="93%"><input type="text" name="kotsearch" id="kotsearch" value=""/></td>
      </tr>
        <tr>
   		  <td height="34">&nbsp; </td>
          <td>&nbsp;</td>
                <td><input type="submit" name="Save" id="submitbutton" value="Search" class="btn btn-info" /></td>
        </tr>
</table>
</div>

</div>
</div>
</form>


<?php include "footer.php"?>
