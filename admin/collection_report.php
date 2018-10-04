<?php 
include "header.php";
function DateToInt($para=null)
{	
$date=explode("-", $para); 
return mktime(0, 0, 0, ($date[1]), $date[0], $date[2]);
}
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
		<div class="entry-head"><h4><strong>Collection Report </strong></h4></div>
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
			$frmDt=DateToInt($frmDt);
			$toDt=DateToInt($toDt);
			
			$sql="select * from tbl_account where trans_date between '$frmDt' and '$toDt'";
			$res=mysql_query($sql);
			?>
				<!------Query Result---------->
				<div class="content-container" id="printableArea">
					<div class="entry-head"><h4><strong>Collection Report (from date : <?=$_POST["frmdt"]?>  To Date : <?=$_POST["toDt"]?>)</strong></h4></div>
					<div class="entry-content">	
						<table width="100%" class="table table-bordered">
							
							<tr>
								<td style="color:#FFFFFF;background-color:#000000" align="center" width="5%"><strong>#</strong></td>
								<td style="color:#FFFFFF;background-color:#000000" align="center" width="10%"><strong>Date</strong></td>
								<td colspan="2" align="center" style="color:#FFFFFF;background-color:#000000"><strong>Description</strong></td>
                                <td align="center" style="color:#FFFFFF;background-color:#000000" width="18%"><strong>Cashier</strong></td>
								<td width="9%" colspan="-3" align="center" style="color:#FFFFFF;background-color:#000000"><strong>Income (Rs.)</strong></td>
							  <td width="10%" colspan="-3" align="center" style="color:#FFFFFF;background-color:#000000"><strong>Expenses (Rs.)</strong></td>	
							</tr>
							<?php if(mysql_num_rows($res)>0)
							{$count=1;$cr=0;$dr=0;
							while($data=mysql_fetch_array($res))
							{
								$emp=$objCoreFO->getRows("tbl_employee_master","id='".$data["userid"]."'")?>
							<tr>
							  <td align="center"><?=$count;?></td>
							  <td align="center"><?=date('d-m-Y',$data["trans_date"]);?></td>
							  <td colspan="2"><?=$data["narration"]?></td>
                              <td><?=$emp["emp_name"]?></td>
							  <td colspan="-3" align="right"><?=number_format($data["amtdr"],2);$dr+=$data["amtdr"];?></td>
							  <td colspan="-3" align="right"><?=number_format($data["amtcr"],2);$cr+=$data["amtcr"];?></td>
						    </tr>
							<?php $count++;}?>
							<tr>
								<td align="right" colspan="5"><strong>Total</strong></td>
								<td colspan="-3" align="right"><strong><?=number_format($dr,2);?></strong></td>
								<td colspan="-3" align="right"><strong><?=number_format($cr,2);?></strong></td>
							</tr>
                            <tr>
								<td align="right" colspan="5"><span style="color:red"><strong>Closing Balance</strong></span></td>
								<td colspan="3" align="right"><span style="color:red"><strong><?=number_format(round($dr-$cr),2);?></strong></span></td>
							</tr>
							<tr id="p">
							  <td colspan="7" align="center"><input type="button" name="print" id="print" value="Print" class="btn"></td>
						    </tr>
							<?php 
							}else{?>
							<tr>
							  <td colspan="7" align="center"><strong>No Data Found</strong></td>
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
