<?php  
/*
Company :Sparrowsoftech.com
System Development : Mr. Asjad Khan
Version :1.0
Date:2-01-2014
Time 6:45 PM
 Warnning: Prohabited of Unauthorized Publication or Changes
// DATE
//	DATETIMEAMPM
//	DateToInt
//	IntToDate
//	IntToTime24
//   TimeToInt24
// TimeToIntAMPM
// IntToTimeAMPMsystimeInt
//getMaxValue to return max value 
//getMinValue to return max value 
//getSumValue to return max value 
*/
 
 
  class Database  
    { 
	var $db;
	public $db_name='hotel_db';
	var $host;
	var $password;
	var $queries;
	var $result;
	var $user;
	public  $nwords ;	
 
 	public $pagination;
	public $id;
	private $id_name;
	private $table_name;
	private $columns = array();
	
	
		function Database($host, $user, $password, $dbname)
		{
			$this->host     = 'localhost';
			$this->user     = 'root';
			$this->password = '';
		
		}
		function connect($redirect = false)
		{ 
				$this->queries = array();
	
				$this->db = mysql_connect('localhost', 'root', $this->password) or $this->notify(mysql_error(), false, true);
				
				mysql_select_db($this->db_name, $this->db) or $this->notify(mysql_error(), false, true);
				date_default_timezone_set("Asia/Kolkata");
				/******/
				//Preloader Values
					$row=$this->getRows("system_one_time_setting", $whr='1');
			 
				$_SESSION["doc_appointment_fee"]=$row["doc_appointment_fee"];
				$_SESSION["doc_appointment_expiry_day"]=$row["doc_appointment_expiry_day"]*(60*60*24);
				$_SESSION["doc_emergency_fee"]=$row["doc_emergency_fee"];
				$_SESSION["ServerCashDate"]=$row["cashdate"];
				///////////////////////////////////////
				if(isset($_GET["cmd"]))
				{
				unset($_SESSION["where"]);
				unset($_SESSION["ORDERCLAUSE"]);
				}	
				///////////////////////////////////////
				/*****/
				
		}
		function Notify($para1=null)
		{// system Error
				echo '<a class="close" data-dismiss="alert">×&nbsp;</a> <div class="alert alert-danger"> <h3>This is a Modal Heading</h3>'.$para1.'<br><br></div>';
		}
		function Error($para1=null)
		{
			echo '<a class="close" data-dismiss="alert">×</a> <div class="alert alert-success"> '.$para1.'</div>';
		}
		function Message($para1=null)
		{
			echo ' <div class="alert alert-info"> '.$para1.'</div>';
		}
		
	
	  // Set timezone




  // Time format is UNIX timestamp or
  // PHP strtotime compatible strings
  
				function systime()
				{
				date_default_timezone_set('Asia/Calcutta');
				$time_now=mktime(date('H'),date('i'),date('s'),0,0,0);
				return date('H:i',$time_now);}
		
				function systimeInt()
				{
				date_default_timezone_set('Asia/Calcutta');
				return $time_now=mktime(date('H'),date('i'),date('s'),0,0,0);}


			  function systemdate()
			  {
			  return $this->DateToInt(date("d-m-Y"));
			  }
  
  
		  	function dateDiff($dob, $now = false)
			{
			if (!$now) $now = date('d-m-Y');
			$dob = explode('-', $dob);
			$now = explode('-', $now);
			$mnt = array(1 => 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
			if (($now[2]%400 == 0) or ($now[2]%4==0 and $now[2]%100!=0)) $mnt[2]=29;
			if($now[0] < $dob[0]){
				$now[0] += $mnt[$now[1]-1];
				$now[1]--;
			}
			if($now[1] < $dob[1]){
				$now[1] += 12;
				$now[2]--;
			}
			if($now[2] < $dob[2]) return false;
			$str=($now[2] - $dob[2]).' Y '.($now[1] - $dob[1]).' M '.($now[0] - $dob[0]).' D';
			return $str;}
			
//$x = my_old('29-4-2008', '28-5-2009');
//print_r($x);
  
/*function dateDiff($dob, $now = false){
	if (!$now) $now = date('d-m-Y');
	$dob = explode('-', $dob);
	$now = explode('-', $now);
	$old = $now[2]*12+$now[1]-$dob[2]*12-$dob[1]-($dob[0]>$now[0] ? 1 : 0);
	$str=  floor($old / 12).' Y'.'   '.($old % 12).' M';
	return $str;
}
//$x = my_old('04-07-1984', date('d-m-Y'));
//print_r($x);
  */
  /*
  function dateDiff_old($time1, $time2, $precision = 6) {

    // If not numeric then convert texts to unix timestamps
	date_default_timezone_set('Asia/Calcutta');
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }
 
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
 
    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();
 
    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Create temp time from time1 and interval
      $ttime = strtotime('+1 ' . $interval, $time1);
      // Set initial values
      $add = 1;
      $looped = 0;
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
        // Create new temp time from time1 and interval
        $add++;
        $ttime = strtotime("+" . $add . " " . $interval, $time1);
        $looped++;
      }
 
      $time1 = strtotime("+" . $looped . " " . $interval, $time1);
      $diffs[$interval] = $looped;
    }
 
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
	break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
	// Add s if value is not 1
	if ($value != 1) {
	  $interval .= "s";
	}
	// Add value and interval to times array
	$times[] = $value.' '.$interval;
	$count++;
      }
    }
 
    // Return string with times
    $sentance= implode(", ", $times);
 
	$sentance= str_replace("years","Y",$sentance);
	$sentance= str_replace("months","M",$sentance);
	$sentance= str_replace("days","D",$sentance);
	$sentance= str_replace("month","M",$sentance);
	$sentance= str_replace("day","D",$sentance);
	return $sentance;
  }
	*/
	
	
			function insertuserwork($para)
			{ //$this->userid=$_SESSION["id"];
			 
			//$lastid1=$this->insert('system_logindetails',array($this->userid,$para, $_SERVER['REMOTE_ADDR']),"userid,remarks,ip");
			//echo 'mailto : smc@gmail.com';
			}
	
			function change_password()
			{
			
			$newpassword=md5($_POST["password"]);
			$confirm_pass=$_POST["confirm_pass"];
			$old_pass=md5($_POST["old_pass"]);
			
			if(($_POST["old_pass"]<>"")&&($newpassword<>"")&&($_POST["confirm_pass"]<>"")){
			 $changeSql="select * from system_login where password='$old_pass' and status=1 and id=".$_SESSION["id"];
			
			$changers=mysql_query($changeSql) or die($error="Please Try after Sometime");
			if(mysql_num_rows($changers)>0)
			{
			$changeSql="update system_login set password='$newpassword' where password='$old_pass' and status=1 and id=".$_SESSION["id"];
			$changers=mysql_query($changeSql) or die($error="Please Try after Sometime");
			?><a style="color:#990000; text-decoration:blink; font-weight:bold">
			<?php 
			echo "Password Changed Sucessfully</br>";
			?></a><?php 
			$this->insertuserwork('Changed Password Sucess');
			}
			else
			{?><a style="color:#990000; text-decoration:blink; font-weight:bold">
			<?php 
			echo "Incorrect Password <br>";
			?></a><?php 
			$this->insertuserwork('Changed Password But Not Sucess');
			
			}
			}
			}	

			function finddd($dt)
			{
			date_default_timezone_set('Asia/Calcutta');
			$date=explode("-", $dt); 
			return $date[0];	}
			
			function findmm($dt)
			{
			date_default_timezone_set('Asia/Calcutta');
			$date=explode("-", $dt); 
			return $date[1];}
			
			function findyy($dt)
			{
			date_default_timezone_set('Asia/Calcutta');
			$date=explode("-", $dt); 
			return $date[2];
			}
	
			function IntToDate($para=null)
			{
				return date("d-m-Y", $para);
			}
			
			function DateToInt($para=null)
			{	$date=explode("-", $para); 
				return mktime(0, 0, 0, ($date[1]), $date[0], $date[2]);
			}
			
			function TimeToInt24($para=null)
			{	 
				date_default_timezone_set('Asia/Calcutta');
				$time=explode(":",$para);
				$hh=$time[0];
				$mm=$time[1];
		 
				 return mktime($hh,$mm,0,0,0,0);
			}
			
			function IntToTime24($para=null)
			{
				date_default_timezone_set('Asia/Calcutta');
				return date('H:i',$para);
				
			}
	
			function addmonth($dt,$mm,$dd)
			{
			  
			date_default_timezone_set('UTC');
			$date=explode("-", $dt); 
			return (mktime(0, 0, 0, ($date[1]+$mm), ($date[0]+$dd), $date[2]));	}
	
			function datetimetointeger($d,$t)
			{
			date_default_timezone_set('Asia/Calcutta');
			$date=explode("-",$d);
			$time=explode(":",$t);
			//echo $time[0].",".$time[1].",0,".$date[0].",".$date[1].",".$date[2]."<br>";
			return mktime($time[0],$time[1],0,$date[1],$date[0],$date[2]);
			}	
					
		
	
			function TimeToIntAMPM($para=null)
			{	 date_default_timezone_set('Asia/Calcutta');
				$hh=substr($para,0,2);
				$mm=substr($para,3,2);
				$AMPM=substr($para,6,2);
				if($AMPM=="PM")
				{
				if($hh<12){
				$hh=12+$hh;
				}
				
				}
				if(($AMPM=="AM") && ($hh==12))
				{
				$hh="00";
				}
				//echo $hh.":".$mm."<br>";;
				 return mktime($hh,$mm,0,0,0,0);
				 //echo "<br>".$hh.":".$mm."<br>";
				 
				
				//return mktime(0, 0, 0, ($date[1]), $date[0], $date[2]);
			}
	
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
			
			function pageCaption($x)
			{
			$filnemae=explode("_",$x);
			return ($filnemae[0]);
			}
			
			function table_GETDATA($sid)
			{
			  $where="md5(id)='$sid'";
			  return $this->getRows($this->Table_Name,$where);
			}
	 
	 		function InvalidURL()
			{
			header("Location:invalidurl.php");
			exit;
			}

			function checkurl($tablename)
	{ 
		$tfilenamet= strtoupper($this->pageCaption($_SESSION["varFileName"])."_List");
	$where1="upper(filename)='$tfilenamet' and UserType=".$_SESSION["usertype"];
	$TEMPRS=$this->getRows('system_filelist',$where1);
	  $TEMPAdd=$TEMPRS["AddOn"];
	$TEMPEdit=$TEMPRS["Edit"];
	$TEMPView=$TEMPRS["View"];
	
	$this->error="";
			if($_SERVER['QUERY_STRING']<>"")
			{
			$QS=explode("=",$_SERVER['QUERY_STRING']);
			if($QS[0]<>"uid") {$this->InvalidURL();}//{$this->InvalidURL($this);}

			if(($_GET["wid"]<>'c4ca4238a0b923820dcc509a6f75849b') && ($_GET["wid"]<>'eccbc87e4b5ce2fe28308fd9f2a7baf3')) {$this->InvalidURL();}
			}
				if(isset($_GET["uid"]))
				{
				$sid=$_GET["uid"];
				$where="md5(id)='$sid'";
				
				$this->temp=$this->getRows($tablename,$where);
				if($this->temp==0){ $this->InvalidURL();}
				
				}
		$this->disbableit="";
		// add bY gaurav
			if(isset($_GET["wid"]))
			{
				if($_GET["wid"]=='c4ca4238a0b923820dcc509a6f75849b')
				{
						if($TEMPEdit==1)
						{
						$this->ButtonOperation='Edit';
						}
						else
						{
						$back=$this->pageCaption($_SESSION["varFileName"])."_list.php";
						header("location:$back");
						}
				
				} 
				elseif($_GET["wid"]=='eccbc87e4b5ce2fe28308fd9f2a7baf3') 
				{
				if($TEMPView==1)
						{
				
				$this->ButtonOperation='View';$this->disbableit='readonly="" style="border:none; background:none; outline-style:none;box-shadow:none;color:#000;resize:none"'; 
				}else
						{
						$back=$this->pageCaption($_SESSION["varFileName"])."_list.php";
						header("location:$back");
						}
				
				}
				
			}
		    else {
						if($TEMPAdd==1)
						{$this->ButtonOperation='New';}
						else
						{
						$back=$this->pageCaption($_SESSION["varFileName"])."_list.php";
						header("location:$back");}
			}
			
	}
	 
	 
	 
	 
	 
	 
	 
	 		function tableExists($table)
			{  
			$tablesInDb = @mysql_query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"')  or $this->Notify(mysql_error().$table);
			if($tablesInDb)
			{
				if(mysql_num_rows($tablesInDb)==1)
				{
					return true; 
				}
				else
				{ 
				echo "Invalid Table Name";
					return false; 
				}
			}
			}
			
			function CreateSelect($SELECTNAME,$table,$value,$option,$where='',$selected,$disbaleit )
			{
		
				if($this->tableExists($table))
				{ 
				if($where<>'')$where='where '.$where;
				$tempSQL="select $value,$option from $table $where order by $value";
				$tempresult=mysql_query($tempSQL)  or $this->Notify(mysql_error());
				if($disbaleit=="")
				{
					 echo' <select id="'.$SELECTNAME.'" name="'.$SELECTNAME.'" class="input-large"  required ""  style="width:100%">';
					 echo '<option  value="">Please Select </option>';
						 while($temprow=mysql_fetch_array($tempresult))
						 {
						 ?>
			<option  value="<?php echo $temprow["$value"]?>" <?php if($temprow["$value"]==$selected){?>selected="selected"<?php } ?>> <?php echo $temprow["$option"];?></option> 
						 <?php
						 }
						 echo '</select>';
			  }
			  else
			  {
			  while($temprow=mysql_fetch_array($tempresult))
			  {
			 if($temprow["$value"]==$selected){?><input type="text"  value="<?php echo $temprow["$option"];?>" <?php echo $disbaleit;?> /><?php  }
			  }
			  }
			  
			  
			}
			}
			
			function CreateDD($selected,$disbaleit)
			{if($disbaleit==""){
		
			
			 echo' <select id="DD" name="DD" class="input-mini" '.$disbaleit.'>';
			 for($i=1;$i<=31;$i++)
			 {
			 ?><option  value="<?php echo $i?>" <?php if($i==$selected){?>selected="selected"<?php } ?>> <?php if($i<10) {echo "0".$i;}else {echo $i;};?></option> 
			 <?php
			 }
			 echo '</select>';
		 }
			 else
			 {
			 echo $selected;
			 }
			}
			
			function CreateMM($selected,$disbaleit)
			{
				if($disbaleit==""){
			 echo' <select id="MM" name="MM" class="input-mini"'.$disbaleit.'>';
		
			 ?>
			<option  value="1" <?php if(1==$selected){?>selected="selected"<?php } ?>> <?php echo "Jan";?></option> 
			<option  value="2" <?php if(2==$selected){?>selected="selected"<?php } ?>> <?php echo "Feb";?></option> 
			<option  value="3" <?php if(3==$selected){?>selected="selected"<?php } ?>> <?php echo "Mar";?></option> 
			<option  value="4" <?php if(4==$selected){?>selected="selected"<?php } ?>> <?php echo "Apr";?></option> 
			<option  value="5" <?php if(5==$selected){?>selected="selected"<?php } ?>> <?php echo "May";?></option> 
			<option  value="6" <?php if(6==$selected){?>selected="selected"<?php } ?>> <?php echo "Jun";?></option> 
			<option  value="7" <?php if(7==$selected){?>selected="selected"<?php } ?>> <?php echo "Jul";?></option> 
			<option  value="8" <?php if(8==$selected){?>selected="selected"<?php } ?>> <?php echo "Aug";?></option> 
			<option  value="9" <?php if(9==$selected){?>selected="selected"<?php } ?>> <?php echo "Sep";?></option> 
			<option  value="10" <?php if(10==$selected){?>selected="selected"<?php } ?>> <?php echo "Oct";?></option> 
			<option  value="11" <?php if(11==$selected){?>selected="selected"<?php } ?>> <?php echo "Nov";?></option> 
			<option  value="12" <?php if(12==$selected){?>selected="selected"<?php } ?>> <?php echo "Dec";?></option> 
			
			 <?php
		
			 echo '</select>';
			 }
			 else
			 {
			 echo $selected;
			 }
			}
	
			function CreateYYYY($selected,$disbaleit)
			{if($disbaleit==""){
			 echo' <select id="YYYY" name="YYYY" class="input-mini"'.$disbaleit.'>';
		
			
		for($i=Date("Y");$i>=1930;$i--)
			 {
			 ?><option  value="<?php echo $i?>" <?php if($i==$selected){?>selected="selected"<?php } ?>> <?php  {echo $i;};?></option> 
			 <?php
			 }
			 echo '</select>';
			  }
			 else
			 {
			 echo $selected;
			 }
			}
			
			function CreateYY($selected,$disbaleit)
			{
			 echo' <select id="YY" name="YY" class="input-mini">';
			 for($i=1;$i<=12;$i++)
			 {
			 ?>
			 <option  value="1" <?php if(1==$selected){?>selected="selected"<?php } ?>> <?php echo "Jan";?></option> 
			 <?php
			 }
			 echo '</select>';
			}
	
			function getMaxValue($tableName,$FieldName1, $whr=Null)
			{	
			if($whr<>null){$whr="Where $whr";}
			$sqlNum = 'SELECT max( ' .$FieldName1.') as numrows FROM ' . $tableName ." ".$whr ;  
				$varResult = mysql_query($sqlNum) or $this->Notify(mysql_error());
				$resutlNum = mysql_fetch_array($varResult)  or $this->Notify(mysql_error());
				return $resutlNum[numrows];
			}
	
			function getMinValue($tableName,$FieldName, $whr=Null)
			{	
			if($whr<>null){$whr="Where $whr";}
			$sqlNum = 'SELECT min( ' .$FieldName1.') as numrows FROM ' . $tableName ." ".$whr ; 
				$varResult = mysql_query($sqlNum) or $this->Notify(mysql_error());
				$resutlNum = mysql_fetch_array($varResult)  or $this->Notify(mysql_error());
				return $resutlNum[numrows];
			}
			
			function getSumValue($tableName,$FieldName,  $whr=Null)
			{	
			
			if($whr<>null){$whr="Where $whr";}
			$sqlNum = 'SELECT sum( ' .$FieldName.') as numrows FROM ' . $tableName ." ".$whr ;
		
				 $varResult = mysql_query($sqlNum) or $this->Notify(mysql_error());
				$resutlNum = mysql_fetch_array($varResult)  or $this->Notify(mysql_error());
				return $resutlNum[numrows];
			}
	
			function getNumRows($tableName, $whr='')
			{	 $sqlNum = 'SELECT count(*) as numrows FROM ' . $tableName .' Where  '.$whr ;
				 
		//echo $sqlNum;
				$varResult = mysql_query($sqlNum) or $this->Notify(mysql_error());
				$resutlNum = mysql_fetch_assoc($varResult) ;
				
					return $resutlNum[numrows];
		
			}
	
/*function getNumRows_ren($tableName, $whr='')
	{	$sqlNum = 'SELECT * FROM ' . $tableName .' Where  '.$whr ;
		 
		
		$varResult = mysql_query($sqlNum) or $this->Notify(mysql_error());
		$counter=0;
		while($resutlNum = mysql_fetch_array($varResult)  or $this->Notify(mysql_error()))
		{
			
			$sql='SELECT count(*) as numrow FROM ' . $tableName .' Where  patient_id='.$resutlNum["patient_id"] ;
			$varResult_2 = mysql_query($sql) or $this->Notify(mysql_error());
			$resutlNum_2 = mysql_fetch_assoc($varResult_2)  or $this->Notify(mysql_error());
			if($resutlNum_2["numrow"]>1)
			{
				$counter++;
			}
			//echo $sql;
		}
		
  		return $counter;

	}*/
	
			 function getRows($tableName, $whr='')
			{	$sqlNum = 'SELECT * FROM ' . $tableName .' Where   '.$whr ;
				//echo $sqlNum;
				 $varResult = mysql_query($sqlNum) ;
				 @$retunrow = mysql_fetch_array($varResult) ;
				 return $retunrow;
			}
	
	//================================= Custome List For Pharmacy Order Form ================================
	//+++++++++++++++++++
		  function PrepairPagination($msql)
		  {
 	 $q=$msql;
 	 $total_pages = mysql_num_rows(mysql_query($q));
			 $limit =20; //how many items to show per page
			if(isset($_GET['page'])) {
			$page = $_GET['page'];
			$start = ($page - 1) * $limit; //first item to display on this page
			} else {
			$page = 0;
			$start = 0; //if no page var is given, set start to 0
			}
			$sql=' LIMIT '.$start.','. $limit;
			 $q=$q.$sql;
			 $this->finalsql=$q;
			
								if ($page == 0)
							 $page = 1;
								$prev = $page - 1;
								$next = $page + 1;
								$lastpage = ceil($total_pages / $limit);
								$lpm1 = $lastpage - 1;
							
								$this->pagination = "";
								if ($lastpage > 1) {
									$this->pagination .= '<div class="pagination pagination-right"><ul>';
									if ($page > 1)
										$this->pagination.= "<li><a href=\"$targetpage?page=$prev\">Previous</a></li>";
									else
										$this->pagination.= "<li class='disabled'><a href='#'>Previous </a></li>";
									if ($lastpage < 7 + ($adjacents * 2)) {
										for ($counter = 1; $counter <= $lastpage; $counter++) {
											if ($counter == $page)
											$this->pagination.='<li class="active"><a href="#"><span class="sr-only">'.$counter.'</span></a></li>';
											else
												$this->pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";
										}
									} else if ($lastpage > 5 + ($adjacents * 2)) {
										if ($page < 1 + ($adjacents * 2)) {
											for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
												if ($counter == $page)
													$this->pagination.='<li class="active"><a href="#">'.$counter.'  </a></li>';
												else
													$this->pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";
											}
											$this->pagination.= "<li class='disabled'><a href='#'>... </a></li>";
											$this->pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
											$this->pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";
										} else if ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
											$this->pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
											$this->pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
 
											for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
												if ($counter == $page)
													$this->pagination.='<li class="active"><a href="#">'.$counter.'  </a></li>';
												else
													$this->pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";
											}
											$this->pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
											$this->pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";
										} else {
											$this->pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
											$this->pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
 											for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
												if ($counter == $page)
													$this->pagination.='<li class="active"><a href="#">'.$counter.'  </a></li>';
												else
													$this->pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";

											}
										}
									}
									if ($page < $counter - 1)
										$this->pagination.= "<li><a href=\"$targetpage?page=$next\">Next</a></li>";
									else
										$this->pagination.= "<li class='disabled'><a href='#'>Next</a></li>";
									$this->pagination.= "</ul></div> ";
  }
  }
			
	
	 
      
  
  //++++++++++++++++++++++++++++*******************
	
	
	function getGallaeryList($table, $rows = '*', $where = null, $order = null,$deleterow)
    {
	if($_GET["cmd"]=="Clear"){unset($_SESSION["where"]);}
	if(isset($_POST["Delete"]))
	{ 
	//$d="delete from $table where md5(id)='". $_POST["deleterow"]."'";
	$d="update $table set suspended_status=1 where md5(id)='". $_POST["deleterow"]."'";
	$d=mysql_query($d) or $this->Notify(mysql_error()."aa");
	$this->Message("One Record Deleted");
	}
	echo ' <table width="100%" border="0" align="center" cellpadding="20" cellspacing="1">';
   
		$tbl_name = $table;
			$targetpage = "photo_list.php";
									$adjacents = 3;
								$query = "SELECT COUNT(*) as num FROM $tbl_name ";
								$total_pages = mysql_fetch_array(mysql_query($query));
								$total_pages = $total_pages[num];
							
							
								$limit = 12;
								$page = $_GET['page'];
								if ($page)
									$start = ($page - 1) * $limit;
								else
									$start = 0;
							
								$sql = "SELECT * FROM $tbl_name order by id desc LIMIT $start, $limit";
								$result = mysql_query($sql);
							
								if ($page == 0)
									$page = 1;
								$prev = $page - 1;
								$next = $page + 1;
								$lastpage = ceil($total_pages / $limit);
								$lpm1 = $lastpage - 1;
							
								$pagination = "";
								if ($lastpage > 1) {
									$pagination .= "<div class=\"pagination\">";
									if ($page > 1)
										$pagination.= "<a href=\"$targetpage?page=$prev\">Previous</a>";
									else
										$pagination.= "<span class=\"disabled\">Previous</span>";
							
									if ($lastpage < 7 + ($adjacents * 2)) {
										for ($counter = 1; $counter <= $lastpage; $counter++) {
											if ($counter == $page)
												$pagination.= "<span class=\"current\">$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";
										}
									} else if ($lastpage > 5 + ($adjacents * 2)) {
										if ($page < 1 + ($adjacents * 2)) {
											for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
												if ($counter == $page)
													$pagination.= "<span class=\"current\">$counter</span>";
												else
													$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";
											}
											$pagination.= "...";
											$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
											$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
										} else if ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
											$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
											$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
											$pagination.= "...";
											for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
												if ($counter == $page)
													$pagination.= "<span class=\"current\">$counter</span>";
												else
													$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";
											}
							
											$pagination.= "...";
											$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
											$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
										} else {
											$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
											$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
											$pagination.= "...";
											for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
												if ($counter == $page)
													$pagination.= "<span class=\"current\">$counter</span>";
												else
													$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";
											}
										}
									}
									if ($page < $counter - 1)
										$pagination.= "<a href=\"$targetpage?page=$next\">Next</a>";
									else
										$pagination.= "<span class=\"disabled\">Next</span>";
									$pagination.= "</div>\n";
								}
