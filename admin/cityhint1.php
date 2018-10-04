<?php include "../common/inc/config.inc.php"?>
<?php

$statename=$_GET["q"];
?>
<select required name="city1" id="city1">
  <option value="">--Select---</option>
  <?php 
$sql="select city_name from tbl_citylist where state='$statename'";
 
$res=mysql_query($sql) or die("contact to admin error no. 567");
if($rws=mysql_num_rows($res))
{
while($rs=mysql_fetch_array($res))
{?>
<option value="<?=$rs["city_name"]?>"><?php echo $rs["city_name"];?></option>
<?php
}}
?> 
</select>
