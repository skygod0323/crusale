<!DOCTYPE html>
<html lang="en-US">
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
   		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
        
		<title><?php echo getWebSiteTitle(); ?></title>
        
	    <meta name="title" content="<?php echo getWebSiteTitle(); ?>">
		<meta name="keywords" content="<?php echo get_page_settings(2); ?>">
		<meta name="description" content="<?php echo get_page_settings(3); ?>">
        
        <meta name="viewport" content="width=device-width">
		<link href='http://fonts.googleapis.com/css?family=Lato:400,900' rel='stylesheet' type='text/css'>
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/gaf_style.min.css">
        
        <!--<link rel="stylesheet" href="css/gaf.ns.css">-->
        <!--<script src="js/vendor/modernizr-2.6.2.min.js"></script>
<script src="js/jquery-1.10.2.js" type="text/javascript"></script>-->

<!--     <script type="text/javascript" src="js/functions.js"></script>-->
<script>
function goLink(lnk)
{
	window.location="notify.php?id="+lnk;
}
</script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
		<div>
        		        
        <!-- basic styles -->

		<link href="new_design/css/chosen.css" rel="stylesheet"/>
		<link rel="stylesheet" href="new_design/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="new_design/css/font-awesome.min.css" />
        <link rel="stylesheet" href="new_design/css/ace-ie.min.css" />
        <link rel="stylesheet" href="new_design/css/ace-rtl.min.css" />
        <link rel="stylesheet" href="new_design/css/ace.min.css" />
        <link rel="stylesheet" href="new_design/css/font-awesome.min.css" />
		<link rel="stylesheet" href="new_design/css/ace-skins.min.css" />

		
		<!-- page specific plugin styles -->

		<!-- fonts -->


		<!--<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='new_design/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="new_design/js/bootstrap.min.js"></script>
		<script src="new_design/js/typeahead-bs2.min.js"></script>-->

		<!-- page specific plugin scripts -->

		
		<!-- inline scripts related to this page -->

	
        <!--js for new design ends-->
        
        <div class="navbar navbar-default" id="navbar" style="width:100%;z-index:99999999;">
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
						
                        
                        <li class="grey">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-gift icon-animated-hand-pointer"></i>
								<span style="vertical-align:middle;"><?php echo $row_bl->usr_balance; ?>&nbsp;<?php echo getCurrencyCode(); ?></span>
							</a>

							<ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								
								<li>
									<a href="payment-deposit.php">
										<div class="clearfix"><span class="pull-left"><?php echo $lang[134]; ?></span></div>
									</a>
								</li>
								<li>
									<a href="transactions.php">
										<div class="clearfix"><span class="pull-left"><?php echo $lang[138]; ?></span></div>
									</a>
								</li>
                                <li></li>
							</ul>
						</li>
                        
                        
						<!---->
						<li class="purple">
                        <?php
						//	$sql_un="select * from user_notification where un_usr_id='".$_SESSION['uid']."' and un_status='1'";
							$sql_un="select * from user_notification,user,project where un_from_usr_id=usr_id and un_prj_id=prj_id and un_usr_id='".$_SESSION['uid']."' and un_status='1'";
							$res_un=mysql_query($sql_un);
							$num_un=mysql_num_rows($res_un);
							
							if($row_bl->usr_emailVerified =='0'){	$num_un=$num_un+1;	}

							/*if($num_un>0){*/
						?>
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon-bell-alt icon-animated-bell"></i>
								<span class="badge badge-important"><?php echo $num_un; ?></span>
							</a>

							<ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="icon-warning-sign"></i>
                                    
                                    
									<?php echo $num_un; ?><?php echo $lang[709]; ?>
								</li>
                    <?php
					/*$sqlc="select * from user where usr_id='".$_SESSION['uid']."' and usr_status='1'";
					$resc=mysql_query($sqlc);
					$rowc=mysql_fetch_object($resc);*/
					if($row_bl->usr_emailVerified =='0'){	?>
					<li>
						<a href="emailVerification.php">
							<div class="clearfix">
								<span class="pull-left">
									<i class="btn btn-xs no-hover btn-pink icon-warning-sign"></i>
									<?php echo $lang[107]; ?>
								</span>
								<!--<span class="pull-right badge badge-info">+12</span>-->
							</div>
						</a>
					</li>
                    <?php	}	?>
								<!--<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-pink icon-comment"></i>
												New Comments
											</span>
											<span class="pull-right badge badge-info">+12</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<i class="btn btn-xs btn-primary icon-user"></i>
										Bob just signed up as an editor ...
									</a>
								</li>-->

				<?php
					$sql_not="select * from user_notification,user,project where un_from_usr_id=usr_id and un_prj_id=prj_id and un_usr_id='".$_SESSION['uid']."' order by un_updated_date desc limit 3";
					$res_not=mysql_query($sql_not);
					while($row_not=mysql_fetch_object($res_not)){
				?>
                	
					<li>
							<a onClick="goLink(<?php echo $row_not->un_id; ?>)" style="cursor:pointer;">
								<?php if($row_not->usr_image != ''){ ?>
						               <img src="images/users/<?php echo $row_not->usr_image; ?>" class="msg-photo" alt="<?php echo $row_not->usr_name; ?>" />
						        <?php } else { ?>
						               <img src="images/users/unknown.png" class="msg-photo" alt="<?php echo $row_not->usr_name; ?>" />
						        <?php } ?>
									<span class="msg-body">
										<span class="msg-title">
											<span class="blue"><?php echo $row_not->usr_name; ?>:</span>
                                              <?php
												if($row_not->un_type=='dispute')
                  								{
													if(strlen(substr($row_not->un_content,0,  strpos($row_not->un_content, "|")))>40){
								                    	echo substr(substr($row_not->un_content,0,  strpos($row_not->un_content, "|")),0,40)." ...";
													}
													else
													{
														echo substr($row_not->un_content,0,  strpos($row_not->un_content, "|"));
													}
												}
                  								else
                  								{
													if(strlen($row_not->un_content)>40){
														echo substr($row_not->un_content,0,40)." ...";
													}
													else
													{
														echo $row_not->un_content;
													}
                  								}
				  								?>
											</span>

											<span class="msg-time">
												<i class="icon-time"></i>
												<span>
                                                <?php 
													$diff=dateDifference($row_not->un_updated_date,date("Y-m-d h:i:s"));
													if($diff>0)
													{
														if(round($diff/365)>=1)
														{
															echo round($diff/365).$lang[704];
														}
														else if($diff/30>=1)
														{
															echo round($diff/30).$lang[705];
														}
														else
														{
															echo $diff.$lang[74];
														}
													}
													else
													{
														echo $lang[354];
													}
												?>    
                                                </span>
											</span>
										</span>
									</a>
								</li>
							<?php	}	?>
								<li>
									<a href="notification.php">
										<?php echo $lang[710]; ?>
										<i class="icon-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="green">
                        <?php
							$sql_msgn="select * from message,user,project where msg_to='".$_SESSION['uid']."' and msg_from=usr_id and msg_prj_id=prj_id and msg_read='0' and msg_to_status='1'";
							$res_msgn=mysql_query($sql_msgn);
							$num_msgn=mysql_num_rows($res_msgn);
							
							?>
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="icon-envelope icon-animated-vertical"></i>
								<span class="badge badge-success"><?php echo $num_msgn; ?></span>
							</a>
						<?php	if($num_msgn>0){	?>
							<ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="icon-envelope-alt"></i>
									<?php echo $num_msgn; ?><?php echo $lang[711]; ?>
								</li>
						<?php
							$sql_msg_not="select * from message,user,project where msg_to='".$_SESSION['uid']."' and msg_from=usr_id and msg_prj_id=prj_id and msg_read='0' and msg_to_status='1' order by msg_date desc limit 3";
							$res_msg_not=mysql_query($sql_msg_not);
							while($row_msg_not=mysql_fetch_object($res_msg_not)){
						?>
								<li>
									<a href="mymessage.php">
                                    <?php if(($row_msg_not->usr_image!="")&&($row_msg_not->usr_image!="NULL")){?>
										<img src="images/users/<?php echo $row_msg_not->usr_image; ?>" class="msg-photo" alt="<?php echo $row_msg_not->usr_name; ?>" />
                                    <?php }else{ ?>
	                                    <img src="images/users/unknown.png" class="msg-photo" alt="<?php echo $row_msg_not->usr_name; ?>" />
                                    <?php } ?>
										<span class="msg-body">
											<span class="msg-title">
												<span class="blue"><?php echo $row_msg_not->usr_name; ?>:</span>
												<?php
												if(strlen($row_msg_not->msg_message)>40){
												echo substr($row_msg_not->msg_message,0,40)." ...";
												}else{
													echo $row_msg_not->msg_message;
												}												
												?>
											</span>

											<span class="msg-time">
												<i class="icon-time"></i>
												<span>
                                                <?php $diff=dateDifference($row_msg_not->msg_date,date("Y-m-d h:i:s"));
					if($diff>0){	echo $diff.$lang[74];	}
					else {	echo $lang[354];	}
                              ?>   </span>
											</span>
										</span>
									</a>
								</li>
						<?php	}	?>
								<li>
									<a href="mymessage.php">
										<?php echo $lang[708]; ?>
										<i class="icon-arrow-right"></i>
									</a>
								</li>
							</ul>
                            <?php }else{	?>
                            <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="icon-envelope-alt"></i>
									<?php echo $lang[712]; ?>
								</li>
								<li>
									<a href="mymessage.php">
										<?php echo $lang[708]; ?>
										<i class="icon-arrow-right"></i>
									</a>
								</li>
							</ul>
                            <?php } ?>
						</li>

						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<!--<img class="nav-user-photo" src="new_design/avatars/user.jpg" alt="Jason's Photo" />-->
                                <img class="nav-user-photo" src="images/users/<?php if($row_bl->usr_image != ''){ echo $row_bl->usr_image; }else{ echo "unknown.png"; } ?>" />
								<span class="user-info">
									<small><?php echo $lang[713]; ?></small>
									<?php echo $row_bl->usr_name; ?>
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="manage.php">
										<i class="icon-cog"></i>
										<?php echo $lang[120]; ?>
									</a>
								</li>

								<li>
									<a href="profile.php">
										<i class="icon-user"></i>
										<?php echo $lang[123]; ?>
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="logout.php">
										<i class="icon-off"></i>
										<?php echo $lang[111]; ?>
									</a>
								</li>
							</ul>
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
        
        
        
