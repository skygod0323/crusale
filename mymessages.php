<?php
ob_start();
session_start();
include "common.php";

$_SESSION['last_page']="mymessages.php";
if($_SESSION['uid']=='')
{
	header("location:login.php");	
}

class InMessageList{
	/*var $start="";
	var $limit="";*/
	var $sqlList="";
	var $start="";
	var $limit="";
	
	function setsql($sql){
		$this->sqlList=$sql;
	}
	function totalrecord(){
		return mysql_num_rows(mysql_query($this->sqlList));
	}
	function listview(){
		$sql=$this->sqlList." limit ".$this->start.",".$this->limit;
		$res=mysql_query($sql);
		return $res;
	}
	/*function fetchRecord(){
		return mysql_fetch_object($this->listview());
	}*/
	function numpage($rowPage){
		 return floor($this->totalrecord()/$rowPage);
	}
}

$p=new Pagination;
$page=$p->setpage();

$al=new InMessageList;
$al->limit=$p->setlimit(10);

$al->setsql("select * from message,user,project where msg_to='".$_SESSION['uid']."' and msg_from=usr_id and msg_prj_id=prj_id");	

$totalitems=$al->totalrecord();
$limit=$al->limit;
$al->start=$p->setstart($page,$limit,$totalitems);
$adjacents=1;
$targetpage = "mymessages.php";

$pagestring ="?cat=".$cat_id."&sk=".$sk_id."&limit=".$limit."&page=";

$recObj=$al->listview();

$showitems=$al->start+1 ." - ";
if(($al->start+$limit)<$totalitems){
	$showitems.=$al->start+$limit;
}
else{
	$showitems.=$totalitems;
}
	$showitems.= $lang[759].$al->totalrecord().$lang[760];


if(isset($_POST['compose']))
{
	print_r($_POST);
	exit;
}
?>
<?php include "includes/header.php"; ?>
<script language="javascript">
$( document ).ready(function() {
    showInbox(1);
});
function showInbox(p)
{
	//$.noConflict();
      closeWriteBox();
	$('#inbox').css({"display":"block"});
	$('#sent').css({"display":"none"});	
      $.post("ajax-file/showInbox.php", {page:p}, function(data){  $('#inbox').html(data);    });
}
function showSent(p)
{
	//$.noConflict();
      closeWriteBox();
	$('#sent').css({"display":"block"});
	$('#inbox').css({"display":"none"});

      $.post("ajax-file/showSent.php", {page:p}, function(data){  $('#sent').html(data);    });
}
function showDetail(id)
{
	did=id+"_ID_thread_body";
	//$.noConflict();	
	$("#"+did).css("display","block");
	$.get("ajax-file/msgRead.php", {msg_id:id});		
}

function closeDetail(id)
{
	did=id+"_ID_thread_body";
	//$.noConflict();	
	$("#"+did).css("display","none");
	//$.get("ajax-file/msgRead.php", {msg_id:id});		
}
function closeSentDetail(id)
{
	did=id+"_ID_sent_body";
	//$.noConflict();	
	$("#"+did).css("display","none");
	//$.get("ajax-file/msgRead.php", {msg_id:id});		
}
function showSentDetail(id)
{
	did=id+"_ID_sent_body";
	//$.noConflict();	
	$("#"+did).css("display","block");
//	$.get("ajax-file/msgRead.php", {msg_id:id});		
}
function showWriteBox(mid)
{
	//$.noConflict();	
	$("#compose_cnter_id").css("display","block");
	$('#inbox').css("display","none");
	$("#msg_id").val(mid);
}
function closeWriteBox()
{
	//$.noConflict();	
	$("#compose_cnter_id").css("display","none");
	$('#inbox').css({"display":"block"});
}
function onSentMessage()
{

//	$("#compose_msg_formsending_id").removeClass("hide");
	
	msg_id=$('#msg_id').val();
	msg_message=$('textarea#msg_message').val();
	
	$.get("ajax-file/replyMessage.php", {msg_id:msg_id,msg_message:msg_message}, function(data){     
          //alert('Sent');
      		
		closeWriteBox();
//		$("#compose_msg_formsending_id").addClass("hide");
	});
}
function delMessage(id,fld)
{
    if(confirm("<?php echo $lang[660]; ?>"))
    {
        $.get("ajax-file/delMessage.php", {msg_id:id,fld:fld}, function(data){
		if(fld=='to')
            {
                showInbox(1);
            }
            else if(fld=='from')
            {
                showSent(1);
            }
        });
    }
}
function refreshPage()
{
	window.location.reload();	
}
</script>
<div><h2 class="header-txt1-style_1"><?php echo $lang[360]; ?></h2></div>

<div class="clearfix">
    <div class="my-message-lft-col">
	<ul>
		<li><a href="javascript:showInbox(1)"><?php echo $lang[361]; ?></a></li>
		<li><a href="javascript:showSent(1)"><?php echo $lang[362]; ?></a></li>
	</ul>
    </div>
    <div id="compose_cnter_id" class="my-message-rgt-col" style="display:none;">
      	
	<div class="my-message-header-bg" style="margin-bottom:10px;">
</div>
    <div class="my-message-body" style="text-align: center;">
          <form id="compose_msg_form_id" name="compose_msg_form" action="" enctype="multipart/form-data" method="post">
              <input type="hidden" name="msg_from" value="<?php echo $_SESSION['uid']; ?>" />
              <input type="hidden" id="msg_id" name="msg_id" />
              <textarea name="msg_message" id="msg_message" style="width: 580px; height: 200px;"></textarea>
              <div style="padding:10px;">
                  <a class="ns_blue ns_btn" onClick="onSentMessage()" name="compose" id="sent_message_btn_id"><?php echo $lang[353]; ?></a>
              <a onClick="closeWriteBox()" class="ns_blue ns_btn" style="cursor: pointer;"><?php echo $lang[352]; ?></a></div>
          </form>
    </div>
    </div>
    
    <div id="inbox" class="my-message-rgt-col">
    </div>
    <div id="sent" style="display:none;" class="my-message-rgt-col">
    </div>
	</div>					
	<div class="pg-bottom-text">
		<?php echo get_page_content('3'); ?>
		<?php
                   $sql_adv="select * from advertisement where adv_status='1' order by rand() limit 1";
                      $res_adv=mysql_query($sql_adv);
                      if(mysql_num_rows($res_adv)>0){
                      ?>
				<ul>
					<li>
                              <?php
                              
                              $row_adv=mysql_fetch_object($res_adv);
                              
                              ?>
                                  <a href="<?php echo $row_adv->adv_link; ?>" target="blank"><img src="upload/advertisement/<?php echo $row_adv->adv_img; ?>" height="<?php echo $row_adv->adv_imageheight; ?>" width="<?php echo $row_adv->adv_imagewidth; ?>"/></a>
                               
                                  </li>
					
				</ul>
                      <?php } ?>
	</div>
</div>
</div>
<?php include "includes/footer.php"; ?>