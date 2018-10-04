<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Hotel Ganga Ashram</title>
<link href="../common/images/riada_logo.ico" rel="shortcut icon" type="image/x-icon">
<style>
a{ text-decoration:none}
</style>
<?php
include "../common/inc/config.inc.php"; 
include "localinclude.php";
$varFileName = basename($_SERVER['PHP_SELF']);
$_SESSION["varFileName"]=$varFileName;
$_SESSION["userid"]=1;
$_SESSION["usertype"]=1; 
$_SESSION["sysdept"]=1;	


if(isset($_GET["cmd"]))
{
	if($_GET["cmd"]=="Clear")
	{
	unset($_SESSION["custid"]);
	unset($_SESSION["where"]);
	}
}
?> 
</head>
<body>
<div class="panel" style="padding-left:5px; background:#425E66; padding-top:0px; border:none; border-radius:0px; margin:0px; height:45px;">
<div class="span5" style="padding:0px; line-height:50px; margin:0; ">
<div  style="font-family:Arial, Helvetica, sans-serif; text-indent:10px; font-weight:bold; line-height:60px; color:#FFF; font-size:20px; text-transform:uppercase"> 
<div style="float:left"><img src="<?php echo IMAGE_PATH?>hotel_ganga.png" style="margin-top:10px;" /></div>
<div style="float:left"> Hotel Ganga Ashram </div></div></div>
<div class="span4" style="margin-top:10px">
<form method="post">
<input type="text" name="search" placeholder="Please Search" style="height:18px; margin-right:3px;">
<input type="submit" name="Search" class="btn btn-info" value="Search">
</form>
</div>
<div class="span4" style="float:right; text-align:right; color:#FFF; line-height:50px;">
 Logged in as admin &nbsp;&nbsp; | &nbsp;&nbsp;<?php echo date('d / m / YY')?>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="logout.php" style="color:#FFF; text-decoration:none">Log out</a>
</div>
</div>
<div class="panel" style="background:#E7AC00; border-radius:0px; padding:5px; height:25px; margin:0px; border:none">
<nav>
	<ul>
		<li><a href="#">Home</a></li>
		<li><a href="#">Tutorials</a>
			<ul>
				<li><a href="#">Photoshop</a></li>
				<li><a href="#">Illustrator</a></li>
				<li><a href="#">Web Design</a>
					<ul>
						<li><a href="#">HTML</a></li>
						<li><a href="#">CSS</a></li>
					</ul>
				</li>
			</ul>
		</li>
		<li><a href="#">Articles</a>
			<ul>
				<li><a href="#">Web Design</a></li>
				<li><a href="#">User Experience</a></li>
			</ul>
		</li>
		<li><a href="#">Inspiration</a></li>
	</ul>
</nav>
</div>


