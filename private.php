<?php
ob_start();
session_start();
include "common.php";

$sql_bid="select * from bid,project where bd_id='".$_GET['b']."' and bd_prj_id=prj_id";

$res_bid=mysql_query($sql_bid);
$row_bid=mysql_fetch_object($res_bid);

$from_user_id=$_SESSION['uid'];
$to_user_id="";
if($row_bid->bd_usr_id == $_SESSION['uid'])
{
	$to_user_id=$row_bid->prj_usr_id;
}
else if($row_bid->prj_usr_id == $_SESSION['uid'])
{
	$to_user_id=$row_bid->bd_usr_id;
}

$sql_from_user="select * from user where usr_id='".$from_user_id."'";
$res_from_user=mysql_query($sql_from_user);
$row_from_user=mysql_fetch_object($res_from_user);

$sql_to_user="select * from user where usr_id='".$to_user_id."'";
$res_to_user=mysql_query($sql_to_user);
$row_to_user=mysql_fetch_object($res_to_user);


class addMessage
{
	var $msg_from;
	var $msg_to;
	var $msg_prj_id;
	var $msg_message;
	var $msg_file;
	var $msg;
	
	function __construct($msg_from, $msg_to, $msg_prj_id, $msg_message, $msg_file)
	{		
		$this->msg_from=$msg_from;
		$this->msg_to=$msg_to;
		$this->msg_prj_id=$msg_prj_id;
		$this->msg_message=$msg_message;
		$this->msg_file=$msg_file;
	}

	function valid()
	{
          include "language.php";
		$valid=true;
		//$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
		
		if($this->msg_message == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[445].'</font>';
			$valid=false;
		}
								
		return $valid;
	}
	
	function add()
	{	
          include "language.php";
		if($this->msg_file != '')
		{
			if ($_FILES["msg_file"]["error"] > 0)
			{
				$this->msg = "<font color='#CC0000'>".$lang[446].$_FILES["msg_file"]["error"]."</font><br />";
				$this->msg = "<font color='#CC0000'>".$lang[447]."</font><br /><br />";
			}
			else
			{	
				$this->msg_file='msg-'.rand(0,9999).trim(addslashes($_FILES['msg_file']['name']));	
				
				$ds = move_uploaded_file($_FILES["msg_file"]["tmp_name"], "upload/message/".$this->msg_file) or die('error');
				
				if($ds)
				{
					$sql="insert into message
						set	
							msg_from ='".$this->msg_from."',
							msg_to ='".$this->msg_to."',
							msg_prj_id ='".$this->msg_prj_id."',
							msg_message ='".$this->msg_message."',
							msg_file ='".$this->msg_file."',
							msg_date =now()";
							
					mysql_query($sql) or die(mysql_error());
					$this->msg='<font color="#009900">'.$lang[448].'</font><br /><br />';	
                              
                              /**** code for email sending start here ****/
		
            $chk_es_sql="select * from user_email_setting where ues_usr_id='".$this->msg_to."' and ues_es_id='2'";
            $chk_es_res=mysql_query($chk_es_sql);
            if(mysql_num_rows($chk_es_res))
            {
            
				$sqlemail="select * from admin_user where id='1'";
				$resemail=mysql_query($sqlemail);
				$rowemail=mysql_fetch_object($resemail);
            
        		$sql_us="select * from user where usr_id='".$this->msg_to."'";
				$res_us=mysql_query($sql_us);
				$row_us=mysql_fetch_object($res_us);
		
				include "email/private.php"; //email design with content included
		
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
					
				}
				else
				{
					$this->msg = "<font color='#CC0000'>".$lang[449]."</font><br /><br />";
				}
				
			}
		}
		else
		{
			$sql="insert into message
				set	
					msg_from ='".$this->msg_from."',
					msg_to ='".$this->msg_to."',
					msg_prj_id ='".$this->msg_prj_id."',
					msg_message ='".$this->msg_message."',
					msg_date =now()";
					
			mysql_query($sql) or die(mysql_error());
			$this->msg='<font color="#009900">'.$lang[448].'</font><br /><br />';
                  
                  /**** code for email sending start here ****/
		
            $chk_es_sql="select * from user_email_setting where ues_usr_id='".$this->msg_to."' and ues_es_id='2'";
            $chk_es_res=mysql_query($chk_es_sql);
            if(mysql_num_rows($chk_es_res))
            {
            
		$sqlemail="select * from admin_user where id='1'";
		$resemail=mysql_query($sqlemail);
		$rowemail=mysql_fetch_object($resemail);
            
            $sql_us="select * from user where usr_id='".$this->msg_to."'";
		$res_us=mysql_query($sql_us);
		$row_us=mysql_fetch_object($res_us);
		
		include "email/private.php"; //email design with content included
		
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
			
		}
	}	
}

if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}
/*if(isset($_SESSION['cmt_name'])){ $cmt_name=$_SESSION['cmt_name']; unset($_SESSION['cmt_name']); } else { $cmt_name=""; }
if(isset($_SESSION['cmt_email'])){ $cmt_email=$_SESSION['cmt_email']; unset($_SESSION['cmt_email']); } else { $cmt_email=""; }
if(isset($_SESSION['cmt_text'])){ $cmt_text=$_SESSION['cmt_text']; unset($_SESSION['cmt_text']); } else { $cmt_text=""; }*/

if(isset($_POST['submitMessage']))
{
	
	$adn=new addMessage(addslashes(trim($_POST['msg_from'])), addslashes(trim($_POST['msg_to'])), addslashes(trim($_POST['msg_prj_id'])), addslashes(trim($_POST['msg_message'])), trim($_FILES['msg_file']['name']));

	/*$_SESSION['cmt_name']=addslashes(trim($_POST['cmt_name']));
	$_SESSION['cmt_email']=addslashes(trim($_POST['cmt_email']));
	$_SESSION['cmt_text']=addslashes(trim($_POST['cmt_text']));*/

	if($adn->valid()){	
		$adn->add();		
	}
	//echo $ecms->msg;
	$_SESSION['msg']=$adn->msg;
	
	header("Location:private.php?b=".$row_bid->bd_id);
}

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php echo getWebSiteTitle(); ?></title>
        