if (mysql_num_rows($result) > 0) {
$ctr=0;
									while ($rs = mysql_fetch_array($result)) {
 
                    ?>
       <?php if($ctr==0) {echo "<tr>";}?>
            <td  valign="baseline" align="center" bgcolor="#FFFFFF" height="150px"><br />
			<div style="background:#CCCCCC; padding-top:20px; padding-bottom:20px;border-radius:5px; height:280px">
		
				 <img src="../uploadthumbs/<?php echo $rs["image"];?>" style="border-radius:5px; " >
		 
			<br />
			<?php echo "Date:".substr($rs["i_date"],0,10);?> 
			<br />
				<div style="width:180px; text-align:justify">	Details:<?php echo substr($rs["image_details"],0,100);?></div> <br />
						
						
						
			<a  style="font-size:11px" href="#delModal<?php echo md5($rs[0]);?>"  data-toggle="modal"> <button class="btn  btn-danger">Delete</button></a>
			</div>
				<div id="delModal<?php echo md5($rs[0]);?>" class="modal hide fade in" role="dialog" ria-labelledby="myModalLabel" aria-hidden="true">
                             <div class="modal-header">
                                <a class="close" data-dismiss="modal">x</a>
                                <h3>Confirmation Delete</h3>
                            </div>
                             <div><form class="contact" method="post">
											<input type="hidden" name="deleterow"  value="<?=md5($rs[0])?>" />
											   <fieldset>
												<div class="modal-body">
												 <ul class="nav nav-list">
												  <?php
													$nooffield= mysql_num_fields($query)  or $this->Notify(mysql_error());
												 for($makehead=1;$makehead< $nooffield;$makehead++){ 
												  echo  '<p>'. mysql_field_name($query,$makehead).':'.$key[$makehead]?>
												   </p><?php }?>
													</ul> 
												 </div>
												</fieldset>
											
											 </div>
											 <div class="modal-footer">
												<button class="btn  btn-danger" name="Delete"  id="submit">Delete</button>
												  <a href="#" class="btn" data-dismiss="modal">Close</a>
											 </div>
											 </form>
                     </div>
			</td>

                 <?php if($ctr==4) {echo "</tr>";}?>
          <?php 
		
		  $ctr++;
		  if($ctr==4)
		  {$ctr=0;}
		  
		  } }?>
  <?php echo '</table>';
		echo '<div class="category" align="right">';
 echo $pagination ?>
