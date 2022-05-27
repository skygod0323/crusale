</div>
<div id="footer-area">
	<footer class="footer-wrapper clearfix" >
		<section class="footer-wrapper-lft-col">
			<div><img src="sitelogo/<?php echo getSiteLogo(); ?>" alt="<?php echo getWebSiteName(); ?>" /></div>
			<div class="clearfix">
                      <div class="number1">
                            <?php
                                $sql_totPr="select count(*) from project";
                                $res_totPr=mysql_query($sql_totPr);
                                $row_totPr=mysql_fetch_row($res_totPr);
                            ?>
					<ul style="float: right">
        				<?php
                                  $var=$row_totPr[0];
                                  $rev=0;
                                  $l=0;
                                  while($var!=0)
                                  {
                                      $r=floor($var%10);
                                      $rev=($rev*10)+$r;
                                      $var=floor($var/10);
                                      $l++;
                                  }
                                  for($z=$l;$z<4;$z++)
                                  {
                                      ?><li>0</li><?php
                                  }
                                  $i=0;
                                  $new=0;
                                  while($rev!=0)
                                  {
                                      $r=floor($rev%10);
                                      $new=($new*10)+$r;
                                      $rev=floor($rev/10);
                                      $i++;
                                  ?>
                                  <li><?php echo $r; ?></li>
                                  <?php
                                  }
                                  while($i<$l){
                                  ?>
                                    <li>0</li>
                                  <?php
                                  $i++;
                                  }
                                  ?>
					</ul>
					<h6><?php echo $lang[75]; ?></h6>
				</div>
				<div class="number2">
                        <?php
					$sql_totFr="select count(*) from user where usr_status='1' and usr_type != 'Employer'";
					$res_totFr=mysql_query($sql_totFr);
					$row_totFr=mysql_fetch_row($res_totFr);
				?>
					<ul style="float: right">
                                  <?php
                                  
                                  $var=$row_totFr[0];
                                  $rev=0;
                                  $l=0;
                                  
                                  while($var!=0)
                                  {
                                      $r=floor($var%10);
                                      $rev=($rev*10)+$r;
                                      $var=floor($var/10);
                                      $l++;
                                  }
                                  
                                  for($z=$l;$z<4;$z++)
                                  {
                                      ?><li>0</li><?php
                                  }
                                  $i=0;
                                  $new=0;
                                  while($rev!=0)
                                  {
                                      $r=floor($rev%10);
                                      $new=($new*10)+$r;
                                      $rev=floor($rev/10);
                                      $i++;
                                      ?>
                                  <li><?php echo $r; ?></li>
                                      <?php
                                  }
                                  while($i<$l){
                                  ?>
                                    <li>0</li>
                                  <?php
                                  $i++;
                                  }
                                  ?>
					</ul>
					<h6><?php echo $lang[64]; ?></h6>
				</div>
			</div>
                  
		</section>
		<div class="footer-wrapper-center-col">
			<div class="footer-wrapper-center-col-nav">
				<h6 align="left"><?php echo $lang[76]; ?></h6>
				<ul style="text-align:left;">
					<li><a href="show-category.php"><?php echo $lang[77]; ?></a></li>
				<li><a href="latest-proj.php"><?php echo $lang[78]; ?></a></li>
				<li><a href="ending-soon.php"><?php echo $lang[79]; ?></a></li>
                <li><a href="lowbids.php"><?php echo $lang[80]; ?></a></li>
				<li><a href="myskills.php"><?php echo $lang[81]; ?></a></li>
				</ul>
			</div>
			<div class="footer-wrapper-center-col-nav" style="padding-bottom:15px;">
				<h6 align="left"><?php echo $lang[166]; ?></h6>
				<ul style="text-align:left;">
					<li><a href="about.php"><?php echo $lang[82]; ?></a></li>
    				<li><a href="contact-us.php"><?php echo $lang[83]; ?></a></li>
                  	<li><a href="terms.php"><?php echo $lang[84]; ?></a></li>
                  	<li><a href="privacy.php"><?php echo $lang[85]; ?></a></li>
				</ul>
			</div>
			<div class="footer-wrapper-center-col-nav">
				<h6 align="left"><?php echo $lang[167]; ?></h6>
				<ul style="text-align:left;">
					<li><a href="profile.php"><?php $lang[86]; ?></a></li> 
                  <li><a href="manage.php"><?php echo $lang[87]; ?></a></li> 
                  <li><a href="mymessage.php"><?php echo $lang[88]; ?></a></li> 
				</ul>
			</div>
		</div>
		<div class="footer-wrapper-right-col">
			<div class="clearfix">
				<ul class="lft-col">
					<li><a href="#"><img src="images/fb-icon.png" alt="" /><?php echo $lang[89]; ?></a></li>
					<li><a href="#"><img src="images/twitter-icon.png" alt="" /><?php echo $lang[90]; ?></a></li>
                    <li><a href="#"><img src="images/you-tube-icon.png" alt="" /><?php echo $lang[93]; ?></a></li>
									</ul>
				<ul class="rgt-col">
		
					<li><a href="#"><img src="" alt="" </a></li>
				</ul>
			</div>
			<div id="copyright">&copy; <?php echo date("Y"); ?> <?php echo getWebSiteName(); ?>. <?php echo $lang[94]; ?></div>
		</div>
	</footer>
</div>
		


<!--        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>-->
        <!--<script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
		<script type="text/javascript" src="js/vendor/menu.js"></script>
        <script type="text/javascript" src="js/vendor/TabbedPane.js"></script>-->

       
    </body>
</html>