	    <meta name="title" content="<?php echo getWebSiteTitle(); ?>">
		<meta name="keywords" content="<?php echo get_page_settings(2); ?>">
		<meta name="description" content="<?php echo get_page_settings(3); ?>">
        
        <meta name="viewport" content="width=device-width">
		<link href='http://fonts.googleapis.com/css?family=Lato:400,900' rel='stylesheet' type='text/css'>
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

       <!-- <link rel="stylesheet" href="css/normalize.css">-->
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/gaf_style.min.css">
        
        <!--<link rel="stylesheet" href="css/gaf.ns.css">-->
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-1.2.1.min.js"></script>
<style type="text/css">
.closeButton
{
 /*   background:url(images/top-sep.jpg) no-repeat left center;*/
    padding-left:18px;
    position:absolute;
    right:10px;
    top:11px;
}
.closeButton a
{
      background-color: #f5a504; /* Dodger Blue */
	border: 1px solid #115290;
	border-radius:3px;
	/*-webkit-border-radius:3px;
  	-moz-border-radius:3px;*/
	color: #fff;
	text-shadow: 0 1px 1px #a2460f;
	display:block;
	padding:0 15px;
	line-height:25px;
	font-weight:700;
	-webkit-transition:background ease-in-out 1s;
	-moz-transition:background ease-in-out 1s;
	-o-transition:background ease-in-out 1s;
	transition:background ease-in-out 1s;
	-ms-transition:background ease-in-out 1s;
}
</style>
<!-- basic styles -->

		<link href="new_design/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="new_design/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<link rel="stylesheet" href="new_design/css/jquery-ui-1.10.3.custom.min.css" />
		<link rel="stylesheet" href="new_design/css/chosen.css" />
		<link rel="stylesheet" href="new_design/css/datepicker.css" />
		<link rel="stylesheet" href="new_design/css/bootstrap-timepicker.css" />
		<link rel="stylesheet" href="new_design/css/daterangepicker.css" />
		<link rel="stylesheet" href="new_design/css/colorpicker.css" />

