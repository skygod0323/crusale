<?php
ob_start();
session_start();
include "../common.php";

$uid=$_GET['u'];
$sql="select * from temp_file_post where fl_uid='".$uid."'";
$res=mysql_query($sql);
if(mysql_num_rows($res)>0){

	while($row=mysql_fetch_object($res)){	?>
	<div class="uploadifive-queue-item">
		
        <div>
        	<span class="filename"><?php echo $row->fl_filename; ?></span>
            <span class="fileinfo"> - </span>
            <span class="fileinfo"><?php echo $lang[522]; ?></span>
            <span class="fileinfo"><a class="close" href="javascript:delProjectTempFiles('<?php echo $row->fl_id; ?>')">X</a></span>
		</div>
    </div>	
<?php	}
}
?>
