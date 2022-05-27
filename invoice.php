<?php
ob_start();
session_start();
include "common.php";

$_SESSION['last_page']="invoice.php";
if($_SESSION['uid']=='')
{
	header("location:login.php");	
}

if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}

class addInvoice
{
	var $inv_usr_id;
	var $inv_prj_id;
	var $inv_amount;
	
	function __construct($inv_usr_id,$inv_prj_id,$inv_amount)
	{
		$this->inv_usr_id=$inv_usr_id;
		$this->inv_prj_id=$inv_prj_id;
		$this->inv_amount=$inv_amount;
	}
	
	function add()
	{
		include "language.php";
		
		$sql="insert into invoice
			set
				inv_usr_id='".$this->inv_usr_id."',
				inv_prj_id='".$this->inv_prj_id."',
				inv_amount='".$this->inv_amount."',
				inv_creation_date=now()";
		mysql_query($sql);
		
		$inv_id=mysql_insert_id();
		
		/******* Code for notification start here *********/
		
		$sql_prj="select * from project where prj_id='".$this->inv_prj_id."'";
		$res_prj=mysql_query($sql_prj);
		$row_prj=mysql_fetch_object($res_prj);
		
		$sql_usr="select * from user where usr_id='".$this->inv_usr_id."'";
		$res_usr=mysql_query($sql_usr);
		$row_usr=mysql_fetch_object($res_usr);
		
			$sql_un="insert into user_notification
			set
				un_usr_id='".$row_prj->prj_usr_id."',
				un_from_usr_id='".$this->inv_usr_id."',
				un_type='invoice',
				un_content='".$row_usr->usr_name."".$lang[781]."(".$lang[777]." ".$inv_id.")',
				un_prj_id='".$this->inv_prj_id."',
				un_updated_date=now()";
				
			mysql_query($sql_un);
		
		/******* Code for notification end here *********/
		
		
		/****** code for email sending start here ******/
		$sqlemail="select * from admin_user where id='1'";
		$resemail=mysql_query($sqlemail);
		$rowemail=mysql_fetch_object($resemail);
            
        $sql_to_usr="select * from user where prj_id='".$row_prj->prj_usr_id."'";
		$res_to_usr=mysql_query($sql_to_usr);
		$row_to_usr=mysql_fetch_object($res_to_usr);
		
		include "email/invoice.php"; //email design with content included
		
        /*$comment='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
		<div style="width:650px;height:100px; padding-bottom:0;">
			'.$lang[778].''.$row_to_usr->usr_name.',<br/><br/>'.$row_usr->usr_name.''.$lang[776].'<br/>'.$lang[762].': '.$inv_id.'<br/>'.$lang[59].': '.date("d-M-Y").'<br/>'.$lang[18].': '.$row_prj->prj_name.'<br/>'.$lang[62].': '.$this->inv_amount.'&nbsp;<a href=\'http://'.$_SERVER['HTTP_HOST'].'/invoice.php\' target=\'_blank\'>'.$lang[782].'</a><br/><br/>'.getWebSiteName().'
		</div></div>'*/;


		$from_mail=$rowemail->email;
        $to=$row_to_usr->usr_email; 	

        $subj=getWebSiteName().$lang[783];
        $headers  = "MIME-Version: 1.0\n";
	    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        $headers .= 'From: '.$from_mail.'';	
		
		mail($to,$subj,$comment,$headers);
		/****** code for email sending start here ******/
	}
}

if(isset($_POST['choose_proj']))
{
	include "language.php";
	
	$adn=new addInvoice(addslashes(trim($_POST['inv_usr_id'])), addslashes(trim($_POST['inv_prj_id'])), addslashes(trim($_POST['inv_amount'])));

	$adn->add();		

	$_SESSION['msg']='<font color="#009900">'.$lang[784].'</font>';
	
	header("location:invoice.php");
}

