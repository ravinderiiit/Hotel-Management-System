<?php
@session_start();
@ob_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
include "localinclude.php";
?>
<style>
.innerBody{margin-left:20px;margin-right:20px;margin-bottom:10px;padding:2%;border:#000000 1px solid;height:auto;}
.innerBody1{margin-left:20px;margin-right:20px;padding-top:5px;padding-left:10px;padding-right:10px;margin-bottom:10px;padding-bottom:25px;height:auto;}

</style>
<div>
	<p></p>
			<div class="innerBody1">
            	<div class="innerBody">
                <table width="100%" class="table table-stripped">
                        <tr>
                        	<th align="left" colspan="5"><h2 style="color:black">Non Occupied Room List</h2></th>
                        </tr>
                        <tr>
                            <th width="5%">#</th>
                            <th width="40%" align="left">Room Type</th>
                            <th width="10%" align="right">Rate</th>
                            <th width="8%">Room No</th>
                            <th width="12%">On Floor</th>
                        </tr>
                        <?php 
                        $where="id NOT IN (select room_dtl_id from tbl_cust_dtls where chkout_status='1')";
                        $sql="select * from view_room_type_floor_dtl_wise where ".$where;
                        $res=mysql_query($sql);
                        if(mysql_num_rows($res)>0)
                        {$count=1;
                            while($data=mysql_fetch_array($res)){?>
                        <tr>
                            <td align="center"><?=$count;?></td>
                            <td align="left"><?=$data["room_type"];?></td>
                            <td align="right"><?=number_format($data["rate"],2);?></td>
                            <td align="center"><?=$data["room_no"];?></td>
                            <td align="right"><?=$data["floor_name"];?></td>
                        </tr>
                        <?php $count++;}}?>
				</table>
                </div>
            </div>

</div>