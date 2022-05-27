<?php
ob_start();
session_start();
include "common.php";



if(isset($_COOKIE['fr_usr']) && isset($_COOKIE['fr_psw']))
{
	$fr_usr=$_COOKIE['fr_usr'];
	$fr_psw=$_COOKIE['fr_psw'];
}
else
{
	$fr_usr='';
	$fr_psw='';
}

if(array_key_exists("login", $_GET)) 
{
	$oauth_provider = $_GET['oauth_provider'];
	if ($oauth_provider == 'twitter')
	{
//		header("Location:login-twitter.php");
		header("Location:sociallogin/twitteroauth/twitter_log.php");
		
	}
	else if ($oauth_provider == 'facebook')
	{
//		header("Location:login-facebook.php");
		header("Location:sociallogin/loginwithfb/login-facebook.php");
	}
	/*else if ($oauth_provider == 'google')
	{
		header("Location:google-login/login-google.php");
	}*/
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php echo getWebSiteTitle(); ?></title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link href="new_design/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="new_design/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="new_design/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<!-- fonts -->

		<link rel="stylesheet" href="new_design/css/ace-fonts.css" />

		<!-- ace styles -->

		<link rel="stylesheet" href="new_design/css/ace.min.css" />
		<link rel="stylesheet" href="new_design/css/ace-rtl.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="new_design/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="new_design/js/html5shiv.js"></script>
		<script src="new_design/js/respond.min.js"></script>
		<![endif]-->
        
<script type="text/javascript">
function validLogin()
{
    var usr_name = document.getElementById('usr_name');
	var usr_password = document.getElementById('usr_password');	
	
	var remember = 'no';
	if ($('#remember').is(':checked')) {
		remember = 'yes';
	}
	
	var msg="";
	var valid=true;	
	
	if (usr_name.value == "" || usr_name.value == null)
    {
		msg='<?php echo $lang[29]; ?>';
		usr_name.value="";
        usr_name.focus();
        //valid = false;
		alert(msg);
    }  
	else if(!isNaN(usr_name.value))
	{
		msg='<?php echo $lang[30]; ?>';
		usr_name.value="";
        usr_name.focus();
        //valid = false;
		alert(msg);
	}
	else if (usr_password.value == "" || usr_password.value == null)
    {
		msg='<?php echo $lang[31]; ?>';
		usr_password.value="";
        usr_password.focus();
        //valid = false;
		alert(msg);
    }
	else if (usr_password.value.length < 6)
    {
		msg='<?php echo $lang[32]; ?>';
		usr_password.value="";
        usr_password.focus();
        //valid = false;
		alert(msg);
    }
	else
	{		
		$.get("loginSubmit.php", {usr_name:usr_name.value,usr_password:usr_password.value, remember:remember},	function(data){
																														// alert(data);
			data=data.trim();
			dt=data.split("|");
			
			if(dt[0]=='0')
			{
				usr_name.value="";
				usr_password.value="";
				alert(dt[1]);
				//$("#loginError").css({"display":"block"});
			}
			else
			{
				//alert(dt[1]);
				window.location=dt[1];
			}																  
		});
	}	
	
	//if(!valid)
//	{
//		document.getElementById("msg").style.color = "red";
//		document.getElementById('msg').innerHTML = msg;			 				
//	}
//    return valid;
}
</script>
<script type="text/javascript">
function validSignup()
{
	var usr_email = document.getElementById('usr_email');
    var usr_name = document.getElementById('usr_name_reg');
	var usr_password = document.getElementById('usr_password_reg');
	var cnf_password = document.getElementById('cnf_password_reg');

	var usr_type;
	if(document.getElementById('usr_type_F').checked)
	{
		usr_type=document.getElementById('usr_type_F').value;
	}
	else if(document.getElementById('usr_type_E').checked)
	{
		usr_type=document.getElementById('usr_type_E').value;
	}
	else if(document.getElementById('usr_type_B').checked)
	{
		usr_type=document.getElementById('usr_type_B').value;
	}
	var lat = usr_email.value;

	var at = "@";
	var dot = ".";
	var lat = usr_email.value.indexOf(at);
	var lstr = usr_email.value.length;
	var ldot = usr_email.value.indexOf(dot);
	
	var msgReg="";
	var valid=true;	
	
	if (usr_email.value == "" || usr_email.value == null)
    {
		msgReg="<?php echo $lang[27]; ?>";
		usr_email.value="";
        usr_email.focus();
 	//  valid = false;
		alert(msgReg);
    }  	
	// check if '@' is at the first position or at last position or absent in given email 
	else if (usr_email.value.indexOf(at) == -1 || usr_email.value.indexOf(at) == 0 || usr_email.value.indexOf(at) == lstr)
	{	
		msgReg="<?php echo $lang[28]; ?>";
		usr_email.value="";
        usr_email.focus();
     // valid = false;	
		alert(msgReg);
	}
	// check if '.' is at the first position or at last position or absent in given email
	else if (usr_email.value.indexOf(dot) == -1 || usr_email.value.indexOf(dot) == 0 || usr_email.value.indexOf(dot) == lstr)
	{
	    msgReg="<?php echo $lang[28]; ?>";
		usr_email.value="";
        usr_email.focus();
     // valid = false;
		alert(msgReg);
	}
    // check if '@' is used more than one times in given email
	else if (usr_email.value.indexOf(at,(lat+1)) != -1)
	{
	    msgReg="<?php echo $lang[28]; ?>";
		usr_email.value="";
        usr_email.focus();
     // valid = false;
		alert(msgReg);
	}  
    // check for the position of '.'
	else if (usr_email.value.substring(lat-1,lat) == dot || usr_email.value.substring(lat+1,lat+2) == dot)
	{
	    msgReg="<?php echo $lang[28]; ?>";
		usr_email.value="";
        usr_email.focus();
    //	valid = false;
		alert(msgReg);
	}
    // check if '.' is present after two characters from location of '@'
	else if (usr_email.value.indexOf(dot,(lat+2)) == -1)
	{
	    msgReg="<?php echo $lang[28]; ?>";
		usr_email.value="";
        usr_email.focus();
    //	valid = false;
		alert(msgReg);
	}	
	// check for blank spaces in given email
	else if (usr_email.value.indexOf(" ") != -1)
	{	
		msgReg="<?php echo $lang[28]; ?>";
		usr_email.value="";
      	usr_email.focus();
    // 	valid = false;
		alert(msgReg);
	}
	else if (usr_name.value == "" || usr_name.value == null)
    {
		alert(usr_name.value);
		msgReg='<?php echo $lang[29]; ?>';
		usr_name.value="";
        usr_name.focus();
     // valid = false;
		alert(msgReg);
    }  
	else if(!isNaN(usr_name.value))
	{
		msgReg='<?php echo $lang[30]; ?>';
		usr_name.value="";
        usr_name.focus();
    //  valid = false;
		alert(msgReg);
	}
	else if (usr_password.value == "" || usr_password.value == null)
    {
		msgReg='<?php echo $lang[31]; ?>';
		usr_password.value="";
        usr_password.focus();
    //  valid = false;
		alert(msgReg);
    }
	else if (usr_password.value.length < 6)
    {
		msgReg='<?php echo $lang[32]; ?>';
		usr_password.value="";
        usr_password.focus();
    //  valid = false;
		alert(msgReg);
    }
	else if (cnf_password.value == "" || cnf_password.value == null)
    {
		msgReg='<?php echo $lang[33]; ?>';
		cnf_password.value="";
        cnf_password.focus();
    //  valid = false;
		alert(msgReg);
    }
	else if (usr_password.value != cnf_password.value)
    {
		msgReg='<?php echo $lang[34]; ?>';
		cnf_password.value="";
        cnf_password.focus();
    //  valid = false;
		alert(msgReg);
    }
	else if(!document.getElementById('userAgreement').checked)
	{
		msgReg='<?php echo $lang[816]; ?>';
		alert(msgReg);
	}
	else
	{		
		
		$.get("createAccount.php", {usr_email:usr_email.value,usr_name:usr_name.value,usr_password:usr_password.value,cnf_password:cnf_password.value,usr_type:usr_type},
			  function(data){	
			data=data.trim();
			dt=data.split("|");
			
			if(dt[0]=='0')
			{
				//	alert(dt[0]);
				alert(dt[1]);
			}
			else
			{
//				alert(dt[1]);
//				window.location="login.php";
				alert('<?php echo $lang[824]; ?>');
				window.location=dt[1];
			}																  
		});
	}	
	
	//if(!valid)
//	{
//		document.getElementById("msg").style.color = "red";
//		document.getElementById('msg').innerHTML = msgReg;			 				
//	}
    //return valid;
}

function sendPassword()
{
	var usr_email = document.getElementById('usr_email_FP');
	
	var lat = usr_email.value;

	var at = "@";
	var dot = ".";
	var lat = usr_email.value.indexOf(at);
	var lstr = usr_email.value.length;
	var ldot = usr_email.value.indexOf(dot);
	
	var msgFP="";
	var valid=true;	
	
	if (usr_email.value == "" || usr_email.value == null)
    {
		msgFP="<?php echo $lang[27]; ?>";
		usr_email.value="";
        usr_email.focus();
 	//  valid = false;
		alert(msgFP);
    }  	
	// check if '@' is at the first position or at last position or absent in given email 
	else if (usr_email.value.indexOf(at) == -1 || usr_email.value.indexOf(at) == 0 || usr_email.value.indexOf(at) == lstr)
	{	
		msgFP="<?php echo $lang[28]; ?>";
		usr_email.value="";
        usr_email.focus();
     // valid = false;	
		alert(msgFP);
	}
	// check if '.' is at the first position or at last position or absent in given email
	else if (usr_email.value.indexOf(dot) == -1 || usr_email.value.indexOf(dot) == 0 || usr_email.value.indexOf(dot) == lstr)
	{
	    msgFP="<?php echo $lang[28]; ?>";
		usr_email.value="";
        usr_email.focus();
     // valid = false;
		alert(msgFP);
	}
    // check if '@' is used more than one times in given email
	else if (usr_email.value.indexOf(at,(lat+1)) != -1)
	{
	    msgFP="<?php echo $lang[28]; ?>";
		usr_email.value="";
        usr_email.focus();
     // valid = false;
		alert(msgFP);
	}  
    // check for the position of '.'
	else if (usr_email.value.substring(lat-1,lat) == dot || usr_email.value.substring(lat+1,lat+2) == dot)
	{
	    msgFP="<?php echo $lang[28]; ?>";
		usr_email.value="";
        usr_email.focus();
    //	valid = false;
		alert(msgFP);
	}
    // check if '.' is present after two characters from location of '@'
	else if (usr_email.value.indexOf(dot,(lat+2)) == -1)
	{
	    msgFP="<?php echo $lang[28]; ?>";
		usr_email.value="";
        usr_email.focus();
    //	valid = false;
		alert(msgFP);
	}	
	// check for blank spaces in given email
	else if (usr_email.value.indexOf(" ") != -1)
	{	
		msgFP="<?php echo $lang[28]; ?>";
		usr_email.value="";
      	usr_email.focus();
    // 	valid = false;
		alert(msgFP);
	}
	else
	{
		$.get("sendPassword.php", {usr_email:usr_email.value},	function(data){
			data=data.trim();
			dt=data.split("|")
			if(dt[0]=='0')
			{
				alert(dt[1]);
			}
			else
			{
				alert(dt[1]);
			}																  
		});
	}
}
</script>	
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<img src="sitelogo/<?php echo getSiteLogo(); ?>" alt="<?php echo getWebSiteName(); ?>" />
									<!--<span class="red">Ace</span>
									<span class="white">Application</span>-->
								</h1>
								<h4 class="blue"><?php echo getWebSiteName(); ?></h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="icon-coffee green"></i>
												<?php echo $lang[732]; ?>
											</h4>

											<div class="space-6"></div>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" name="usr_name" id="usr_name" placeholder="<?php echo $lang[733]; ?>" value="<?php echo $fr_usr; ?>" />
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" name="usr_password" id="usr_password" placeholder="<?php echo $lang[734]; ?>" value="<?php echo $fr_psw; ?>" />
															<i class="icon-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<label class="inline">
															<input type="checkbox" class="ace" id="remember" name="remember" value="yes" />
															<span class="lbl"> <?php echo $lang[735]; ?></span>
														</label>

														<button type="button" class="width-35 pull-right btn btn-sm btn-primary" onClick="validLogin();">
															<i class="icon-key"></i>
															<?php echo $lang[51]; ?>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>

											<div class="social-or-login center">
												<span class="bigger-110"><?php echo $lang[736]; ?></span>
											</div>

											<div class="social-login center">
												<a href="?login&oauth_provider=facebook" class="btn btn-primary">
													<i class="icon-facebook"></i>
												</a>

												<a class="btn btn-info"><!--href="?login&oauth_provider=twitter"-->
													<i class="icon-twitter"></i>
												</a>

												<!--<a href="?login&oauth_provider=google" class="btn btn-danger">
													<i class="icon-google-plus"></i>
												</a>-->
                                                <?php include "sociallogin/google_log.php"; ?>
											</div>
										</div><!-- /widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a href="#" onClick="show_box('forgot-box'); return false;" class="forgot-password-link">
													<i class="icon-arrow-left"></i>
													<?php echo $lang[737]; ?>
												</a>
											</div>

											<div>
												<a href="#" onClick="show_box('signup-box'); return false;" class="user-signup-link">
													<?php echo $lang[738]; ?>
													<i class="icon-arrow-right"></i>
												</a>
											</div>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="icon-key"></i>
												<?php echo $lang[739]; ?>
											</h4>

											<div class="space-6"></div>
											<p>
												<?php echo $lang[740]; ?>
											</p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="<?php echo $lang[741]; ?>" id="usr_email_FP" name="usr_email_FP"/>
															<i class="icon-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
														<button type="button" class="width-35 pull-right btn btn-sm btn-danger" onClick="sendPassword();">
															<i class="icon-lightbulb"></i>
															<?php echo $lang[742]; ?>
														</button>
													</div>
												</fieldset>
											</form>
										</div><!-- /widget-main -->

										<div class="toolbar center">
											<a href="#" onClick="show_box('login-box'); return false;" class="back-to-login-link">
												<?php echo $lang[743]; ?>
												<i class="icon-arrow-right"></i>
											</a>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /forgot-box -->

								<div id="signup-box" class="signup-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="icon-group blue"></i>
												<?php echo $lang[744]; ?>
											</h4>

											<div class="space-6"></div>
											<p> <?php echo $lang[745]; ?> </p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" name="usr_email" id="usr_email" class="form-control" placeholder="<?php echo $lang[741]; ?>" />
															<i class="icon-envelope"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="usr_name_reg" id="usr_name_reg" class="form-control" placeholder="<?php echo $lang[733]; ?>" />
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="usr_password_reg" id="usr_password_reg" class="form-control" placeholder="<?php echo $lang[734]; ?>" />
															<i class="icon-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="cnf_password_reg" id="cnf_password_reg" class="form-control" placeholder="<?php echo $lang[746]; ?>" />
															<i class="icon-retweet"></i>
														</span>
													</label>
                                                    
                                                    
											<div class="control-group">
												<p> <?php echo $lang[631]; ?> </p>

												<div class="radio">
													<label>
														<input id="usr_type_F" name="usr_type" value="<?php echo $lang[64]; ?>" type="radio" class="ace" />
														<span class="lbl"> <?php echo $lang[64]; ?></span>
													</label>
												</div>

												<div class="radio">
													<label>
														<input id="usr_type_E" name="usr_type" value="<?php echo $lang[60]; ?>" type="radio" class="ace" />
														<span class="lbl"> <?php echo $lang[60]; ?></span>
													</label>
												</div>

												<div class="radio">
													<label>
														<input id="usr_type_B" name="usr_type" value="<?php echo $lang[620]; ?>" type="radio" class="ace" checked="checked" />
														<span class="lbl"> <?php echo $lang[620]; ?></span>
													</label>
												</div>

											</div>
										

													<label class="block">
														<input type="checkbox" class="ace" id="userAgreement" />
														<span class="lbl">
															<?php echo $lang[747]; ?>
															<a href="terms.php"><?php echo $lang[748]; ?></a>
														</span>
													</label>

													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="icon-refresh"></i>
															<?php echo $lang[749]; ?>
														</button>

														<button type="button" class="width-65 pull-right btn btn-sm btn-success" onClick="validSignup();">
															<?php echo $lang[750]; ?>
															<i class="icon-arrow-right icon-on-right"></i>
														</button>
													</div>
												</fieldset>
											</form>
										</div>

										<div class="toolbar center">
											<a href="#" onClick="show_box('login-box'); return false;" class="back-to-login-link">
												<i class="icon-arrow-left"></i>
												<?php echo $lang[751]; ?>
											</a>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /signup-box -->
							</div><!-- /position-relative -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>
		</div><!-- /.main-container -->

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

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			function show_box(id) {
			 jQuery('.widget-box.visible').removeClass('visible');
			 jQuery('#'+id).addClass('visible');
			}
		</script>
	</body>
</html>
<?php
if(isset($_SESSION['uid']) && $_SESSION['uid']!='')
{
	header("Location:manage.php");
}
?>