?>
	<?php include "includes/header.php"; ?>
    
	<<div class="section db" style="background-image:url('upload/parallax_02.jpg');">
                <div class="container">
                    <div class="page-title text-center">
                        <div class="heading-holder">
                            <h1><?php echo $lang[132]; ?></h1>
                        </div>
                        
                    </div>
                </div><!-- end container -->
            </div><!-- end section -->

            <div class="section lb">
                <div class="container">
                    <div class="row">
                        <div class="sidebar col-md-3">
                            <div class="post-padding clearfix">
                                <ul class="nav nav-pills nav-stacked">
									<li ><a href="financial-dash.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[133]; ?></a></li>
                                    <li ><a href="payment-deposit.php"><span class="glyphicon glyphicon-user"></span>  <?php echo $lang[134]; ?></a></li>
									<li ><a href="transfer-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[135]; ?></a></li>
									<li ><a href="withdraw-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[136]; ?></a></li>
									<li ><a href="release-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[137]; ?></a></li>
									<li class="active"><a href="invoice.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[796]; ?></a></li>
									<li ><a href="transactions.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[138]; ?></a></li>
                                    </ul>
                            </div><!-- end widget -->
                        </div><!-- end col -->

                        <div class="content col-md-9">
                            <div class="post-padding">
                                <div class="job-title nocover hidden-sm hidden-xs"><h5><?php echo $lang[796]; ?></h5></div>
                                
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">   
										
											<div class="signup-form-str" id="msg"><?php echo $msg; ?></div>
											<?php
											
								/*			$sql_tf="select * from project,bid,user where bd_prj_id=prj_id and prj_usr_id=usr_id and bd_usr_id='".$_SESSION['uid']."' and (bd_status=1 or prj_id in(select rr_prj_id from review_rating where rr_from_usr=prj_usr_id and (rr_completionrate='1' or rr_completionrate='0')) and bd_status=1) and bd_amount>(select sum(tr_amount) from transaction where tr_prj_id=project.prj_id and tr_status='1' and tr_to_id=bid.bd_usr_id and tr_from_id=project.prj_usr_id)";*/
											
								//			$sql_tf="select * from project,bid,user where bd_prj_id=prj_id and prj_usr_id=usr_id and bd_usr_id='".$_SESSION['uid']."' and (bd_status=1 or prj_id in(select rr_prj_id from review_rating where rr_from_usr=prj_usr_id and (rr_completionrate='1' or rr_completionrate='0')) and bd_status=1)";
											
											$sql_tf="select * from project p,bid b,user where b.bd_prj_id=p.prj_id and p.prj_usr_id=usr_id and b.bd_usr_id='".$_SESSION['uid']."' and b.bd_status=1 and (p.prj_status='running' or p.prj_status='close') and b.bd_amount>((select COALESCE(sum(tr_amount),0) from transaction where tr_prj_id=p.prj_id and tr_status='1' and tr_to_id=b.bd_usr_id and tr_from_id=p.prj_usr_id)+(select COALESCE(sum(inv_amount),0) from invoice where inv_usr_id=b.bd_usr_id and inv_prj_id=p.prj_id and inv_payment_status='0' and inv_status='1'))";
											$res_tf=mysql_query($sql_tf);
											if(mysql_num_rows($res_tf)>0){	?>

											<form action="" onSubmit="return validForm()" method="post" class="form-horizontal">
                	
												<input type="hidden" id="inv_usr_id" name="inv_usr_id" value="<?php echo $_SESSION['uid']; ?>"/>
												<div class="signup-form-str">
													<label class="form-label"><?php echo $lang[243]; ?></label>
													
													<select id="inv_prj_id" name="inv_prj_id" style="min-width:280px;" onChange="projSelected(this.value);" >
														<option value="0"><?php echo $lang[243]; ?></option>
													<?php	
														$i=0;
														while($row_tf=mysql_fetch_object($res_tf)){	?>
														<option value="<?php echo $row_tf->prj_id; ?>"><?php echo $row_tf->prj_name; ?></option>
													<?php	$i++;	}	?>
													</select>
												</div>
												<div id="sec_area" style="display:none;">
													<div class="signup-form-str">
														<label class="form-label"><?php echo $lang[790]; ?></label>
														<input type="hidden" id="remain_amt"/>
														<input type="text" id="inv_amount" name="inv_amount" style="min-width:280px;"/>
													</div>
																
													<div class="form-group">
														<input type="hidden" name="confirm" value="1"/>
														<div class="col-md-12" align="center">
														<input type="submit" id="choose_proj" name="choose_proj" value="<?php echo $lang[791]; ?>" class="btn btn-info">
														</div>
													</div>
												</div>
                               
											</form>
											<?php	}else{	?>
											<h3><font color="#FF0000"><?php echo $lang[792]; ?></font></h3>
											<?php } ?>
										</div>
										<div class="col-md-12 col-sm-12"> 

											<!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-->					
                    
											<div class="col-sm-12" style="margin-top:20px;">
												<div class="page-header"><h3><?php echo $lang[793]; ?></h3></div>
												<div class="tabbable">
													<ul class="nav nav-tabs" id="myTab">
														<li class="active">
															<a data-toggle="tab" href="#incoming"><?php echo $lang[794]; ?></a>
														</li>
														<li class="">
															<a data-toggle="tab" href="#outgoing"><?php echo $lang[795]; ?></a>
														</li>
													</ul>
													<div class="tab-content">
														<div id="incoming" class="tab-pane active">

														
														
