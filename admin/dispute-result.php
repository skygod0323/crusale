<?php 
ob_start();
session_start(); 
include "../common.php";

check_user_login();
class DisputeDetails{
	var $pds_id;
		
	function __construct($pds_id){
		$this->pds_id=$pds_id;
	}
	function detailsObj(){
		$sql="select * from project_dispute,project where pds_prj_id=prj_id and pds_id=".$this->pds_id;
		$res=mysql_query($sql);
		return mysql_fetch_object($res);
	}		
}

$ob=new DisputeDetails($_GET['fid']);
$row=$ob->detailsObj();

if(isset($_POST['acptWebMs']))  //Code for accepting Web master
{
    $pds_id=addslashes(trim($_POST['pds_id']));

    $sql_pds="select * from project_dispute,bid,project,user where pds_bd_id=bd_id and pds_prj_id=prj_id and prj_usr_id=usr_id and pds_id='".$pds_id."'";
    $res_pds=mysql_query($sql_pds);
    $row_pds=mysql_fetch_object($res_pds);

    $sql_upd_acp="update project_dispute
       set
           pds_closeDate=now(),
           pds_status='0'
       where
           pds_id='".$pds_id."'";
    mysql_query($sql_upd_acp);

    $sql_to_us="select * from user,escrow where usr_id=es_to_id and es_prj_id='".$row_pds->pds_prj_id."' and es_status='1' and es_to_id='".$row_pds->bd_usr_id."'";
    $res_to_us=mysql_query($sql_to_us);
    $row_to_us=mysql_fetch_object($res_to_us);


    $new_bal = $row_to_us->usr_balance + $row_pds->pds_releaseAmount;
        
    $return_amount=$row_to_us->es_amount-$row_pds->pds_releaseAmount;

    $new_wm_bal=$row_pds->usr_balance + $return_amount;

    $sql_upd="update user
	set
		usr_balance=".$new_bal."
	where
		usr_id='".$row_to_us->es_to_id."'";
    mysql_query($sql_upd);  // freelancer's balance update

    $sql_wmUser="update user
	set
		usr_balance=".$new_wm_bal."
	where
		usr_id='".$row_to_us->es_from_id."'";

    mysql_query($sql_wmUser);//webmaster's balance update

    $sql_rel="update transaction
	set
		tr_release = '1'
	where
		tr_id = '".$row_to_us->es_tr_id."'";
		
    mysql_query($sql_rel);

    $sql_esc="update escrow 
	set
		es_status = '0'
	where 
		es_id='".$row_to_us->es_id."'";
    mysql_query($sql_esc);
	header("location:open-dispute.php");
}
if(isset($_POST['acptFreeln']))  //Code for accepting Freelancer
{
    $pds_id=addslashes(trim($_POST['pds_id']));

    $sql_pds="select * from project_dispute,bid,project,user where pds_bd_id=bd_id and pds_prj_id=prj_id and prj_usr_id=usr_id and pds_id='".$pds_id."'";
    $res_pds=mysql_query($sql_pds);
    $row_pds=mysql_fetch_object($res_pds);

    $sql_upd_acp="update project_dispute
       set
           pds_closeDate=now()
           pds_status='0'
       where
           pds_id='".$pds_id."'";
    mysql_query($sql_upd_acp);

    $sql_to_us="select * from user,escrow where usr_id=es_to_id and es_prj_id='".$row_pds->pds_prj_id."' and es_status='1' and es_to_id='".$row_pds->bd_usr_id."'";
    $res_to_us=mysql_query($sql_to_us);
    $row_to_us=mysql_fetch_object($res_to_us);


    $new_bal = $row_to_us->usr_balance + $row_pds->pds_claimAmount;
        
    $return_amount=$row_to_us->es_amount-$row_pds->pds_claimAmount;

    $new_wm_bal=$row_pds->usr_balance + $return_amount;

    $sql_upd="update user
	set
		usr_balance=".$new_bal."
	where
		usr_id='".$row_to_us->es_to_id."'";
    mysql_query($sql_upd);  // freelancer's balance update

    $sql_wmUser="update user
	set
		usr_balance=".$new_wm_bal."
	where
		usr_id='".$row_to_us->es_from_id."'";

    mysql_query($sql_wmUser);//webmaster's balance update

    $sql_rel="update transaction
	set
		tr_release = '1'
	where
		tr_id = '".$row_to_us->es_tr_id."'";
		
    mysql_query($sql_rel);

    $sql_esc="update escrow 
	set
		es_status = '0'
	where 
		es_id='".$row_to_us->es_id."'";
    mysql_query($sql_esc);
	header("location:open-dispute.php");
}
?>
<?php include "includes/admin-top.php" ?>
<div class="main-container" id="main-container">
	<script type="text/javascript">
		try{ace.settings.check('main-container' , 'fixed')}catch(e){}
	</script>

	<div class="main-container-inner">
		<a class="menu-toggler" id="menu-toggler" href="#">
			<span class="menu-text"></span>
		</a>
