<?php 
include "header.php";
?>
<style>
.innerBody{margin-left:20px;margin-right:20px;padding-top:10px;padding-left:5px;padding-right:5px;margin-bottom:10px;padding-bottom:10px;border:#CCCCCC 1px solid;height:auto;}
</style>
<script>
$(document).ready(function(){
	$("#print").click(function(){
	var originalContent=$("body").html();
	$(this).hide();
	$("#p").hide();
	var pArea=$("#printableArea").html();
	$("body").html(pArea);
	window.print();
	$("body").html(originalContent);
	});
});
</script>
<div class="content">
	<div class="content-header">
	<h3 class="head-dashboard">Report</h3>
 	</div>
	<div class="content-container">
		<div class="entry-head"><h4><strong>Booking Status Report</strong></h4></div>
			<div class="entry-content">
			<form method="post">
			<table width="100%" class="table">
				<tr>
					<td width="22%">&nbsp;</td>
					<td width="7%">From date</td>
					<td width="1%"><strong>:</strong></td>
				  <td width="12%"><input type="text" name="frmdt" id="frmdt" class="tcal" style="width:100%" readonly value="<?=date('d-m-Y')?>"/></td>
					<td width="9%"><div align="right">To Date</div></td>
					<td width="1%"><strong>:</strong></td>
				  <td width="12%"><input type="text" name="toDt" id="toDt" class="tcal" style="width:100%" readonly value="<?=date('d-m-Y')?>"/></td>
					<td width="0%"></td>
				    <td width="28%"><input type="submit" name="Search1" id="Search" value="Search" class="btn btn-info"/></td>
			      <td width="8%">&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td></td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td colspan="2"></td>
				  <td>&nbsp;</td>
			  </tr>
			</table>
			
			<?php if(isset($_POST["Search1"]))
			{
			$frmDt=$_POST["frmdt"];
			$toDt=$_POST["toDt"];
			$frmDt=$objCoreFO->DateToInt($frmDt);
			$toDt=$objCoreFO->DateToInt($toDt);
			
			$sql="select tbl_customer_master.id
				,tbl_customer_master.name
				,tbl_cust_dtls.room_dtl_id
				,view_room_type_floor_dtl_wise.room_type
				,view_room_type_floor_dtl_wise.room_no
				,tbl_customer_master.stampdate
				from tbl_customer_master
				left join tbl_cust_dtls on tbl_cust_dtls.customer_mas_id=tbl_customer_master.id
				left join view_room_type_floor_dtl_wise on view_room_type_floor_dtl_wise.id=tbl_cust_dtls.room_dtl_id
where tbl_customer_master.stampdate>='$frmDt' and tbl_customer_master.stampdate<='$toDt'";
			$res=mysql_query($sql);
			?>
				<!------Query Result---------->
				<div class="content-container" id="printableArea">
					<div class="entry-head"><h4><strong>Booking Status Report (from date : <?=$_POST["frmdt"]?>  To Date : <?=$_POST["toDt"]?>)</strong></h4></div>
					<div class="entry-content">	
						<table width="100%" class="table table-bordered">
							<tr>
								<td style="color:#FFFFFF;background-color:#000000" align="center" width="4%"><strong>#</strong></td>
								<td style="color:#FFFFFF;background-color:#000000" align="center" width="9%"><strong>Booking date</strong></td>
								<td width="16%" align="center" style="color:#FFFFFF;background-color:#000000"><div align="left"><strong>Room Type</strong></div></td>
								<td width="8%" align="center" style="color:#FFFFFF;background-color:#000000"><div align="center"><strong>Room No.</strong></div></td>
								<td width="20%" align="center" style="color:#FFFFFF;background-color:#000000"><div align="center"><strong>Booked by</strong> </div></td>
							</tr>
							<?php if(mysql_num_rows($res)>0)
							{$count=1;
							while($data=mysql_fetch_array($res))
							{?>
							<tr>
							  <td align="center"><?=$count;?></td>
							  <td align="center"><?=$objCoreFO->IntToDate($data["stampdate"]);?></td>
							  <td><?=$data["room_type"];?></td>
							  <td><div align="center">
							    <?=$data["room_no"];?>
						      </div></td>
							  <td><div align="left">
							    <?=$data["name"];?>
						      </div></td>
							 
							  
						    </tr>
							<?php $count++;}?>
							<tr id="p">
							  <td colspan="8" align="center"><input type="button" name="print" id="print" value="Print" class="btn"></td>
						    </tr>
							<?php 
							}else{?>
							<tr>
							  <td colspan="8" align="center"><strong>No Data Found</strong></td>
						    </tr>
							<?php }?>
						</table>
					</div>
				</div>
				<!--------End---------------->
			<?php }?>
		   </form>		
<?php include "footer.php"?>
	</div>
</div>