<?php 

$page = 1;
$cur_page = $page;
$page -= 1;
$per_page = 10; // Per page records
$previous_btn = true;
$next_btn = true;
//$first_btn = false;
//$last_btn = false;
$start = $page * $per_page;

$sql_usr="select * from user where usr_id='".$_SESSION['uid']."'";
$res_usr=mysql_query($sql_usr);
$row_usr=mysql_fetch_object($res_usr);

$sql_inc="select * from invoice,project,user where inv_prj_id=prj_id and inv_usr_id=usr_id and prj_usr_id='".$_SESSION['uid']."' and inv_status='1' order by inv_payment_status,inv_creation_date LIMIT $start, $per_page";
$res_inc=mysql_query($sql_inc) or die('MySql Error' . mysql_error());
?>
<div class="row" id="ActBid">
	<div class="col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead>
		    		<tr>
						<th style="text-align:center"><?php echo $lang[762]; ?></th>
					    <th style="text-align:center"><?php echo $lang[59]; ?></th>
				        <th><?php echo $lang[18]; ?></th>
				        <th><?php echo $lang[64]; ?></th>
                        <th style="text-align:right"><?php echo $lang[62]; ?> (<?php echo getCurrencyCode(); ?>)</th>
						<th style="text-align:center"><?php echo $lang[598]; ?></th>
                    </tr>
				</thead>
				<tbody>
                <?php
					if(mysql_num_rows($res_inc)>0)
					{
						while($row_inc=mysql_fetch_object($res_inc)){
					?>
                	<tr>
                    	<td width="18%" valign="top" style="text-align:center"><?php echo $row_inc->inv_id; ?></td>
                        <td width="10%" align="center"><?php echo date("d-M-y",strtotime($row_inc->inv_creation_date)); ?></td>
                        <td width="32%" style="text-align:left"><a href="project.php?p=<?php echo $row_inc->prj_id; ?>" target="_blank"><?php echo $row_inc->prj_name; ?></a></td>
                        <td width="18%" align="left"><a href="profile.php?u=<?php echo md5($row_inc->usr_id); ?>" target="_blank"><?php echo $row_inc->usr_name; ?></a></td>
                        <td width="12%" style="text-align:right"><?php echo getCurrencySymbol()." ".$row_inc->inv_amount; ?></td>
                        <td width="10%" align="center" id="inc-<?php echo $row_inc->inv_id; ?>">
						<?php if($row_inc->inv_payment_status=='0'){
							if($row_inc->inv_amount > $row_usr->usr_balance){	?>
						<a href="payment-deposit.php" class="btn btn-xs btn-purple"><?php echo $lang[772]; ?></a>
						<?php	}else{	?>
                        <input type="button" value="<?php echo $lang[772]; ?>" onClick="payInvoice(<?php echo $row_inc->inv_id; ?>)" class="btn btn-xs btn-purple"/>
                        <?php	}
							}else{ echo $lang[789];	} ?>
                        </td>
					</tr>
                         <?php
							}	
						}else{
					?>
	                <tr><td colspan="6" align="center"><p class="alert" style="color:#F00"><?php echo $lang[773]; ?></p></td></tr>
                      <?php	}	?>
						<style>select { font-size:13px; }</style>
	            </tbody>
			</table>
            
            <?php	
					/* -----Total count--- */
					$query_pag_num="select count(*) AS count from invoice,project,user where inv_prj_id=prj_id and inv_usr_id=usr_id and prj_usr_id='".$_SESSION['uid']."' and inv_status='1'"; // Total records
					$result_pag_num = mysql_query($query_pag_num);
					$row = mysql_fetch_array($result_pag_num);
					$count = $row['count'];
					$no_of_paginations = ceil($count / $per_page);

					if ($cur_page >= 7)
					{
					    $start_loop = $cur_page - 3;
					    if ($no_of_paginations > $cur_page + 3)
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
					    if ($no_of_paginations > 7)
					        $end_loop = 7;
					    else
					        $end_loop = $no_of_paginations;
					}
	 ?>
     
     <?php if($count>0){	?>
<ul class="pagination pull-right no-margin">
<?php
// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
	?>
    <li class="prev"><a href="javascript:loadIncomingInvoice('<?php echo $pre; ?>')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
<?php	} else if ($previous_btn) {	?>
	<li class="prev disabled"><a><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
<?php	}	?>
	<!--<li class="prev disabled">
		<a href="#"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
	</li>-->
    
    <?php
