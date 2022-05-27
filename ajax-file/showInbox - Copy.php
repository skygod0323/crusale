<?php
ob_start();
session_start();
include "../common.php";

if($_POST['page'])
{
$page = $_POST['page'];
$cur_page = $page;
$page -= 1;
$per_page = 10; // Per page records
$previous_btn = true;
$next_btn = true;
//$first_btn = false;
//$last_btn = false;
$start = $page * $per_page;

$sql_inbox="select * from message,user,project where msg_to='".$_SESSION['uid']."' and msg_from=usr_id and msg_prj_id=prj_id and msg_to_status='1' order by msg_date desc LIMIT ".$start.", ".$per_page;
$recObj=mysql_query($sql_inbox) or die('MySql Error' . mysql_error());

/* -----Total count--- */
$query_pag_num = "SELECT count(*) AS count from message,user,project where msg_to='".$_SESSION['uid']."' and msg_from=usr_id and msg_prj_id=prj_id and msg_to_status='1'"; // Total records

$result_pag_num = mysql_query($query_pag_num);
$row = mysql_fetch_array($result_pag_num);
$count = $row['count'];
$no_of_paginations = ceil($count / $per_page);

/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
if($cur_page >= 7)
{
    $start_loop = $cur_page - 3;
    if($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6)
    {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    }
    else
    {
        $end_loop = $no_of_paginations;
    }
}
else
{
    $start_loop = 1;
    if($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
?>
<div class="my-message-header-bg">
	<div class="my-message-header-bg-arrow-str">
		<ul>
            <?php
             // FOR ENABLING THE PREVIOUS BUTTON
            if ($previous_btn && $cur_page > 1){
                 $pre = $cur_page - 1;
            ?>
                 <li><a href="javascript:showInbox('<?php echo $pre; ?>')"><img src="images/lft-arrow.jpg" alt="" /></a></li>
                 <?php	}else if($previous_btn){	?>
                 <li><a style="opacity:0.6;text-decoration:none;" href="javascript:void(0);"><img src="images/lft-arrow.jpg" alt="" /></a></li>
                    
            <?php	}
                    // TO ENABLE THE NEXT BUTTON
                    if($next_btn && $cur_page < $no_of_paginations)
                    {
                        $nex = $cur_page + 1;
                    ?>
                      <li><a href="javascript:showInbox('<?php echo $nex; ?>')"><img src="images/rgt-arrow.jpg" alt="" /></a></li>
                    <?php
                    }else if ($next_btn){
                    ?>
                      <li><a style="opacity:0.6;text-decoration:none;" href="javascript:void(0);"><img src="images/rgt-arrow.jpg" alt="" /></a></li>
                    <?php
                    }
                    ?>
                    
<!--                    <li><a href="#"><img src="images/rgt-arrow.jpg" alt="" /></a></li>-->
			</ul>
		</div>
	</div>
	<div class="my-message-body">
		<ul>
              <?php while($row=mysql_fetch_object($recObj)){ ?>
			<li class="clearfix" onClick="showDetail(<?php echo $row->msg_id; ?>)">
				<div class="message-body-lft-col">
				<?php if(($row->usr_image!="")&&($row->usr_image!="NULL")){?>
				<div class="message-img-str"><img src="images/users/<?php echo $row->usr_image; ?>" alt="" width="93px" height="89px" /></div>
				<?php } ?>
				<div class="message-info-str">
                         <a onClick="showDetail(<?php echo $row->msg_id; ?>)"><h6><?php echo $row->usr_name; ?></h6></a>
        			<p class="date">
                              <?php 
					$diff=dateDifference($row->msg_date,date("Y-m-d h:i:s"));
					if($diff>0){	echo $diff.$lang[74];	}
					else {	echo $lang[354];	}
                              ?>                                  
                    </p>
				</div>
				</div>
                            
				<div class="message-body-rgt-col">
					<div class="my-message-body-check-bx-txt"><a onClick="showDetail(<?php echo $row->msg_id; ?>)"><?php echo $row->prj_name;?></a>
                                  <div style="width: 15px;float:right;padding-right: 2px;"><a style="cursor: pointer;" onClick="delMessage(<?php echo $row->msg_id; ?>,'to')"><img src="images/msg_delete.png"/></a></div>
                    </div>
					<div class="my-message-body-welcome-txt"><?php echo $row->msg_message;  ?></div>
				</div>
                        <li class="clearfix" id="<?php echo $row->msg_id; ?>_ID_thread_body" style="display: none;">
                            <div class="message-body-rgt-col" style="width:565px;padding-left:2px;">
                                <div class="my-message-body-check-bx-txt"><?php echo $lang[355]; ?>&nbsp;<a href="profile.php?u=<?php echo md5($row->usr_id); ?>" target="_blank"><?php echo $row->usr_name; ?></a>&nbsp;<?php echo $lang[356]; ?>&nbsp;<a href="project.php?p=<?php echo $row->prj_id; ?>" target="_blank"><?php echo $row->prj_name;?></a></div>
                                <div class="my-message-body-welcome-txt"><p><?php echo $row->msg_message;  ?></p></div>
                            </div>
<!--                                <div style="width: 18px;float:right;">
                                    <img src="images/close.png"/>
                                </div>-->
                                 
                         <div class="attchments">
                             <div style="width: 60px;float:right;padding-bottom: 5px;"><a style="padding-right: 5px;" href="javascript:showWriteBox(<?php echo $row->msg_id; ?>)"><?php echo $lang[359]; ?></a><a href="javascript:closeDetail(<?php echo $row->msg_id; ?>)"><img src="images/close.png"/></a></div>
                                <?php if($row->msg_file != ''){ ?>
                                 <b><?php echo $lang[357]; ?>&nbsp;<a href="upload/message/<?php echo $row->msg_file; ?>" target="_blank"><?php echo $lang[358]; ?></a></b>
                                <?php } ?>
                            </div>
                                
                            </li>
                        
            </li>
                      <?php } ?>
				
			</ul>
			</div
><?php } ?>