<?php echo "</div>";

	 }
	
		function getList($table, $rows = '*', $where = null, $order = null,$deleterow)
    {

	if(@$_GET["cmd"]=="Clear"){unset($_SESSION["where"]);} 
	if(isset($_POST["Delete"]))
	{
	//$d="delete from $deleterow where md5(id)='". $_POST["deleterow"]."'";
	$d="update $deleterow set suspended_status=1 where md5(id)='". $_POST["deleterow"]."'";
	$d=mysql_query($d) or $this->Notify(mysql_error()."010101");
	$this->Message("One Record Deleted");
	}
	$adjacents = 3;
        $q = 'SELECT '.$rows.' FROM '.$table;

        if($where != null)
            $q .= ' WHERE '.$where;
			        if(isset($_POST["ORDERCLAUSE"]))
					{
					$_SESSION["ORDERCLAUSE"]=$_POST["ORDERCLAUSE"];
					}
					if(isset($_SESSION["ORDERCLAUSE"])){
			 $q .= ' order by '."`".$_SESSION["ORDERCLAUSE"]."`";
			  $ORDERCLAUSEDESCASCa="^";
			  			  if(isset($_POST["ORDERCLAUSEDESCASC"])){$ORDERCLAUSEDESCASCa=$_POST["ORDERCLAUSEDESCASC"];}  

			  if( $ORDERCLAUSEDESCASCa=="v") {$q .= ' Asc';  } 
			  if( $ORDERCLAUSEDESCASCa=="^") {$q .= ' Desc'; } 
	
			  }
 	 
			  
			  
			 	 //echo $_POST["ORDERCLAUSEDESCASC"].$q;
        if($this->tableExists($table))
       {
        $query = @mysql_query($q) or $this->Notify(mysql_error()."TBL019101");
        if($query)
        {
	 	$total_pages = mysql_num_rows(mysql_query($q));
		$targetpage=$_SESSION["varFileName"];

		 $limit = FRONT_PAGE_LIMIT; //how many items to show per page
			if(isset($_GET['page'])) {
			$page = $_GET['page'];
			$start = ($page - 1) * $limit; //first item to display on this page
			} else {
			$page = 0;
			$start = 0; //if no page var is given, set start to 0
			}
			$sql=' LIMIT '.$start.','. $limit;
			$q=$q.$sql;
		
								if ($page == 0)
							 	$page = 1;
								$prev = $page - 1;
								$next = $page + 1;
								$lastpage = ceil($total_pages / $limit);
								$lpm1 = $lastpage - 1;
							
								$pagination = "";
								if ($lastpage > 1) {
									$pagination .= '<div class="pagination pagination-right"><ul>';
									if ($page > 1)
										$pagination.= "<li><a href=\"$targetpage?page=$prev\">Previous</a></li>";
									else
										$pagination.= "<li class='disabled'><a href='#'>Previous </a></li>";
									if ($lastpage < 7 + ($adjacents * 2)) {
										for ($counter = 1; $counter <= $lastpage; $counter++) {
											if ($counter == $page)
											$pagination.='<li class="active"><a href="#"><span class="sr-only">'.$counter.'</span></a></li>';
											else
												$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";
										}
									} else if ($lastpage > 5 + ($adjacents * 2)) {
										if ($page < 1 + ($adjacents * 2)) {
											for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
												if ($counter == $page)
													$pagination.='<li class="active"><a href="#">'.$counter.'  </a></li>';
												else
													$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";
											}
											$pagination.= "<li class='disabled'><a href='#'>... </a></li>";
											$pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
											$pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";
										} else if ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
											$pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
											$pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
 
											for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
												if ($counter == $page)
													$pagination.='<li class="active"><a href="#">'.$counter.'  </a></li>';
												else
													$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";
											}
											$pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
											$pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";
										} else {
											$pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
											$pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
 											for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
												if ($counter == $page)
													$pagination.='<li class="active"><a href="#">'.$counter.'  </a></li>';
												else
													$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";

											}
										}
									}
									if ($page < $counter - 1)
										$pagination.= "<li><a href=\"$targetpage?page=$next\">Next</a></li>";
									else
										$pagination.= "<li class='disabled'><a href='#'>Next</a></li>";
									$pagination.= "</ul></div> ";
		}
	
								 $query = @mysql_query($q)  or $this->Notify(mysql_error()."aaaaaa");
             $this->numResults = mysql_num_rows($query) ;
			
			 	
			$callingpage=explode("_",$targetpage);

			$filnemae=explode(".",$targetpage);
			  $filesql="select * from system_filelist where filename='".$filnemae[0]."' and UserType=".$_SESSION["usertype"];
			$fileans=mysql_query($filesql) or die('Contact to Admin File System Error 635383-ZAP');
			$showoption=mysql_fetch_array($fileans);
		    $_SESSION["otherpagename"]=$callingpage[0].'_alter';
			if($showoption["List"]==0)
			{	header("location:index.php");}
		
			if($showoption["AddOn"]==1)
			{	echo '<script type="text/javascript">ShowHideAdd("Y");</script>';}
			else
			{	echo '<script type="text/javascript">ShowHideAdd("N");</script>';}
			$color='active';
			
			?>
