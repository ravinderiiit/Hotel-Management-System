<?php @session_start();
@ob_start();
 
class class_core_admin extends Database
 {
 var $Save;
 
  var $message;

  function class_core_admin(){}
  function showmsg()
  {
	//return "hello class";  
  }
 
		function table_GETDATA($sid)
		{
		  $where="md5(id)='$sid'";
		  return $this->getRows($this->Table_Name,$where);
		}
/*************************System Time setup ****************************/		
function sysTimeSetup()
{

$this->Table_Name="system_timing";
	if(isset($_POST["Save"]))
	{
	//System Details
	$this->stampdate=$this->DateToInt(date("d-m-Y"));
	$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
	$this->userid=$_SESSION["userid"];
		
		if(isset($_POST["Timing"]))
		{
			if($_POST["Timing"]=="byTime")
			{
			$this->timing_rules="CUSTOM";
			$this->timing=$_POST["chkouttime"];
			
			$lastid=$this->insert($this->Table_Name,array($this->timing_rules,$this->timing,$this->userid,$this->stampdate,$this->stamptime),"timing_rules,timing,userid,stampdate,stamptime");
			$where="id<>$lastid";
			$this->update($this->Table_Name,array('suspended_status'=>1),$where);
			$_SESSION["message"]='<div class="alert alert-success"><strong>Success!</strong> Timing rules successfully setup to <strong>"'.$this->timing.'"</strong> system</div>';
			}
			else if($_POST["Timing"]=="24 hours")
			{
			$this->timing_rules="DEFAULT";
			$this->timing="24 HOURS";
			$lastid=$this->insert($this->Table_Name,array($this->timing_rules,$this->timing,$this->userid,$this->stampdate,$this->stamptime),"timing_rules,timing,userid,stampdate,stamptime");
			$where="id<>$lastid";
			$this->update($this->Table_Name,array('suspended_status'=>1),$where);
			$_SESSION["message"]='<div class="alert alert-success"><strong>Success!</strong> Timing rules successfully setup to <strong>24 hours</strong> system</div>';
			}
		}
		else
		{
		$_SESSION["message"]='<div class="alert alert-danger"><strong>Warning!</strong> Please select one timing rule to complete setup</div>';
		}
	}
}
//************************* End ****************************/
/*************************System Filelist Master list / alter ****************************/
function SystemMaster_list()
{ 
$this->Table_Name="system_filelist_master";
$viewname="view_systemmaster_menu_wise";
	
	if(isset($_POST["Search"]))
	{ 
	$_SESSION["where"]=" filename like('%".$_POST["search"]."%') or MenuName like ('%".$_POST["search"]."%') or menu_name like ('%".$_POST["search"]."%')";
	}
 			
	$this->getList($viewname,'id ,filename as "File Name",MenuName as "Menu Name",menu_name as "Under Menu"',$_SESSION["where"],'id',$this->Table_Name);
}
function SystemMaster_alter()
{
		$this->Table_Name="system_filelist_master";
		$vtablename="system_filelist_master";
		
		$this->checkurl($vtablename);
		
		
        $this->filename=$this->temp["filename"]; 
		$this->MenuName=$this->temp["MenuName"];
		$this->undermenuno=$this->temp["undermenuno"];
		
		
		if(isset($_POST["Save"]))
		{
		$this->filename=$_POST["filename"];
		$this->MenuName=ucfirst($_POST["MenuName"]);
		$this->undermenuno=$_POST["undermenuno"];
		
		

			if($_POST["ButtonOperation"]=="New")
			{
				$whr="filename='".$this->filename."'";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{	
				$lastid=$this->insert($this->Table_Name,array($this->filename,$this->MenuName,$this->undermenuno),"filename,MenuName,undermenuno");
				$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
				header("location:SystemMaster_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> File Name Already Exist.Please try with another name</div>';
				}
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
			$uid= $_GET["uid"];
			$where="md5(id)='$uid'";
			$this->update($this->Table_Name,array('filename'=>$this->filename,'MenuName'=>$this->MenuName,'undermenuno'=>$this->undermenuno),$where);
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:SystemMaster_list.php");
			}
			if($_POST["ButtonOperation"]=="View")
			{header("location:SystemMaster_list.php"); }
		}
}
//************************* End ****************************/
/*************************System Filelist details list / alter ****************************/
function SystemMasterDtls_list()
{
 
$this->Table_Name="system_filelist_details";
$viewname="system_filelist";
$_SESSION["where"]= "1 GROUP BY mid";
$this->UserType=NULL;
$this->UserName=NULL;	
	if(isset($_POST["Search"]))
	{ 
	$_SESSION["where"]=" filename like('%".$_POST["search"]."%') or MenuName like ('%".$_POST["search"]."%')";
	}
	if(isset($_GET["uid"]))
	{
	$_SESSION["where"]=" md5(UserType)='".$_GET["uid"]."'";
	}
	
	 $menu='if(List=1,"Grant","Revoked") as "List",if(AddOn=1,"Grant","Revoked") as "Add",if(Edit=1,"Grant","Revoked") as "Edit",if(View=1,"Grant","Revoked") as "View",if(`Delete`=1,"Grant","Revoked") as "Delete",if(Edit=1,"Grant","Revoked") as "Edit"';
	$this->getList($viewname,'id ,filename as "File Name",MenuName as "Menu Name",menu_name as "Under Menu",'.$menu.',EditName as "Edit Name",ViewName as "View Name",DeleteName as "Delete Name",viewfile as "View File",editfile as "Edit File"', $_SESSION["where"],'id',$this->Table_Name);			
					
	if(isset($_POST["Save"]))
	{
		if($_POST["Save"]=="Edit")
		{
			if($_POST["user"]!=NULL)
			{
			$user=$_POST["user"];
			header("location:SystemMasterDtls_alter.php?uid=$user");
			}
			else
			{
			header("location:SystemMasterDtls_alter.php");
			}
		}
	}

}
function SystemMasterDtls_alter()
{
$where="1 group by mid";
$this->flag=0;
$this->UserType=NULL;
if(isset($_GET["uid"]))
{
$this->UserType=$_GET["uid"];
$where=" md5(UserType)='".$_GET["uid"]."'";
}

		$this->res=mysql_query("select * from system_filelist group by id");
		if(mysql_num_rows($this->res)>0)
		{
		$this->flag=1;
		}
	

//saving process begins
$this->Table_Name="system_filelist_details";
$vtablename="system_filelist";
				
				$sql="select * from tbl_user_type where md5(id)='".$this->UserType."'";
				$usrRes=mysql_query($sql);
					if(mysql_num_rows($usrRes)>0)
					{
					$usrData=mysql_fetch_array($usrRes);
					$this->UserType=$usrData["id"];
					$this->UserName=$usrData["user_type"];
					}
		
		if(isset($_POST["Save"]))
		{
			$count=$_POST["count"];
							
				
					//for those user who has not listed
					
						
							for($i=1;$i<$count;$i++)
							{
							$this->mid			=	$_POST["mid_$i"];
							$this->List			=	$_POST["List_$i"];
							$this->Add			=	$_POST["Add_$i"];
							$this->Edit			=	$_POST["Edit_$i"];
							$this->Delete		=	$_POST["Delete_$i"];
							$this->View			=	$_POST["View_$i"];
							$this->EditName		=	$_POST["EditName_$i"];
							$this->ViewName		=	$_POST["ViewName_$i"];
							$this->DeleteName	=	$_POST["DeleteName_$i"];
							$this->viewFile		=	$_POST["viewFile_$i"];
							$this->editFile		=	$_POST["editFile_$i"];
							$this->panelYesNo	=	$_POST["panelYesNo_$i"];
							
								$whr="mid='".$this->mid."' and UserType='".$this->UserType."'";
								if($this->getNumRows($this->Table_Name, $whr)<=0)
								{
								$this->insert($this->Table_Name,array($this->mid,$this->List,$this->Add,$this->Edit,$this->Delete,$this->View,$this->EditName,$this->ViewName,$this->DeleteName,$this->viewFile,$this->editFile,$this->panelYesNo,$this->UserType),"mid,List,AddOn,Edit,`Delete`,View,EditName,ViewName,DeleteName,viewFile,editFile,panelYesNo,UserType");
								}
								else
								{	
													
								$where=" mid='".$this->mid."' and UserType='".$this->UserType."'";				
								$this->update($this->Table_Name,array('`Delete`'=>$this->Delete,'List'=>$this->List,'AddOn'=>$this->Add,'Edit'=>$this->Edit,'View'=>$this->View,'EditName'=>$this->EditName,'ViewName'=>$this->ViewName,'DeleteName'=>$this->DeleteName,'viewFile'=>$this->viewFile,'editFile'=>$this->editFile,'panelYesNo'=>$this->panelYesNo),$where);
								}
							}
							$_SESSION["message"]='<div class="alert alert-success"><strong>Success!</strong> Permission Granted Successfully</div>';
							header("location:SystemMasterDtls_list.php?page=1&cmd=Clear");
						
											

			}
		
}

//************************* End ****************************/
/*************************Financial year Master list / alter ****************************/
function sysFY_list()
{ 
$this->Table_Name="tbl_sys_financial_year";
$counter=$_POST['counter'];
		for($i=1;$i<$counter;$i++)
		{	
			if(isset($_POST["Save_$i"]))
			{
				$fy_id=$_POST["fy_id_$i"];
				if($_POST["Save_$i"]=="Enable")
				{
				$where="1";
				$this->update($this->Table_Name,array('suspended_status'=>1),$where);
				$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
				$_SESSION["fy_id"]=0;
				}
				if($_POST["Save_$i"]=="Disabled")
				{
				$where="1";
				$this->update($this->Table_Name,array('suspended_status'=>1),$where);
				$where="id='$fy_id'";
				$this->update($this->Table_Name,array('suspended_status'=>0),$where);
				$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
				$_SESSION["fy_id"]=$fy_id;		
				}
			}
		}
}
function sysFY_alter()
{
		$this->Table_Name="tbl_sys_financial_year";
		$vtablename="tbl_sys_financial_year";
		
		$this->checkurl($vtablename);
		
		
        $this->yr_frm=$this->temp["yr_frm"]; 
		$this->yr_to=$this->temp["yr_to"]; 
		
		
		if(isset($_POST["Save"]))
		{
		$this->yr_to=strtoupper($_POST["yr_to"]);
		$this->yr_frm=strtoupper($_POST["yr_frm"]);
		$yr_diff=$this->yr_to-$this->yr_frm;
		$counter=$_POST['counter'];
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		

			if($_POST["ButtonOperation"]=="New")
			{
				if($yr_diff==1)
				{
				$whr="yr_frm='".$this->yr_frm."' and yr_to='".$this->yr_to."' and suspended_status=0";
						if($this->getNumRows($this->Table_Name, $whr)<=0)
						{
							$yr=date('Y');
							if($yr>=$this->yr_frm && $yr+1>=$this->yr_to)
							{
							$lastid=$this->insert($this->Table_Name,array($this->yr_frm,$this->yr_to,$this->userid,$this->stampdate,$this->stamptime),"yr_frm,yr_to,userid,stampdate,stamptime");
							$where="1";
							$this->update($this->Table_Name,array('suspended_status'=>1),$where);
							$where="id='$lastid'";
							$this->update($this->Table_Name,array('suspended_status'=>0),$where);
							$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
							header("location:sysFinancialYear_list.php");
							}
							else
							{
							$_SESSION["message"]='<div class="alert alert-danger"><strong>Warning!</strong> You cannot add future YEAR with current year '.$yr.' to '.($yr+1).'</div>';	
							}
						}
						else
						{
						$_SESSION["message"]='<div class="alert alert-danger"><strong>Warning!</strong> This series is already defined.Please try with another series.</div>';
						}
				}
				else
				{
				$_SESSION["message"]='<div class="alert alert-danger"><strong>Warning!</strong> The format of year series is incorrect.</div>';	
				}
			}
			if($_POST["ButtonOperation"]=="Edit")
			{  
			$uid= $_GET["uid"];
			$where="md5(id)='$uid'";
			$this->update($this->Table_Name,array('yr_to'=>$this->yr_to,'yr_frm'=>$this->yr_frm,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:sysFinancialYear_list.php");
			}
			if($_POST["ButtonOperation"]=="View")
			{ 			header("location:sysFinancialYear_list.php"); }
			
			
		}
}
//************************* End ****************************/
/*************************User Type Master list / alter ****************************/
function UserType_list()
{ 
$this->Table_Name="tbl_user_type";
			$viewname="tbl_user_type";
 			
			$this->getList($viewname,'id ,user_type as "User Types"',$_SESSION["where"],'id',$this->Table_Name);
}
function UserType_alter()
{
		$this->Table_Name="tbl_user_type";
		$vtablename="tbl_user_type";
		
		$this->checkurl($vtablename);
		
		
        $this->user_type=$this->temp["user_type"]; 
		
		
		
		if(isset($_POST["Save"]))
		{
		$this->user_type=ucfirst($_POST["user_type"]);
		
		

			if($_POST["ButtonOperation"]=="New")
			{
				$whr="user_type='".$this->user_type."' and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{
				$lastid=$this->insert($this->Table_Name,array($this->user_type),"user_type");
				
				$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
				header("location:UserType_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> User already defined.Please try with another name.</div>';
				}
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
			$uid= $_GET["uid"];
			$where="md5(id)='$uid'";
			$this->update($this->Table_Name,array('user_type'=>$this->user_type),$where);
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:UserType_list.php");
			}
			if($_POST["ButtonOperation"]=="View")
			{header("location:UserType_list.php"); }
		}
}
//************************* End ****************************/

/*************************Menu Master list / alter ****************************/
function menu_list()
{ 
	$_SESSION["where"]="suspended_status=0";
	if(isset($_POST["Search"])){$_SESSION["where"]=" menu_name like('%".$_POST["search"]."%') and suspended_status=0";}
		
			
			$this->Table_Name="tbl_menu_master";
			$viewname="tbl_menu_master";
 			
			$this->getList($viewname,'id ,menu_name as "Menu Name"',$_SESSION["where"],'id',$this->Table_Name);
}
function menu_alter()
{
		$this->Table_Name="tbl_menu_master";
		$vtablename="tbl_menu_master";
		
		$this->checkurl($vtablename);
		
		
        $this->menu_name=$this->temp["menu_name"]; 
		
		
		
		if(isset($_POST["Save"]))
		{
		$this->menu_name=strtoupper($_POST["menu_name"]);
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		

			if($_POST["ButtonOperation"]=="New")
			{
				$whr="menu_name='".$this->menu_name."' and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{
				$lastid=$this->insert($this->Table_Name,array($this->menu_name,$this->userid,$this->stampdate,$this->stamptime),"menu_name,userid,stampdate,stamptime");
				
				$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
				header("location:Menu_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> Menu Name already defined.Please try with another name.</div>';
				}
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
			$uid= $_POST["uid"];
			$where="md5(id)='$uid'";
			$this->update($this->Table_Name,array('menu_name'=>$this->menu_name,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:Menu_list.php");
			}
			if($_POST["ButtonOperation"]=="View")
			{header("location:Menu_list.php"); }
		}
}
//************************* End ****************************/
/*************************Group Master list / alter ****************************/
function Group_list()
{ 
		$_SESSION["where"]="suspended_status=0";
		if(isset($_POST["Search"])){$_SESSION["where"]=" group_name like('%".$_POST["search"]."%') and suspended_status=0";}
		
			
			$this->Table_Name="tbl_group_mstr";
			$viewname="tbl_group_mstr";
 			
			$this->getList($viewname,'id ,group_name as "Group Name"',$_SESSION["where"],'id',$this->Table_Name);
}
function Group_alter()
{
		$this->Table_Name="tbl_group_mstr";
		$vtablename="tbl_group_mstr";
		
		$this->checkurl($vtablename);
		
		
        $this->group_name=$this->temp["group_name"]; 
		
		
		
		if(isset($_POST["Save"]))
		{
		$this->group_name=strtoupper($_POST["group_name"]);
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		

			if($_POST["ButtonOperation"]=="New")
			{
				$whr="group_name='".$this->group_name."' and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{
				$lastid=$this->insert($this->Table_Name,array($this->group_name,$this->userid,$this->stampdate,$this->stamptime),"group_name,userid,stampdate,stamptime");
				$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
				header("location:Group_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> Group already defined.Please try with another name.</div>';
				}
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
			$uid= $_GET["uid"];
			$where="md5(id)='$uid'";
			$this->update($this->Table_Name,array('group_name'=>$this->group_name,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:group_list.php");
			}
			if($_POST["ButtonOperation"]=="View")
			{ 			header("location:group_list.php"); }
		}
}
//************************* End ****************************/

/*************************Floor Master list / alter ****************************/
function floor_list()
{ 
		$_SESSION["where"]="suspended_status=0";
		if(isset($_POST["Search"])){$_SESSION["where"]=" floor_name like('%".$_POST["search"]."%') and suspended_status=0";}
		
			
			$this->Table_Name="tbl_floor_mstr";
			$viewname="tbl_floor_mstr";
 			
			$this->getList($viewname,'id ,floor_name as "Floor Name"',$_SESSION["where"],'id',$this->Table_Name);
}
function floor_alter()
{
		$this->Table_Name="tbl_floor_mstr";
		$vtablename="tbl_floor_mstr";
		
		$this->checkurl($vtablename);
		
		
        $this->floor_name=$this->temp["floor_name"]; 
		
		
		
		if(isset($_POST["Save"]))
		{
		$this->floor_name=strtoupper($_POST["floor_name"]);
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		

			if($_POST["ButtonOperation"]=="New")
			{
				$whr="floor_name='".$this->floor_name."' and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{
				$lastid=$this->insert($this->Table_Name,array($this->floor_name,$this->userid,$this->stampdate,$this->stamptime),"floor_name,userid,stampdate,stamptime");
				$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
				header("location:floor_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> Floor already defined.Please try with another name.</div>';
				}
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
			$uid= $_GET["uid"];
			$where="md5(id)='$uid'";
			$this->update($this->Table_Name,array('floor_name'=>$this->floor_name,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:floor_list.php");
			}
			if($_POST["ButtonOperation"]=="View")
			{ 			header("location:floor_list.php"); }
		}
}
//************************* End ****************************/
/*************************Room  Taxes Master list / alter ****************************/
function roomtaxes_list()
{ 
		$_SESSION["where"]="suspended_status=0";
		if(isset($_POST["Search"])){$_SESSION["where"]=" (taxname like('%".$_POST["search"]."%') or percentage like('%".$_POST["search"]."%')) and suspended_status=0";}
		
			
			$this->Table_Name="tbl_room_tax_master";
			$viewname="tbl_room_tax_master";
 			
			$this->getList($viewname,'id ,taxname as "Tax Name"',$_SESSION["where"],'id',$this->Table_Name);
}
function roomtaxes_alter()
{
		$this->Table_Name="tbl_room_tax_master";
		$vtablename="tbl_room_tax_master";
		
		$this->checkurl($vtablename);
		
		
        $this->tax_name=$this->temp["taxname"]; 
		 $this->tax_val=$this->temp["percentage"]; 
		
		
		
		if(isset($_POST["Save"]))
		{
		$this->taxname=ucfirst($_POST["tax_name"]);
		
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		

			if($_POST["ButtonOperation"]=="New")
			{
				$whr="taxname='".$this->taxname."' suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{
				$lastid=$this->insert($this->Table_Name,array($this->taxname,$this->userid,$this->stampdate,$this->stamptime),"taxname,userid,stampdate,stamptime");
				$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
				header("location:RoomTaxMaster_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> Tax already defined.Please try with another name & value.</div>';
				}
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
			$uid= $_GET["uid"];
			$where="md5(id)='$uid'";
			$this->update($this->Table_Name,array('taxname'=>$this->taxname,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:RoomTaxMaster_list.php");
			}
			if($_POST["ButtonOperation"]=="View")
			{ 			header("location:RoomTaxMaster_list.php"); }
		}
}
//************************* End ****************************/
/*************************Room  Taxes Master list / alter ****************************/
function roomtaxdtl_list()
{ 
		$_SESSION["where"]="suspended_status=0";
		if(isset($_POST["Search"])){$_SESSION["where"]=" (taxname like('%".$_POST["search"]."%') or group_name like('%".$_POST["search"]."%') or calc_val like('%".$_POST["search"]."%') ) and suspended_status=0";}
		
			
			$this->Table_Name="tbl_room_tax_details";
			$viewname="view_room_tax_mstr_dtl_wise";
 			
			$this->getList($viewname,'id ,taxname as "Tax Name",group_name as "for Group",min_range as "MIN. Range",max_range as "MAX. Range",calc_val as "Value (%)"',$_SESSION["where"],'id',$this->Table_Name);
}
function roomtaxdtl_alter()
{
		$this->Table_Name="tbl_room_tax_details";
		$vtablename="tbl_room_tax_details";
		
		$this->checkurl($vtablename);
		
		
        $this->tax_mstr_id=$this->temp["tax_mstr_id"]; 
		$this->group_mstr_id=$this->temp["group_mstr_id"]; 
		$this->min_range=$this->temp["min_range"]; 
		$this->max_range=$this->temp["max_range"]; 
		$this->calc_val=$this->temp["calc_val"]; 
		$this->suspended_status=$this->temp["suspended_status"]; 
		$this->userid=$this->temp["userid"]; 
		$this->stampdate=$this->temp["stampdate"]; 
		$this->stamptime=$this->temp["stamptime"]; 
		
		if(isset($_POST["Save"]))
		{
		$this->tax_mstr_id=$_POST["tax_mstr_id"];
		$this->group_mstr_id=$_POST["group_mstr_id"];
		$this->min_range=$_POST["min_range"];
		$this->max_range=$_POST["max_range"];
		$this->calc_val=$_POST["calc_val"];
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		

			if($_POST["ButtonOperation"]=="New")
			{
				$whr="tax_mstr_id='".$this->tax_mstr_id."' and group_mstr_id='".$this->group_mstr_id."' and min_range='".$this->min_range."' and max_range='".$this->max_range."' and calc_val='".$this->calc_val."' and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{
				$lastid=$this->insert($this->Table_Name,array($this->tax_mstr_id,$this->group_mstr_id,$this->min_range,$this->max_range,$this->calc_val,$this->userid,$this->stampdate,$this->stamptime),"tax_mstr_id,group_mstr_id,min_range,max_range,calc_val,userid,stampdate,stamptime");
				$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
				header("location:RoomTaxDtl_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> Tax already defined.Please try with another name & value.</div>';
				}
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
			$uid= $_GET["uid"];
			$where="md5(id)='$uid'";
			$this->update($this->Table_Name,array('tax_mstr_id'=>$this->tax_mstr_id,'group_mstr_id'=>$this->group_mstr_id,'min_range'=>$this->min_range,'max_range'=>$this->max_range,'calc_val'=>$this->calc_val,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:RoomTaxDtl_list.php");
			}
			if($_POST["ButtonOperation"]=="View")
			{ 			header("location:RoomTaxDtl_list.php"); }
		}
}
//************************* End ****************************/

/*************************Room Type Master list / alter ****************************/
function roomtype_list()
{ 
	$_SESSION["where"]="suspended_status=0";
	if(isset($_POST["Search"])){$_SESSION["where"]=" (room_type like('%".$_POST["search"]."%') or group_name like('%".$_POST["search"]."%')) and suspended_status=0";}
	 
			
			$this->Table_Name="tbl_room_type_mstr";
			$viewname="view_tbl_room_type_mstr_group_wise";
 			
			$this->getList($viewname,'id ,room_type as "Room Types",group_name as "Under Group",rate as "Rate"',$_SESSION["where"],'id',$this->Table_Name);
}
function roomtype_alter()
{
		$this->Table_Name="tbl_room_type_mstr";
		$vtablename="tbl_room_type_mstr";
		
		$this->checkurl($vtablename);
		
		
        $this->room_type=$this->temp["room_type"]; 
		$this->rate=$this->temp["rate"]; 
		$this->group_mstr_id=$this->temp["group_mstr_id"]; 
		
		if(isset($_POST["Save"]))
		{
		$this->room_type=strtoupper($_POST["room_type"]);
		$this->rate=$_POST["rate"];
		$this->group_id=$_POST["group_id"];
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		

			if($_POST["ButtonOperation"]=="New")
			{
				$whr="room_type='".$this->purpose_name."' and rate='".$this->rate."'  and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{
				$lastid=$this->insert($this->Table_Name,array($this->group_id,$this->room_type,$this->rate,$this->userid,$this->stampdate,$this->stamptime),"group_mstr_id,room_type,rate,userid,stampdate,stamptime");
			
				$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
				header("location:RoomType_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> Room Type and its Rate already defined. Please try with another name.</div>';
				}
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
			$uid= $_GET["uid"];
			$where="md5(id)='$uid'";
			$this->update($this->Table_Name,array('group_mstr_id'=>$this->group_id,'room_type'=>$this->room_type,'rate'=>$this->rate,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:RoomType_list.php");
			}
			if($_POST["ButtonOperation"]=="View")
			{ header("location:RoomType_list.php");}
		}
}

//************************* End ****************************/
/*************************Room Details list / alter ****************************/
function roomdtl_list()
{ 
$_SESSION["where"]="suspended_status=0";
if(isset($_POST["Search"])){$_SESSION["where"]=" (room_type like('%".$_POST["search"]."%') or rate like('%".$_POST["search"]."%') or room_no like('%".$_POST["search"]."%') or floor_name like('%".$_POST["search"]."%')) and suspended_status=0";}
		
			
			$this->Table_Name="tbl_room_dtl";
			$viewname="view_room_type_floor_dtl_wise";
 			
			$this->getList($viewname,'id ,room_no as "Room No.",room_type as "Room Type",under_group as "Under Group",floor_name as "On Floor",rate as "Room Rate"',$_SESSION["where"],'id',$this->Table_Name);
}
function roomdtl_alter()
{
		$this->Table_Name="tbl_room_dtl";
		$vtablename="tbl_room_dtl";
		
		$this->checkurl($vtablename);
		
		
        $this->room_type_mstr_id=$this->temp["room_type_mstr_id"]; 
		$this->floor_id=$this->temp["floor_id"]; 
		$this->room_no=$this->temp["room_no"];
		
		if(isset($_POST["Save"]))
		{
		$this->room_type_mstr_id=strtoupper($_POST["room_type_mstr_id"]);
		$this->floor_id=$_POST["floor_id"];
		$this->room_no=$_POST["room_no"];
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		

			if($_POST["ButtonOperation"]=="New")
			{
				$whr="room_no='".$this->room_no."' and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{		
				$lastid=$this->insert($this->Table_Name,array($this->room_type_mstr_id,$this->floor_id,$this->room_no,$this->userid,$this->stampdate,$this->stamptime),"room_type_mstr_id,floor_id,room_no,userid,stampdate,stamptime");
				
				$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
				header("location:RoomDtl_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> Room Already assigned you cannot assigned multiple room type into a single Room No.</div>';
				}
			
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
				$whr="room_no='".$this->room_no."' and room_type_mstr_id='".$this->room_type_mstr_id."' and floor_id='".$this->floor_id."' and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{			
				$uid= $_GET["uid"];
				$where="md5(id)='$uid'";
				$this->update($this->Table_Name,array('room_type_mstr_id'=>$this->room_type_mstr_id,'floor_id'=>$this->floor_id,'room_no'=>$this->room_no,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
				$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
				header("location:RoomDtl_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> Room Already assigned you cannot assigned multiple room type into a single Room No.</div>';
				}
			}
			if($_POST["ButtonOperation"]=="View")
			{ header("location:RoomDtl_list.php");}
		}
}
//************************* End ****************************/
/*************************Purpose Type Master list / alter ****************************/
function purpose_list()
{ 
	$_SESSION["where"]="suspended_status=0";
	if(isset($_POST["Search"])){$_SESSION["where"]=" purpose_name like('%".$_POST["search"]."%') and suspended_status=0";}
			$this->Table_Name="tbl_purpose_mstr";
			$viewname="tbl_purpose_mstr";
 			
			$this->getList($viewname,'id ,purpose_name as "Purpose"',$_SESSION["where"],'id',$this->Table_Name);
}
function purpose_alter()
{
		$this->Table_Name="tbl_purpose_mstr";
		$vtablename="tbl_purpose_mstr";
		
		$this->checkurl($vtablename);
		
		
        $this->purpose_name=$this->temp["purpose_name"]; 
	
		
		if(isset($_POST["Save"]))
		{
		$this->purpose_name=strtoupper($_POST["purpose_name"]);
		
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		

			if($_POST["ButtonOperation"]=="New")
			{
				$whr="purpose_name='".$this->purpose_name."' and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{		
				$lastid=$this->insert($this->Table_Name,array($this->purpose_name,$this->userid,$this->stampdate,$this->stamptime),"purpose_name,userid,stampdate,stamptime");
				
				$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
				header("location:purpose_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> Purpose already defined please try with another name.</div>';
				}
			
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
				$whr="purpose_name='".$this->purpose_name."' and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{			
				$uid= $_GET["uid"];
				$where="md5(id)='$uid'";
				$this->update($this->Table_Name,array('purpose_name'=>$this->purpose_name,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
				$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
				header("location:RoomDtl_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong>Purpose already defined please try with another name..</div>';
				}
			}
			if($_POST["ButtonOperation"]=="View")
			{header("location:RoomDtl_list.php"); }
		}
}
//************************* End ****************************/
/*************************Facility Type Master list / alter ****************************/
function facility_list()
{ 
	$_SESSION["where"]="suspended_status=0";
	if(isset($_POST["Search"])){$_SESSION["where"]=" fac_name like('%".$_POST["search"]."%') and suspended_status=0";}
			$this->Table_Name="tbl_facility_dtl";
			$viewname="view_facility_room_wise";
 			
			$this->getList($viewname,'id ,room_type as "Room Type",fac_name as "Facility",rate as "Rate"',$_SESSION["where"],'id',$this->Table_Name);
}
function facility_alter()
{
		$this->Table_Name="tbl_facility_dtl";
		$vtablename="tbl_facility_dtl";
		
		$this->checkurl($vtablename);
		
		
        $this->room_type_mstr_id=$this->temp["room_type_mstr_id"]; 
		$this->fac_name=$this->temp["fac_name"]; 
		$this->rate=$this->temp["rate"];
		if(isset($_POST["Save"]))
		{
		$this->room_type_mstr_id=$_POST["room_type_mstr_id"];
		$this->fac_name=strtoupper($_POST["fac_name"]);
		$this->rate=$_POST["rate"];
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		

			if($_POST["ButtonOperation"]=="New")
			{
				$whr="room_type_mstr_id='".$this->room_type_mstr_id."' and fac_name='".$this->fac_name."' and rate='".$this->rate."' and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{		
				$lastid=$this->insert($this->Table_Name,array($this->room_type_mstr_id,$this->fac_name,$this->rate,$this->userid,$this->stampdate,$this->stamptime),"room_type_mstr_id,fac_name,rate,userid,stampdate,stamptime");
				
				$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
				header("location:RoomFacilty_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> Facility already defined in selected Room please try with another name.</div>';
				}
			
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
				$whr="room_type_mstr_id='".$this->room_type_mstr_id."' and fac_name='".$this->fac_name."' and rate='".$this->rate."' and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{			
				$uid= $_GET["uid"];
				$where="md5(id)='$uid'";
				$this->update($this->Table_Name,array('room_type_mstr_id'=>$this->room_type_mstr_id,'fac_name'=>$this->fac_name,'rate'=>$this->rate,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
				$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
				header("location:RoomFacilty_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong>Facility already defined in selected Room please try with another name.</div>';
				}
			}
			if($_POST["ButtonOperation"]=="View")
			{header("location:RoomFacilty_list.php"); }
		}
}
//************************* End ****************************/
/*************************User Setup Master list / alter ****************************/
function usersetup_list()
{ 
			$this->Table_Name="system_login";
			$viewname="system_login";
 			
			$this->getList($viewname,'id ,emailid as "User Id",preveledge as "Preveledge"',$_SESSION["where"],'id',$this->Table_Name);
}
function usersetup_alter()
{
		$this->Table_Name="system_login";
		$vtablename="system_login";
		
		$this->checkurl($vtablename);
		
		
        $this->user_type=$this->temp["user_type"]; 
		$this->empid=$this->temp["empid"]; 
		$this->preveledge=$this->temp["preveledge"];
		$this->emailid=$this->temp["emailid"]; 
		$this->user_type=$this->temp["user_type"]; 
		$this->sysdept_id=$this->temp["sysdept_id"]; 
		
		 
		
		
		
		if(isset($_POST["Save"]))
		{
			
		$this->user_type=($_POST["user_type"]);
		$sysdept=explode("@",$_POST["preveledge"]);
		$this->sysdept_id=$sysdept[0];
		$this->empid=$_POST["empid"];
		$this->preveledge=$sysdept[1];
		$this->emailid=$_POST["emailid"];
		$this->password=md5($_POST["password"]);
		$this->cpassword=md5($_POST["cpassword"]);
		//System Details
		$this->creation_date=(date("Y-m-d H:i"));
		
		
		

			if($_POST["ButtonOperation"]=="New")
			{
				if(($this->cpassword==$this->password)&& $this->password!="" )
				{
					$whr="emailid='".$this->emailid."'";
					if($this->getNumRows($this->Table_Name, $whr)<=0)
					{
					$lastid=$this->insert($this->Table_Name,array($this->user_type,$this->sysdept_id,$this->empid,$this->preveledge,$this->emailid,$this->password,$this->creation_date),"user_type,sysdept_id,empid,preveledge,emailid,password,creation_date");
					$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
					header("location:usersetup_list.php");
					}
					else
					{
					$_SESSION["message"]='<div class="alert alert-danger"><strong>Warning!</strong> email id already defined.Please try with another name.</div>';
					}
				}
				else
				{
					$_SESSION["message"]='<div class="alert alert-danger"><strong>Warning!</strong> User Id & Password does not matched</div>';
				}
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
			$uid= $_GET["uid"];
			$where="md5(id)='$uid'";
			if(($this->cpassword==$this->password)&& $this->password!="" ){
			$this->update($this->Table_Name,array('user_type'=>$this->user_type,'sysdept_id'=>$this->sysdept_id,'empid'=>$this->empid,'preveledge'=>$this->preveledge,'emailid'=>$this->emailid,'password'=>$this->password,'creation_date'=>$this->creation_date),$where);
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:usersetup_list.php");
			}
			else{
			$_SESSION["message"]='<div class="alert alert-danger"><strong>Warning!</strong>  Password did not matched</div>';
			
			}
			
			}
			if($_POST["ButtonOperation"]=="View")
			{ 			header("location:usersetup_list.php"); }
		
		}
}
//************************* End ****************************/
/*************************User Setup Master list / alter ****************************/
function employeesetup_list()
{ 
	$this->Table_Name="tbl_employee_master";
			$viewname="tbl_employee_master";
 			
			$this->getList($viewname,'id ,emp_code as "Employee Code",emp_name as "Employee Name",contact_no as "Contact No.",email as "Email Id"',$_SESSION["where"],'id',$this->Table_Name);
}
function employeesetup_alter()
{
		$this->Table_Name="tbl_employee_master";
		$vtablename="tbl_employee_master";
		
		$this->checkurl($vtablename);
		
		
        $this->emp_code=$this->temp["emp_code"]; 
		$this->emp_name=$this->temp["emp_name"]; 
		$this->dept_id=$this->temp["dept_id"];
		$this->desg_id=$this->temp["desg_id"]; 
		$this->doj=$this->temp["doj"];
		$this->contact_no=$this->temp["contact_no"];
		$this->email=$this->temp["email"];
		$this->dob=$this->temp["dob"];
		$this->emp_image=$this->temp["emp_image"];
		
		 
		
		
		
		if(isset($_POST["Save"]))
		{
		
		$this->emp_code=$_POST["emp_code"];
		$this->emp_name=$_POST["emp_name"];
		$this->dept_id=$_POST["dept_id"];
		$this->desg_id=$_POST["desg_id"];
		$this->doj=$this->DateToInt($_POST["doj"]);
		$this->contact_no=$_POST["contact_no"];
		$this->email=$_POST["email"];
		$this->dob=$this->DateToInt($_POST["dob"]);
		$this->emp_image=basename($_FILES['emp_image']['name']);
		///System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		
		
		

			if($_POST["ButtonOperation"]=="New")
			{
					$whr="emp_code='".$this->emp_code."'";
					if($this->getNumRows($this->Table_Name, $whr)<=0)
					{
					$lastid=$this->insert($this->Table_Name,array($this->emp_code,$this->emp_name,$this->dept_id,$this->desg_id,$this->doj,$this->contact_no,$this->email,$this->dob,$this->emp_image,$this->userid,$this->stampdate,$this->stamptime),"emp_code,emp_name,dept_id,desg_id,doj,contact_no,email,dob,emp_image,userid,stampdate,stamptime");
					
					if($this->emp_image!="")
					{
					$slicenm=explode(".",$this->emp_image);
					$filnm="MSTR".md5($lastid);
					$len=sizeof($slicenm);
					$ext=$slicenm[$len-1];
					$this->emp_image=$filnm.".".$ext;
					
					$su=move_uploaded_file($_FILES["emp_image"]["tmp_name"],"../common/resource/employee/".$this->emp_image);
						if($su)
						{
							echo "Success";
						}
						else
						{
							echo "Failed";
						}
					}
					
					
					$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
					header("location:employeesetup_list.php");
					}
					else
					{
					$_SESSION["message"]='<div class="alert alert-danger"><strong>Warning!</strong> Employee Code already defined.Please try with another name.</div>';
					}
			
				
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{ 
				
			
			
			 
			$uid= $_GET["uid"];
			$where="md5(id)='$uid'";
			
			if($this->emp_image!="")
						{
						$slicenm=explode(".",$this->emp_image);
						$filnm="MSTR".$uid;
						$len=sizeof($slicenm);
						$ext=$slicenm[$len-1];
						$this->emp_image=$filnm.".".$ext;
						
						$su=move_uploaded_file($_FILES["emp_image"]["tmp_name"],"../common/resource/employee/".$this->emp_image);
							if($su)
							{
								echo "Success";
							}
							else
							{
								echo "Failed";
							}
						}
			
			$this->update($this->Table_Name,array('emp_code'=>$this->emp_code,'emp_name'=>$this->emp_name,'dept_id'=>$this->dept_id,'desg_id'=>$this->desg_id,'doj'=>$this->doj,'contact_no'=>$this->contact_no,'email'=>$this->email,'dob'=>$this->dob,'emp_image'=>$this->emp_image,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:employeesetup_list.php");
			}
			if($_POST["ButtonOperation"]=="View")
			{ 			header("location:employeesetup_list.php");
			}
		
		}
}
//************************* End ****************************/

/*************************Department Master list / alter ****************************/
function department_list()
{ 
		$_SESSION["where"]="suspended_status=0";
		if(isset($_POST["Search"])){$_SESSION["where"]=" department like('%".$_POST["search"]."%') and suspended_status=0";}
		
			
			$this->Table_Name="tbl_dept_mstr";
			$viewname="tbl_dept_mstr";
 			
			$this->getList($viewname,'id ,department as "Department"',$_SESSION["where"],'id',$this->Table_Name);
}
function department_alter()
{
		$this->Table_Name="tbl_dept_mstr";
		$vtablename="tbl_dept_mstr";
		
		$this->checkurl($vtablename);
		
		
        $this->department=$this->temp["department"]; 
		
		
		
		if(isset($_POST["Save"]))
		{
		$this->department=strtoupper($_POST["department"]);
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		

			if($_POST["ButtonOperation"]=="New")
			{
				$whr="department='".$this->department."' and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{
				$lastid=$this->insert($this->Table_Name,array($this->department,$this->userid,$this->stampdate,$this->stamptime),"department,userid,stampdate,stamptime");
				$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
				header("location:department_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> Floor already defined.Please try with another name.</div>';
				}
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
			$uid= $_GET["uid"];
			$where="md5(id)='$uid'";
			$this->update($this->Table_Name,array('department'=>$this->department,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:department_list.php");
			}
			if($_POST["ButtonOperation"]=="View")
			{ 			header("location:department_list.php");
			 }
		}
}
//************************* End ****************************/
/*************************Designation Master list / alter ****************************/
function designation_list()
{ 
		$_SESSION["where"]="suspended_status=0";
		if(isset($_POST["Search"])){$_SESSION["where"]=" designation like('%".$_POST["search"]."%') and suspended_status=0";}
		
			
			$this->Table_Name="tbl_desg_mstr";
			$viewname="tbl_desg_mstr";
 			
			$this->getList($viewname,'id ,designation as "Designation"',$_SESSION["where"],'id',$this->Table_Name);
}
function designation_alter()
{
		$this->Table_Name="tbl_desg_mstr";
		$vtablename="tbl_desg_mstr";
		
		$this->checkurl($vtablename);
		
		
        $this->designation=$this->temp["designation"]; 
		
		
		
		if(isset($_POST["Save"]))
		{
		$this->designation=strtoupper($_POST["designation"]);
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		

			if($_POST["ButtonOperation"]=="New")
			{
				$whr="designation='".$this->designation."' and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{
				$lastid=$this->insert($this->Table_Name,array($this->designation,$this->userid,$this->stampdate,$this->stamptime),"designation,userid,stampdate,stamptime");
				$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
				header("location:designation_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> Floor already defined.Please try with another name.</div>';
				}
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
			$uid= $_GET["uid"];
			$where="md5(id)='$uid'";
			$this->update($this->Table_Name,array('designation'=>$this->designation,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:designation_list.php");
			}
			if($_POST["ButtonOperation"]=="View")
			{ 			header("location:designation_list.php");
			 }
		}
}
//************************* End ****************************/

/*************************Department Master list / alter ****************************/
function sysdept_list()
{ 
		
		
			
			$this->Table_Name="sysdept";
			$viewname="sysdept";
 			
			$this->getList($viewname,'id ,name as "Department Name"',$_SESSION["where"],'id',$this->Table_Name);
}
function sysdept_alter()
{
		$this->Table_Name="sysdept";
		$vtablename="sysdept";
		
		$this->checkurl($vtablename);
		
		
        $this->sysdept_name=$this->temp["name"]; 
		
		
		
		if(isset($_POST["Save"]))
		{
		$this->sysdept_name=strtoupper($_POST["sysdept_name"]);
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		

			if($_POST["ButtonOperation"]=="New")
			{
				$whr="name='".$this->sysdept_name."' and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{
				$lastid=$this->insert($this->Table_Name,array($this->sysdept_name,$this->userid,$this->stampdate,$this->stamptime),"name,userid,stampdate,stamptime");
				$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
				header("location:sysdept_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> Floor already defined.Please try with another name.</div>';
				}
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
			$uid= $_GET["uid"];
			$where="md5(id)='$uid'";
			$this->update($this->Table_Name,array('name'=>$this->sysdept_name,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:sysdept_list.php");
			}
			if($_POST["ButtonOperation"]=="View")
			{ 			header("location:sysdept_list.php");}
		}
}
//************************* End ****************************/
/*************************Password Master list / alter ****************************/

function change_password()
{
		$this->Table_Name="system_login";
		$vtablename="system_login";
		//$this->checkurl($vtablename);
	
		
		
       
		
		
		
		if(isset($_POST["Save"]))
		{
		$this->old_password=md5($_POST["old_password"]);
		$this->new_password=md5($_POST["new_password"]);
		$this->confirm_password=md5($_POST["confirm_password"]);
		$this->emailid=$_SESSION["emailid"];
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		$str="SELECT * FROM `system_login` where emailid='".$_SESSION["emailid"]."'";
		$query=mysql_query($str);
		$row=mysql_fetch_array($query);
		 $row['password'];
		

			if($_POST["ButtonOperation"]=="New")
			{
				
				if(($this->old_password== $row['password']))
				{
					if(($this->new_password==$this->confirm_password))
					{
				 $where="emailid='$this->emailid'";
				 $this->update($this->Table_Name,array('password'=>$this->confirm_password),$where);
				$_SESSION["message"]='<div style="color:red;font-weight:bold">Password updated sucessfully please Login Again</div>';
				 header("location:../index.php");
					}
					else
					{
					$_SESSION["message"]='<div class="alert alert-danger">Check New Password and Confirm Password</div>';
					}
					
				}
					else
					{
					$_SESSION["message"]='<div class="alert alert-danger">Wrong Old Password</div>';
					}
				
			}
	
			
			
		}
}
//************************* End ****************************/

/*************************Company Master list / alter ****************************/
function company_list()
{ 
		$_SESSION["where"]="suspended_status=0";
		if(isset($_POST["Search"])){$_SESSION["where"]=" department like('%".$_POST["search"]."%') and suspended_status=0";}
		
			
			$this->Table_Name="tbl_company_mstr";
			$viewname="tbl_company_mstr";
 			
			$this->getList($viewname,'id ,company_name as "Company Name",regsvtax_no as "Registration No."',$_SESSION["where"],'id',$this->Table_Name);
}
function company_alter()
{
		$this->Table_Name="tbl_company_mstr";
		$vtablename="tbl_company_mstr";
		
		$this->checkurl($vtablename);
		
		$this->company_name=$this->temp["company_name"]; 
		$this->regsvtax_no=$this->temp["regsvtax_no"]; 
		$this->logo=$this->temp["logo"]; 
				
		if(isset($_POST["Save"]))
		{
		
		
		$this->company_name=strtoupper($_POST["company_name"]);
		$this->regsvtax_no=($_POST["regsvtax_no"]);
		
		
		
		
		$this->logo=basename($_FILES['logo']['name']);
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		
		
			
			
			if($_POST["ButtonOperation"]=="New")
			{
				
				
				$lastid=$this->insert($this->Table_Name,array($this->company_name,$this->regsvtax_no,$this->stampdate,$this->userid,$this->stampdate,$this->stamptime),"company_name,regsvtax_no,creation_date,userid,stampdate,stamptime");
				
				if($this->logo!="")
					{
					$slicenm=explode(".",$this->logo);
					$filnm="MSTR".md5($lastid);
					$len=sizeof($slicenm);
					$ext=$slicenm[$len-1];
					$this->logo=$filnm.".".$ext;
					
					$su=move_uploaded_file($_FILES["logo"]["tmp_name"],"../common/resource/Companies/logo/".$this->logo);
						if($su)
						{
							//echo "Success";
							$where="id='$lastid'";
				 			$this->update($this->Table_Name,array('logo'=>$this->logo),$where);
							header("location:company_list.php?page=1&cmd=Clear");
						}
						else
						{
							$_SESSION['message']='<div class="alert alert-danger">Logo Upload Failed</div>';
						}
					}
					else
					{
						header("location:company_list.php?page=1&cmd=Clear");
				}
						
			}	
			if($_POST["ButtonOperation"]=="Edit")
			{  
			$uid= $_GET["uid"];
			$where="md5(id)='$uid'";
			$this->update($this->Table_Name,array('company_name'=>$this->company_name,'regsvtax_no'=>$this->regsvtax_no,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
			
			
			if($this->logo!="")
					{
					$slicenm=explode(".",$this->logo);
					$filnm="MSTR".md5($lastid);
					$len=sizeof($slicenm);
					$ext=$slicenm[$len-1];
					$this->logo=$filnm.".".$ext;
					
					$su=move_uploaded_file($_FILES["logo"]["tmp_name"],"../common/resource/Companies/logo/".$this->logo);
						if($su)
						{
							//echo "Success";
							$where="md5(id)='$uid'";
				 			$this->update($this->Table_Name,array('logo'=>$this->logo),$where);
							header("location:company_list.php?page=1&cmd=Clear");
						}
						else
						{
							$_SESSION['message']='<div class="alert alert-danger">Logo Upload Failed</div>';
						}
					}
					else
					{
						header("location:company_list.php?page=1&cmd=Clear");
				}
			
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:company_list.php");
			}
			if($_POST["ButtonOperation"]=="View")
			{ 			header("location:company_list.php");
			 }
		
		

	
			
			
		}
}

//************************* End ****************************/
/*************************Company Branch list / alter ****************************/
function companybranch_list()
{ 
		$_SESSION["where"]="";
		if(isset($_POST["Search"])){$_SESSION["where"]=" department like('%".$_POST["search"]."%') ";}
		
			
			$this->Table_Name="tbl_company_detl";
			$viewname="tbl_company_detl";
 			
			$this->getList($viewname,'id , 	unit_name as "Unit Name",city as "City",state as "State",contact_no as "Contact"',$_SESSION["where"],'id',$this->Table_Name);
}
function companybranch_alter()
{
		$this->Table_Name="tbl_company_detl";
		$vtablename="tbl_company_detl";
		
		$this->checkurl($vtablename);
		
		$this->company_mstr_id=$this->temp["company_mstr_id"];
		$this->dept_id=$this->temp["dept_id"];
		$this->unit_name=$this->temp["unit_name"];
		$this->building_no=$this->temp["building_no"];
		$this->street=$this->temp["street"];
		$this->district=$this->temp["district"];
		$this->city=$this->temp["city"];
		$this->state=$this->temp["state"];
		$this->pincode=$this->temp["pincode"];
		$this->contact_no=$this->temp["contact_no"];
		$this->luxury_tax_no=$this->temp["luxury_tax_no"];
		$this->vat_tin_no=$this->temp["vat_tin_no"];
		
		
		if(isset($_POST["Save"]))
		{
		$this->company_mstr_id=$_POST["company_mstr_id"];
		$this->dept_id=$_POST["dept_id"];
		$this->unit_name=strtoupper($_POST["unit_name"]);
		$this->building_no=strtoupper($_POST["building_no"]);
		$this->street=strtoupper($_POST["street"]);
		$this->district=strtoupper($_POST["district"]);
		$this->city=strtoupper($_POST["city"]);
		$this->state=strtoupper($_POST["state"]);
		$this->pincode=($_POST["pincode"]);
		$this->contact_no=($_POST["contact_no"]);
		$this->luxury_tax_no=strtoupper($_POST["luxury_tax_no"]);
		$this->vat_tin_no=strtoupper($_POST["vat_tin_no"]);
		//System Details
		$this->stampdate=$this->DateToInt(date("d-m-Y"));
		$this->stamptime=$this->IntToTimeAMPM($this->systimeInt());
		$this->userid=$_SESSION["userid"];
		

			if($_POST["ButtonOperation"]=="New")
			{
				$whr="dept_id='".$this->dept_id."' and suspended_status=0";
				if($this->getNumRows($this->Table_Name, $whr)<=0)
				{
				$lastid=$this->insert($this->Table_Name,array($this->company_mstr_id,$this->dept_id,$this->unit_name,$this->building_no,$this->street,$this->district,$this->city,$this->state,$this->pincode,$this->contact_no,$this->luxury_tax_no,$this->vat_tin_no,$this->userid,$this->stampdate,$this->stamptime),"company_mstr_id,dept_id,unit_name,building_no,street,district,city,state,pincode,contact_no,luxury_tax_no,vat_tin_no,userid,stampdate,stamptime");
				
				$_SESSION["message"]='<div class="alert alert-success">One New Record Added</div>';
				header("location:companybranch_list.php");
				}
				else
				{
				$_SESSION["message1"]='<div class="alert alert-danger"><strong>Warning!</strong> Floor already defined.Please try with another name.</div>';
				}
			}
	
			if($_POST["ButtonOperation"]=="Edit")
			{  
			$uid= $_GET["uid"];
			$where="md5(id)='$uid'";
			$this->update($this->Table_Name,array('company_mstr_id'=>$this->company_mstr_id,'dept_id'=>$this->dept_id,'unit_name'=>$this->unit_name,'building_no'=>$this->building_no,'street'=>$this->street,'district'=>$this->district,'city'=>$this->city,'state'=>$this->state,'pincode'=>$this->pincode,'contact_no'=>$this->contact_no,'luxury_tax_no'=>$this->luxury_tax_no,'vat_tin_no'=>$this->vat_tin_no,'userid'=>$this->userid,'stampdate'=>$this->stampdate,'stamptime'=>$this->stamptime),$where);
			
			$_SESSION["message"]='<div class="alert alert-success">One New Record Updated</div>';
			header("location:companybranch_list.php");
			}
			if($_POST["ButtonOperation"]=="View")
			{ 			header("location:companybranch_list.php");
			 }
		}
}
//************************* End ****************************/
} 

?> 		