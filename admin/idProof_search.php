<?php
@session_start();
@ob_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
include "localinclude.php";
$objCoreFO->customer_idproof_search();
?>
<script>
$(document).ready(function(){
	$("#gst_search").autocomplete({
		source:"../ProgramFile/auto/FO_suggest_guestIDProof.php",
		minlength:1,
		select:function(event,ui)
		{
			$("#img1").attr('src','../common/resource/idproof/' + ui.item.front);
			$("#img2").attr('src','../common/resource/idproof/' + ui.item.backk);
			$("#frontside").val(ui.item.front);
			$("#backside").val(ui.item.backk);
			}
		});
	});
</script>
<style>
.innerBody{margin-left:20px;margin-right:20px;margin-bottom:10px;padding:2%;border:#000000 1px solid;height:auto;}
.innerBody1{margin-left:20px;margin-right:20px;padding-top:5px;padding-left:10px;padding-right:10px;margin-bottom:10px;padding-bottom:25px;height:auto;}
table th,td{
	text-align:left;
	}
</style>
<div>
	<p></p>
			<div class="innerBody1">
            	<div class="innerBody">
                <form method="post">
                <?php if(isset($_SESSION["message"])){echo $_SESSION["message"];unset($_SESSION["message"]);}?>
                <table class="table table-bordered" width="100%">
                	<tr>
                    	<td width="10%" colspan="2">Search</td>
                        <td width="1%"><strong>:</strong></td>
                        <td width="89%"><input type="text" name="gst_search" id="gst_search" style="width:98%"></td>
                    </tr>
                    <tr>
                    	<td colspan="4">
                        	<table width="100%">
                            	<tr>
                                    <td colspan="3" width="50%" align="center">
                                    <img id="img1" src="../common/resource/idlogo.jpg" style="width:500px;height:500px">
                                    <input type="hidden" name="frontside" id="frontside" />
                                    </td>
                                    <td colspan="3" width="50%" align="center">
                                    <img id="img2" src="../common/resource/idlogo.jpg" style="width:500px;height:500px">
                                     <input type="hidden" name="backside" id="backside" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    	<td width="10%" colspan="4" align="center">
                        <input type="submit" name="Save" id="Save" class="btn btn-danger" value="Update"></td>
                    </tr>
                </table>
                </form>
                </div>
            </div>

</div>