<?php
@session_start();
@ob_start();
include "AdvBooking_view.php";
?>
<style>
.innerBody{
margin-left:10px;margin-right:10px;padding-top:5px;padding-left:5px;padding-right:5px;margin-bottom:10px;padding-bottom:-30px;border:#CCCCCC 1px solid;height:auto;
}
</style>
<div class="content">
	
<div class="content-container">
<div class="entry-head">
	<h4>
		<strong> Profile</strong>
	</h4>
</div>
<div class="entry-content">
	<!-------Customer Personal Details----------->
	<div class="content-container">
		<div class="entry-head"><h4><strong> Personal Details </strong></h4></div>
			<div class="entry-content">	
				<div class="innerBody">
					<p></p>
					<table width="100%" class="table">
				<tr>
					<td width="13%">Customer Name </td>
					<td width="2%"><strong>:</strong></td>
				  <td colspan="4">
				    <strong>
				    <?=$data1["name"]?>
			        </strong></td>
			  </tr>
				<tr>
				  <td>Gender</td>
				  <td><strong>:</strong></td>
				  <td><strong>
			      <?=$data1["gender"]?>
				  </strong></td>
				  <td width="14%" align="left">Age</td>
				  <td width="1%"><strong>:</strong></td>
				  <td width="19%"><strong>
			      <?=$data1["age"]?>
				  </strong></td>
		  </tr>
				<tr>
				  <td>Contact No. </td>
				  <td><strong>:</strong></td>
				  <td>
				    <strong>
				    <?=$data1["mobile"]?>
			        </strong></td>
				  <td>Alternate No. </td>
				  <td><strong>:</strong></td>
				  <td><strong>
			      <?=$data1["alt_no"]?>
				  </strong></td>
		    </tr>
				<tr>
				  <td valign="top">Address</td>
				  <td valign="top"><strong>:</strong></td>
				  <td valign="top"><strong>
			      <?=$data1["address"]?>
				  </strong></td>
				  <td valign="top">Pin Code</td>
				  <td valign="top"><strong>:</strong></td>
				  <td valign="top"><strong>
			      <?=$data1["pincode"]?>
				  </strong></td>
				</tr>
				
				<tr>
				  <td>Comming From</td>
				  <td><strong>:</strong></td>
				  <td><strong>
			      <?=$data1["coming_frm"]?>
				  </strong></td>
				  <td>Purpose</td>
				  <td><strong>:</strong></td>
				  <td><strong>
			      <?=$data1["purpose"]?>
				  </strong></td>
			  </tr>
				<tr>
				  <td>No. of Male</td>
				  <td><strong>:</strong></td>
				  <td><strong>
			      <?=$data1["no_of_male"]?>
				  </strong></td>
				  <td>No. of Female</td>
				  <td><strong>:</strong></td>
				  <td><strong>
			      <?=$data1["no_of_female"]?>
				  </strong></td>
		    </tr>
			</table>	
				</div>
			</div>
		</div>
	<!--------------End----------------->
<?php include "footer.php"?>
</div>
</div>