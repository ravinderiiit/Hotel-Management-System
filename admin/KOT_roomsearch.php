<?php
@session_start();
@ob_start();
include "header.php";
$s="select * from tbl_order_details where md5(kot)='".$_GET['uid']."' group by kot";
$q=mysql_query($s);
$r=mysql_fetch_assoc($q);
$s2="SELECT * FROM `tbl_order_master` where md5(id)='".$_GET['wid']."'";
$q2=mysql_query($s2);
$r2=mysql_fetch_array($q2);
$rpt_id =$r2['rpt_id'];
$cust_no_name=$r2['cust_no_name'];
?>
<script type="text/javascript">
$(document).ready(function() {                
$("#FORMNAME1").validate({
rules: {

},
messages: {
			



},
});                



$("#P").click(function(){

var originalContent=$("body").html();
$(this).hide();
$("#Pi").hide();

var pArea=$("#printableArea").html();
$("body").html(pArea);
window.print();
$("body").html(originalContent);
});
});		   
//---auto search-----
</script>
<div class="content">
	<div class="content-header">
	<h3 class="head-dashboard">&nbsp;</h3>
	
	
	</div>
<div class="content-container">
<div class="entry-head">
<h4>
 KOT Print
  
</h4>
</div>



<div class="entry-content" id="printableArea"  >
<div style="margin:0px 30% 0px 30%">

						  <div align="center"><strong>
                          <span style="font-size:large">
                          <img src="../common/images/hga_logo.png" align="absmiddle" width="40">&nbsp;&nbsp;HOTEL GANGA ASHRAM</span></strong> 
						  <br />   
						  <p></p>
						  <p>Kutchery Road, Ranchi - 834001, Jharkhand,India Phone: +(91)-651-2215514</p>
						  </div>
<table width="21%" class="table table-stripped">
	
	
	<tr>
	  <td colspan="4">
      			<table width="100%" >
                	<tr>
                			<td width="15%" style="background:#999;color:#FFF"><strong>KOT No.</strong></td>
                            <td width="1%" style="background:#999;color:#FFF"><strong>:</strong></td>
                            <td width="15%" style="background:#999;color:#FFF"><?php echo $r['kot'];  ?></td>
                            <td width="23%" style="background:#999;color:#FFF"><strong>&nbsp;</strong></td>
                            <td width="17%" style="background:#999;color:#FFF" align="right"><strong>KOT Date</strong></td>
                            <td width="1%" style="background:#999;color:#FFF"><strong>:</strong></td>
                            <td width="28%" style="background:#999;color:#FFF"><?php echo date('d-m-Y h:i A',$r['order_datetime']); ?></td>
                    </tr>
                </table>
       </td>
	  </tr>
	
	<tr style="background:#666666;color:#FFFFFF" >
	  <td width="2%">#</td>
	  <td width="85%">Item name </td>
	  <td width="10%" align="center">Rate </td>
	  <td width="3%" align="center">Qty</td>
	  </tr>
      
	<?php  
	
	$str="SELECT * FROM `view_order_details` where kot='".$r['kot']."'";
		  $query=mysql_query($str);$count=1;
		  while($row=mysql_fetch_array($query))
	 {
		 ?>
   
	<tr <?php if($row['suspended_status']==1){?> style="text-decoration:line-through;color:#F00" <?php }?>>
     
	  <td><?php echo $count ;?></td>
	  <td><?php echo $row['item_name']; ?></td>
	  <td align="right"><?php echo $row['rate']; ?></td>
	  <td align="center"><?php echo $row['qty']; ?></td>
     </tr>
      
       
	 <?php $count++; 
	 $room_no=$row['room_no'];}?>
     <tr>
     	<td colspan="4">
        	<table width="100%">
            	<tr>
                	<td width="22%"  style="background:#999;color:#FFF"><strong>Room No.</strong></td>
                    <td width="4%"  style="background:#999;color:#FFF"><strong>:</strong></td>
                    <td width="10%"  style="background:#999;color:#FFF"><strong><?php  $s3="SELECT * FROM `view_cus_mstr_dtl_wise` where id='".$rpt_id."' and cust_dtl_id='".$cust_no_name."'";
							$q3=mysql_query($s3);
							$r3=mysql_fetch_array($q3); echo $r3['room_no']; ?></strong></td>
                    <td width="17%"  style="background:#999;color:#FFF"><strong>&nbsp;</strong></td>
                    <td width="23%"  style="background:#999;color:#FFF"><strong>Waiter</strong></td>
                    <td width="5%"  style="background:#999;color:#FFF"><strong>:</strong></td>
                    <td width="19%"  style="background:#999;color:#FFF"><strong><?php $s2="SELECT * FROM `tbl_employee_master` where id='".$r['emp_id']."'";
					$q2=mysql_query($s2);
					$r2=mysql_fetch_array($q2); 
					echo $r2['emp_name'];?></strong></strong></td>
                </tr>
            </table>
        </td>
        
     </tr>
</table>
</div>
<p align="center" id="Pi"><input type="button" name="Save" value="Print" id="P" class="btn btn-danger"/> &nbsp;&nbsp;<a href="KOT_search.php" class="btn btn-danger">Home</a> </p>
<?php include "footer.php"?>
</div>
</div>
</div>
		