<div class="table-responsive">
   <table class="table table-striped table-hover"> <thead>
			<tr>
	 <?php 
	 $nooffield= mysql_num_fields($query)  or $this->Notify(mysql_error());
	 for($makehead=1;$makehead< $nooffield;$makehead++){ 
	 $fnamexyz= mysql_field_name($query,$makehead);
	 $tname=explode("_",$fnamexyz);
 
	 	 if(($tname[0]=="IntToDate") || ($tname[0]=="IntToTimeAMPM")|| ($tname[0]=="IntToTime24")|| ($tname[0]=="TIME24")|| ($tname[0]=="TIMEAMPM")|| ($tname[0]=="Age"))
		 { $FieldName=$tname[1];}
		  else 
		   {$FieldName=$fnamexyz;}
 
	 ?><form method="POST">
	 
		  <td    nowrap="nowrap"  ><strong><?php echo $FieldName;?>
 <?php 
 
 if(isset($_POST["ORDERCLAUSE"])){$tempfilename=$_POST["ORDERCLAUSE"];} else {$tempfilename="";}
 
 if($fnamexyz<>$tempfilename){?>
	      <input type="SUBMIT"  name="ORDERCLAUSEDESCASC" value="^" style="background:none; font-weight:bold; border:none; box-shadow:none" />
<?php } else { 
 				 
					if($_POST["ORDERCLAUSEDESCASC"]<>"^"){?>
				    <input type="SUBMIT"  name="ORDERCLAUSEDESCASC" value="^" style="background:none; font-family:Webdings; font-weight:bold; border:none; box-shadow:none" />
				  <?php } else {?>
					 
				    <input type="SUBMIT"  name="ORDERCLAUSEDESCASC" value="v" style="background:none;font-weight:bold; border:none; box-shadow:none" />
				    <?php }
		  
	 
		   }?>
		<input type="hidden" name="fieldvalue" value="<?=$makehead+1?>" />
		<input type="hidden" name="ORDERCLAUSE" value="<?php echo $fnamexyz;?>" />
 
       </strong></td>  </form>
	  
		 <?php }?>
		 <?php if($showoption["Edit"]==1){  ?> <td ><span  style="font-weight:bold;font-size:12px"><?php echo $showoption["EditName"];?></span></td><?php }?>
		 <?php if($showoption["Delete"]==1){?><td><span  style="font-weight:bold;font-size:12px"><?php echo $showoption["DeleteName"];?></span></td><?php }?>
		 <?php if($showoption["View"]==1){?><td><span  style="font-weight:bold; font-size:12px"><?php echo $showoption["ViewName"];?></span></td><?php }?>
		 </tr> 
		 </thead>
            <tbody>
		 <?php 
			while($key=@mysql_fetch_array($query))
			{if($color=='active'){$color='warning';}else {$color='active';}echo "<tr class='$color'>";
			for($x = 0; $x < mysql_num_fields($query); $x++)
			{	 	// if(($tname[0]=="DATE") || ($tname[0]=="DATETIME")|| ($tname[0]=="DATETIMEAMPM")|| ($tname[0]=="TIME24")|| ($tname[0]=="TIMEAMPM"))
			
				 $tname=explode("_", mysql_field_name($query,$x));
				 
				 if(($tname[0]=="IntToDate"))
				 {$value=$this->IntToDate($key[$x]);}
				 elseif($tname[0]=="IntToTimeAMPM")
				  {$value=$this->IntToTime12($key[$x]);}
				   elseif($tname[0]=="IntToTime24")
				  {$value=$this->IntToTime24($key[$x]);}
				  elseif(($tname[0]=="Age"))
				 {$value=$this->dateDiff($this->IntToDate($key[$x]),date('d-m-Y'));}
				
				  else
				 {$value=$key[$x];}
				 
				   
				  
				 
			if($x>0){echo "<td id='x_date'><font size=2> ".$value."</font> </td>";}}
			?>
 <?php
       if($showoption["Edit"]==1){
	if($showoption["editfile"]<>"No"){$editfile=$showoption["editfile"];} else {$editfile=$_SESSION["otherpagename"];}?>

			<td style="width:1px" align="center">
			
			<a style="font-size:11px" href="<?php echo $editfile.'.php?uid='.md5($key[0]).'&wid='.md5(1);?>">  <?php echo $showoption["EditName"];?></a>
			 </td>
			 <?php }?>			 
				</td>

			  <?php if($showoption["Delete"]==1){?>
				<td style="width:1px" align="center">
				<a  style="font-size:11px" href="#delModal<?php echo md5($key[0]);?>"  data-toggle="modal"> <?php echo $showoption["DeleteName"];?></a>
				<div id="delModal<?php echo md5($key[0]);?>" class="modal hide fade in" role="dialog" ria-labelledby="myModalLabel" aria-hidden="true" style="text-align:left;">
                             <div class="modal-header btn-danger" style="height:30px ">
                                <a class="close" data-dismiss="modal" style="float:right"><strong style="cursor:default">X</strong></a>
                                <h2 style="text-transform:inherit; font-size:18px">Confirmation Delete</h2>
                            </div>
                             <div><form class="contact" method="post">
											<input type="hidden" name="deleterow"  value="<?=md5($key[0])?>" />
											   <fieldset>
												<div class="modal-body">
												 <ul class="nav nav-list">
                                                        
                                            <table width="100%" border="0">
                                                  <?php
													$nooffield= mysql_num_fields($query)  or $this->Notify(mysql_error());
												 for($makehead=1;$makehead< $nooffield;$makehead++)
												 { ?>
                                                <tr>
                                                <td width="26%" style="background:none"><?php echo mysql_field_name($query,$makehead)?> </td>
                                                <td width="2%" style="background:none"><strong>:</strong></td>
                                                <td width="72%" style="background:none"><?php echo $key[$makehead]?></td>
                                                </tr>
												<?php }?>
                                                </table>
                                                   
													</ul> 
												 </div>
												</fieldset>
											
											 </div>
											 <div class="modal-footer">
												<button class="btn  btn-danger" name="Delete"  id="submit">Delete</button>
												  <a href="#" class="btn" data-dismiss="modal">Close</a>
											 </div>
											 </form>
                     </div>
			 </td>
				<?php }?>
				 <?php if($showoption["View"]==1){
				if($showoption["viewfile"]<>"No"){$executeview=$showoption["viewfile"];} else {$executeview=$_SESSION["otherpagename"];}
					 ?>
				<td style="width:2px" align="center">
 			    <a style="font-size:11px" href="<?php echo $executeview.'.php?uid='.md5($key[0]).'&wid='.md5(3).'&cmd=Clear'?>" /><?php echo $showoption["ViewName"];?></a>

				

				 
				</td>
				<?php } 
			
			 
			}	 
			echo " </tbody></table></div>";