		<!-- fonts -->

		<link rel="stylesheet" href="new_design/css/ace-fonts.css" />

		<!-- ace styles -->

		<link rel="stylesheet" href="new_design/css/ace.min.css" />
		<link rel="stylesheet" href="new_design/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="new_design/css/ace-skins.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="new_design/css/ace-ie.min.css" />
		<![endif]-->

		<!-- ace settings handler -->

		<script src="new_design/js/ace-extra.min.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="new_design/js/html5shiv.js"></script>
		<script src="new_design/js/respond.min.js"></script>
		<![endif]-->
    </head>
    <body >
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
		<div style="background-color:#FFF">
<div id="div-fixed-wrap" class="navbar navbar-default" id="navbar" style="z-index:99999999;">
			<!--<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>-->

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="index.php" class="navbar-brand">
						<small>
							<i class="icon-leaf"></i>
							<?php echo getWebSiteName(); ?>
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->
				<?php if(isset($_SESSION['uid'])){ 
				
				$sql_bl="select * from user where usr_id=".$_SESSION['uid']; //query for account balance
				$res_bl=mysql_query($sql_bl);
				$row_bl=mysql_fetch_object($res_bl);
				
				?>
				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="light-blue">
							<div class="closeButton"><a href="javascript:window.close();" class="btn btn-info"><?php echo $lang[352]; ?></a></div>

						</li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
                <?php }else{	?>
                <div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
                    <li class="grey">
						<a href="login.php"><?php echo $lang[51]; ?></a>
                    </li>
                    </ul>
				</div>
                <?php } ?>
			</div><!-- /.container -->
		</div>



    <div style="width:100%;margin:0 auto;padding-bottom:50px;padding-top:100px;padding-left: 25px;padding-right:25px;">

        <div style="padding-left: 25px;"><h2><?php echo $lang[450]; ?><a href="profile.php?u=<?php echo md5($row_from_user->usr_id); ?>" target="_blank"><b><?php echo $row_from_user->usr_name; ?></b></a><?php echo $lang[451]; ?><a href="profile.php?u=<?php echo md5($row_to_user->usr_id); ?>" target="_blank"><b><?php echo $row_to_user->usr_name; ?></b></a><br></h2></div>
                            
        <div style="padding-left: 25px;"><h3><?php echo $lang[452]; ?><a href="project.php?p=<?php echo $row_bid->prj_id; ?>" target="_blank"><?php echo $row_bid->prj_name; ?></a></h3></div>
        
        
          
   			<div style="padding-left: 10px;padding-right: 10px;">
            <?php
			/*"select * from message,user where if(msg_to_usr_id='".$_SESSION['uid_fb']."' , msg_from_usr_id=usr_id , msg_to_usr_id=usr_id) and msg_id in(select max(msg_id) from message where (msg_to_usr_id='".$_SESSION['uid_fb']."' or msg_from_usr_id='".$_SESSION['uid_fb']."') ".$excl_ur." group by if(msg_to_usr_id='".$_SESSION['uid_fb']."',msg_from_usr_id,msg_to_usr_id)) order by msg_updated_date desc"*/
			
			$row_from_user->usr_id;
			
	            $sql_msg="select * from message,user where msg_from=usr_id and msg_prj_id='".$row_bid->prj_id."' and (usr_id='".$row_from_user->usr_id."' or usr_id='".$row_to_user->usr_id."') order by msg_date desc";
    	        $res_msg=mysql_query($sql_msg);
        	    if(mysql_num_rows($res_msg)>0)
            	{	?>
        			<div class="row">
						<div class="col-xs-12">
							<div class="table-responsive">
								<table id="sample-table-1" class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th><?php echo $lang[692]; ?></th>
											<th><?php echo $lang[693]; ?></th>
											<th><i class="icon-time bigger-110 hidden-480"></i></th>
										</tr>
									</thead>
									<tbody>
                                    <?php
						                while($row_msg=mysql_fetch_object($res_msg)){
					                ?>
										<tr>
											<td width="28%"><?php echo stripslashes($row_msg->usr_name); ?></td>
											<td>
                               	            	<?php echo stripslashes($row_msg->msg_message); ?>
						                    	<?php if($row_msg->msg_file != ''){ ?>
	                        						<br />
                                                	<b><?php echo $lang[357]; ?>&nbsp;<a href="upload/message/<?php echo $row_msg->msg_file; ?>" target="_blank"><?php echo $lang[358]; ?></a></b>
												<?php } ?>
                                            </td>
											<td width="20%"><?php echo date("d-M-Y",strtotime($row_msg->msg_date)); ?></td>
										</tr>
									<?php	}	?>
									</tbody>
								</table>
							</div><!-- /.table-responsive -->
						</div><!-- /span -->
					</div>
			<?php	}	?>
        </div>
        
