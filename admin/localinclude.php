<link rel="stylesheet" href="includetime/ui-1.10.0/ui-lightness/jquery-ui-1.10.0.custom.min.css" /> 
<link rel="stylesheet" href="includetime/jquery.ui.timepicker.css" /> 
<?php 
require_once "../common/inc/config.inc.php";

require_once "../ProgramFile/class_core_admin.php";
require_once "../ProgramFile/class_core_FO.php";
require_once "../ProgramFile/class_core_Res.php";
require_once "../ProgramFile/class_core_Account.php";


$objCoreAdmin = new class_core_admin();
$objCoreFO = new class_core_FO();
$objCoreRes = new class_core_Res();
$objCoreAcnt = new class_core_Account();

//echo $objCoreAdmin->showmsg();
//echo $objCoreFO->showmsg();
//echo $objCoreRes->showmsg();
//echo $objCoreAcnt->showmsg();
?>
<script src="includetime/jquery.ui.timepicker.js"></script>
<script src="../js/common.js"></script>
<script>
function PopupCenter(url, title, w, h) {  
    // Fixes dual-screen position                         Most browsers      Firefox  
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;  
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;  
              
    width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;  
    height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;  
              
    var left = ((width / 2) - (w / 2)) + dualScreenLeft;  
    var top = ((height / 2) - (h / 2)) + dualScreenTop;  
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);  
  
    // Puts focus on the newWindow  
    if (window.focus) {  
        newWindow.focus();  
    }  
} 
</script>


 