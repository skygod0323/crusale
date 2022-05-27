<?php
ob_start();
session_start();
include "common.php";
if(isset($_SESSION['uid'])!="")
{
    header("Location: manage.php");
}


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
<?php include "includes/header.php"; ?>
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
		$.post(
		"loginSubmit.php", 
		{usr_name:usr_name.value,usr_password:usr_password.value, remember:remember},
		function(data){
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
				window.location='login.php';
				//location.reload();
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
// 			alert('check dt0='+dt[0]+' | dt1='+dt[1]);
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

            <div class="db section">
                <div class="container">
                    <div class="page-title text-center">
                        <div class="heading-holder">
                            <h1>Login & Register</h1>
                        </div>
                        <p class="lead"><?php echo $lang[732]; ?></p>
                    </div>
                </div><!-- end container -->
            </div><!-- end section -->
			<script type="text/javascript">
            function forgot_box() {
            $.post(
                'fetch_form.php',
                {},
                function (r){
                    //alert (r);
                    $('#ajaxbox').html(r);
                }
                );
            
            }
            function login_box() {
            location.reload();
            //window.location='login.php';
            }
            
            </script>
            <div class="section wb">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12" id="ajaxbox">
                        	<div id="login-box">
                            <form class="submit-form customform loginform" action="javascript:void(0);" method="post">
                                <h4>Login Account</h4>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control"name="usr_name" id="usr_name" placeholder="<?php echo $lang[733]; ?>" value="<?php echo $fr_usr; ?>" >
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="text" class="form-control" name="usr_password" id="usr_password" placeholder="<?php echo $lang[734]; ?>" value="<?php echo $fr_psw; ?>">
                                </div>
                                
                                <button class="btn btn-custom" onClick="validLogin();"><?php echo $lang[51]; ?></button>

                                <div class="checkbox checkbox-primary">
                                    <input id="remember" name="remember" value="yes" type="checkbox" class="styled">
                                    <label><small><?php echo $lang[735]; ?></small></label>
                                </div>
                                <p style="text-align:center;"><?php echo $lang[736]; ?></p>
                                <ul class="list-inline social-small" style="text-align:center;">
                                        <li><a href="?login&oauth_provider=facebook"><i class="fa fa-facebook" style="color:#fff;"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="https://accounts.google.com/o/oauth2/auth?response_type=code&amp;redirect_uri=http%3A%2F%2Ffb.demonstrationserver.com%2Ffreelancer%2Flogin.php&amp;client_id=326666661405-u3ds9eolpplt9kocqkjnomemp4h338v1.apps.googleusercontent.com&amp;scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email&amp;access_type=offline&amp;approval_prompt=force"><i class="fa fa-google-plus"></i></a></li>
                                        
                                    </ul>
                                    
                                 <div>
									<a href="javascript:void(0);" onClick="forgot_box($.post());" class="forgot-password-link">
									<i class="icon-arrow-left"></i>
									<?php echo $lang[737]; ?>
									</a>
								</div>
                            </form>
							</div>
                        </div><!-- end col -->
                     
                        
                

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <form class="submit-form customform loginform">
                                <h4><?php echo $lang[744]; ?></h4>
                                <p> <?php echo $lang[745]; ?> </p>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" name="usr_name_reg" id="usr_name_reg" class="form-control" placeholder="<?php echo $lang[733]; ?>">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                    <input type="email" name="usr_email" id="usr_email" class="form-control" placeholder="<?php echo $lang[741]; ?>" >
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="usr_password_reg" id="usr_password_reg" class="form-control" placeholder="<?php echo $lang[734]; ?>" >
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="cnf_password_reg" id="cnf_password_reg" class="form-control" placeholder="<?php echo $lang[746]; ?>">
                                </div>
                                		<div class="control-group">
												<p> <?php echo $lang[631]; ?> </p>

												
													
														<input id="usr_type_F" name="usr_type" value="<?php echo $lang[64]; ?>" type="radio" class="ace" />
														<span class="lbl"> <?php echo $lang[64]; ?></span>
											
												
														<input id="usr_type_E" name="usr_type" value="<?php echo $lang[60]; ?>" type="radio" class="ace" />
														<span class="lbl"> <?php echo $lang[60]; ?></span>
													
												
														<input id="usr_type_B" name="usr_type" value="<?php echo $lang[620]; ?>" type="radio" class="ace" checked="checked" />
														<span class="lbl"> <?php echo $lang[620]; ?></span>
													
												

											</div>
                                            <br/>
														<input type="checkbox" class="ace" id="userAgreement" />
														<span class="lbl">
															<?php echo $lang[747]; ?>
															<a href="terms.php"><?php echo $lang[748]; ?></a>
                                                          </span><br/><br/>
											
                                
                                				<div class="clearfix">
														<button type="reset" class="btn btn-custom">
															<i class="icon-refresh"></i>
															<?php echo $lang[749]; ?>
														</button>

														<button type="button" class="btn btn-custom" onClick="validSignup();">
															<?php echo $lang[750]; ?>
															<i class="icon-arrow-right icon-on-right"></i>
														</button>
													</div>
                            </form>
                        </div><!-- end col -->

                    </div><!-- end row -->
                </div><!-- end container -->
            </div><!-- end section -->
<?php include "includes/footer.php"; ?>