        <div style="padding-left: 25px;"><h2><?php echo $lang[694]; ?></h2></div>

        <form action="" method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal">
            <input name="msg_from" value="<?php echo $_SESSION['uid']; ?>" type="hidden">
            <input name="msg_to" value="<?php echo $row_to_user->usr_id; ?>" type="hidden">
            <input name="msg_prj_id" value="<?php echo $row_bid->prj_id; ?>" type="hidden">
        
	<!--<div class="clearfix" style="">-->
                   
		<!--<div style="width:100%;float:left;margin:0 0 0 0px;">-->
			<p><strong><font color="red"><?php echo $lang[695]; ?></font></strong> <?php echo $lang[453]; ?><?php echo getSiteTitle(); ?><br><?php echo $lang[454]; ?><a target="_blank" href="terms.php"><?php echo $lang[215]; ?></a>.</p>

                  <div class="signup-form-str" id="msg"><?php echo $msg; ?></div>
                                
             <div class="form-group">
						
                 <div class="col-sm-4">
			<textarea class="form-control"  name="msg_message" id="msg_message" rows="10"></textarea>
                 </div>
			
            </div>                                    
                                          
                <div class="signup-form-str">
					<label class="form-label"><?php echo $lang[208]; ?></label>
                    <p style="margin-bottom:1px;"><?php echo $lang[209]; ?></p>
                   <!-- <p style="color:#F00;margin-top:-1px;margin-bottom:-1px;"><?php /*echo $lang[210];*/ ?></p>-->
                    <div class="col-sm-4">
					<input id="id-input-file-2" name="msg_file" type="file">
                    </div>
                    <div>
                     <i><?php echo $lang[211]; ?></i>
                     </div>
                </div>
                
				<div style="width:100%;text-align:center">
					<input type="submit" id="btnSave" value="<?php echo $lang[455]; ?>" class="btn btn-info" name="submitMessage">
				</div>

			<!--</div>-->
		<!--</div>-->
      </form>
</div>

<!-- basic scripts -->

		<!--[if !IE]> -->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='new_design/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='new_design/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='new_design/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="new_design/js/bootstrap.min.js"></script>
		<script src="new_design/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="new_design/js/excanvas.min.js"></script>
		<![endif]-->

		<script src="new_design/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="new_design/js/jquery.ui.touch-punch.min.js"></script>
		<script src="new_design/js/chosen.jquery.min.js"></script>
		<script src="new_design/js/fuelux/fuelux.spinner.min.js"></script>
		<script src="new_design/js/date-time/bootstrap-datepicker.min.js"></script>
		<script src="new_design/js/date-time/bootstrap-timepicker.min.js"></script>
		<script src="new_design/js/date-time/moment.min.js"></script>
		<script src="new_design/js/date-time/daterangepicker.min.js"></script>
		<script src="new_design/js/bootstrap-colorpicker.min.js"></script>
		<script src="new_design/js/jquery.knob.min.js"></script>
		<script src="new_design/js/jquery.autosize.min.js"></script>
		<script src="new_design/js/jquery.inputlimiter.1.3.1.min.js"></script>
		<script src="new_design/js/jquery.maskedinput.min.js"></script>
		<script src="new_design/js/bootstrap-tag.min.js"></script>