echo "<div align='right'>". $pagination."</div>";
       
            return true; 
        }
        else
        {
            return false; 
        }
        }
else
      return false; 
    }
	
	/********* GET DETAIL LIST************/
	function getDetailList($table, $rows = '*', $where = null, $order = null)
    {
 
	if(isset($_POST["Delete"]))
	{ $d="delete from $table where md5(id)='". $_POST["deleterow"]."'";
	$d=mysql_query($d)  or $this->Notify(mysql_error());
	 $this->Message("One Record Deleted ");
	}
	$adjacents = 3;
        $q = 'SELECT '.$rows.' FROM '.$table;
        if($where != null)
            $q .= ' WHERE '.$where;
			
      
        if($this->tableExists($table))
       {
	   if(isset($_POST["SUBMIT"]))
			{$_SESSION["ORDERBY"]=$_POST["fieldvalue"];
			if($_SESSION["ASCDESC"]=="asc"){$_SESSION["ASCDESC"]="desc";} else {$_SESSION["ASCDESC"]="asc";
			
			}
		 
			}
			if(!isset($_SESSION["ORDERBY"])){$_SESSION["ORDERBY"]=1;$_SESSION["ASCDESC"]="asc";}
			$q.=" order  by ".$_SESSION["ORDERBY"]." ".$_SESSION["ASCDESC"];
		
        $query = @mysql_query($q) or die(mysql_error())  ;
	
        if($query)
        {
	 	$total_pages = mysql_num_rows(mysql_query($q));
		$targetpage=$_SESSION["varFileName"];
		 $limit = FRONT_PAGE_LIMIT; //how many items to show per page
			if(isset($_GET['page'])) {
			$page = $_GET['page'];
			$start = ($page - 1) * $limit; //first item to display on this page
			} else {
			$page = 0;
			$start = 0; //if no page var is given, set start to 0
			}
			$sql=' LIMIT '.$start.','. $limit;
		 $q=$q.$sql;
	//	 echo $q;
			 
			
							if ($page == 0)
							 $page = 1;
								$prev = $page - 1;
								$next = $page + 1;
								$lastpage = ceil($total_pages / $limit);
								$lpm1 = $lastpage - 1;
							
								$pagination = "";
								if ($lastpage > 1) {
									$pagination .= '<div class="pagination pagination-right"><ul>';
									
									if ($page > 1)
									
										$pagination.= "<li><a href=\"$targetpage?page=$prev\">Previous</a></li>";
										
									else
										$pagination.= "<li class='disabled'><a href='#'>Previous </a></li>";
							
									if ($lastpage < 7 + ($adjacents * 2)) {
										for ($counter = 1; $counter <= $lastpage; $counter++) {
											if ($counter == $page)
											$pagination.='<li class="active"><a href="#">1 <span class="sr-only">($counter)</span></a></li>';
											else
												$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";
										}
									} else if ($lastpage > 5 + ($adjacents * 2)) {
										if ($page < 1 + ($adjacents * 2)) {
											for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
												if ($counter == $page)
													$pagination.='<li class="active"><a href="#">'.$counter.'  </a></li>';
												else
													$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";
											}

											$pagination.= "<li class='disabled'><a href='#'>... </a></li>";
											$pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
											$pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";
										} else if ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
											$pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
											$pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
 
											for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
												if ($counter == $page)
													$pagination.='<li class="active"><a href="#">'.$counter.'  </a></li>';
												else
													$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";
											}
							
											
											$pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
											$pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";
										} else {
											$pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
											$pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
 											for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
												if ($counter == $page)
													$pagination.='<li class="active"><a href="#">'.$counter.'  </a></li>';
												else
													$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";
											}
										}
									}
									if ($page < $counter - 1)
										$pagination.= "<li><a href=\"$targetpage?page=$next\">Next</a></li>";
									else
										$pagination.= "<li class='disabled'><a href='#'>Next</a></li>";
									$pagination.= "</ul></div> ";
		}
								 $query = @mysql_query($q);
             $this->numResults = mysql_num_rows($query);
			
			$callingpage=explode("_",$targetpage);
			$_SESSION["otherpagename"]=$callingpage[0].'_alter';
			$color='active';
			?>

            <tbody>
		 <?php 
			while($key=@mysql_fetch_array($query))
			{if($color=='active'){$color='warning';}else {$color='active';}echo "<tr class='$color'>";
			for($x = 0; $x < mysql_num_fields($query); $x++)
			{
			if($x>0){echo "<td  ><font size=2> ". $key[$x]."</font> </td>";}}
			?>
			 
				<td style="width:1px" align="center">

				<a  style="font-size:11px" href="#delModal<?php echo md5($key[0]);?>"  data-toggle="modal"> Delete</a>
				<div id="delModal<?php echo md5($key[0]);?>" class="modal hide fade in" role="dialog" ria-labelledby="myModalLabel" aria-hidden="true">
                             <div class="modal-header">
                                <a class="close" data-dismiss="modal">x</a>
                                <h3>Confirmation Delete</h3>
                            </div>
                             <div><form class="contact" method="post">
											<input type="hidden" name="deleterow"  value="<?=md5($key[0])?>" />
											   <fieldset>
												<div class="modal-body">
												 <ul class="nav nav-list">
												  <?php
													$nooffield= mysql_num_fields($query);
												 for($makehead=1;$makehead< $nooffield;$makehead++){ 
												  echo  '<p>'. mysql_field_name($query,$makehead).':'.$key[$makehead]?>
												   </p><?php }?>
													</ul> 
												 </div>
												</fieldset>
											
											 </div>
											 <div class="modal-footer">
												<button class="btn  btn-danger" name="Delete"  id="submit">Delete</button>
												  <a href="#" class="btn" data-dismiss="modal">Close</a>
											 </div>
											 </form>
                     </div>
			 
				</td>
				
				 
			<?php
			
			 
			}	 
			echo " </tbody></table></div>";
