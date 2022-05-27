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

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/gaf_style.min.css">
        <link type="text/css" rel="stylesheet" href="css/promotion.css"/>
        <!--<link rel="stylesheet" href="css/gaf.ns.css">-->
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-1.2.1.min.js"></script>
<!--        <script type="text/javascript" src="js/functions.js"></script>-->
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
		<div>
<div id="div-fixed-wrap">
	<div class="top-bg">
		<div id="wrapper-container">
			<header class="clearfix">
				<div id="logo"><a href="index.php"><img src="sitelogo/<?php echo getSiteLogo(); ?>" alt="<?php echo getWebSiteName(); ?>" /></a></div>
				<div id="top-login-area">
					<div class="top-icon">
                    	
						<ul>
                        <?php if(isset($_SESSION['uid'])){ 
						
					$sql_bl="select * from user where usr_id=".$_SESSION['uid']; //query for account balance
					$res_bl=mysql_query($sql_bl);
					$row_bl=mysql_fetch_object($res_bl);

				?>
                        
                        <?php
					$sqlc="select * from user where usr_id='".$_SESSION['uid']."' and usr_status='1'";
					$resc=mysql_query($sqlc);
					$rowc=mysql_fetch_object($resc);
					if($rowc->usr_emailVerified =='0'){	?>
                        	<li style="color:#F00;text-decoration:blink"><a href="emailVerification.php" style="color:#F00"><?php echo $lang[107]; ?></a></li>
                            <?php }else{ ?>
                        	<li><a href="membership.php"><?php echo $lang[108]; ?></a></li>
                        <?php } ?>
                              
                              <li style="color: #DDFFFF"><a href="withdraw-funds.php"><?php echo getCurrencySymbol().$row_bl->usr_balance." ".getCurrencyCode();?></a></li>
					<?php
						$sql_msgn="select * from message where msg_to='".$_SESSION['uid']."' and msg_read='0'";
                                    $res_msgn=mysql_query($sql_msgn);
						$num_msgn=mysql_num_rows($res_msgn);
						/*if($num_msgn>0){*/
					?>
						<li><a href="mymessage.php"><img src="images/env-icon.png" alt="" /></a></li>
						<?php /*}*/ ?>
                        <?php
						$sql_un="select * from user_notification where un_usr_id='".$_SESSION['uid']."' and un_status='1'";
						$res_un=mysql_query($sql_un);
						$num_un=mysql_num_rows($res_un);
						/*if($num_un>0){*/
					?>
						<li><a href="notification.php"><img src="images/exc-icon.png" alt="" /></a></li>
						<?php /*}*/ ?>
						<li><a href="faq-view.php"><img src="images/question-mark-icon.png" alt="" /></a></li>
                        <?php } ?>
					</ul>
				</div>
                    <?php if($_SESSION['uid']==''){ ?>	
					<div class="login"><a href="login.php"><?php echo $lang[109]; ?></a></div>
					<div class="student-signup-btn-str"><a href="signup.php"><?php echo $lang[110]; ?></a></div>
                    <?php }else{ ?>
                              <div style="padding-left:18px;position:absolute;right:110px;top:11px;"><a href="manage.php"><?php echo $_SESSION['usr']; ?></a></div>
                              <div style="padding-left:18px;position:absolute;right:0px;top:11px;"><a style="font-size:18px;font-weight:700;" href="logout.php"><?php echo $lang[111]; ?></a></div>
                    <?php } ?>
				</div>
			</header>
		</div>
	</div>
	<div id="top-nav-area">
		<div id="wrapper-container" class="clearfix">
			<nav class="nav-pad">
				<ul class="top-menu">
                    <?php   if($_SESSION['uid']!='' && $_SESSION['type']=="Freelancer"){    ?>
                            <li><a href="about.php"><?php echo $lang[82]; ?></a></li>
                            <li><a href="latest-proj.php"><?php echo $lang[116]; ?></a></li>
                    <?php   }else{  ?>
                            <li><a href="post-project.php"><?php echo $lang[112]; ?></a></li>
                            <li><a href="find-freelancer.php"><?php echo $lang[113]; ?></a></li>
                    <?php   }   ?>
					
				</ul>
				<ul id="nav">
					<li><a style="cursor:pointer;"><?php echo $lang[114]; ?></a>
					<ul>
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
			</nav>
		</div>
	</div>
</div>

<?php
$filename=substr($_SERVER['SCRIPT_NAME'],strpos($_SERVER['SCRIPT_NAME'],'/',1)+1,strlen($_SERVER['SCRIPT_NAME']));
$file=substr($filename,0,strpos($filename,'.'));
?>

<?php if($file != "index"){?>
<div>
				<div id="page-container-inner">
<?php    if(isset($_SESSION['uid']))	{	?>
                <div class="dashboard-nav">
	<ul id="nav1" class="clearfix">
		<li><a href="manage.php"><?php echo $lang[120]; ?></a>
			<ul> 
				<li><a href="manage.php"><?php echo $lang[121]; ?></a></li> 
				<li><a href="mymessage.php"><?php echo $lang[122]; ?></a></li> 
			</ul> 
        </li>
		<li><a style="cursor:pointer"><?php echo $lang[123]; ?></a>
			<ul> 
				<li><a href="changeuserinfo.php"><?php echo $lang[124]; ?></a></li> 
				<li><a href="change-email.php"><?php echo $lang[125]; ?></a></li> 
				<li><a href="profile.php"><?php echo $lang[126]; ?></a></li> 
				<li><a href="change-password.php"><?php echo $lang[127]; ?></a></li>                         
				<li><a href="membership.php"><?php echo $lang[128]; ?></a></li> 
			</ul>
        </li>
		<li><a style="cursor:pointer"><?php echo $lang[129]; ?></a>
			<ul>
                      <?php   if($_SESSION['type']!="Employer"){    ?>
				<li><a href="employer-following.php"><?php echo $lang[130]; ?></a></li> 
                      <?php } ?>
                        <?php   if($_SESSION['type']!="Freelancer"){    ?>
				<li><a href="find-freelancer.php"><?php echo $lang[131]; ?></a></li> 
                        <?php } ?>
			</ul>
        </li>
		<li><a style="cursor:pointer"><?php echo $lang[132]; ?></a>
			<ul>
				<li><a href="financial-dash.php"><?php echo $lang[133]; ?></a></li> 
				<li><a href="payment-deposit.php"><?php echo $lang[134]; ?></a></li>
                        <?php   if($_SESSION['type']!="Freelancer"){    ?>
				<li><a href="transfer-funds.php"><?php echo $lang[135]; ?></a></li>
                        <?php   }   ?>
				<li><a href="withdraw-funds.php"><?php echo $lang[136]; ?></a></li> 
                        <?php   if($_SESSION['type']!="Freelancer"){    ?>
				<li><a href="release-funds.php"><?php echo $lang[137]; ?></a></li>
                        <?php   }   ?>
				<li class="ns_last"><a href="transactions.php"><?php echo $lang[138]; ?></a></li> 
            </ul>
		</li>
	</ul>
</div>
<?php } ?>

<?php } ?>