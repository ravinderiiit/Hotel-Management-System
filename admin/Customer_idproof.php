<?php
@session_start();
@ob_start();
include "Customer_view.php";
$objCoreFO->customer_idproof();
?>
<?php 

$uid=$_SESSION["custid"];
$mstrres=mysql_query("select * from tbl_customer_master where md5(id)='$uid'");
//$data1=mysql_fetch_array($res1);
$mstrData=mysql_fetch_array($mstrres);
?>
 <style>
  
  </style>
<style>
.innerBody{
margin-left:10px;margin-right:10px;padding-top:5px;padding-left:5px;padding-right:5px;margin-bottom:10px;padding-bottom:-30px;border:#CCCCCC 1px solid;height:auto;
}

.modal-header, h4, .close {
      background-color: #5cb85c;
      color:white !important;
      text-align: center;
	  font-weight:bold;
      font-size: 14px;
  }
  .modal-footer {
      background-color: #f9f9f9;
  }
</style>
<script type="text/javascript">
function readURL1(input,ids) 
{
	
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$(ids)
				.attr('src', e.target.result);
				var slc=ids.split("_");
				if(slc[0]=="#image1")
				{
					var imgmodal="#img1_" + slc[1];
					$(imgmodal)
					.attr('src', e.target.result);
				}
				else if(slc[0]=="#image2")
				{
					var imgmodal="#img2_" + slc[1];
					$(imgmodal)
					.attr('src', e.target.result);
				}
			

		}

		reader.readAsDataURL(input.files[0]);
	}
}
$(document).ready(function(){
	$("input[type='button']").click(function(){
		var count=$(this).attr('id');
		//alert(count);
		var btn1,btn2,slices,namefile;
		slices=count.split("_");
		if(slices[0]=="btn1"){namefile="file1_" + slices[1];}
		if(slices[0]=="btn2"){namefile="file2_" + slices[1];}
		//alert(namefile);
		$("#" + namefile).click();
		});
		
	$("input[type='file']").change(function(){
		var sliced=($(this).attr('id')).split("_");
		var name=sliced[0],ids=sliced[1],imgName;
		if(name=="file1"){imgName="#image1_" + ids;}
		if(name=="file2"){imgName="#image2_" + ids;}
		readURL1(this,imgName);
	});
	
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
		<strong> Customer Identity Details </strong>
	</h4>
</div>
<div class="entry-content">
<form method="post" enctype="multipart/form-data">
<?php if(isset($_SESSION["message"])){echo $_SESSION["message"];unset($_SESSION["message"]);}?>
	<!-------Customer Details----------->
		<!--<div class="innerBody">
			<p></p>
			<table width="100%" class="table">
				<tr>
				  <td width="90">Front Side </td>
				  <td width="5"><strong>:</strong></td>
				  <td width="507"><input type="file" name="frontside" id="frontside" onchange="readURL1(this)"/></td>
				  <td width="315">&nbsp;</td>
			      <td width="106">Back Side </td>
			      <td width="12"><strong>:</strong></td>
			      <td width="218"><input type="file" name="backside" id="backside" onchange="readURL2(this)"/></td>
			  </tr>
			  <tr>
				  <td colspan="3" align="right" valign="middle" width="50%">
				  <?php if($data1["image1"]!=""){$src1="resource/idproof/".$data1["image1"];}else{$src1="resource/idlogo.jpg";}?>
				  <img src=<?=$src1;?> style="width:30%;height:30%" id="img1">
				  </td>
				  <td colspan="4" align="left" valign="middle" width="50%">
				  <?php if($data1["image2"]!=""){$src2="resource/idproof/".$data1["image2"];}else{$src2="resource/idlogo.jpg";}?>
				  <img src=<?=$src2;?> style="width:30%;height:30%" id="img2">
				  </td>
			  </tr>
				<tr>
				  <td height="32" colspan="7" align="center"><input type="submit" name="Save" id="Save" value="Save" class="btn btn-info"></td>
			  </tr>
			</table>	
			<p></p>
		</div>-->
	<!--------------End----------------->
    
    <!-------Customer Details----------->
		<div class="innerBody">
			<p></p>
			<table width="100%" class="table table-bordered">
				<tr>
                  <td width="3%" align="center" style="background-color:#006633;color:#FFFFFF"><strong>#</strong></td>
				  <td width="5%" align="center" style="background-color:#006633;color:#FFFFFF"><strong>Room No.</strong></td>
                  <td width="40%" align="left" style="background-color:#006633;color:#FFFFFF"><strong>Guest Name</strong></td>
                  <td width="10%" colspan="2" style="background-color:#006633;color:#FFFFFF"><div align="center"><strong>Front Side</strong></div></td>
                  <td width="10%" colspan="2" style="background-color:#006633;color:#FFFFFF"><div align="center"><strong>Back Side</strong></div></td>
                  <td width="1%" align="center" style="background-color:#006633;color:#FFFFFF"><input type="checkbox" name="selectAll" id="selectAll" title="Select All"/></td>
			   </tr>
               <?php 
			  	$sql="select * from tbl_cust_guest_dtls where cust_mstr_id='".$mstrData["id"]."' and suspended_status=0";
				$guestRes=mysql_query($sql);
				if(mysql_num_rows($guestRes)>0){$count=1;
				while($guestData=mysql_fetch_array($guestRes))
				{
					
					
					$roomData=mysql_fetch_array(mysql_query("select * from view_cus_mstr_dtl_wise where cust_dtl_id='".$guestData["cust_dtls_id"]."'"));
				?>
               <tr>
                <td align="center">
				<?=$count;?>
                
                <input type="hidden" name="id_<?=$count;?>" id="id_<?=$count;?>" value="<?=$guestData["id"]?>" style="width:95%"/>
                </td>
               	<td align="center"><?=$roomData["room_no"];?></td>
                <td><?=$guestData["guest_name"];?>
                <p></p>
                <a onClick="PopupCenter('idProof_search.php?uid=<?=md5($guestData['id'])?>','Id Proof Search','1000px','500px')" class="btn" style="margin-top:30px">Search</a>
                </td>
                <td align="center" width="9%">
                <?php if($guestData["id_proof_front"]==""){$source="idlogo.jpg";}else{$source="idproof/".$guestData["id_proof_front"];}?>
                <a href="#myModal_front_<?=$count;?>" data-toggle="modal">
                <img id="image1_<?=$count;?>" src="../common/resource/<?=$source;?>" style="width:60px;height:80px;border:1px solid black"/>
                </a>
                <!-- Modal -->
                 <div class="modal fade" id="myModal_front_<?=$count;?>" role="dialog">
                 	<div class="modal-dialog">
                    	<!-- Modal content-->
                      	<div class="modal-content">
                            <div class="modal-header">ID Proof 1</div>
                            <div class="modal-body">
                            <img id="img1_<?=$count;?>" src="../common/resource/<?=$source;?>" style="width:300px;height:300px"/>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-danger btn-danger pull-left" 
                              data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                            </div>
                        </div>
                        <!-- Modal content end-->
                    </div>
                 </div>
                <!-- Modal end -->
                
                
                </td>
                <td align="center" width="1%">
               <input type="button" name="image1_<?=$count;?>" id="btn1_<?=$count;?>" value="..." class="btn btn-primary" 
                    title="Click to open file" style="font-weight:bold"/>
                    
               <input type="file" name="file1_<?=$count;?>" id="file1_<?=$count;?>" style="display:none"/>
                </td>
                
                <td width="9%" align="center" valign="bottom">
                <?php if($guestData["id_proof_back"]==""){$source="idlogo.jpg";}else{$source="idproof/".$guestData["id_proof_back"];}?>
               <a href="#myModal_back_<?=$count;?>" data-toggle="modal">
                <img id="image2_<?=$count;?>" src="../common/resource/<?=$source;?>" style="width:60px;height:80px;border:1px solid black"/>
               </a>
                <!-- Modal -->
                 <div class="modal fade" id="myModal_back_<?=$count;?>" role="dialog">
                 	<div class="modal-dialog">
                    	<!-- Modal content-->
                      	<div class="modal-content">
                            <div class="modal-header">ID Proof 2</div>
                            <div class="modal-body">
                            <img id="img2_<?=$count?>" src="../common/resource/<?=$source;?>" style="width:300px;height:300px"/>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-danger btn-danger pull-left" 
                              data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
                            </div>
                        </div>
                        <!-- Modal content end-->
                    </div>
                 </div>
                <!-- Modal end -->
                
                </td>
                <td align="right" valign="bottom" width="1%">
                <input type="button" name="image2_<?=$count;?>" id="btn2_<?=$count;?>" value="..." class="btn btn-info" title="Click to open file" style="font-weight:bold"/>
                <input type="file" name="file2_<?=$count;?>" id="file2_<?=$count;?>" style="display:none"/>
                </td>
                <td align="center">
                 <input type="checkbox" name="chk_<?=$count;?>" id="chk_<?=$count;?>" title="Click Me"/>
                </td>
               </tr>
              <?php $count++;
			    }
			    ?> 
              <tr>
              	<td colspan="8" align="right">
                <?php $caption1="Update";$caption2="Remove";?>
                <input type="submit" name="Save" id="Save" value="<?=$caption1?>" class="btn btn-warning"/>
                <input type="submit" name="Save" id="Save" value="<?=$caption2?>" class="btn btn-danger"/>
                </td>
              </tr>
              <?php }?>
			</table>
            <input type="hidden" name="gv_counter" id="gv_counter" value="<?=$count;?>"/>	
			<p></p>
		</div>
	<!--------------End----------------->
</form>	
<?php include "footer.php"?>
</div>
</div>