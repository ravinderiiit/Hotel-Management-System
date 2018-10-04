<?php 
@session_start();
@ob_start();
include "localinclude.php";
function IntToTimeAMPM($para=null)
{
date_default_timezone_set('Asia/Calcutta');
$time=date('H:i',$para);
$time=explode(":",$time);
$hh=$time[0];
$mm=$time[1];	

if($hh==00){$AMPM="AM";$hh=12;}
elseif(($hh>00)&&($hh<12)){$AMPM="AM";}
elseif(($hh>=12)&&($hh<24)){$AMPM="PM";$hh=$hh-12;}

//	if(($hh>12)&&($mm>0)){$hh=$time[0]-12;$AMPM="PM";}
return "$hh:$mm $AMPM";
}

if(!isset($_GET["uid"]))
{
header("location:AdvBooking_view.php?page=1&cmd=Clear");
}
else
{
$uid=$_GET["uid"];
$check_in_dt=$objCoreFO->datetimetointeger(date('d-m-Y'),date('H:i',strtotime(date('H:i'))));
//avance customer details updation
$sql="select * from tbl_adv_booking_mstr where md5(id)='$uid' and suspended_status=1";
$resAdvMstr=mysql_query($sql);
if(mysql_num_rows($resAdvMstr)>0)
{
	
$AdvMstrData=mysql_fetch_array($resAdvMstr);

$name=$AdvMstrData["name"];
$gender=$AdvMstrData["gender"];
$age=$AdvMstrData["age"];
$mobile=$AdvMstrData["mobile"];
$alt_no=$AdvMstrData["alt_no"];
$address=$AdvMstrData["address"];
$pincode=$AdvMstrData["pincode"];
$coming_frm=$AdvMstrData["coming_frm"];
$no_of_male=$AdvMstrData["no_of_male"];
$no_of_female=$AdvMstrData["no_of_female"];
$purpose=$AdvMstrData["purpose"];
$discount=$AdvMstrData["discount"];
$stampdate=$objCoreFO->DateToInt(date('d-m-Y'));
$stamptime=IntToTimeAMPM($objCoreFO->TimeToInt24(date('H:i')));
$userid=$_SESSION["userid"];	
	mysql_query("insert into tbl_customer_master (name,gender,age,mobile,alt_no,address,pincode,coming_frm,no_of_male,no_of_female,purpose,discount,stampdate,stamptime,userid) values('$name','$gender','$age','$mobile','$alt_no','$address','$pincode','$coming_frm','$no_of_male','$no_of_female','$purpose','$discount','$stampdate','$stamptime','$userid')") or die("Error! 65 contact to admin");
	$lastId=mysql_insert_id();
		
		
		//for room details updation
		$resMstr=mysql_query("select * from tbl_adv_booking_dtls where md5(adv_booking_id)='$uid' and status=1")or die("Error! 78 contact to admin");
		if(mysql_num_rows($resMstr)>0)
		{
			while($mstrData=mysql_fetch_array($resMstr))
			{
			$id=$mstrData["id"];
			$room_dtl_id=$mstrData["room_dtl_id"];
			$check_out_dt=$mstrData["check_out_dt"];
			mysql_query("insert into tbl_cust_dtls(customer_mas_id,room_dtl_id,check_in_dt,check_out_dt) values ('$lastId','$room_dtl_id','$check_in_dt','$check_out_dt')") or die("Error! 79 contact to admin");
			$insId=mysql_insert_id();
			
			mysql_query("update tbl_adv_booking_dtls set chkin_status='$insId' where id='$id'") or die("Error! 82 contact to admin");
			}
		}
		//end
		
		
		//for payments details updation to master
		$sql=" select * from tbl_adv_account where sysdept='3' and md5(trns_id)='$uid' and confrm_stat=0";
		$res=mysql_query($sql) or die("Error! 98 contact to admin");;
		if(mysql_num_rows($res)>0)
		{
			while($data=mysql_fetch_array($res))
			{
			$id=$data["id"];
			$vNo=$data["voucherno"];
			$trn_type=$data["trn_type"];
			$pay_mode=$data["pay_mode"];
			$card_no=$data["card_no"];
			$trans_date=$data["trans_date"];
			$sysdept=$data["sysdept"];
			
			$amtdr=$data["amtdr"];
			$amtcr=$data["amtcr"];
			$narration=$data["narration"];
			
				$sqlInsert="insert into tbl_account (trn_type,voucherno,pay_mode,card_no,trans_date,sysdept,trns_id,amtdr,amtcr,narration) values('$trn_type','$vNo','$pay_mode','$card_no','$trans_date','$sysdept','$lastId','$amtdr','$amtcr','$narration')";
				mysql_query($sqlInsert)or die("Error! 107 contact to admin");
				$insertID=mysql_insert_id();
				
				$sqlUpdate="update tbl_adv_account set confrm_stat='$insertID' where id='$id'";
				mysql_query($sqlUpdate) or die("Error! 111 contact to admin");
			
			}
		}
		//end
}







//close the record of advance booking
$sql="update tbl_adv_booking_mstr set suspended_status=2 where md5(id)='$uid'";
mysql_query($sql)or die("Error! 134 contact to admin");
//end


$_SESSION["message"]='<div class="alert alert-danger"><strong>Success!</strong> One new record successfully checked in</div>';
header("location:AdvBooking_list.php?cid=$uid");
}
?>