<?php
$filename=substr($_SERVER['SCRIPT_NAME'],strpos($_SERVER['SCRIPT_NAME'],'/',1)+1,strlen($_SERVER['SCRIPT_NAME']));
$file=substr($filename,0,strpos($filename,'.'));
?>
<link rel="stylesheet" href="css/style_menu.css" type="text/css" />
<?php if($file != "index"){	?>

	
	<div class="navbar navbar-default" role="navigation" style="background-color:#CCC; padding-left:20px;" >
    	<div class="navbar-collapse collapse">
        	<ul class="nav navbar-nav" style="text-align: left;">
            
	            <?php   if($_SESSION['uid']!='' && $_SESSION['type']=="Freelancer"){    ?>
                <li <?php if($file=="about"){ ?>class="active"<?php } ?>>
              		<a href="about.php" ><?php echo $lang[82]; ?></a>
				</li>
                <?php	}else{	?>
                <li <?php if($file=="post-project"){ ?>class="active"<?php } ?>>
              		<a href="post-project.php" ><?php echo $lang[112]; ?></a>
				</li>
                <?php	}	?>
                <?php    if(isset($_SESSION['uid']))	{	?>
            	<li class="dropdown <?php if($file=="manage" || $file=="mymessages"){ ?>active<?php } ?>">
                	<a href="manage.php" class="dropdown-toggle" data-toggle="dropdown"><?php echo $lang[120]; ?></a>
                    <ul class="dropdown-menu">
						<li><a href="manage.php"><?php echo $lang[121]; ?></a></li> 
						<li><a href="mymessage.php"><?php echo $lang[122]; ?></a></li> 
					</ul>
                </li>
                
				<li class="dropdown <?php if($file=="changeuserinfo" || $file=="change-email" || $file=="profile" || $file=="change-password" || $file=="membership"){ ?>active<?php } ?>">
                	<a class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer"><?php echo $lang[123]; ?></a>
                    <ul class="dropdown-menu">
		                <li><a href="changeuserinfo.php"><?php echo $lang[124]; ?></a></li> 
						<li><a href="change-email.php"><?php echo $lang[125]; ?></a></li> 
						<li><a href="profile.php"><?php echo $lang[126]; ?></a></li> 
						<li><a href="change-password.php"><?php echo $lang[127]; ?></a></li>                         
						<li><a href="membership.php"><?php echo $lang[128]; ?></a></li> 
					</ul>
                </li>
				<?php	}	?>
            	<li class="dropdown <?php if($file=="employer-following" || $file=="find-freelancer"){ ?>active<?php } ?>">
                	<a class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer"><?php echo $lang[129]; ?></a>
	                <ul class="dropdown-menu">
		                <?php   if($_SESSION['type']!="Employer"){    ?>
						<li><a href="employer-following.php"><?php echo $lang[130]; ?></a></li> 
        				<?php } ?>
                        <?php   if($_SESSION['type']!="Freelancer"){    ?>
						<li><a href="find-freelancer.php"><?php echo $lang[131]; ?></a></li> 
                        <?php } ?>
					</ul>
                </li>
                <?php    if(isset($_SESSION['uid']))	{	?>
            	<li class="dropdown <?php if($file=="financial-dash" || $file=="payment-deposit" || $file=="payment-deposit-confirm" || $file=="transfer-funds" || $file=="withdraw-funds" || $file=="release-funds" || $file=="transactions"){ ?>active<?php } ?>">
              		<a class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer"><?php echo $lang[132]; ?><!--<b class="caret"></b>--></a>
              		<ul class="dropdown-menu">
                		<li><a href="financial-dash.php"><?php echo $lang[133]; ?></a></li> 
						<li><a href="payment-deposit.php"><?php echo $lang[134]; ?></a></li>
                        <?php   if($_SESSION['type']!="Freelancer"){    ?>
						<li><a href="transfer-funds.php"><?php echo $lang[135]; ?></a></li>
                        <?php   }   ?>
						<li><a href="withdraw-funds.php"><?php echo $lang[136]; ?></a></li> 
                        <?php   if($_SESSION['type']!="Freelancer"){    ?>
						<li><a href="release-funds.php"><?php echo $lang[137]; ?></a></li>
                        <?php   }   ?>
                        <li><a href="invoice.php"><?php echo $lang[796]; ?></a></li>
						<li><a href="transactions.php"><?php echo $lang[138]; ?></a></li> 
					</ul>
				</li>
                <?php	}	?>
                
                <li class="dropdown <?php if($file=="show-category" || $file=="latest-proj" || $file=="ending-soon" || $file=="lowbids" || $file=="myskills"){ ?>active<?php } ?>">
              		<a class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer"><?php echo $lang[114]; ?><!--<b class="caret"></b>--></a>
              		<ul class="dropdown-menu">
                		<li><a href="show-category.php"><?php echo $lang[115]; ?></a></li>
                        <?php   if($_SESSION['type']!="Freelancer"){    ?>
						<li><a href="latest-proj.php"><?php echo $lang[116]; ?></a></li>
                        <?php } ?>
						<li><a href="ending-soon.php"><?php echo $lang[117]; ?></a></li>
                        <li><a href="lowbids.php"><?php echo $lang[118]; ?></a></li>
						<li><a href="myskills.php"><?php echo $lang[119]; ?></a></li>
					</ul>
				</li>
                
			</ul>
		</div><!--/.nav-collapse -->
	</div>
<?php	}	?>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript" charset="utf-8"></script>	
<script src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/jquery.effects.core.js" type="text/javascript"></script>
<script type="text/javascript" src="js/scripts.js"></script>-->      

				

<?php /*}*/ ?>
<div style="background-color:#FFF">
<?php	if($file!='index'){	?>
<div id="page-container-inner" <?php	if($file=='project'){	?>style="padding-top:0px;"	<?php } ?> >
<?php	}	?>