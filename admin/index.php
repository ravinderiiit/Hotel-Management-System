<?php include 'header.php'?>
<title> Welcome To Hotel Ganga Ashram </title>
<div class="content">
<div class="content-container">

<div class="dashboard"><h2>Welcome to Administrator</h2></div>
</div>
<p></p>
<div style="float:left;">
<span class="btn btn-success" style="width:10px;height:10px"></span> Available
<span class="btn btn-danger" style="width:10px;height:10px"></span> Not Available 
<span class="btn btn-warning" style="width:10px;height:10px"></span> Advance Booked
</div><br />
<p></p>   
<div class="content-container">  
     
     <!-------start------->
     <?php 
	 $sql="select * from tbl_floor_mstr where suspended_status=0";
	 $floorRes=mysql_query($sql);
	 if(mysql_num_rows($floorRes)>0){while($floorData=mysql_fetch_array($floorRes)){?>
      <div style="margin-left:20px;margin-top:20px;margin-right:20px;margin-bottom:-15px">
                  <div class="content-header">
                    <h3 class="head-dashboard"><?=$floorData["floor_name"]?></h3>
                  </div>
      </div>
						<?php 
                        $sql="select * from view_room_type_floor_dtl_wise where floor_id='".$floorData["id"]."' and suspended_status=0";
                        $RoomRes=mysql_query($sql);?>
                        
                          <div style="height:auto;margin:20px 20px 20px 20px;padding:10px;line-height:80px;text-align:center">
                             <?php if(mysql_num_rows($RoomRes)>0){while($RoomData=mysql_fetch_array($RoomRes)){
								 $class="btn btn-success";
								  $title="Available  ::  ".$RoomData["room_type"]."  :: Rate - ".number_format($RoomData["rate"],2);
								  $status=0;
								 $file="#";
								 //checking for current booking status
								 $sqlCheck="select * from view_cus_mstr_dtl_wise where room_dtl_id='".$RoomData["id"]."' and chkout_status=1";
								 $roomValidate=mysql_query($sqlCheck);
								 if(mysql_num_rows($roomValidate)>0)
								 {
									 $roomValData=mysql_fetch_array($roomValidate);
									 $class="btn btn-danger";
									 $title=$RoomData["room_type"]."  ::  Booked by - ".$roomValData["name"]."  ::  Check OutDate -".date('d-m-Y h:i A',$roomValData['check_out_dt']);
									 $status=1;
								 }
								 //end of current booking status checking
								 
								 //checking if advance booked or not
								 $sqlCheck="select * from tbl_adv_booking_dtls where room_dtl_id='".$RoomData["id"]."' and chkin_status=0 and status=1";
								 $roomValidate=mysql_query($sqlCheck);
								 if(mysql_num_rows($roomValidate)>0)
								 {
									 $roomValData=mysql_fetch_array($roomValidate);
									 $advRow=$objCoreFO->getRows("tbl_adv_booking_mstr","id='".$roomValData["adv_booking_id"]."'");
									 $class="btn btn-warning";
									 $title=$RoomData["room_type"]."  ::  Booked by - ".$advRow["name"]."  ::  CheckIn Date -".date('d-m-Y h:i A',$roomValData['check_in_dt']);
									 $status=2;
								 }
								 //end checking
								 
								 
								 if($status==1){$file="Customer_roomdtl.php?uid=".md5($roomValData['id']);}
								 if($status==2){$file="AdvCustomer_roomdtl.php?uid=".md5($advRow['id']);}
								 ?>
							 <a href="<?=$file?>" class="<?=$class?>" style="height:60px;width:60px;line-height:60px" title="<?=$title?>"><strong><?=$RoomData["room_no"]?></strong></a>
                         <?php }
						 }else{?>NO ROOMS<?php }?>
                          </div>
                          
      <?php }}?>	
      <!-------End------->				
</div>



</div>
<div class="debug">
</div>
<div class="footer">Designed by Sparrow Softech Pvt. Ltd.</div>
<!-- 0.3168s --></body></html>