echo "<div align='right'>". $pagination."</div>";
      
                    
            return true; 
        }
        else
        {
            return false; 
        }
        }
else
      return false; 
    }
 
 
 
	/********** END OF DETAIL LIST */
 
        public function insert($table,$values,$rows = null)
  			 {   
        if($this->tableExists($table))  
        {  
            $insert = 'INSERT INTO '.$table;  
            if($rows != null)  
            {  
                $insert .= ' ('.$rows.')';   
            }  
  
            for($i = 0; $i < count($values); $i++)  
            {  
                 
                    $values[$i] = '"'.$values[$i].'"';  
					
            }  
            $values = implode(',',$values);  
            $insert .= ' VALUES ('.$values.')';  
			//echo $insert;
             $ins = @mysql_query($insert) or $this->Notify(mysql_error());;              
			$insert_id=mysql_insert_id();
            if($ins)  
            {  
                return $insert_id;   
            }  
            else  
            {  
                return false;   
            }  
        }  
    }
 
        public function delete($table,$where)
			{  
        if($this->tableExists($table))  
        {  
            if($where == null)  
            {  
                $delete = 'DELETE '.$table;   
            }  
            else  
            {  
                $delete = 'DELETE FROM '.$table.' WHERE '.$where;   
            }  
            $del = @mysql_query($delete) or $this->Notify(mysql_error());
  
            if($del)  
            {  
                return true;   

            }  
            else  
            {  
               return false;   
            }  
        }  
        else  
        {  
            return false;   
        }  
   }  
  		 public function update($table,$rows,$where=null)  
   			 {  
	     if($this->tableExists($table))  
        {  
            // Parse the where values  
            // even values (including 0) contain the where rows  
            // odd values contain the clauses for the row  
			///echo count($where);
          
            $update = 'UPDATE '.$table.' SET ';  
            $keys = array_keys($rows);   
            for($i = 0; $i < count($rows); $i++)  
			   {  
					if(is_string($rows[$keys[$i]]))  
					{  
						$update .= $keys[$i].'="'.$rows[$keys[$i]].'"';  
					}  
					else  
					{  
						$update .= $keys[$i].'='.$rows[$keys[$i]];  
					}  
					  
					// Parse to add commas  
					if($i != count($rows)-1)  
					{  
						$update .= ',';   
					}  
				}  
      			$update .= ' WHERE '.$where;  
	 
          	 $query = @mysql_query($update) or $this->Notify(mysql_error()); 
			
            if($query)  
            {  
                return true;   
            }  
            else  
            {  
                return false;   
            }  
        }  
        else  
        {  
            return false;   
        }  
    }
	
		function integertotime($in)
		{
		date_default_timezone_set('Asia/Calcutta');
		return date('H:i A',$in);
		}
		
		function timetointeger($in)
		{
		date_default_timezone_set('Asia/Calcutta');
		$time=explode(":",$in);
		 
		return mktime($time[0],$time[1],0,0,0,0);
		}
			
			
