<?php
ob_start();
session_start();
include "common.php";

$msg_id=$_POST['msg_id'];
$msg_message=addslashes(trim($_POST['msg_message']));

$sql="select * from message where msg_id='".$msg_id."'";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);


if (isset($_FILES["msg_file"]))
{
    if ($_FILES["msg_file"]["error"] > 0) {
        echo "Error: " . $_FILES["msg_file"]["error"] . "<br>";
    }
	else
	{
		$msg_file='msg-'.rand(0,9999).trim(addslashes($_FILES['msg_file']['name']));
        move_uploaded_file($_FILES["msg_file"]["tmp_name"], "upload/message/".$msg_file);
        //echo "Uploaded File :" . $_FILES["msg_file"]["name"];
		
		$sql_reply="insert into message
			set	
				msg_from ='".$row->msg_to."',
				msg_to ='".$row->msg_from."',
				msg_prj_id ='".$row->msg_prj_id."',
				msg_message ='".$msg_message."',
				msg_file ='".$msg_file."',
				msg_date =now()";
		
				mysql_query($sql_reply);
    }
}
else
{
	$sql_reply="insert into message
			set	
				msg_from ='".$row->msg_to."',
				msg_to ='".$row->msg_from."',
				msg_prj_id ='".$row->msg_prj_id."',
				msg_message ='".$msg_message."',
				msg_date =now()";
	mysql_query($sql_reply);
}

/**** code for email sending start here ****/
		
        $chk_es_sql="select * from user_email_setting where ues_usr_id='".$row->msg_to."' and ues_es_id='2'";
        $chk_es_res=mysql_query($chk_es_sql);
        if(mysql_num_rows($chk_es_res))
        {
            
		$sqlemail="select * from admin_user where id='1'";
		$resemail=mysql_query($sqlemail);
		$rowemail=mysql_fetch_object($resemail);
            
            $sql_us="select * from user where usr_id='".$row->msg_to."'";
		$res_us=mysql_query($sql_us);
		$row_us=mysql_fetch_object($res_us);
		
		
		include "email/replyMessage.php"; //email design with content included
		
		/*$comment='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
		<div style="width:650px;height:100px; padding-bottom:0;">'.$lang[664].'</div></div>';*/


		$from_mail=$rowemail->email;
            $to=$row_us->usr_email; 	

           $subj=$lang[663];
           $headers  = "MIME-Version: 1.0\n";
	       $headers .= "Content-type: text/html; charset=iso-8859-1\n";
           $headers .= 'From: '.$from_mail.'';	
		
		mail($to,$subj,$comment,$headers);
            }
		/**** code for email sending end here ****/
?>