<?php include "includes/admin-left-con.php" ?>
<div class="main-content">
	<div class="breadcrumbs" id="breadcrumbs">
		<script type="text/javascript">
			try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
		</script>

		<ul class="breadcrumb">
			<li>
				<i class="icon-home home-icon"></i>
					<a href="welcome.php">Home</a>
				</li>
				<li>
					<a>Manage Dispute </a>
				</li>
				<li class="active">Dispute Result</li>
		</ul><!-- .breadcrumb -->
					<!-- #nav-search -->
	</div>
<div class="page-content">
<form class="form-horizontal" name="fd_view" id="fd_view" method="post"> 
<input type="hidden" id="pds_id" name="pds_id" value="<?php echo $row->pds_id; ?>"/>
   <div class="row">
		<div class="col-sm-6">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="smaller">Webmaster's Reason</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
	                    
						<div class="form-group">
							<label class="col-sm-4 control-label no-padding-right" for="form-field-2">Project Name: </label>
							<div class="col-sm-8">
								<label style="padding-top:4px;"><?php echo $row->prj_name; ?></label>
							</div>
						</div>
                        <div class="form-group">
							<label class="col-sm-4 control-label no-padding-right" for="form-field-2">Reason of Dispute: </label>
							<div class="col-sm-8">
								<label style="padding-top:4px;"><?php echo $row->pds_reason; ?></label>
							</div>
						</div>
                        <div class="form-group">
							<label class="col-sm-4 control-label no-padding-right" for="form-field-2">Dispute Date: </label>
							<div class="col-sm-8">
								<label style="padding-top:4px;"><?php echo date("d-m-Y",strtotime($row->pds_disputeDate)); ?></label>
							</div>
						</div>
                        <div class="form-group">
							<label class="col-sm-4 control-label no-padding-right" for="form-field-2">Release Amount: </label>
							<div class="col-sm-8">
								<label style="padding-top:4px;"><?php echo $row->pds_releaseAmount; ?></label>
							</div>
						</div>
                        <div class="form-group">
							<label class="col-sm-4 control-label no-padding-right" for="form-field-2"></label>
							<div class="col-sm-8">
								<label style="padding-top:4px;"><?php if($row->pds_releaseAmount==$row->pds_setteledAmount){ ?><span style="color:#063">Approved</span><?php } ?></label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
                
<?php if($row->pds_claimReason!=''){ ?>

<div class="col-sm-6">
	<div class="widget-box">
		<div class="widget-header">
			<h4 class="smaller">Freelancer's Reason</h4>
		</div>
		<div class="widget-body">
			<div class="widget-main">
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-2">Claim Date: </label>
					<div class="col-sm-8">
						<label style="padding-top:4px;"><?php echo date("d-m-Y",strtotime($row->pds_claimDate)); ?></label>
					</div>
				</div>
                 <div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-2">Claim Amount: </label>
					<div class="col-sm-8">
						<label style="padding-top:4px;"><?php echo $row->pds_claimAmount; ?></label>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-2">Claim Reason: </label>
					<div class="col-sm-8">
						<label style="padding-top:4px;"><?php echo $row->pds_claimReason; ?></label>
					</div>
				</div>
                 <div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-2"></label>
					<div class="col-sm-8">
						<label style="padding-top:4px;"> <?php if($row->pds_claimAmount==$row->pds_setteledAmount){ ?><span style="color:#063">Approved</span><?php } ?></label>
					</div>
				</div>
                
                
                
			</div>
		</div>
	</div>
</div>

<?php } ?>
			</div> <!-- end div class="bodyRightightCon_inner" -->
		</form>					
<br clear="all"/>
 </div>

 </div>
 </div>
 <br clear="all" />

 </div>  
  <?php include "includes/footer.php" ?>
<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
 <script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.js"></script>

		<!-- ace scripts -->

		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			jQuery(function($) {
				var oTable1 = $('#sample-table-2').dataTable( {
				"aoColumns": [
			      { "bSortable": false },
			      null, null,null,null,
				  { "bSortable": false }
				] } );
				
				
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
			
			
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			})
		</script>
</body>
</html>