/////////////////////////////////		
/////////////////////////////////			
		function fileupload($tablename,$fname,$id1,$StartFileName)
		{
			
				$tname=$_FILES[$fname]['tmp_name'];
				$file_slice = explode('.', $_FILES[$fname]['name']);
				
				$ext = '';
				$ext = strtoupper(end($file_slice));
				$format = ($ext == 'JPG') ? 'JPEG' : $ext;
				
			
			
			if ((($ext == "GIF")|| ($ext == "JPEG")|| ($ext == "JPG")))
			{
				if ($_FILES[$fname]["error"] > 0)
				{
					"Return Code: " . $_FILES[$fname]["error"] . "<br />";
					return 1;
				}
				else
				{	
					$filemd=$StartFileName."_".$id1;
					$myfilesave1="../staffimage/".$filemd.".".$ext;
					$this->BThumbnail($tname, $myfilesave1, 130,240,$format);
					$qry2 = "UPDATE  ".$tablename."  SET emp_photo= '".$filemd.".".$ext."'  WHERE md5(id)='$id1'"; 				
					mysql_query($qry2);
					
					return;
					
				}
			
			}
		}
/////////////////////////

////////////////////////
		function BThumbnail($img_path, $tn_path, $width,$height, $format="JPEG")
		{ 
			assert(in_array($format, array("JPEG","PNG","GIF")));
			$img = call_user_func("ImageCreateFrom$format", $img_path);
			$img_wd = ImageSX($img);
			$img_ht = ImageSY($img);
			if($img_wd>$img_ht) // if width is bigger that height(landscape)
			{
			$tn_wd  = $width;
			$tn_ht  = ($img_ht * $tn_wd) / $img_wd;
			}
			if($img_wd<$img_ht) // if height is bigger that height(portrait)
			{
			$tn_ht  = $height;
			$tn_wd  = ($img_wd * $tn_ht) / $img_ht;
			}
			if($img_wd==$img_ht)  // if width =  hight (Square)
			{
			$tn_ht  = $height;
			$tn_wd  = $width;
			}
			$tn  = ImageCreateTrueColor($tn_wd, $tn_ht);
			ImageCopyResampled($tn, $img, 0, 0, 0, 0, $tn_wd, $tn_ht, $img_wd, $img_ht);
		
			call_user_func("Image$format", $tn, $tn_path, $width);
			ImageDestroy($img);
			ImageDestroy($tn);
		}	
	
