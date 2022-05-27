<?php
$path=$_SERVER['SCRIPT_NAME'];
$pos=strrpos($path,'/');
$file=substr($path,($pos+1));
$file = strstr($file, '.', true);
?>
<div class="sidebar" id="sidebar">
	<script type="text/javascript">
		try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
	</script>
	<div class="sidebar-shortcuts" id="sidebar-shortcuts">
		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<a class="btn btn-success" href="welcome.php" title="Home"><i class="icon-home"></i></a>
			<a class="btn btn-info" href="change-pass.php" title="Change Password"><i class="icon-key"></i></a>
			<a class="btn btn-warning" href="memplan-view.php" title="Membership Plan"><i class="icon-group"></i></a>
			<a class="btn btn-danger" href="setting-view.php" title="Site Settings"><i class="icon-cogs"></i></a>
		</div>

		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<span class="btn btn-success"></span>
			<span class="btn btn-info"></span>
			<span class="btn btn-warning"></span>
			<span class="btn btn-danger"></span>
		</div>
	</div>
	<ul class="nav nav-list">
		<li <?php if($file=="change-user" || $file=="change-email" || $file=="change-pass"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-dashboard"></i>
				<span class="menu-text"> Manage Admin </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="change-user"){ ?> class="active" <?php } ?>><a href="change-user.php">Change User Name</a></li>
				<li <?php if($file=="change-email"){ ?> class="active" <?php } ?>><a href="change-email.php">Change Email</a></li>
				<li <?php if($file=="change-pass"){ ?> class="active" <?php } ?>><a href="change-pass.php">Change Password</a></li>
			</ul>
		</li>
        <li <?php if($file=="testi-view" || $file=="testi-edit" || $file=="testi-add" || $file=="homepic-view" || $file=="homepic-edit" || $file=="homepic-add" || $file=="setting-view" || $file=="setting-edit" || $file=="country" || $file=="city" || $file=="social-view" || $file=="social-edit"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-cog"></i>
				<span class="menu-text"> Manage Settings </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="setting-view" || $file=="setting-edit"){ ?> class="active" <?php } ?>><a href="setting-view.php">View Settings</a></li>
                <li <?php if($file=="country"){ ?> class="active" <?php } ?>><a href="country.php">Add/Edit Country</a></li>
  				<li <?php if($file=="city"){ ?> class="active" <?php } ?>><a href="city.php">Add/Edit City</a></li>
                <li <?php if($file=="social-view" || $file=="social-edit"){ ?> class="active" <?php } ?>><a href="social-view.php">Social Media</a></li>
				<li <?php if($file=="homepic-view" || $file=="homepic-edit" || $file=="homepic-add"){ ?> class="active" <?php } ?>><a href="homepic-view.php">Home Pic</a></li>
				<li <?php if($file=="testi-view" || $file=="testi-edit" || $file=="testi-add"){ ?> class="active" <?php } ?>><a href="testi-view.php">Testimonials</a></li>
			</ul>
		</li>
        <li <?php if($file=="cms-view" || $file=="cms-edit"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-list"></i>
				<span class="menu-text"> Manage CMS </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="cms-view" || $file=="cms-edit"){ ?> class="active" <?php } ?>><a href="cms-view.php">View CMS</a></li>
			</ul>
		</li>
        <li <?php if($file=="memplan-add" || $file=="memplan-view" || $file=="memplan-edit"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-unlock"></i>
				<span class="menu-text"> Membership Plan </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="memplan-add"){ ?> class="active" <?php } ?>><a href="memplan-add.php">Add Membership Plan</a></li>			
                <li <?php if($file=="memplan-view" || $file=="memplan-edit"){ ?> class="active" <?php } ?>><a href="memplan-view.php">View Membership Plans</a></li>
			</ul>
		</li>
        <li <?php if($file=="user-view" || $file=="user-details"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-user"></i>
				<span class="menu-text"> Manage Users </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="user-view" || $file=="user-details"){ ?> class="active" <?php } ?>><a href="user-view.php">View Users</a></li>
			</ul>
		</li>
         <li <?php if($file=="profilecompleteness-view" || $file=="profilecompleteness-edit"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-certificate"></i>
				<span class="menu-text">Profile Completeness</span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="profilecompleteness-view" || $file=="profilecompleteness-edit"){ ?> class="active" <?php } ?>><a href="profilecompleteness-view.php">View Settings</a></li>
			</ul>
		</li>
        <li <?php if($file=="project-view"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-book"></i>
				<span class="menu-text"> Manage Projects </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="project-view"){ ?> class="active" <?php } ?>><a href="project-view.php">View Projects</a></li>
			</ul>
		</li>
        <li <?php if($file=="open-dispute" || $file=="closed-dispute" || $file=="dispute-details" || $file=="dispute-result"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-info-sign"></i>
				<span class="menu-text"> Project Disputes </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="open-dispute" || $file=="dispute-details"){ ?> class="active" <?php } ?>><a href="open-dispute.php">Open Disputes</a></li>			
                <li <?php if($file=="closed-dispute" || $file=="dispute-result"){ ?> class="active" <?php } ?>><a href="closed-dispute.php">Closed Disputes</a></li>
			</ul>
		</li>
        <li <?php if($file=="bidding_option-view" || $file=="bidding_option-edit"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-bell"></i>
				<span class="menu-text"> Bidding-Options </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="bidding_option-view" || $file=="bidding_option-edit"){ ?> class="active" <?php } ?>><a href="bidding_option-view.php">View Bidding-Options</a></li>
			</ul>
		</li>
        <li <?php if($file=="projpromotion-view" || $file=="projpromotion-edit"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-bullhorn"></i>
				<span class="menu-text"> Project-Promotion </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="projpromotion-view" || $file=="projpromotion-edit"){ ?> class="active" <?php } ?>><a href="projpromotion-view.php">View Promotions</a></li>
			</ul>
		</li>
        <li <?php if($file=="transfer-view" || $file=="deposit-view" || $file=="withdraw-view" || $file=="request-view"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-exchange"></i>
				<span class="menu-text">Transactions</span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="transfer-view"){ ?> class="active" <?php } ?>><a href="transfer-view.php">View Transfers</a></li>
                <li <?php if($file=="deposit-view"){ ?> class="active" <?php } ?>><a href="deposit-view.php">View Deposits</a></li>
                <li <?php if($file=="withdraw-view"){ ?> class="active" <?php } ?>><a href="withdraw-view.php">View Withdraws</a></li>
                <li <?php if($file=="request-view"){ ?> class="active" <?php } ?>><a href="request-view.php">View Withdraw Requests</a></li>
			</ul>
		</li>
        <li <?php if($file=="gateway-add" || $file=="gateway-view" || $file=="gateway-edit"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-credit-card"></i>
				<span class="menu-text"> Payment Gateway </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="gateway-add"){ ?> class="active" <?php } ?>><a href="gateway-add.php">Add Gateway</a></li>
                <li <?php if($file=="gateway-view" || $file=="gateway-edit"){ ?> class="active" <?php } ?>><a href="gateway-view.php">View Gateway</a></li>
			</ul>
		</li>
        <li <?php if($file=="category-add" || $file=="category-view" || $file=="category-edit"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-list-alt"></i>
				<span class="menu-text"> Manage Category </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="category-add"){ ?> class="active" <?php } ?>><a href="category-add.php">Add Category</a></li>
                <li <?php if($file=="category-view" || $file=="category-edit"){ ?> class="active" <?php } ?>><a href="category-view.php">View Category</a></li>
			</ul>
		</li>
        <li <?php if($file=="subcategory-add" || $file=="subcategory-view"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-list-alt"></i>
				<span class="menu-text"> Sub-Category </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="subcategory-add"){ ?> class="active" <?php } ?>><a href="subcategory-add.php">Add Category</a></li>
                <li <?php if($file=="subcategory-view"){ ?> class="active" <?php } ?>><a href="subcategory-view.php">View Category</a></li>
			</ul>
		</li>
        <li <?php if($file=="skill-add" || $file=="skill-view"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-list-alt"></i>
				<span class="menu-text"> Manage Skills </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="skill-add"){ ?> class="active" <?php } ?>><a href="skill-add.php">Add Skill</a></li>
                <li <?php if($file=="skill-view"){ ?> class="active" <?php } ?>><a href="skill-view.php">View Skills</a></li>
			</ul>
		</li>
       <li <?php if($file=="contact-view" || $file=="contact-details"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-comment-alt"></i>
				<span class="menu-text"> Manage Contact </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
                <li <?php if($file=="contact-view" || $file=="contact-details"){ ?> class="active" <?php } ?>><a href="contact-view.php">View Contact</a></li>
			</ul>
		</li>
        <li <?php if($file=="advertisement-add" || $file=="advertisement-view" || $file=="advertisement-edit"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-desktop"></i>
				<span class="menu-text"> Advertisement </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="advertisement-add"){ ?> class="active" <?php } ?>><a href="advertisement-add.php">Add Advertisement</a></li>
                <li <?php if($file=="advertisement-view" || $file=="advertisement-edit"){ ?> class="active" <?php } ?>><a href="advertisement-view.php">View Advertisement</a></li>
			</ul>
		</li>
        <li <?php if($file=="notice-add" || $file=="notice-view" || $file=="notice-edit"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-lightbulb"></i>
				<span class="menu-text"> Manage Notice </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li <?php if($file=="notice-add"){ ?> class="active" <?php } ?>><a href="notice-add.php">Add Notice</a></li>
                <li <?php if($file=="notice-view" || $file=="notice-edit"){ ?> class="active" <?php } ?>><a href="notice-view.php">View Notice</a></li>
			</ul>
		</li>
        <li <?php if($file=="faq_category_list" || $file=="faq_category_add"  || $file=="faq_category_edit" || $file=="custom-faq"){ ?> class="active open" <?php } ?>>
			<a href="#" class="dropdown-toggle">
				<i class="icon-question-sign"></i>
				<span class="menu-text"> Manage FAQ </span>
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
            	<li <?php if($file=="faq_category_list" || $file=="faq_category_add"  || $file=="faq_category_edit"){ ?> class="active" <?php } ?>><a href="faq_category_list.php">FAQ Category</a></li>			
                <li <?php if($file=="custom-faq"){ ?> class="active" <?php } ?>><a href="custom-faq.php">Add/Edit FAQ</a></li> 
			</ul>
		</li>
	</ul>
    <div class="sidebar-collapse" id="sidebar-collapse">
		<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
	</div>
</div>	