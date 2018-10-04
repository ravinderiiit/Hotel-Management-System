<?php
@session_start();
@ob_start();
include "Customer_view.php";
$objCoreFO->customer_profile();
?>
<?php 
$uid=$_SESSION["custid"];
$data1=$objCoreFO->getRows("tbl_customer_master"," md5(id)='$uid'");
?>

<style>
.innerBody{
margin-left:10px;margin-right:10px;padding-top:5px;padding-left:5px;padding-right:5px;margin-bottom:10px;padding-bottom:-30px;border:#CCCCCC 1px solid;height:auto;
}
</style>
<script>
$(document).ready(function(){
	
	$("#selectAll").click(function(){
			if($(this).is(":checked"))
			{
			$("input[type='checkbox']").attr("checked",true);
			}
			else
			{
			$("input[type='checkbox']").attr("checked",false);
			}
	});

});
</script>
<div class="content">
	
<div class="content-container">
<div class="entry-head">
	<h4>
		<strong> Profile</strong>
	</h4>
</div>
<div class="entry-content">
<form method="post">
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
						  <td colspan="4"><input type="text" name="cust_name" id="cust_name" value="<?=$data1["name"]?>"/></td>
						  <td>&nbsp;</td>
						  <td>Father Name</td>
						  <td><strong>:</strong></td>
						  <td width="23%"><input type="text" name="father_name" id="father_name" value="<?=$data1["father_name"]?>"/></td>
					  </tr>
						<tr>
						  <td>Gender</td>
						  <td><strong>:</strong></td>
						  <td width="23%"><input type="text" name="gender" id="gender" value="<?=$data1["gender"]?>"/></td>
						  <td>Age</td>
						  <td><strong>:</strong></td>
						  <td><input type="text" name="age" id="age" value="<?=$data1["age"]?>" style="width:100%"/></td>
						  <td width="2%">&nbsp;</td>
						  <td width="11%">Nationality</td>
						  <td width="2%"><strong>:</strong></td>
						  <td>
						  <?php $nation=$data1["nation"]?>
					   <select name="nation" id="nation" required>
					  <option value="">--Select Country--</option>
					  <option value="Afghanistan" <?php if("Afghanistan"==$nation){ ?> selected="selected"<?php }?>>Afghanistan</option>
					  <option value="Australia"<?php if("Australia"==$nation){ ?> selected="selected"<?php }?>>Australia</option>
					  <option value="Bangladesh"<?php if("Bangladesh"==$nation){ ?> selected="selected"<?php }?>>Bangladesh</option>
					  <option value="Bhutan"<?php if("Bhutan"==$nation){ ?> selected="selected"<?php }?>>Bhutan</option>
					  <option value="Brazil"<?php if("Brazil"==$nation){ ?> selected="selected"<?php }?>>Brazil</option>
					  <option value="Canada"<?php if("Canada"==$nation){ ?> selected="selected"<?php }?>>Canada</option>
					  <option value="China"<?php if("China"==$nation){ ?> selected="selected"<?php }?>>China</option>
					  <option value="Colombia"<?php if("Colombia"==$nation){ ?> selected="selected"<?php }?>>Colombia</option>
					  <option value="Egypt"<?php if("Egypt"==$nation){ ?> selected="selected"<?php }?>>Egypt</option>
					  <option value="France"<?php if("France"==$nation){ ?> selected="selected"<?php }?>>France</option>
					  <option value="Germany"<?php if("Germany"==$nation){ ?> selected="selected"<?php }?>>Germany</option>
					  <option value="Ghana"<?php if("Ghana"==$nation){ ?> selected="selected"<?php }?>>Ghana</option>
					  <option value="Greenland"<?php if("Greenland"==$nation){ ?> selected="selected"<?php }?>>Greenland</option>
					  <option value="Hong Kong"<?php if("Hong Kong"==$nation){ ?> selected="selected"<?php }?>>Hong Kong</option>
					  <option value="India"<?php if("India"==$nation){ ?> selected="selected"<?php }?>>India</option>
					  <option value="Indonesia"<?php if("Indonesia"==$nation){ ?> selected="selected"<?php }?>>Indonesia</option>
					  <option value="iraq"iraq""<?php if("iraq"==$nation){ ?> selected="selected"<?php }?>>Iraq</option>
					  <option value="Ireland"<?php if("Ireland"==$nation){ ?> selected="selected"<?php }?>>Ireland</option>
					  <option value="Japan"<?php if("Japan"==$nation){ ?> selected="selected"<?php }?>>Japan</option>
					  <option value="Kenya"<?php if("Kenya"==$nation){ ?> selected="selected"<?php }?>>Kenya</option>
					  <option value="Kuwait"<?php if("Kuwait"==$nation){ ?> selected="selected"<?php }?>>Kuwait</option>
					  <option value="Mexico"<?php if("Mexico"==$nation){ ?> selected="selected"<?php }?>>Mexico</option>
					  <option value="Nepal"<?php if("Nepal"==$nation){ ?> selected="selected"<?php }?>>Nepal</option>
					  <option value="New Zealand"<?php if("New Zealand"==$nation){ ?> selected="selected"<?php }?>>New Zealand</option>
					  <option value="Pakistan"<?php if("Pakistan"==$nation){ ?> selected="selected"<?php }?>>Pakistan</option>
					  <option value="Philippines"<?php if("Philippines"==$nation){ ?> selected="selected"<?php }?>>Philippines</option>
					  <option value="Russian Federation"<?php if("Russian Federation"==$nation){ ?> selected="selected"<?php }?>>Russian Federation</option>
					  <option value="Saudi Arabia"<?php if("Saudi Arabia"==$nation){ ?> selected="selected"<?php }?>>Saudi Arabia</option>
					  <option value="Singapore"<?php if("Singapore"==$nation){ ?> selected="selected"<?php }?>>Singapore</option>
					  <option value="South Africa"<?php if("South Africa"==$nation){ ?> selected="selected"<?php }?>>South Africa</option>
					  <option value="Sri Lanka"<?php if("Sri Lanka"==$nation){ ?> selected="selected"<?php }?>>Sri Lanka</option>
					  <option value="United Kingdom"<?php if("United Kingdom"==$nation){ ?> selected="selected"<?php }?>>United Kingdom</option>
					  <option value="United States"<?php if("United States"==$nation){ ?> selected="selected"<?php }?>>United States</option>
					  <option value="Zambia"<?php if("Zambia"==$nation){ ?> selected="selected"<?php }?>>Zambia</option>
					  <option value="Zimbabwe"<?php if("Zimbabwe"==$nation){ ?> selected="selected"<?php }?>>Zimbabwe</option>
					</select>
						  </td>
						  </tr>
						<tr>
						  <td>Contact No. </td>
						  <td><strong>:</strong></td>
						  <td><input type="text" name="mobile" id="mobile" value="<?=$data1["mobile"]?>"/></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>Alternate No. </td>
						  <td><strong>:</strong></td>
						  <td><input type="text" name="alt_no" id="alt_no" value="<?=$data1["alt_no"]?>"/></td>
						  </tr>
						<tr>
						  <td valign="top">Address</td>
						  <td valign="top"><strong>:</strong></td>
						  <td colspan="4" valign="top">
						  <textarea name="address" id="address" style="width:100%;resize:none"><?=$data1["address"]?></textarea>
						  </td>
						  
						  <td valign="top">&nbsp;</td>
						  <td valign="top">Pin Code</td>
						  <td valign="top"><strong>:</strong></td>
						  <td valign="top"><input type="text" name="pincode" id="pincode" value="<?=$data1["pincode"]?>"/></td>
						</tr>
						
						<tr>
						  <td>Comming From</td>
						  <td><strong>:</strong></td>
						  <td><input type="text" name="coming_frm" id="coming_frm" value="<?=$data1["coming_frm"]?>"/></td>
						  <td width="8%">&nbsp;</td>
						  <td width="1%">&nbsp;</td>
						  <td width="15%">&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>Purpose</td>
						  <td><strong>:</strong></td>
						  <td>
						  <select name="purpose" id="purpose">
						  <option value="">Please Select</option>
						  <?php
						  $res=mysql_query("select * from tbl_purpose_mstr where 1");
						  if(mysql_num_rows($res)>0){
							  while($data=mysql_fetch_array($res))
							  {?>
							  <option value="<?=$data["purpose_name"]?>" <?php if($data1["purpose"]==$data["purpose_name"]){?> selected="selected" <?php }?>><?=$data["purpose_name"]?></option>
							  <?php }
						  }?>
					  	  </select>
						  </td>
					  </tr>
						<tr>
						  <td>Male</td>
						  <td><strong>:</strong></td>
						  <td><input type="number" name="no_of_male" id="no_of_male" value="<?=$data1["no_of_male"]?>"/></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>Female</td>
						  <td><strong>:</strong></td>
						  <td><input type="number" name="no_of_female" id="no_of_female" value="<?=$data1["no_of_female"]?>"/></td>
						  </tr>
						<tr>
						  <td colspan="10" align="right"><input type="submit" name="Save1" id="Save1" value="Update" class="btn btn-info" /></td>
					  </tr>
					</table>	
				</div>
			</div>
		</div>
	<!--------------End----------------->
	<br />
	<!-------Customer Guest Details----------->
	<div class="content-container">
		<div class="entry-head"><h4><strong> Guest Details </strong></h4></div>
			<div class="entry-content">	
				<div class="innerBody">
					<p></p>
					<!--<table width="100%" class="table table-striped">
						<tr>
							<th width="3%">#</th>
							<th width="14%" align="left">Romm Type</th>
							<th width="11%">Romm No</th>
							<th width="53%" align="left">Guest Name</th>
							<th width="8%">Age</th>
							<th width="7%">Gender</th>
							<th width="4%"><input type="checkbox" name="selectAll" id="selectAll" title="Select All"></th>
						</tr>
						<?php 
						$sql="select * from tbl_cust_dtls where md5(customer_mas_id)='".$_SESSION["custid"]."' order by id asc";
						$res=mysql_query($sql);
						if(mysql_num_rows($res)>0)
						{$count=1;
							while($data=mysql_fetch_array($res)){
							$sql="select * from view_room_type_floor_dtl_wise where id='".$data["room_dtl_id"]."'";
							$data2=mysql_fetch_array(mysql_query($sql));
						?>
						<tr>
							<td align="center">
							<?=$count?>
							<input type="hidden" name="custDtlId_<?=$count?>" id="custDtlId_<?=$count?>" value="<?=$data["id"]?>" style="width:100%">
							</td>
							<td><?=$data2["room_type"]?></td>
							<td align="center"><?=$data2["room_no"]?></td>
							<td><input type="text" name="guestNm_<?=$count?>" id="guestNm_<?=$count?>" value="<?=$data["guest_name"]?>" style="width:100%"></td>
							<td align="center"><input type="text" name="age_<?=$count?>" id="age_<?=$count?>" value="<?=$data["age"]?>" style="width:100%"></td>
							<td align="center">
							<select name="gender_<?=$count?>" id="gender_<?=$count?>" style="width:100%">
							<option value="Male" <?php if($data["gender"]=="MALE"){?> selected="selected" <?php }?>>Male</option>
							<option value="Female" <?php if($data["gender"]=="FEMALE"){?> selected="selected" <?php }?>>Female</option>
							</select>
							</td>
							<td align="center"><input type="checkbox" name="chk_<?=$count?>" id="chk_<?=$count?>" title="Click Me"></td>
						</tr>
						<?php $count++;}}?>
						<tr>
							<td align="right" colspan="7">
							<input type="hidden" name="counter" id="counter" value="<?=$count?>">
							<input type="submit" name="Save2" id="Save2" value="Update" class="btn btn-info">
							</td>
						</tr>
					</table>-->	
                  <?php if(isset($_SESSION["g_msg"])){echo $_SESSION["g_msg"];unset($_SESSION["g_msg"]);}?>
                  <table id="guest_table" width="100%">
                    	<tr>
                        	<td width="5%">Room no.</td>
                            <td><strong>:</strong></td>
                          <td width="6%">
                            <select name="room_no" id="room_no" style="width:100%">
                            <option value="">Select</option>
                           <?php 
						     $sql="select * from view_cus_mstr_dtl_wise where id='".$data1['id']."'";
						     $res=mysql_query($sql);
							 if(mysql_num_rows($res)>0){while($data=mysql_fetch_array($res)){?>
                            <option value="<?=$data["cust_dtl_id"]."@".$data["id"]?>"><?=$data["room_no"]?></option>
                            <?php }}?>
                            </select>
                            </td>
                        	<td width="8%"><div align="right">Guest Name</div></td>
                            <td><strong>:</strong></td>
                          <td width="20%"><input type="text" name="guest_name" id="g_name" style="width:100%"/></td>
                            <td width="5%"><div align="right">Age</div></td>
                            <td><strong>:</strong></td>
                          <td width="5%"><input type="number" name="guest_age" id="g_age" style="width:100%"/></td>
                            <td width="7%"><div align="right">Gender</div></td>
                            <td><strong>:</strong></td>
                          <td width="8%">
                            <select name="guest_gender" id="g_gender" style="width:100%">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            </select>
                            </td>
                            <td width="8%"><div align="right">Contact No</div></td>
                            <td><strong>:</strong></td>
                          <td width="15%"><input type="number" name="guest_contact" id="g_contact" style="width:100%"></td>
                            <td></td>
                            <td><div align="center">
                              <input type="submit" name="add" id="add" class="btn-success" value="Add"/>
                            </div></td>
                        </tr>
                    </table>
                  <p></p>
                    <?php if(isset($_SESSION["updateMsg"])){echo $_SESSION["updateMsg"];unset($_SESSION["updateMsg"]);}
					$sql="select * from tbl_cust_guest_dtls where cust_mstr_id='".$data1["id"]."' and suspended_status=0";
					$res=mysql_query($sql);
					if(mysql_num_rows($res)>0){$count=1;?>
                  <table width="100%" class="table table-bordered">
                        <tr>
							<th width="4%">#</th>
                            <th width="8%">Room No.</th>
                            <th width="30%"><div align="left">Guest Name</div></th>
                           	<th width="20%">Contact No</th> 
                            <th width="7%">Age</th>
                            <th width="8%">Gender</th>
                            <th width="11%">Modify</th>                      
                        </tr>
                        <?php while($data=mysql_fetch_array($res)){?>
                        <tr>
                        	<td align="center">
							<?=$count;?>
                            <input type="hidden" name="id_<?=$count;?>" id="id_<?=$count;?>" value="<?=$data["id"];?>" style="width:98%"/>
                            </td>
                            <?php 
							$res1=mysql_query("select * from view_cus_mstr_dtl_wise where cust_dtl_id='".$data["cust_dtls_id"]."'");
							$room_data=mysql_fetch_array($res1);?>
                            <td align="center">
                            <?php $post="gv_Save_".$count; 
							  if(isset($_POST[$post]))
							  {
								  if($_POST[$post]!="Edit"){echo $room_data["room_no"];}
								  else{?>
                                             <select name="gv_roomno_<?=$count;?>" id="gv_roomno_<?=$count;?>" style="width:100%">
                                                <option value="">Select</option>
                                               <?php 
                                                 $sql="select * from view_cus_mstr_dtl_wise where id='".$data1['id']."'";
                                                 $resRoom=mysql_query($sql);
                                                 if(mysql_num_rows($resRoom)>0){while($dataRoom=mysql_fetch_array($resRoom)){?>
                                                <option value="<?=$dataRoom["cust_dtl_id"]."@".$dataRoom["id"]?>" <?php if($room_data["room_no"]==$dataRoom["room_no"]){?> selected <?php }?>><?=$dataRoom["room_no"]?></option>
                                                <?php }}?>
                                            </select>
								  <?php }                          
							  }
							  else{echo $room_data["room_no"];}?>
							
                            </td>
                            <td align="left">
                              <?php $post="gv_Save_".$count; 
							  if(isset($_POST[$post]))
							  {
								  if($_POST[$post]!="Edit"){echo $data["guest_name"];}else{?><input type="text" name="gv_name_<?=$count;?>" id="gv_name_<?=$count;?>" value="<?=$data["guest_name"];?>" style="width:98%"/><?php }
                          
							  }
							  else{echo $data["guest_name"];}?>
                            </td>
                            <td align="center">
                            <?php $post="gv_Save_".$count; 
							  if(isset($_POST[$post]))
							  {
								  if($_POST[$post]!="Edit"){echo $data["contact_no"];}else{?><input type="text" name="gv_contact_<?=$count;?>" id="gv_contact_<?=$count;?>" value="<?=$data["contact_no"];?>" style="width:96%;text-align:right"/><?php }
                          
							  }
							  else{echo $data["contact_no"];}?>
							
                            </td>
                            <td align="center">
							<?php $post="gv_Save_".$count; 
							  if(isset($_POST[$post]))
							  {
								  if($_POST[$post]!="Edit"){echo $data["age"];}else{?><input type="number" name="gv_age_<?=$count;?>" id="gv_age_<?=$count;?>" value="<?=$data["age"];?>" style="width:95%" max="100"/><?php }
                          
							  }
							  else{echo $data["age"];}?>
                            </td>
                            <td align="center">
							<?php $post="gv_Save_".$count; 
							  if(isset($_POST[$post]))
							  {
								  if($_POST[$post]!="Edit"){echo $data["gender"];}else{?>
                                 
								  
								  <select name="gv_gender_<?=$count;?>" id="gv_gender_<?=$count;?>" style="width:95%">
                                    <option value="Male" <?php if($data["gender"]=="Male"){?> selected <?php }?>>Male</option>
                                    <option value="Female" <?php if($data["gender"]=="Female"){?> selected <?php }?>>Female</option>
                                  </select>
								  
								  <?php }
                          
							  }
							  else{echo $data["gender"];}?>
							
                            </td>
                            <td align="center">
                            <?php 
							$post="gv_Save_".$count;$caption="Edit";$caption2="Delete"; 
							if(isset($_POST[$post]))
							{
								if($_POST[$post]=="Edit"){$caption="Update";$caption2="Cancel";}else{$caption="Edit";$caption2="Delete";}
							}
							?>
                            <input type="submit" name="gv_Save_<?=$count;?>" id="gv_Save_<?=$count;?>" value="<?=$caption;?>" class="btn btn-warning"/>
                            <input type="submit" name="gv_Save_<?=$count;?>" id="gv_Save_<?=$count;?>" value="<?=$caption2;?>" class="btn btn-danger"/>
                            </td>
                        </tr>
                        <?php $count++;}?>
                    </table>
                    <input type="hidden" name="g_counter" id="g_counter" value="<?=$count?>">
                    <?php }?>
                  <p></p>
			  </div>
			</div>
		</div>
	<!--------------End----------------->
</form>
<?php include "footer.php"?>
</div>
</div>