                    <!-- ace scripts -->

		<script src="new_design/js/ace-elements.min.js"></script>
		<script src="new_design/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
                    <script type="text/javascript">
			jQuery(function($) {
				$('#id-disable-check').on('click', function() {
					var inp = $('#form-input-readonly').get(0);
					if(inp.hasAttribute('disabled')) {
						inp.setAttribute('readonly' , 'true');
						inp.removeAttribute('disabled');
						inp.value="This text field is readonly!";
					}
					else {
						inp.setAttribute('disabled' , 'disabled');
						inp.removeAttribute('readonly');
						inp.value="This text field is disabled!";
					}
				});
			
			
				$(".chosen-select").chosen(); 
				$('#chosen-multiple-style').on('click', function(e){
					var target = $(e.target).find('input[type=radio]');
					var which = parseInt(target.val());
					if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
					 else $('#form-field-select-4').removeClass('tag-input-style');
				});
			
			
				$('[data-rel=tooltip]').tooltip({container:'body'});
				$('[data-rel=popover]').popover({container:'body'});
				
				$('textarea[class*=autosize]').autosize({append: "\n"});
				$('textarea.limited').inputlimiter({
					remText: '%n character%s remaining...',
					limitText: 'max allowed : %n.'
				});
			
				$.mask.definitions['~']='[+-]';
				$('.input-mask-date').mask('99/99/9999');
				$('.input-mask-phone').mask('(999) 999-9999');
				$('.input-mask-eyescript').mask('~9.99 ~9.99 999');
				$(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});
			
			
			
				$( "#input-size-slider" ).css('width','200px').slider({
					value:1,
					range: "min",
					min: 1,
					max: 8,
					step: 1,
					slide: function( event, ui ) {
						var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
						var val = parseInt(ui.value);
						$('#form-field-4').attr('class', sizing[val]).val('.'+sizing[val]);
					}
				});
			
				$( "#input-span-slider" ).slider({
					value:1,
					range: "min",
					min: 1,
					max: 12,
					step: 1,
					slide: function( event, ui ) {
						var val = parseInt(ui.value);
						$('#form-field-5').attr('class', 'col-xs-'+val).val('.col-xs-'+val);
					}
				});
				
				
				$( "#slider-range" ).css('height','200px').slider({
					orientation: "vertical",
					range: true,
					min: 0,
					max: 100,
					values: [ 17, 67 ],
					slide: function( event, ui ) {
						var val = ui.values[$(ui.handle).index()-1]+"";
			
						if(! ui.handle.firstChild ) {
							$(ui.handle).append("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>");
						}
						$(ui.handle.firstChild).show().children().eq(1).text(val);
					}
				}).find('a').on('blur', function(){
					$(this.firstChild).hide();
				});
				
				$( "#slider-range-max" ).slider({
					range: "max",
					min: 1,
					max: 10,
					value: 2
				});
				
				$( "#eq > span" ).css({width:'90%', 'float':'left', margin:'15px'}).each(function() {
					// read initial values from markup and remove that
					var value = parseInt( $( this ).text(), 10 );
					$( this ).empty().slider({
						value: value,
						range: "min",
						animate: true
						
					});
				});
			
				
				$('#id-input-file-1 , #id-input-file-2').ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false //| true | large
					//whitelist:'gif|png|jpg|jpeg'
					//blacklist:'exe|php'
					//onchange:''
					//
				});
				
				$('#id-input-file-3').ace_file_input({
					style:'well',
					btn_choose:'Drop files here or click to choose',
					btn_change:null,
					no_icon:'icon-cloud-upload',
					droppable:true,
					thumbnail:'small'//large | fit
					//,icon_remove:null//set null, to hide remove/reset button
					/**,before_change:function(files, dropped) {
						//Check an example below
						//or examples/file-upload.html
						return true;
					}*/
					/**,before_remove : function() {
						return true;
					}*/
					,
					preview_error : function(filename, error_code) {
						//name of the file that failed
						//error_code values
						//1 = 'FILE_LOAD_FAILED',
						//2 = 'IMAGE_LOAD_FAILED',
						//3 = 'THUMBNAIL_FAILED'
						//alert(error_code);
					}
			
				}).on('change', function(){
					//console.log($(this).data('ace_input_files'));
					//console.log($(this).data('ace_input_method'));
				});
				
			
				//dynamically change allowed formats by changing before_change callback function
				$('#id-file-format').removeAttr('checked').on('change', function() {
					var before_change
					var btn_choose
					var no_icon
					if(this.checked) {
						btn_choose = "Drop images here or click to choose";
						no_icon = "icon-picture";
						before_change = function(files, dropped) {
							var allowed_files = [];
							for(var i = 0 ; i < files.length; i++) {
								var file = files[i];
								if(typeof file === "string") {
									//IE8 and browsers that don't support File Object
									if(! (/\.(jpe?g|png|gif|bmp)$/i).test(file) ) return false;
								}
								else {
									var type = $.trim(file.type);
									if( ( type.length > 0 && ! (/^image\/(jpe?g|png|gif|bmp)$/i).test(type) )
											|| ( type.length == 0 && ! (/\.(jpe?g|png|gif|bmp)$/i).test(file.name) )//for android's default browser which gives an empty string for file.type
										) continue;//not an image so don't keep this file
								}
								
								allowed_files.push(file);
							}
							if(allowed_files.length == 0) return false;
			
							return allowed_files;
						}
					}
					else {
						btn_choose = "Drop files here or click to choose";
						no_icon = "icon-cloud-upload";
						before_change = function(files, dropped) {
							return files;
						}
					}
					var file_input = $('#id-input-file-3');
					file_input.ace_file_input('update_settings', {'before_change':before_change, 'btn_choose': btn_choose, 'no_icon':no_icon})
					file_input.ace_file_input('reset_input');
				});
			
			
			
			
				$('#spinner1').ace_spinner({value:0,min:0,max:200,step:10, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
				.on('change', function(){
					//alert(this.value)
				});
				$('#spinner2').ace_spinner({value:0,min:0,max:10000,step:100, touch_spinner: true, icon_up:'icon-caret-up', icon_down:'icon-caret-down'});
				$('#spinner3').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'icon-plus smaller-75', icon_down:'icon-minus smaller-75', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
			
			
				
				$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				$('input[name=date-range-picker]').daterangepicker().prev().on(ace.click_event, function(){
					$(this).next().focus();
				});
				
				$('#timepicker1').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				$('#colorpicker1').colorpicker();
				$('#simple-colorpicker-1').ace_colorpicker();
			
				
				$(".knob").knob();
				
				
				//we could just set the data-provide="tag" of the element inside HTML, but IE8 fails!
				var tag_input = $('#form-field-tags');
				if(! ( /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase())) ) 
				{
					tag_input.tag(
					  {
						placeholder:tag_input.attr('placeholder'),
						//enable typeahead by specifying the source array
						source: ace.variable_US_STATES,//defined in ace.js >> ace.enable_search_ahead
					  }
					);
				}
				else {
					//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
					tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
					//$('#form-field-tags').autosize({append: "\n"});
				}
				
				
				
			
				/////////
				$('#modal-form input[type=file]').ace_file_input({
					style:'well',
					btn_choose:'Drop files here or click to choose',
					btn_change:null,
					no_icon:'icon-cloud-upload',
					droppable:true,
					thumbnail:'large'
				})
				
				//chosen plugin inside a modal will have a zero width because the select element is originally hidden
				//and its width cannot be determined.
				//so we set the width after modal is show
				$('#modal-form').on('shown.bs.modal', function () {
					$(this).find('.chosen-container').each(function(){
						$(this).find('a:first-child').css('width' , '210px');
						$(this).find('.chosen-drop').css('width' , '210px');
						$(this).find('.chosen-search input').css('width' , '200px');
					});
				})
				/**
				//or you can activate the chosen plugin after modal is shown
				//this way select element becomes visible with dimensions and chosen works as expected
				$('#modal-form').on('shown', function () {
					$(this).find('.modal-chosen').chosen();
				})
				*/
			
			});
</script>

    </body>
</html>                