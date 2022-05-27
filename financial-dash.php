<?php
ob_start();
session_start();
include "common.php";
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
									<li class="active"><a href="financial-dash.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[133]; ?></a></li>
                                    <li ><a href="payment-deposit.php"><span class="glyphicon glyphicon-user"></span>  <?php echo $lang[134]; ?></a></li>
									<li ><a href="transfer-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[135]; ?></a></li>
									<li ><a href="withdraw-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[136]; ?></a></li>
									<li ><a href="release-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[137]; ?></a></li>
									<li ><a href="invoice.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[796]; ?></a></li>
									<li ><a href="transactions.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[138]; ?></a></li>
                                    </ul>
                            </div><!-- end widget -->
                        </div><!-- end col -->

                        <div class="content col-md-9">
                            <div class="post-padding">
                                <div class="job-title nocover hidden-sm hidden-xs"><h5><?php echo $lang[235]; ?></h5></div>
                                
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">   
                                            
                                            <?php include "dashboard.php"; ?>
											
										</div>
                                    </div><!-- end row -->
                                    <hr class="invis">
									
								
                            </div><!-- end post-padding -->
                        </div><!-- end col -->
                    </div><!-- end row -->  
                </div><!-- end container -->
            </div><!-- end section -->
			
			
<?php include "includes/footer.php"; ?>