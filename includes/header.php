<!DOCTYPE html>
<html lang="en">



<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- SITE META -->
    <title><?php echo getWebSiteTitle(); ?></title>
	<meta name="title" content="<?php echo getWebSiteTitle(); ?>">
	<meta name="keywords" content="<?php echo get_page_settings(2); ?>">
	<meta name="description" content="<?php echo get_page_settings(3); ?>">

    <!-- FAVICONS -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    

    <!-- BOOTSTRAP STYLES -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- TEMPLATE STYLES -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- RESPONSIVE STYLES -->
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
    <!-- COLORS -->
    <link rel="stylesheet" type="text/css" href="css/colors.css">

    <!-- CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="css/custom.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='new_design/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
<script>
function goLink(lnk)
{
	window.location="notify.php?id="+lnk;
}
</script>
</head>
<body>

    <!-- PRELOADER -->
        <div class="cssload-container">
            <div class="cssload-loader"></div>
        </div>
    <!-- end PRELOADER -->
    
    <!-- START SITE -->
        <div id="wrapper">
            <header class="header">
                <div class="container-fluid">
                    <nav class="navbar navbar-default yamm">
                        <div class="container">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" title="" href="index.php"><img src="sitelogo/<?php echo get_page_settings(5); ?>" alt="<?php echo getWebSiteName(); ?>" class="img-responsive"></a>
                            </div>
                            <!-- end navbar header -->

                            <div id="navbar" class="navbar-collapse collapse">
                                <ul class="nav navbar-nav">
                                    <?php if(!isset($_SESSION['uid'])){ ?>
									<li <?php if($file=="post-project"){ ?>class="active"<?php } ?>><a href="post-project.php" ><?php echo $lang[112]; ?></a></li>
                                    <li><a href="employer-following.php"><?php echo $lang[130]; ?></a></li> 
									<li><a href="find-freelancer.php"><?php echo $lang[131]; ?></a></li> 
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
                                    <?php } ?>
                                    <?php if(isset($_SESSION['uid'])){ ?>
                                    <li <?php if($file=="post-project"){ ?>class="active"<?php } ?>><a href="post-project.php" ><?php echo $lang[112]; ?></a></li>
                                    
                                    <li class="dropdown<?php if($file=="manage" || $file=="mymessages"){ ?>active<?php } ?>"><a href="manage.php" data-toggle="dropdown" class="dropdown-toggle"><?php echo $lang[120]; ?> <b class="fa fa-angle-down"></b></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="manage.php"><?php echo $lang[121]; ?></a></li> 
						<li><a href="mymessage.php"><?php echo $lang[122]; ?></a></li> 
                                        </ul><!-- end dropdown-menu -->
                                    </li><!-- end hasmenu --> 
                                    
                                    <li class="dropdown <?php if($file=="changeuserinfo" || $file=="change-email" || $file=="profile" || $file=="change-password" || $file=="membership"){ ?>active<?php } ?>">
                                        <a class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer"><?php echo $lang[123]; ?></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="changeuserinfo.php"><?php echo $lang[124]; ?></a></li> 
                                            <li><a href="change-email.php"><?php echo $lang[125]; ?></a></li> 
                                            <li><a href="profile.php"><?php echo $lang[126]; ?></a></li> 
                                            <li><a href="change-password.php"><?php echo $lang[127]; ?></a></li>                         
                                            <li><a href="membership.php"><?php echo $lang[128]; ?></a></li> 
                                        </ul>
                                    </li><!-- end hasmenu --> 
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
                                    <?php } ?>
                                </ul>
                                <ul class="nav navbar-nav" style="float:right;">
                                	<?php if(isset($_SESSION['uid'])){ 
                                    $sql_bl="select * from user where usr_id=".$_SESSION['uid']; //query for account balance
									$res_bl=mysql_query($sql_bl);
									$row_bl=mysql_fetch_object($res_bl); ?>
                                    
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer"><span style="margin:10px;"><?php echo $row_bl->usr_balance; ?>&nbsp;<?php echo getCurrencyCode(); ?></span><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            
                                            <li><a href="payment-deposit.php"><?php echo $lang[134]; ?></a></li>
                                            <li><a href="transactions.php"><?php echo $lang[138]; ?></a></li>
                                        </ul>
                                    </li>
                                    <?php
									//	$sql_un="select * from user_notification where un_usr_id='".$_SESSION['uid']."' and un_status='1'";
										$sql_un="select * from user_notification,user,project where un_from_usr_id=usr_id and un_prj_id=prj_id and un_usr_id='".$_SESSION['uid']."' and un_status='1'";
										$res_un=mysql_query($sql_un);
										$num_un=mysql_num_rows($res_un);
							
										if($row_bl->usr_emailVerified =='0'){	$num_un=$num_un+1;	}

										/*if($num_un>0){*/
									?>
                                    <li class="dropdown">
                                    	<!-- Button trigger modal -->
                                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#notification" style="margin-right:5px;"><?php echo $num_un; ?>  <i class="fa fa-bell" aria-hidden="true"></i>
</span></a>
                                    </li> 
                                    <li class="dropdown">
                                    	<!-- Button trigger modal -->
                                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#msg" style="margin-right:5px;"><?php echo $num_un; ?>  <i class="fa fa-envelope" aria-hidden="true"></i>
</span></a>
                                    </li> 
                                    
                                     
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="cursor:pointer;padding:4px;"><img style="height:35px;" class="img-circle" src="images/users/<?php if($row_bl->usr_image != ''){ echo $row_bl->usr_image; }else{ echo "unknown.png"; } ?>" /><span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li class="dropdown-header"><?php echo $lang[713]; ?> <?php echo $row_bl->usr_name; ?></li>
                                            <li><a href="manage.php"><span class="glyphicon glyphicon-user"></span> <?php echo $lang[120]; ?></a></li>
                                            <li><a href="profile.php"><span class="glyphicon glyphicon-off"></span> <?php echo $lang[123]; ?></a></li>
                                            <li><a href="logout.php"><span class="glyphicon glyphicon-lock"></span> <?php echo $lang[111]; ?></a></li>
                                            
                                        </ul>
                                    </li> <?php } ?>
                                    <?php if(!isset($_SESSION['uid'])){ ?>
                                    <li><a class="btn btn-primary" title="" href="login.php">Login</a></li>
                                    <?php } ?>
                                </ul>
                                <!-- end dropdown -->
                                
                            <!--/.nav-collapse -->
                        </div>
                        <!--/.container-fluid -->
                    </nav>
                    <!-- end nav -->
                </div>
                <!-- end container -->
            </header>
            <!-- end header -->
			<!-- Modal 1-->
                                <div class="modal fade" id="msg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                      	<?php
                                            $sql_msgn="select * from message,user,project where msg_to='".$_SESSION['uid']."' and msg_from=usr_id and msg_prj_id=prj_id and msg_read='0' and msg_to_status='1'";
                                            $res_msgn=mysql_query($sql_msgn);
                                            $num_msgn=mysql_num_rows($res_msgn);
                                            
                                         ?>
                                        <h5 class="modal-title" id="exampleModalLabel"><?php	if($num_msgn>0){echo $num_msgn;}?><?php echo $lang[711]; ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        	
										
                                            
                                        <?php	if($num_msgn>0){	?>
                                            
                                        <?php
                                            $sql_msg_not="select * from message,user,project where msg_to='".$_SESSION['uid']."' and msg_from=usr_id and msg_prj_id=prj_id and msg_read='0' and msg_to_status='1' order by msg_date desc limit 3";
                                            $res_msg_not=mysql_query($sql_msg_not);
                                            while($row_msg_not=mysql_fetch_object($res_msg_not)){
                                        ?>
                                                <li class="dropdown-header">
                                                    <a href="mymessage.php">
                                                    <?php if(($row_msg_not->usr_image!="")&&($row_msg_not->usr_image!="NULL")){?>
                                                        <img style="height:35px;" src="images/users/<?php echo $row_msg_not->usr_image; ?>" class="msg-photo" alt="<?php echo $row_msg_not->usr_name; ?>" />
                                                    <?php }else{ ?>
                                                        <img style="height:35px;" src="images/users/unknown.png" class="msg-photo" alt="<?php echo $row_msg_not->usr_name; ?>" />
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
                                                <li class="dropdown-header">
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
                                                <li class="dropdown-header">
                                                    <a href="mymessage.php">
                                                        <?php echo $lang[708]; ?>
                                                        <i class="icon-arrow-right"></i>
                                                    </a>
                                                </li>
                                        
                                            <?php } ?>
						

                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
            <!-- Modal 2 -->
                             <div class="modal fade" id="notification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                      	<?php
						//	$sql_un="select * from user_notification where un_usr_id='".$_SESSION['uid']."' and un_status='1'";
							$sql_un="select * from user_notification,user,project where un_from_usr_id=usr_id and un_prj_id=prj_id and un_usr_id='".$_SESSION['uid']."' and un_status='1'";
							$res_un=mysql_query($sql_un);
							$num_un=mysql_num_rows($res_un);
							
							if($row_bl->usr_emailVerified =='0'){	$num_un=$num_un+1;	}

							/*if($num_un>0){*/
						?>
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $num_un; ?><?php echo $lang[709]; ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                      
                             
							

							
                    <?php
					/*$sqlc="select * from user where usr_id='".$_SESSION['uid']."' and usr_status='1'";
					$resc=mysql_query($sqlc);
					$rowc=mysql_fetch_object($resc);*/
					if($row_bl->usr_emailVerified =='0'){	?>
					<li class="dropdown-header">
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
                	
					<li class="dropdown-header">
							<a onClick="goLink(<?php echo $row_not->un_id; ?>)" style="cursor:pointer;">
								<?php if($row_not->usr_image != ''){ ?>
						               <img style="height:35px;" src="images/users/<?php echo $row_not->usr_image; ?>" class="msg-photo" alt="<?php echo $row_not->usr_name; ?>" />
						        <?php } else { ?>
						               <img style="height:35px;" src="images/users/unknown.png" class="msg-photo" alt="<?php echo $row_not->usr_name; ?>" />
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
								<li class="dropdown-header">
									<a href="notification.php">
										<?php echo $lang[710]; ?>
										<i class="icon-arrow-right"></i>
									</a>
								</li>
							</ul>
                                      
                                       </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>