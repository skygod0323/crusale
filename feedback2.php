<?php
ob_start();
session_start();
include "common.php";

if(isset($_GET['bd']))
{
$bd_id=$_GET['bd'];
$sql_t="select * from bid where bd_id=".$bd_id;
$res_t=mysql_query($sql_t);
$row_t=mysql_fetch_object($res_t);
}

$msg="";



if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}
if(isset($_SESSION['fb_rate'])){	$fb_rate=$_SESSION['fb_rate'];	unset($_SESSION['fb_rate']);	}else{ $fb_rate=""; }
if(isset($_SESSION['fb_message'])){	$fb_message=$_SESSION['fb_message'];	unset($_SESSION['fb_message']);	}else{ $fb_message=""; }

if(isset($_POST['submitFeedback']))
{

/*	print_r($_POST);
	exit;*/

	$fb_recv_id=$_POST['fb_recv_id'];
	$fb_rate=trim(addslashes($_POST['fb_rate']));
	$fb_prj_id=$_POST['fb_prj_id'];
	$fb_message=trim(addslashes($_POST['fb_message']));
	
	
	$_SESSION['fb_rate']=$fb_rate;
	$_SESSION['fb_message']=$fb_message;
	
	$valid=true;
	
	if($fb_message=="")
	{
		$_SESSION['msg']='<font color="#CC0000">Please enter some feedback message</font>';
		$valid=false;
	}

	if($valid==true)
	{
		$sql="insert into feedback
			set
				fb_sender_id ='".$_SESSION['uid']."',
				fb_recv_id ='".$fb_recv_id."',
				fb_rate ='".$fb_rate."',
				fb_prj_id ='".$fb_prj_id."',
				fb_message ='".$fb_message."',
				fb_updated_date =now()";
		
		mysql_query($sql);
		
//		$msg="<font color='#009900'>Feedback submitted successfully</font>";
		
		header("location:manage.php");	
		
	}
	else
	{
		$_SESSION['msg']=$msg;
	
		header("location:feedback.php");	
	}
	
}

?>
   	<?php include "includes/header.php"; ?>
<script language="javascript">
$(document).ready(
	function(){		
		$('#submit_id').click(function(){	
			$('#feedbackform').submit();		
		});        
	});


</script>
	<div class="ns_clear"></div>
	<div class="grid">
	

<div id="ns_content"> 
<link href="css/gaf_style_new.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/jquery_002.js"></script> 


<form name="feedbackform" id="feedbackform" method="POST" action="" enctype="multipart/form-data">


<input type="hidden" name="fb_recv_id" value="<?php echo $row_t->bd_usr_id; ?>"/>
<input type="hidden" name="fb_prj_id" value="<?php echo $row_t->bd_prj_id; ?>"/>
<div class="ns_layout ns_two-thirds">
    <div class="ns_col-1"> 
        <div class="ns_pad" style="padding-left:50px;"> 
            <h2>Feedback</h2> 
            
<table id="profile_table_id">
    <tbody>
        <tr>
            <td></td>
            <td></td>
            <td style="padding-left:10px;"><div id="msg"><strong><?php echo $msg; ?></strong></div></td>
        </tr>
        
        <tr>
            <td><strong>Rating: </strong></td>
            <td></td>
            <td style="padding-left:10px;">
            <select name="fb_rate" id="fb_rate">
            <?php
			for($i=1;$i<=10;$i++){
			?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php } ?>
            </select>
            </td>
        </tr>
        <tr>
            <td><strong>Meassage: </strong></td>
            <td></td>
            <td style="padding-left:10px;">
            <textarea id="fb+message" name="fb_message"></textarea>
            </td>
        </tr>
    </tbody>
</table>

            <br>
            <a href="javascript:void(0)" id="submit_id" class="ns_btn ns_blue">Save</a>
            <!--<input type="submit" name="login" id="login" class="ns_btn ns_blue" value="Login"/>-->
           
           
        </div> 
    </div> 
    
</div> 
</p>
<input type="hidden" name="submitFeedback" value="1"/>

</form>

</div> 

	</div>
	<div class="ns_clear"></div>

	<?php include "includes/footer.php"; ?>


	<div class="ns_clear"></div>

</div>



</body>
</html>