for ($i = $start_loop; $i <= $end_loop; $i++) {
    if ($cur_page == $i){	?>
        <li class="active"><a><?php echo $i; ?></a></li>
	<?php	}else{	?>
        <li><a href="javascript:loadIncomingInvoice('<?php echo $i; ?>')"><?php echo $i; ?></a></li>
	<?php	}
}
	 ?>
<?php
// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;	?>
    <li class="next"><a href="javascript:loadIncomingInvoice('<?php echo $nex; ?>')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
<?php	} else if ($next_btn) {	?>
    <li class="next disabled"><a><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
<?php	}	?>
	<!--<li class="next">
		<a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
	</li>-->
</ul>
<?php	}	?>
     
		</div>
	</div>
</div>

														
														
														
														
														
														</div>
														<div id="outgoing" class="tab-pane">

														
														
<?php 														

$page = 1;
$cur_page = $page;
$page -= 1;
$per_page = 10; // Per page records
$previous_btn = true;
$next_btn = true;
//$first_btn = false;
//$last_btn = false;
$start = $page * $per_page;

$sql_out="select * from invoice,project,user where inv_prj_id=prj_id and prj_usr_id=usr_id and inv_usr_id='".$_SESSION['uid']."' and inv_status='1' order by inv_payment_status,inv_creation_date LIMIT $start, $per_page";
$res_out=mysql_query($sql_out) or die('MySql Error' . mysql_error());
?>
<div class="row" id="CurWrk">
	<div class="col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead>
		    		<tr>
						<th style="text-align:center"><?php echo $lang[762]; ?></th>
	                   	<th style="text-align:center"><?php echo $lang[59]; ?></th>
    	               	<th><?php echo $lang[18]; ?></th>
                		<th>Employer</th>
                        <th style="text-align:right"><?php echo $lang[62]; ?> (<?php echo getCurrencyCode(); ?>)</th>
						<th style="text-align:center"><?php echo $lang[61]; ?></th>
		        	</tr>
				</thead>
               	<tbody>
                <?php
					if(mysql_num_rows($res_out)>0)
					{
						while($row_out=mysql_fetch_object($res_out)){
				?>
                   	<tr>
                         <td width="18%" valign="top" style="text-align:center"><?php echo $row_out->inv_id; ?></td>
                         <td width="10%" style="text-align:center"><?php echo date("d-M-y",strtotime($row_out->inv_creation_date)); ?></td>
                         <td width="32%" style="text-align:left"><a href="project.php?p=<?php echo $row_out->prj_id; ?>" target="_blank"><?php echo $row_out->prj_name; ?></a></td>
                         <td width="18%" align="left"><a href="profile.php?u=<?php echo md5($row_out->usr_id); ?>" target="_blank"><?php echo $row_out->usr_name; ?></a></td>
                         <td width="12%" style="text-align:right"><?php echo getCurrencySymbol()." ".$row_out->inv_amount; ?></td>
                         <td width="10%" style="text-align:center"><?php	if($row_out->inv_payment_status=='0'){ echo $lang[69]; }else{ echo $lang[774]; } ?></td>
                    </tr>
               <?php
					}
				}else{
			?>
                   	<tr><td colspan="6" align="center"><p class="alert" style="color:#F00"><?php echo $lang[775]; ?></p></td></tr>
            <?php	}	?>
                     	<style>select { font-size:13px; }</style>
				</tbody>
			</table>
            
            <?php	
					/* -----Total count--- */
					$query_pag_num="select count(*) AS count from invoice,project,user where inv_prj_id=prj_id and prj_usr_id=usr_id and inv_usr_id='".$_SESSION['uid']."' and inv_status='1'"; // Total records
					$result_pag_num = mysql_query($query_pag_num);
					$row = mysql_fetch_array($result_pag_num);
					$count = $row['count'];
					$no_of_paginations = ceil($count / $per_page);

					if ($cur_page >= 7)
					{
					    $start_loop = $cur_page - 3;
					    if ($no_of_paginations > $cur_page + 3)
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
					    if ($no_of_paginations > 7)
					        $end_loop = 7;
					    else
					        $end_loop = $no_of_paginations;
					}
	 ?>
	<?php if($count>0){	?>
<ul class="pagination pull-right no-margin">
<?php
// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
	?>
    <li class="prev"><a href="javascript:loadOutgoingInvoice('<?php echo $pre; ?>')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
<?php	} else if ($previous_btn) {	?>
	<li class="prev disabled"><a><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
<?php	}	?>
	<!--<li class="prev disabled">
		<a href="#"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
	</li>-->
    
    <?php