///////////////////////////////	 


		function int_to_words($x)
       {
   $nwords = array("zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", "eleven", "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eighteen", "nineteen", "twenty", 30 => "thirty", 40 => "forty", 50 => "fifty", 60 => "sixty", 70 => "seventy", 80 => "eighty", 90 => "ninety" );	
           global $nwords;
           if(!is_numeric($x))
           {
               $w = '#';
           }else if(fmod($x, 1) != 0)
           {
               $w = '#';
           }else{
               if($x < 0)
               {
                   $w = 'minus ';
                   $x = -$x;
               }else{
                   $w = '';
               }
               if($x < 21)
               {
                   $w .= $nwords[$x];
               }else if($x < 100)
               {
                   $w .= $nwords[10 * floor($x/10)];
                   $r = fmod($x, 10);
                   if($r > 0)
                   {
                       $w .= '-'. $nwords[$r];
                   }
               } else if($x < 1000)
               {
                   $w .= $nwords[floor($x/100)] .' hundred';
                   $r = fmod($x, 100);
                   if($r > 0)
                   {
                       $w .= ' and '. int_to_words($r);
                   }
               } else if($x < 100000)
               {
                   $w .= int_to_words(floor($x/1000)) .' thousand';
                   $r = fmod($x, 1000);
                   if($r > 0)
                   {
                       $w .= ' ';
                       if($r < 100)
                       {
                           $w .= 'and ';
                       }
                       $w .= int_to_words($r);
                   }
               } else {
                   $w .= int_to_words(floor($x/100000)) .' lakh';
                   $r = fmod($x, 100000);
                   if($r > 0)
                   {
                       $w .= ' ';
                       if($r < 100)
                       {
                           $word .= 'and ';
                       }
                       $w .= int_to_words($r);
                   }
               }
           }
           return $w;
       }
}   
?> 