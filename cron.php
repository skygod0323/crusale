<?php
include "common.php";

$sql="select * from user where usr_mp_id>1 and usr_mem_expiry<'".date("Y-m-d")."'";
$res=mysql_query($sql);
while($row=mysql_fetch_object($res))
{

    $upd_sql="update user
        set
            usr_mp_id='1',
            usr_mem_expiry =date_add(now(),INTERVAL 1 MONTH)
        where
            usr_id='".$row->usr_id."'";
    mysql_query($upd_sql);

    /**** code for email sending start here ****/
		
            
    $sqlemail="select * from admin_user where id='1'";
    $resemail=mysql_query($sqlemail);
    $rowemail=mysql_fetch_object($resemail);
		
	include "email/cron.php"; //email design with content included

	/*$comment='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
		<div style="width:650px;height:100px; padding-bottom:0;">
			'.$lang[682].'
		</div></div>';*/


		$from_mail=$this->cu_email;
            $to=$row->usr_email;

           $subj=$lang[683];
           $headers  = "MIME-Version: 1.0\n";
	       $headers .= "Content-type: text/html; charset=iso-8859-1\n";
           $headers .= 'From: '.$from_mail.'';	
		
		mail($to,$subj,$comment,$headers);
            
		/**** code for email sending end here ****/
}


/****	Code for delete read notofication start here	****/

$del_after=getNotificationDeleteDayAfter();

$sql_un="select * from user_notification where un_status='0' and TIMESTAMPDIFF(DAY, un_updated_date, now())>".$del_after." order by un_updated_date desc";
$res_un=mysql_query($sql_un);
while($row_un=mysql_fetch_object($res_un))
{
	$sql_un_del="delete from user_notification where un_id='".$row_un->un_id."'";
	mysql_query($sql_un_del);
}

/****	Code for delete read notofication end here	****/

?>