for ($i = $start_loop; $i <= $end_loop; $i++) {
    if ($cur_page == $i){	?>
        <li class="active"><a><?php echo $i; ?></a></li>
	<?php	}else{	?>
        <li><a href="javascript:loadOutgoingInvoice('<?php echo $i; ?>')"><?php echo $i; ?></a></li>
	<?php	}
}
	 ?>
<?php
// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;	?>
    <li class="next"><a href="javascript:loadOutgoingInvoice('<?php echo $nex; ?>')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
<?php	} else if ($next_btn) {	?>
    <li class="next disabled"><a><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
<?php	}	?>
	<!--<li class="next">
		<a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
	</li>-->
</ul>
<?php	}	?>
            
		</div>
	</div>
</div>
														
														
														
														
														
														</div>
													</div>
												</div>
											</div>
        
										
										
										</div>
                                    </div><!-- end row -->
                                    <hr class="invis">
									
								
                            </div><!-- end post-padding -->
                        </div><!-- end col -->
                    </div><!-- end row -->  
                </div><!-- end container -->
            </div><!-- end section -->
	
	
	
	
<script type="text/javascript">
$(document).ready(function(){
	loadIncomingInvoice(1);
	loadOutgoingInvoice(1);
});

function projSelected(prj)
{
	if(prj == 0)
	{
		$("#sec_area").css("display","none");
	}
	else
	{
		$("#sec_area").css("display","block");
		$.post("ajax-file/retProjectDetails.php",{prj:prj},    function(data){  $("#remain_amt").val(data);	});
	}
}
function validForm()
{
	var inv_prj_id=document.getElementById('inv_prj_id');
	var remain_amt=document.getElementById('remain_amt');
	var inv_amount=document.getElementById('inv_amount')

	var msg="";
	var valid=false;
	
	if(inv_prj_id.value == 0)
	{
		msg='<?php echo $lang[785]; ?>';
		valid=false;
	}
	else if(inv_amount.value == '' || inv_amount.value == null)
	{
		msg='<?php echo $lang[786]; ?>';
		inv_amount.value='';
		inv_amount.focus();
		valid=false;
	}
	else if(isNaN(inv_amount.value))
	{
		msg='<?php echo $lang[242]; ?>';
		inv_amount.value='';
		inv_amount.focus();
		valid=false;
	}
	else if(parseInt(inv_amount.value)>parseInt(remain_amt.value))
	{
		msg='<?php echo $lang[787]; ?>'+remain_amt.value;
		inv_amount.value='';
		inv_amount.focus();
		valid=false;
	}
	else
	{
		valid=true;	
	}
	
	if(!valid)
	{
		document.getElementById("msg").style.color = "red";
		document.getElementById('msg').innerHTML = msg;			 				
	}
	
	return valid;
}
function payInvoice(id)
{
	bootbox.confirm("<?php echo $lang[788]; ?>", function(result) {
		if(result)
		{
			$.post("ajax-file/payInv.php",{inv:id},    function(data){    $("#inc-"+id).html('');	$("#inc-"+id).html('<?php echo $lang[789]; ?>');	loadOutgoingInvoice(1);	});
       	}
	});
}
function loadIncomingInvoice(page)
{
	$.post("ajax-file/loadIncomingInvoice.php",{page:page},    function(data){    $('#incoming').html(data); });
}
function loadOutgoingInvoice(page)
{
	$.post("ajax-file/loadOutgoingInvoice.php",{page:page},    function(data){    $('#outgoing').html(data); });
}
</script>



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
        
        
	
			<?php include "includes/footer.php"; ?>