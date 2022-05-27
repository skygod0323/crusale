-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 29, 2014 at 03:22 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";



--
-- Database: `freelancer`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login_details`
--

DROP TABLE IF EXISTS `admin_login_details`;
CREATE TABLE `admin_login_details` (
  `admin_login_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `last_login_time` datetime NOT NULL,
  `user_ip` varchar(256) NOT NULL,
  PRIMARY KEY (`admin_login_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=119 ;

--
-- Dumping data for table `admin_login_details`
--

INSERT INTO `admin_login_details` (`admin_login_id`, `id`, `last_login_time`, `user_ip`) VALUES
(99, 2, '2013-09-20 22:39:44', '70.29.53.169'),
(100, 2, '2013-09-22 12:00:02', '95.35.56.28'),
(101, 2, '2013-09-24 18:18:35', '127.0.0.1'),
(102, 2, '2013-09-24 18:42:47', '127.0.0.1'),
(103, 2, '2013-09-30 14:16:46', '127.0.0.1'),
(104, 2, '2013-09-30 18:19:16', '127.0.0.1'),
(105, 2, '2013-10-09 11:23:10', '127.0.0.1'),
(106, 2, '2013-10-22 23:07:23', '::1'),
(107, 2, '2013-10-23 17:55:29', '127.0.0.1'),
(108, 2, '2013-10-24 12:29:41', '127.0.0.1'),
(109, 2, '2013-11-13 18:35:28', '::1'),
(110, 2, '2013-12-04 16:17:25', '::1'),
(111, 2, date_add(NOW(),INTERVAL -8 DAY), '::1'),
(112, 2, date_add(NOW(),INTERVAL -7 DAY), '::1'),
(113, 2, date_add(NOW(),INTERVAL -6 DAY), '::1'),
(114, 2, date_add(NOW(),INTERVAL -5 DAY), '::1'),
(115, 2, date_add(NOW(),INTERVAL -4 DAY), '::1'),
(116, 2, date_add(NOW(),INTERVAL -3 DAY), '::1'),
(117, 2, date_add(NOW(),INTERVAL -2 DAY), '::1'),
(118, 2, date_add(NOW(),INTERVAL -1 DAY), '::1');

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(150) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `username`, `password`, `email`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `advertisement`
--

DROP TABLE IF EXISTS `advertisement`;
CREATE TABLE `advertisement` (
  `adv_id` int(10) NOT NULL AUTO_INCREMENT,
  `adv_img` varchar(255) DEFAULT NULL,
  `adv_link` varchar(255) DEFAULT NULL,
  `adv_imagewidth` int(10) NOT NULL,
  `adv_imageheight` int(10) NOT NULL,
  `adv_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`adv_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `advertisement`
--

INSERT INTO `advertisement` (`adv_id`, `adv_img`, `adv_link`, `adv_imagewidth`, `adv_imageheight`, `adv_status`) VALUES
(1, 'imdb_300x250.jpg', 'http://itechscripts.com/my_movie_portal.html', 300, 250, 1),
(2, 'imdb_728x90.jpg', 'http://itechscripts.com/my_movie_portal.html', 728, 90, 1),
(3, 'olx_300x250.jpg', 'http://itechscripts.com/olx_clone.html', 300, 250, 0),
(4, 'olx_728x90.jpg', 'http://itechscripts.com/olx_clone.html', 728, 90, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bid`
--

DROP TABLE IF EXISTS `bid`;
CREATE TABLE `bid` (
  `bd_id` int(10) NOT NULL AUTO_INCREMENT,
  `bd_prj_id` int(10) NOT NULL,
  `bd_usr_id` int(10) NOT NULL,
  `bd_date` datetime NOT NULL,
  `bd_amount` double(10,2) NOT NULL,
  `bd_days` int(5) NOT NULL,
  `bd_milestone` int(10) DEFAULT NULL,
  `bd_details` text NOT NULL,
  `bd_uplift` int(1) NOT NULL DEFAULT '0',
  `bd_highlight` int(1) NOT NULL DEFAULT '0',
  `bd_deadline` datetime DEFAULT NULL,
  `bd_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bd_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `bid`
--

INSERT INTO `bid` (`bd_id`, `bd_prj_id`, `bd_usr_id`, `bd_date`, `bd_amount`, `bd_days`, `bd_milestone`, `bd_details`, `bd_uplift`, `bd_highlight`, `bd_deadline`, `bd_status`) VALUES
(1, 1, 2, date_add(NOW(),INTERVAL -32 DAY), 250.00, 10, 50, 'dshfkj rhtoirtrong lktjhlj', 0, 0, NULL, 0),
(7, 2, 4, date_add(NOW(),INTERVAL -32 DAY), 925.00, 8, 50, 'asdasd', 1, 0, date_add(NOW(),INTERVAL -20 DAY), 1),
(3, 2, 2, date_add(NOW(),INTERVAL -30 DAY), 950.00, 15, 50, 'hiuh iuyioyoiy o yoiuyioyu', 0, 0, NULL, 0),
(5, 3, 5, date_add(NOW(),INTERVAL -25 DAY), 625.00, 5, 50, 'sadsadsa', 1, 0, NULL, 0),
(6, 4, 4, date_add(NOW(),INTERVAL -25 DAY), 4025.00, 10, 50, 'hnjgj', 1, 0, NULL, 0),
(8, 5, 1, date_add(NOW(),INTERVAL -20 DAY), 550.00, 10, 50, 'hdsiuh urtoir eutoirut oirororyu', 0, 0, NULL, 0),
(12, 13, 2, date_add(NOW(),INTERVAL -18 DAY), 800.00, 5, 50, 'drjthoreui utioyutuytr', 0, 0, date_add(NOW(),INTERVAL -6 DAY), 1),
(13, 35, 9, date_add(NOW(),INTERVAL -16 DAY), 1500.00, 10, 50, 'dsuty iure tyrut y uytuyu truort', 0, 0, date_add(NOW(),INTERVAL -6 DAY), 1),
(14, 36, 9, date_add(NOW(),INTERVAL -15 DAY), 1200.00, 10, 50, 'sdfiheriou oirutoirutoiu tryutruyotru  rtuytuytuotu', 0, 0, date_add(NOW(),INTERVAL -2 DAY), 1),
(15, 37, 9, date_add(NOW(),INTERVAL -14 DAY), 22.00, 10, 50, 'fgrekthiu ytryutruyoiu tuyrtuy ortuy rtyuu', 0, 0, date_add(NOW(),INTERVAL -2 DAY), 1),
(31, 39, 9, date_add(NOW(),INTERVAL -12 DAY), 600.00, 10, 50, 'ftu09 09rtiy09ty u0t9ui 560978', 0, 0, NULL, 0),
(32, 39, 12, date_add(NOW(),INTERVAL -10 DAY), 550.00, 12, 50, 'tryoi oituyoit uioyt u', 0, 0, NULL, 0),
(33, 43, 13, date_add(NOW(),INTERVAL -9 DAY), 510.00, 10, 50, 'sdukfyhreio tuytoyu yoiuytr uyoituy rt', 0, 0, date_add(NOW(),INTERVAL +1 DAY), 1),
(35, 45, 13, date_add(NOW(),INTERVAL -8 DAY), 1250.00, 25, 50, 'DGDFGDFGDFGDFG', 1, 0, date_add(NOW(),INTERVAL +2 DAY), 1),
(36, 47, 13, date_add(NOW(),INTERVAL -3 DAY), 250.00, 10, 50, 'sruirui riourtiouptruio trgoiutiouty', 0, 0, NULL, 0),
(41, 52, 1, date_add(NOW(),INTERVAL -4 DAY), 150.00, 15, 50, 'eworu 8rtu8re tuertureioutroeiuyt', 0, 0, NULL, 0),
(43, 54, 1, date_add(NOW(),INTERVAL -5 DAY), 1300.00, 12, 60, 'sample biiiid', 1, 1, NULL, 0),
(44, 61, 13, date_add(NOW(),INTERVAL -5 DAY), 1400.00, 10, 50, 'rtuip uitiy tiupoyti upoytu', 0, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bidding_option`
--

DROP TABLE IF EXISTS `bidding_option`;
CREATE TABLE `bidding_option` (
  `bo_id` int(11) NOT NULL AUTO_INCREMENT,
  `bo_option` text NOT NULL,
  `bo_description` text NOT NULL,
  `bo_amount` decimal(7,2) NOT NULL,
  `bo_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bo_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bidding_option`
--

INSERT INTO `bidding_option` (`bo_id`, `bo_option`, `bo_description`, `bo_amount`, `bo_status`) VALUES
(1, 'Go to the Top of the List! Sponsor Your Bid!', 'Increase your chances to WIN by 430%! If you''re picked, you get REFUNDED!', '5.00', 1),
(2, 'Highlight Your Bid!', 'Make your bid stand out from the pack! Your bid will be highlighted on the project page, making it stand out for the employer.', '5.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bidoption`
--

DROP TABLE IF EXISTS `bidoption`;
CREATE TABLE `bidoption` (
  `b_id` int(11) NOT NULL AUTO_INCREMENT,
  `b_bd_id` int(11) NOT NULL,
  `b_bo_id` int(11) NOT NULL,
  `b_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`b_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `bidoption`
--

INSERT INTO `bidoption` (`b_id`, `b_bd_id`, `b_bo_id`, `b_status`) VALUES
(1, 2, 1, 1),
(2, 4, 1, 1),
(3, 5, 1, 1),
(4, 6, 1, 1),
(5, 7, 1, 1),
(6, 16, 1, 1),
(7, 16, 2, 1),
(8, 17, 1, 1),
(9, 17, 2, 1),
(10, 18, 1, 1),
(11, 18, 2, 1),
(12, 22, 1, 1),
(13, 22, 2, 1),
(14, 27, 2, 1),
(15, 29, 2, 1),
(16, 35, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `cat_id` int(10) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `cat_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `cat_status`) VALUES
(1, 'Websites, IT & Software', 1),
(2, 'Mobile Phones & Computing', 1),
(3, 'Writing & Content', 1),
(4, 'Design, Media & Architecture', 1),
(5, 'Data Entry & Admin', 1),
(6, 'Engineering & Science', 1),
(7, 'Product Sourcing & Manufacturing', 1),
(8, 'Sales & Marketing', 1),
(9, 'Business, Accounting, Human Resources & Legal', 1),
(10, 'Translation & Languages', 1),
(11, 'Other', 1);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
  `ct_id` int(11) NOT NULL AUTO_INCREMENT,
  `ct_cn_id` int(11) NOT NULL,
  `ct_name` varchar(100) NOT NULL,
  `ct_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ct_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`ct_id`, `ct_cn_id`, `ct_name`, `ct_status`) VALUES
(1, 104, 'Kolkata', 1),
(2, 104, 'Mumbai', 1),
(3, 104, 'Pune', 1),
(4, 104, 'Delhi', 1),
(5, 104, 'Bangalore', 1),
(6, 236, 'London', 1),
(7, 14, 'Sydney', 1),
(8, 14, 'Melbourne', 1),
(9, 207, 'Durban', 1),
(10, 207, 'Cape Town', 1),
(11, 207, 'Johannesburg', 1),
(12, 237, 'Florida', 1),
(13, 237, 'California', 1),
(14, 237, 'New York', 1),
(15, 237, 'Washington', 1),
(16, 236, 'Liverpool', 1),
(17, 236, 'Manchester', 1),
(18, 85, 'Berlin', 1),
(19, 85, 'Munich', 1),
(20, 85, 'Frankfurt', 1),
(21, 85, 'Hamburg', 1),
(22, 104, 'Agra', 1),
(23, 104, 'Amritsar', 1),
(24, 104, 'Indore', 1),
(25, 104, 'Patna', 1),
(26, 104, 'Madurai', 1),
(27, 104, 'Hyderabad', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

DROP TABLE IF EXISTS `cms`;
CREATE TABLE `cms` (
  `cms_id` int(11) NOT NULL AUTO_INCREMENT,
  `cms_title` varchar(255) NOT NULL,
  `cms_page` varchar(255) NOT NULL,
  `cms_content` text NOT NULL,
  `cms_updated_date` datetime NOT NULL,
  `cms_status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cms_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`cms_id`, `cms_title`, `cms_page`, `cms_content`, `cms_updated_date`, `cms_status`) VALUES
(1, 'About Us', 'aboutus', '<p>Everything you need to know about Narula Institute of Technology: its history and mission, location, and the answers to some of our most frequently asked questions.</p>\r\n<p>Narula Institute of Technology is a unit of JIS Group of academic institutions, managed under the Narula Educational Trust. It was established by Sardar Jodh Singh, an esteemed &amp; eminent industrialist, whose very life defines the word "Karamyogi". Belonging to the rare breed of successful industrialists who feel that they owe a debt to be society and are committed to repay it, he set up this Charitable Trust with a view to imparting education of highest quality in various fields, particularly in technology and management, the two core areas which are of immense need in to-days world in a developing country like ours.\r\nNarula Institute of Technolgy was inaugurated by the Hon''ble Chief Minister Sri Buddhadeb Bhattacharya on August 17th 2001, Hon''ble Minister of Higher Education, Sri Satya Sadhan Chakraborty also graced the occasion. </p>', '2011-10-18 15:09:44', 1),
(2, 'Contact Us', 'contact-us', '<p>Hi, and thanks for visiting our feedback page. We are always happy to hear\r\nfrom our visitors. However, before you contact us, please read this page\r\ncarefully.</p>\r\n<p>Though we read each and every message and do our best to reply to everyone,\r\nplease understand that, due to the extremely high number of queries we receive\r\non a daily basis, we cannot guarantee a personal response in every case.</p>\r\n<p>Also, please avoid sending more than one message/question on the same topic.\r\nSending multiple requests will not prompt us to reply sooner -- it will\r\nonly substantially slow down our response time and may even result in all your\r\nqueries being ignored.</p>', '2012-03-15 03:07:35', 1),
(3, 'Footer', 'Footer', '<p>Freelancer.com <span>(formerly GetAFreelancer) is the world''s largest outsourcing and crowdsourcing marketplace for small business</span>. We have hundreds of thousands of satisfied customers from all over the world. We connect over <span class="COUNT-REGISTERED-USER">4,032,916</span> employers and freelancers globally from over 234 countries &amp; regions. Through our website, employers can hire freelancers to do work in areas such as software, writing, data entry and design right through to engineering and the sciences, sales and marketing, and accounting &amp; legal services. The average job is under US$200, making \r\noutsourcing for the first time extremely cost effective for small businesses.</p>\r\n<p>Would you like to find freelance jobs and make money online? Just sign up to get started! We have created a safe environment for both freelancers and employers via our secure milestone payment system.  We have thousands of freelance coders, writers, programmers, designers, marketers and more. Getting the best web design, professional \r\nprogramming, custom writing or affordable marketing has never been easier! Try outsourcing for free today! Don''t forget to bookmark our homepage for your next project or job.</p>', '2012-08-09 16:45:38', 1),
(4, 'Privacy Policy', 'Privacy Policy', '    <p><b>Last Updated, November 15, 2010</b>. To see what has changed <a href="http://www.imdb.com/privacy_change">click here</a>. </p>\r\n \r\n<p>IMDb knows that you care how information about you is used and \r\nshared, and we appreciate your trust that we will do so carefully and \r\nsensibly. <b>By visiting IMDb, you are accepting the practices described in this Privacy Notice.</b> </p>\r\n \r\n<p><b>What Personal Information About Users Does IMDb Gather?</b></p>\r\n \r\n<p>The information we learn from users helps us personalize and \r\ncontinually improve your experience at IMDb. Here are the types of \r\ninformation we gather. </p>\r\n \r\n<ul type="disc"> \r\n<li><b>Information You Give Us</b>: We receive and store any information you enter on our Web site or give us in any other way. <a href="http://www.imdb.com/privacy_info">Click here</a>\r\n to see examples of what we collect. You can choose not to provide \r\ncertain information, but then you might not be able to take advantage of\r\n many of our features. We use the information that you provide for such \r\npurposes as responding to your requests, customizing future browsing for\r\n you, improving our site, and communicating with you. </li>\r\n \r\n<li><b>Automatic Information</b>: We receive and store certain types of \r\ninformation whenever you interact with us. For example, like many Web \r\nsites, we use "cookies," and we obtain certain types of information when\r\n your Web browser accesses IMDb or advertisements and other content \r\nserved by or on behalf of IMDb on other Web sites. <a href="http://www.imdb.com/privacy_auto">Click here</a> to see examples of the information we receive. </li>\r\n \r\n<li><b>E-mail Communications</b>: To help us make e-mails more useful \r\nand interesting, we often receive a confirmation when you open e-mail \r\nfrom IMDb if your computer supports such capabilities. We also compare \r\nour user list to lists received from other companies, in an effort to \r\navoid sending unnecessary messages to our users. If you do not want to \r\nreceive e-mail or other mail from us, please use our <a href="http://www.imdb.com/register/">User Administration</a> pages to adjust your preferences. </li>\r\n \r\n<li><b>Information from Other Sources</b>: We might receive information about you from other sources and add it to our account information. <a href="http://www.imdb.com/privacy_other">Click here</a> to see examples of the information we receive.</li>\r\n \r\n</ul> \r\n<p><b>What About Cookies?</b> </p>\r\n \r\n<ul type="disc"> \r\n<li>Cookies are alphanumeric identifiers that we transfer to your \r\ncomputer''s hard drive through your Web browser to enable our systems to \r\nrecognize your browser and to provide features such as My Movies, local \r\nshow times, and browsing preferences. </li>\r\n \r\n<li>The "help" portion of the toolbar on most browsers will tell you how\r\n to prevent your browser from accepting new cookies, how to have the \r\nbrowser notify you when you receive a new cookie, or how to disable \r\ncookies altogether. Additionally, you can disable or delete similar data\r\n used by browser add-ons, such as Flash cookies, by changing the \r\nadd-on''s settings or visiting the Web site of its manufacturer. However,\r\n because cookies allow you to take full advantage of some of IMDb''s \r\nessential features, we recommend that you leave them turned on. </li>\r\n\r\n<li>We use web beacons (also known as &#8220;action tags&#8221; or &#8220;single-pixel \r\ngifs&#8221;) and other technologies to measure the effectiveness of certain \r\nsite features and to conduct research and analysis.  We also allow third\r\n parties to place web beacons and other technologies on our site to \r\nconduct research and analysis, but we do not provide personal \r\ninformation to such third parties.</li>\r\n \r\n</ul> \r\n<p><b>Does IMDb Share the Information It Receives?</b></p>\r\n \r\n<p>Information about our users is an important part of our business, and\r\n we are not in the business of selling it to others. We share user \r\ninformation with our parent corporation (Amazon.com, Inc.), the \r\nsubsidiaries it controls, and as described below. </p>\r\n \r\n<ul type="disc"> \r\n<li><b>Affiliated Businesses We Do Not Control</b>: We work closely with\r\n our affiliated businesses. In some cases, we will include offerings \r\nfrom these businesses on IMDb. In other cases, we may include joint \r\nofferings from IMDb and these businesses on IMDb. You can tell when \r\nanother business is involved in the offering, and we share user \r\ninformation related to those offerings with that business. </li>\r\n \r\n<li><b>Agents</b>: We employ other companies and individuals to perform \r\nfunctions on our behalf. Examples include sending e-mail, removing \r\nrepetitive information from user lists, analyzing data, and providing \r\nmarketing assistance. They have access to personal information needed to\r\n perform their functions, but may not use it for other purposes. </li>\r\n \r\n<li><b>Promotional Offers</b>: Sometimes we send offers to selected \r\ngroups of IMDb users on behalf of other businesses. When we do this, we \r\ndo not give that business your name and e-mail address. If you do not \r\nwant to receive such offers, please use our <a href="http://www.imdb.com/register/">User Administration</a> pages to adjust your preferences. </li>\r\n \r\n<li><b>Business Transfers</b>: As we continue to develop our business, \r\nwe might sell or buy additional services or business units. In such \r\ntransactions, user information generally is transferred along with the \r\nrest of the service or business unit. Also, in the event that IMDb, \r\nInc., or substantially all of its assets are acquired, user information \r\nwill of course be included in the transaction. </li>\r\n \r\n<li><b>Protection of IMDb and Others</b>: We release account and other \r\npersonal information when we believe release is appropriate to comply \r\nwith law; enforce or apply our <a href="http://www.imdb.com/terms">Terms and Conditions of Use</a>\r\n and other agreements; or protect the rights, property, or safety of \r\nIMDb, our users, or others. This includes exchanging information with \r\nother companies and organizations for fraud protection and credit risk \r\nreduction. Obviously, however, this does not include selling, renting, \r\nsharing, or otherwise disclosing personally identifiable information \r\nfrom customers for commercial purposes in violation of the commitments \r\nset forth in this Privacy Notice.</li>\r\n \r\n<li><b>With Your Consent</b>: Other than as set out above, you will \r\nalways receive notice when information about you might go to third \r\nparties, and you will have an opportunity to choose not to share the \r\ninformation.</li>\r\n \r\n</ul> \r\n<p><b>What About Third-Party Advertisers?</b></p>\r\n \r\n<p>Our site includes third-party advertising and links to other \r\nwebsites. We do not provide any personally identifiable customer \r\ninformation to these advertisers or third-party websites. </p>\r\n \r\n<p>These third-party websites and advertisers, or Internet advertising \r\ncompanies working on their behalf, sometimes use technology to send (or \r\n"serve") the advertisements that appear on our website directly to your \r\nbrowser. They automatically receive your IP address when this happens. \r\nThey may also use cookies, JavaScript, web beacons (also known as action\r\n tags or single-pixel gifs), and other technologies to measure the \r\neffectiveness of their ads and to personalize advertising content. We do\r\n not have access to or control over cookies or other features that they \r\nmay use, and the information practices of these advertisers and \r\nthird-party websites are not covered by this Privacy Notice. Please \r\ncontact them directly for more information about their privacy \r\npractices. In addition, the <a href="http://www.networkadvertising.org/">Network Advertising Initiative</a>\r\n offers useful information about Internet advertising companies (also \r\ncalled "ad networks" or "network advertisers"), including information \r\nabout how to opt-out of their information collection. </p>\r\n \r\n<p>IMDb also displays personalized third-party advertising based on \r\npersonal information about users, such as information you submit to us \r\nabout movies you own or have watched.&nbsp; <a href="http://www.imdb.com/privacy_info">Click here</a>\r\n for more information about the personal information that we gather. \r\nAlthough IMDb does not provide any personal information to advertisers, \r\nadvertisers (including ad-serving companies) may assume that users who \r\ninteract with or click on a personalized advertisement meet their \r\ncriteria to personalize the ad (for example, users in the northwestern \r\nUnited States who bought, watched, or browsed for romantic comedies). If\r\n you do not want us to use personal information that we gather to allow \r\nthird parties to personalize advertisements we display to you, please \r\nadjust your <a href="http://www.imdb.com/help/show_leaf?personalizedadvertisingsettings">Advertising Preferences</a>.</p>\r\n \r\n<p><b>How Secure Is Information About Me?</b></p>\r\n \r\n<p>If you use our subscription service, we work to protect the security \r\nof your subscription information during transmission by using Secure \r\nSockets Layer (SSL) software, which encrypts information you input. </p>\r\n \r\n<p>It is important for you to protect against unauthorized access to \r\nyour password and to your computer. Be sure to sign off when finished \r\nusing a shared computer.</p>\r\n \r\n<p><b>What Choices and Access Do I Have?</b></p>\r\n \r\n<ul type="disc"> \r\n<li>As discussed above, you can always choose not to provide \r\ninformation,\n even though it might be needed to take advantage of such \r\nIMDb features as My Movies and local show times. </li>\r\n \r\n<li>You can add or update certain information, such as your e-mail address, by using our <a href="http://www.imdb.com/register/">User Administration</a> pages. When you update information, we usually keep a copy of the prior version for our records. </li>\r\n \r\n<li>If you do not want to receive e-mail or other mail from us, please use our <a href="http://www.imdb.com/register/">User Administration</a>\r\n pages to adjust your preferences. (If you do not want to receive legal \r\nnotices from us, such as this Privacy Notice, those notices will still \r\ngovern your use of IMDb, and it is your responsibility to review them \r\nfor changes.) </li>\r\n \r\n<li>If you do not want us to use personal information that we gather to \r\nallow third parties to personalize advertisements we display to you, \r\nplease adjust your <a href="http://www.imdb.com/help/show_leaf?personalizedadvertisingsettings">Advertising Preferences</a>.</li>\r\n \r\n<li>The "help" portion of the toolbar on most browsers will tell you how\r\n to prevent your browser from accepting new cookies, how to have the \r\nbrowser notify you when you receive a new cookie, or how to disable \r\ncookies altogether. Additionally, you can disable or delete similar data\r\n used by browser add-ons, such as Flash cookies, by changing the \r\nadd-on''s settings or visiting the Web site of its manufacturer. However,\r\n because cookies allow you to take advantage of some of IMDb''s essential\r\n features, we recommend that you leave them turned on. </li>\r\n \r\n</ul> \r\n<p><b>Children</b></p>\r\n \r\n<p>IMDb is not intended for use by children under the age of 13. If you \r\nare under 13, you may not submit information about yourself to IMDb. </p>\r\n \r\n<p><b>Conditions of Use, Notices, and Revisions</b></p>\r\n \r\n<p>If you choose to visit IMDb, your visit and any dispute over privacy is subject to this Notice and our <a href="http://www.imdb.com/terms">Terms and Conditions of Use</a>,\r\n including limitations on damages, resolution of disputes, and \r\napplication of the law of the state of Washington. If you have any \r\nconcern about privacy at IMDb, please send us a thorough description to <a href="http://www.imdb.com/help/feedback/contact?target=1">our help desk</a>, and we will try to resolve it. Our business changes constantly. This Notice and the <a href="http://www.imdb.com/terms">Terms and Conditions of Use</a>\r\n will change also, and use of information that we gather now is subject \r\nto the Privacy Notice in effect at the time of use. We may e-mail \r\nperiodic reminders of our notices and conditions, unless you have \r\ninstructed us not to, but you should check our Web site frequently to \r\nsee recent changes. Unless stated otherwise, our current Privacy Notice \r\napplies to all information that we have about you and your \r\naccount.&nbsp; We stand behind the promises we make, however, and will \r\nnever materially change our policies and practices to make them less \r\nprotective of customer information collected in the past without the \r\nconsent of affected customers.</p>', '2012-04-08 00:00:00', 1);
INSERT INTO `cms` (`cms_id`, `cms_title`, `cms_page`, `cms_content`, `cms_updated_date`, `cms_status`) VALUES
(5, 'Terms', 'Terms', '<div id="content-body" class="terms clear-block body-text">\r\n<div class="body-title">\r\n<h1>Terms of Use</h1>\r\n</div>\r\n<p>This Terms of Use agreement was last updated: January 13th, 2012</p>\r\n<p>This Terms of Use agreement is effective as of: January 15th, 2009</p>\r\n<h3>A. Acceptance of Terms</h3>\r\n<p>PLEASE READ THE TERMS OF USE THOROUGHLY AND CAREFULLY. The terms and conditions set forth below ("Terms of Use") Use and the <a href="#">Privacy Policy</a>\r\n constitute a legally-binding agreement between Freelancer Clone, Inc., a Delaware corporation ("Freelancer Clone"), and you. These Terms of Use contain provisions that define your limits, legal rights and obligations with respect to your use of and participation in (i) the Freelancer Clone website, including the classified advertisements, forums, various email functions\r\n and Internet links, and all content and Freelancer Clone services available through the domain and sub-domains of Freelancer Clone located at www.Freelancer Clone.com (collectively referred to herein as the "Website"), and (ii) the online transactions between those users of the Website who are offering Services (each, a "service professional") and those users of the Website who are obtaining Services (each, a "Service User") through the Website (collectively, the "Services"). The Terms of Use described below incorporate the Privacy Policy and apply to all users of the Website, including users who are also contributors of video content, information, private and public messages, advertisements, and other materials or Services on the Website. <span class="annotation">These terms govern the relationship between you and Freelancer Clone, Inc., and between buyers and sellers on Freelancer Clone.<br />\r\n        <br />\r\n        Check out our privacy policy after you read this.</span></p>\r\n<p>You acknowledge that the Website serves as a venue for the online distribution and publication of user-submitted information between service professionals and Service Users, and, by using, visiting, registering for, and/or otherwise participating in this Website, including the Services presented, promoted, and displayed on the Website, and by clicking below on "I have read and agree to the Terms of Use and the Privacy Policy," you hereby certify that: (1) you are either a service professional or Service user, (2) you have the authority to enter into these Terms of Use, (3) you authorize the transfer of payment for Services requested through the use of the Website, and (4) as stated above, you agree to be bound by all terms and conditions of these Terms of Use and any other documents incorporated by reference herein. If you do not so agree to the foregoing, you should not click to affirm your acceptance thereof, in which case you are prohibited from accessing or using the Website. If you do not agree to any of the provisions set forth in the Terms of Use, kindly discontinue viewing or participating in this Website immediately. <span class="annotation">Freelancer Clone is meant to be a website where users can buy and sell services from one another.</span></p>\r\n<p>All references to "you" or "your," as applicable, mean the person that accesses, uses, and/or participates in the Website in any manner. If you use the Website or open an Account (as defined below) on behalf of a business, you represent and warrant that you have the authority to bind that business and your acceptance of the Terms of Use will be deemed an acceptance by that business and "you" and "your" herein shall refer to that business.<span class="annotation">You have been notified of these terms, and you accept them if you continue to use Freelancer Clone.<br />        <br />        If you''re posting for a business, you must have the authority from the business owner to do so.</span></p>\r\n<ol>\r\n<li>MODIFICATIONS TO TERMS OF USE AND/OR PRIVACY POLICY\r\n<p>Freelancer Clone reserves the right, in its sole discretion, to change, modify, or otherwise amend the Terms of Use, and any other documents incorporated by reference herein, at any time, and Freelancer Clone will post notice of the changes and the amended Terms of Use at the domain of <a href="#">Freelancer Clone</a>, and/or may communicate the amendments through any method of written contact that Freelancer Clone has established with you. It is your responsibility to review the Terms of Use for any changes. Your use of the Website following any amendment of the Terms of Use will signify your assent to and acceptance of any revised Terms of Use. If you do not agree to abide by these or any future Terms of Use, please do not use or access the Website</p>\r\n</li>\r\n<li>PRIVACY POLICY\r\n<p>Freelancer Clone has established a Privacy Policy that explains to users how their information is collected and used. The Privacy Policy is referenced above and hereby incorporated into the Terms of Use set forth herein. Your use of this Website is governed by the Privacy Policy.</p>\r\n<p>The Privacy Policy is located at: <a href="#">Freelancer Clone</a>.</p>\r\n<span class="annotation">Freelancer Clone may occasionally change these terms. If that happens, we will try to communicate the changes to you by email, and we will at least post the changes on this page.</span> </li>\r\n</ol>\r\n<h3>B. Membership and Accessibility</h3>\r\n<ol>\r\n<li>LICENSE TO ACCESS\r\n<p>Freelancer Clone has established a Privacy Policy that explains to users how their information is collected and used. The Privacy Policy is referenced above and hereby incorporated into the Terms of Use set forth herein. Your use of this Website is governed by the Privacy Policy.</p>\r\n<span class="annotation">You can use Freelancer Clone as long as you follow the rules, and don''t copy or change the website without our permission.</span> </li>\r\n<li>MEMBERSHIP ELIGIBILITY CRITERIA\r\n<p>Use of the Website is available only to individuals who are at least 18 years old and can form legally binding contracts under applicable law. You represent, acknowledge and agree that you are at least 18 years of age, and that: (a) all registration information that you submit is truthful and accurate, (b) you will maintain the accuracy of such information, and (c) your use of the Website and Services offered through this Website do not violate any applicable law or regulation.  Your Account (defined below) may be terminated without warning if we believe that you are under the age of 18 or that you are not complying with any applicable federal, state or local laws, rules or regulations.<span class="annotation">To use Freelancer Clone, you have to be 18, you have to submit truthful information, you can''t break any laws, you can''t ''scrape'' or collect user information from our site, you can''t recruit from our site for non-Freelancer Clone transactions, and you can''t spam our users.</span></p>\r\n<p>To access and participate in certain features of the Website, you will need to create a password-protected account ("Account"). You are solely responsible for safeguarding your password at all times and shall keep your password secure at all times. You shall be solely responsible for all activity that occurs on your Account and you shall notify Freelancer Clone immediately of any breach of security or any unauthorized use of your Account. Similarly, you shall never use another''s Account without permission.  You agree that you will not misrepresent yourself or represent your self as another user of the Website and/or the Services offered through the Website.  You hereby acknowledge and agree that Freelancer Clone will not be liable for your losses caused by an unauthorized use of your Account. Notwithstanding the foregoing, you may be liable for the losses of Freelancer Clone or others due to such unauthorized use. An Account holder is sometimes referred to herein as a "Registered User."<span class="annotation" style="top: 12em;">Keep\r\n your password safe, and let us know if someone breaches your account. We aren''t liable for problems that result from someone breaking into your account.</span></p>\r\n<p>You acknowledge and agree that you shall comply with the following policies (the "Account Policies"):</p>\r\n<ol>\r\n<li>You will not copy or distribute any part of the Website in any medium without Freelancer Clone''s prior written authorization.</li>\r\n<li>You will not alter or modify any part of the Website other than as may be reasonably necessary to use the Website for its intended purpose.</li>\r\n<li>You will provide accurate and complete information when creating your Account.</li>\r\n<li>You shall not use any automated system, including but not limited to, "robots," "spiders," "offline readers," "scrapers," etc., to access the Website for any purpose without Freelancer Clone''s prior written approval.</li>\r\n<li>You shall not in any manual or automated manner collect service professionals or Service Users information, including but not limited to, names, addresses, phone numbers, or email addresses, copying copyrighted text, or otherwise misuse or misappropriate Website information or content, including but not limited to, use on a "mirrored", competitive, or third party site.</li>\r\n<li>You shall not in any way that transmits more request messages to the Freelancer Clone servers, or any server of a Freelancer Clone subsidiary or affiliate, in a given period of time than a human can reasonably produce in the same period by using a conventional online web browser; provided, however, that the operators of public search engines may use spiders or robots to copy materials from the site for the sole purpose of creating publicly available searchable indices of the materials, but not caches or archives of such material. Freelancer Clone reserves the right to revoke these exceptions either generally or in specific cases.</li>\r\n<li>You shall not recruit, solicit, or contact\r\n in any form service professionals or Service Users for employment or contracting for a business not affiliated with Freelancer Clone without express written permission from Freelancer Clone. Should Freelancer Clone find that you violated the terms of this paragraph or any terms stated herein, Freelancer Clone reserves the right, at its sole discretion, to immediately terminate your use of the Website.</li>\r\n<li>You shall not take any action that (i) unreasonably encumbers or, in Freelancer Clone''s sole discretion, may unreasonably encumber the Website''s infrastructure; (ii) interferes or attempts to interfere with the proper working of the Website or any third-party participation in the Website; or (iii) bypasses Freelancer Clone''s measures that are used to prevent or restrict access to the Website.</li>\r\n<li>You agree not to collect or harvest any personally identifiable data, including without limitation, names or other Account information, from the Website, nor to use the communication systems provided by the Website for any commercial solicitation purposes.</li>\r\n</ol>\r\n<p>If you do not meet, or are unable to comply with, any of the above-referenced membership eligibility criteria or Account Policies, please do not use the Website. <span class="annotation">We can terminate your account if you violate these rules.</span></p>\r\n</li>\r\n<li>ADDITIONAL POLICIES\r\n<p>Your access to, use of, and participation in the Website is subject to the Terms of Use and all applicable Freelancer Clone regulations, guidelines and additional policies that Freelancer Clone may set forth from time to time, including without limitation, a copyright policy and any other restrictions or limitations that Freelancer Clone publishes on the Website (the "Additional Policies"). You hereby agree to comply with the Additional Policies and your obligations thereunder at all times. You hereby acknowledge and agree that if you fail to adhere to any of the terms and conditions of this Agreement or documents referenced herein, including the Account Policies, membership eligibility criteria or Additional Policies, Freelancer Clone, in its sole discretion, may terminate your Account at any time without prior notice to you.</p>\r\n</li>\r\n</ol>\r\n<h3>C. Member Conduct</h3>\r\n<ol>\r\n<li>PROHIBITIONS ON SUBMITTED CONTENT\r\n<p>You shall not upload, post, transmit, transfer, disseminate, distribute, or facilitate distribution of any content, including text, images, video, sound, data, information, or software, to any part of the Website, including your profile ("Profile"), the posting of your Service ("Offer"), the posting of your desired Service ("Want"), or the posting of any opinions or reviews ("Feedback") in connection with the Website, the Service, the service professional, or the Service User (all of the foregoing content is sometimes collectively referred to herein as "Submitted Content" and the posting of Submitted Content is sometimes referred to as a "Posting" or as "Postings") that: </p>\r\n<ul>\r\n<li>misrepresents the source of anything you post, including impersonation of another individual or entity or any false or inaccurate biographical information for any service professionals;</li>\r\n<li>provides or create links to external sites that violate the Terms of Use;</li>\r\n<li>is intended to harm or exploit any individual under the age of 18 ("Minor") in any way;</li>\r\n<li>is designed to solicit, or collect personally identifiable information of any Minor, including, but not limited to, name, email address, home address, phone number, or the name of his or her school;</li>\r\n<li>invades anyone''s privacy by attempting to harvest, collect, store, or publish private or personally identifiable information, such as names, email addresses, phone numbers, passwords, account information, credit card numbers, home addresses, or other contact information without their knowledge and willing consent;</li>\r\n<li>contains falsehoods or misrepresentations that could damage Freelancer Clone or any third party;</li>\r\n<li>is pornographic, harassing, hateful, illegal, obscene, defamatory, libelous, slanderous, threatening, discriminatory, racially, culturally or ethnically offensive; incites, advocates, or expresses pornography, obscenity, vulgarity, profanity, hatred, bigotry, racism, or gratuitous violence; encourages conduct that would be considered a criminal offense, give rise to civil liability or violate any law; promotes racism, hatred or physical harm of any kind against any group or individual; contains nudity, violence or inappropriate subject matter; or is otherwise inappropriate; <span class="annotation">Don''t use this website to launder money or advertise for services you aren''t offering here.</span></li>\r\n<li>is copyrighted, protected by trade secret or otherwise subject to third-party proprietary rights, including privacy and publicity rights, unless you are the owner of such rights or have permission from the rightful owner to post the material and to grant Freelancer Clone all of the license rights granted herein;</li>\r\n<li>contains or promotes an illegal or unauthorized copy of another person''s copyrighted work, such as pirated computer programs or links to them, information to circumvent manufacture-installed copy-protection devices, pirated music or links to pirated music files, or lyrics, guitar tabs or sheet music, works of art, teaching tools, or any other item the copy, display, use, performance, or distribution of which infringes on another''s copyright, intellectual property right, or any other proprietary right;</li>\r\n<li>is intended to threaten, stalk, defame, defraud, degrade, victimize, or intimidate an individual or group of individuals for any reason on the basis of age, gender, disability, ethnicity, sexual orientation, race, or religion; or to incite or encourage anyone else to do so;</li>\r\n<li>intends to harm or disrupt another user''s computer or would allow others to illegally access software or bypass security on websites or servers, including but not limited, to spamming;</li>\r\n<li>impersonates, uses the identity of, or attempts to impersonate a Freelancer Clone employee, agent, manager, host, another user, or any other person though any means;</li>\r\n<li>advertises or solicits a business not related to or appropriate for the Website (as determined by Freelancer Clone in its sole discretion);</li>\r\n<li>contains or could be considered "junk mail", "spam", "chain letters", "pyramid schemes", "affiliate marketing", or unsolicited commercial advertisement;</li>\r\n<li>contains advertising for ponzi schemes, discount cards, credit counseling, online surveys or online contests;</li>\r\n<li>distributes or contains viruses or any other \r\ntechnologies that may harm Freelancer Clone, or the interests or property of \r\nFreelancer Clone users;</li>\r\n<li>contains links to commercial services or websites, except as allowed pursuant to the Terms of Use;</li>\r\n<li>is non-local or irrelevant content;</li>\r\n<li>contains identical content to other open Postings you have already posted; or</li>\r\n<li>uses any form of automated device or computer \r\nprogram that enables the submission of Postings without the express \r\nwritten consent of Freelancer Clone.</li>\r\n</ul>\r\n<span class="annotation">Please don''t post anything that is \r\nfalse, is meant to contact minors, is meant to get personal information \r\nwithout the other person''s knowledge, violates copyright laws, is meant \r\nto harm someone else''s computer, or is pornographic, threatening, \r\ndiscriminatory, offensive, or generally inappropriate for or irrelevant \r\nto this site.</span> </li>\r\n<li>PROHIBITIONS ON SENDING MESSAGES\r\n<p>You will not send messages to other users containing: </p>\r\n<ul>\r\n<li>offers to make national or international money \r\ntransfers for amounts exceeding the asking price of a service, with \r\nintent to request a refund of any portion of the payment; or</li>\r\n<li>unsolicited advertising or marketing of a service not offered on the Website or an external website.</li>\r\n</ul>\r\n<span class="annotation">You have to pay for what you buy, and you have to provide the services that you''ve agreed to provide.</span> </li>\r\n<li>NO DISCRIMINATION\r\n            <ol>\r\n<li><strong>Employment Postings.</strong> Federal, state\r\n and local laws prohibit employment postings with any preference, \r\nlimitation or discrimination based on race, color, religion, sex, \r\nnational origin, age, handicap or other protected class. Freelancer Clone will \r\nnot knowingly accept any Posting for employment which is in violation of\r\n the law. Freelancer Clone has the right, in its sole discretion and without \r\nprior notice to you, to immediately remove any employment Posting that \r\ndiscriminates or is any way in violation of any federal, state, or local\r\n law.</li>\r\n<li><strong>Real Estate Postings.</strong> The Federal \r\nFair Housing Act of 1968 prohibits real estate postings with any \r\npreference, limitation or discrimination based on race, color, religion,\r\n sex, national origin, handicap or familial status or an intention to \r\nmake any such preference, limitation or discrimination. Freelancer Clone will \r\nnot knowingly accept any Posting for real estate which is in violation \r\nof the law.</li>\r\n</ol>\r\n            <span class="annotation">Posting discriminatory requests for employment or housing violates federal law.</span> </li>\r\n<li>PROHIBITIONS WITH RESPECT TO SERVICES\r\n<p>While using the Website, you shall not: </p>\r\n<ul>\r\n<li>post content or items in any inappropriate category or areas on the Website;</li>\r\n<li>violate any laws, third-party rights, Account \r\nPolicies, or any provision of the Terms of Use, such as the prohibitions\r\n described above;</li>\r\n<li>fail to deliver payment for Services purchased by \r\nyou, unless the service professional has materially changed the \r\ndescription\r\n of the Service description after you negotiate an agreement \r\nfor such Service, a clear typographical error is made, or you cannot \r\nauthenticate the service professional''s identity;</li>\r\n<li>fail to perform Services purchased from you, unless \r\nthe Service User fails to materially meet the terms of the mutually \r\nagreed upon agreement for the Services, refuses to pay, a clear \r\ntypographical error is made, or you cannot authenticate the Service \r\nUser''s identity;</li>\r\n<li>manipulate the price of any Service or interfere with other users'' Postings; <span class="annotation">Don''t try to manipulate your feedback rating.</span></li>\r\n<li>circumvent or manipulate our fee structure, the billing process, or fees owed to Freelancer Clone;</li>\r\n<li>post false, inaccurate, misleading, defamatory, or libelous content (including personal information about any Website user);</li>\r\n<li>take any action that may undermine the Feedback or \r\nratings systems (such as displaying, importing or exporting Feedback \r\ninformation off of the Website or using it for purposes unrelated to the\r\n Website);<span class="annotation">Be truthful in the feedback you post \r\nabout people. Don''t be meaner or nicer than the service professional \r\ndeserves. We will kick you off Freelancer Clone if you try to blackmail someone\r\n by threatening to give them bad feedback that isn''t deserved.</span></li>\r\n</ul>\r\n</li>\r\n<li>FEEDBACK\r\n<p>As a participant in the Website, you agree to use \r\ncareful, prudent, and good judgment when leaving Feedback for another \r\nuser. The following actions constitute inappropriate uses of Feedback: \r\n(a) threatening to leave negative or impartial Feedback for another user\r\n unless that user provides services not included in the original Posting\r\n or not agreed to as part of the Service to be provided; (b) leaving \r\nFeedback in order to make the service professional or Service User \r\nappear better than he or she actually is or was; and (c) including \r\nconditions in an Offer or Want that restrict a service professional or a\r\n Service User from leaving Feedback. </p>\r\n<ol>\r\n<li>Sanctions for Inappropriate Use of Feedback. If you \r\nviolate any of the above-referenced rules in connection with leaving \r\nFeedback, Freelancer Clone, in its sole discretion, may take any of the \r\nfollowing actions: (i) cancel your Feedback or any of your Postings; \r\n(ii) limit your Account privileges; (iii) suspend your Account; and/or \r\n(iv) decrease your status earned via the Feedback page.<span class="annotation">Let us know if you see inappropriate feedback. We can remove any feedback postings at our own discretion.</span></li>\r\n<li>Reporting Inappropriate Use of Feedback. You may contact Freelancer Clone regarding any inappropriate use of Feedback via-email at <a href="#">support@xxxxxxx.com</a>.</li>\r\n<li>Resolving Disputes in Connection with Feedback. In \r\nthe event of any dispute between users of the Website concerning \r\nFeedback, Freelancer Clone shall be the final arbiter of such dispute. Further,\r\n IN THE EVENT OF ANY DISPUTE BETWEEN USERS OF THE WEBSITE CONCERNING \r\nFEEDBACK, Freelancer Clone HAS THE RIGHT, IN ITS SOLE AND ABSOLUTE DISCRETION, \r\nTO REMOVE SUCH FEEDBACK OR TAKE ANY ACTION IT DEEMS REASONABLE WITHOUT \r\nINCURRING ANY LIABILITY THEREFOR. </li>\r\n</ol>\r\n        </li>\r\n</ol>\r\n<p>The foregoing lists of prohibitions provide examples and is not \r\ncomplete or exclusive. Freelancer Clone reserves the right to (a) terminate \r\nyour access to your Account, your ability to post to this Website (or \r\nthe Services) and (b) refuse, delete or remove, move or edit the \r\ncontent, in whole or in part, of any Postings; with or without cause and\r\n with or without notice, for any reason or no reason, or for any action \r\nthat Freelancer Clone determines is inappropriate or disruptive to this Website\r\n or to any other user of this Website and/or Services. Freelancer Clone \r\nreserves the right to restrict the number of e-mails or other messages \r\nthat you are allowed to send to other users to a number that Freelancer Clone \r\ndeems appropriate in Freelancer Clone''s sole discretion. Freelancer Clone may report \r\nto law enforcement authorities any actions that may be illegal, and any \r\nreports it receives of such conduct. When legally required or at \r\nFreelancer Clone''s discretion, Freelancer Clone will cooperate with law enforcement \r\nagencies in any investigation of alleged illegal activity on this \r\nWebsite or on the Internet. <strong>Freelancer Clone does not and cannot review\r\n every Posting posted to the Website. These prohibitions do not require \r\nFreelancer Clone to monitor, police or remove any Postings or other information\r\n submitted by you or any other user.</strong> <span class="annotation">Freelancer Clone is too big for us to monitor on our own, so we can''t guarantee we''ll remove every bad thing that people post here.</span></p>\r\n<h3>D. Rules for service professionals</h3>\r\n<ol>\r\n<li>PROFILES AND OFFERS MUST NOT BE FRAUDULENT\r\n<p>Subject to any exceptions set forth in these Terms of Use\r\n or Additional Policies, if any, service professionals shall not: (a) \r\nlist Services or offers relating to any Service in a category that is \r\ninappropriate to the Service they are offering; (b) misrepresent the \r\nlocation at which they will provide a Service; (c) include brand names \r\nor other inappropriate keywords in their Profile, Offer, Want, Feedback,\r\n or any other title or description relating to a Service; (d) use \r\nmisleading titles that do not accurately describe the Service; or (e) \r\ninclude any information in their Profile that is fraudulent.</p>\r\n<span class="annotation">We can limit or cancel your account if you violate any of these terms.</span> </li>\r\n<li>PROFILES AND OFFERS CANNOT USE TECHNIQUES TO AVOID OR CIRCUMVENT Freelancer Clone FEES\r\n<p>Subject to any exceptions set forth in these Terms of Use\r\n or Additional Policies, if any, service professionals shall not: (a) \r\noffer a catalog or a link to a third-party website from which Service \r\nUsers or any Registered User or user of the Website may obtain the \r\nService directly; (b) exceed multiple Posting limits; (c) post a single \r\nService but offer additional identical services in the Service \r\ndescription; (d) charge fees for traveling further than desired to \r\nprovide the Service; (e) offer the opportunity through Freelancer Clone to \r\npurchase the Service or any other service outside of Freelancer Clone; (f) use \r\ntheir Profile page or user name to promote services not offered on or \r\nthrough the Website and/or prohibited services.</p>\r\n</li>\r\n<li>PROFILES AND OFFERS MUST PROMOTE A FAIR PLAYING FIELD AND PROVIDE A SAFE, SIMPLE, AND POSITIVE EXPERIENCE FOR ALL WEBSITE USERS\r\n<p>Subject to any exceptions set forth in these Terms of Use\r\n or Additional Policies, if any, service professionals shall not: (a) \r\nsolicit Service Users to mail cash or use other payment methods not \r\nspecifically permitted by Freelancer Clone as approved payment methods; (b) \r\ninclude links that do not conform to Freelancer Clone''s policies with respect \r\nto third-party links; (c) use certain types of HTML and JavaScript in \r\nPostings, your Profile page, your Offer page, or your Wants page; (d) \r\npromote raffles, prizes, bonuses, games of chance, giveaways, or random \r\ndrawings; (e) use profanity in any Posting; (f) acknowledge or credit a \r\nthird-party service professional for services or products directly \r\nconnected with your particular Posting (1) with more than 10 words of \r\ntext at HTML font size greater than 3 and/or a logo of 88X33 pixels \r\n(provided that you represent and warrant that you have the necessary \r\nrights, licenses, permissions and/or authorizations from the applicable \r\nthird party to use that third party''s name and/or logo), (2) with any \r\npromotional material in connection with that third-party company, and/or\r\n (3) with a link to the third-party''s website with any information in \r\naddition to the Service provided via Freelancer Clone; (g) include third-party \r\nendorsements in a Posting; or (h) create a Posting that does not offer a\r\n Service.</p>\r\n</li>\r\n<li>SANCTIONS FOR VIOLATING ANY OF THE RULES FOR SERVICE PROFESSIONALS\r\n<p>If a service professional violates any of the \r\nabove-referenced rules in connection with his or her Posting, Freelancer Clone,\r\n in its sole discretion, may take any of the following actions: (a) \r\ncancel the Posting; (b) limit the service professional''s Account \r\nprivileges; (c) suspend the service professional''s Account; (d) cause \r\nthe service professional to forfeit any fees earned on a canceled \r\nPosting; and/or (e) decrease the service professional''s status earned \r\nvia the Feedback page.</p>\r\n<span class="annotation">Don''t contact a service \r\nprofessional unless you think you might actually use their service. Once\r\n you''ve agreed to a service and a price, don''t renege on your promise to\r\n pay.</span> </li>\r\n</ol>\r\n<h3>E. Rules for Service Users</h3>\r\n<ol>\r\n<li>SERVICE USERS SHALL NOT TAKE ANY OF THE FOLLOWING ACTIONS:\r\n<p>(a) commit to purchasing or using a Service without \r\npaying; (b) sign up for, negotiate a price for, use, or otherwise \r\nsolicit a Service with no intention of following through with your use \r\nof or payment for the Service; (c) agree to purchase a Service when you \r\ndo not meet the service professional''s terms as outlined in the Posting,\r\n or agree to purchase a Service with the intention of disrupting a \r\nPosting; or (d) misuse any options made available now or in the future \r\nby Freelancer Clone in connection with the use or purchase of any Service.</p>\r\n</li>\r\n<li>SANCTIONS FOR VIOLATING ANY OF THE RULES FOR SERVICE USERS\r\n<p>If a Service User violates any of the above-referenced\r\n \r\nrules in connection with his or her Posting, Freelancer Clone, in its sole \r\ndiscretion, may take any of the following actions: (a) cancel the \r\nPosting; (b) limit the Service User''s Account privileges; (c) suspend \r\nthe Service User''s Account; and/or (d) decrease the Service User''s \r\nstatus earned via the Feedback page.</p>\r\n</li>\r\n</ol>\r\n<h3>F. Use of Submitted Content</h3>\r\n<ol>\r\n<li>NO CONFIDENTIALITY\r\n<p>The Website may now or in the future permit the \r\nsubmission of videos or other communications submitted by you and other \r\nusers, including without limitation, your Profile, your Offer, your \r\nWants, any Feedback, and all Submitted Content, and the hosting, \r\nsharing, and/or publishing of such Submitted Content. You understand \r\nthat whether or not such Submitted Content is published, Freelancer Clone does \r\nnot guarantee any confidentiality with respect to any Submitted Content.<span class="annotation">We can''t guarantee the confidentiality of anything you post publicly.</span></p>\r\n<p>You agree that any Submitted Content provided by for \r\nwhich you authorize to be searchable by Registered Users who have access\r\n to the Website is provided on a non-proprietary and non-confidential \r\nbasis. You agree that Freelancer Clone shall be free to use or disseminate such\r\n freely searchable Submitted Content on an unrestricted basis for the \r\npurpose of providing the Services. <span class="annotation">You''re responsible for what you post.</span></p>\r\n</li>\r\n<li>YOUR REPRESENTATIONS AND WARRANTIES\r\n<p>You shall be solely responsible for your own Submitted \r\nContent and the consequences of posting or publishing it. In connection \r\nwith Submitted Content, you affirm, represent, and/or warrant that: (a) \r\nyou own or have the necessary licenses, rights, consents, and \r\npermissions to use and authorize Freelancer Clone to use all patent, trademark,\r\n trade secret, copyright or other proprietary rights in and to any and \r\nall Submitted Content to enable inclusion and use of the Submitted \r\nContent in the manner contemplated by the Website and these Terms of \r\nUse; and (b) you have the written consent, release, and/or permission of\r\n each and every identifiable individual person in the Submitted Content \r\nto use the name or likeness of each and every such identifiable \r\nindividual person to enable inclusion and use of the Submitted Content \r\nin the manner contemplated by the Website and these Terms of Use. You \r\nagree to pay for all royalties, fees, and any other monies owing any \r\nperson by reason of any Submitted Content posted by you to or through \r\nthe Website. <span class="annotation">Once you''ve posted information \r\npublicly on Freelancer Clone, we can display or advertise it in other places. \r\nIf you don''t want us to have access to your information anymore, just \r\ntake down your post.</span></p>\r\n</li>\r\n<li>YOUR OWNERSHIP RIGHTS AND LICENSE TO Freelancer Clone\r\n<p>You retain all of your ownership rights in your Submitted\r\n Content. However, by submitting the Submitted Content to Freelancer Clone for \r\nposting on the Website, you hereby grant, and you represent and warrant \r\nthat you have the right to grant, to Freelancer Clone a perpetual, worldwide, \r\nnon-exclusive, royalty-free, sublicenseable and transferable license to \r\nlink to, use, reproduce, distribute, reformat, translate, prepare \r\nderivative works of, display, and perform the Submitted Content in \r\nconnection with the Website and Freelancer Clone''s (and its successor''s) \r\nbusiness operations, including without limitation, for the promotion and\r\n redistribution of any part or all of the Website, and any derivative \r\nworks thereof, in any media formats and through any media channels. You \r\nalso hereby grant each user of the Website a non-exclusive license to \r\naccess your Submitted Content through the Website, and to use, \r\nreproduce, distribute, prepare derivative works of, display and perform \r\nsuch Submitted Content as permitted through the functionality of the \r\nWebsite and under these Terms of Use. The foregoing license granted by \r\nyou terminates once you remove or delete the Submitted Content from the \r\nWebsite.</p>\r\n<p>You acknowledge and understand that the technical \r\nprocessing and transmission of the Website, including your Submitted \r\nContent, may involve (a) transmissions over various networks; and (b) \r\nchanges to conform and adapt to technical requirements of connecting \r\nnetworks or devices. <span class="annotation">We are not liable for anything posted by Freelancer Clone''s users, and we can remove any user content on the website whenever we want.</span></p>\r\n<p>You may remove your Submitted Content from the Website at\r\n any time. If you choose to remove your Submitted Content, the license \r\ngranted above will automatically expire.</p>\r\n</li>\r\n<li>Freelancer Clone''S DISCLAIMERS AND RIGHT TO REMOVE\r\n            <ol>\r\n<li>Freelancer Clone does not endorse any Submitted Content or \r\nany opinion, recommendation, or advice expressed therein, and Freelancer Clone \r\nexpressly disclaims any and all liability in connection with all \r\nSubmitted Content. Freelancer Clone does not permit copyright infringing \r\nactivities and infringement of intellectual property rights on the \r\nWebsite, and Freelancer Clone will remove any Data (as defined below) or \r\nSubmitted Content if properly notified, pursuant to the "take down" \r\nnotification procedure described in Section G below, that such Posting \r\nor Submitted Content infringes on another''s intellectual property \r\nrights. Freelancer Clone reserves the right to remove any Data or Submitted \r\nContent without prior notice. Freelancer Clone will also terminate a user''s \r\naccess to the Website, if he or she is determined to be a repeat \r\ninfringer. A repeat infringer is a Website user who has been notified of\r\n infringing activity more than twice and/or has had Submitted Content \r\nremoved from the Website more than twice. Freelancer Clone also reserves the \r\nright, in its sole and absolute discretion, to decide whether any Data \r\nor Submitted Content is appropriate and complies with these Terms of Use\r\n for all violations, in addition to copyright infringement and \r\nviolations of intellectual property law, including, but not limited to, \r\npornography, obscene or defamatory material, or excessive length. \r\nFreelancer Clone may remove such Submitted Content and/or terminate a user''s \r\naccess for uploading such material in violation of these Terms of Use at\r\n any time, without prior notice and in its sole discretion. <span class="annotation">We''re\r\n sorry if you see something offensive on our site posted by another \r\nuser. However, what other people post is not our fault. Let us know \r\nabout it, and we''ll remove it.</span></li>\r\n<li>You acknowledge and understand that when using the \r\nWebsite, you will be exposed to Submitted Content from a variety of \r\nsources, and that Freelancer Clone is not responsible for the accuracy, \r\nusefulness, safety, or intellectual property rights of or relating to \r\nsuch Submitted Content. You further acknowledge and understand that you \r\nmay be exposed to Submitted Content that is inaccurate, offensive, \r\nindecent, or objectionable, and you agree to waive, and hereby do waive,\r\n any legal or equitable rights or remedies you have or may have against \r\nFreelancer Clone with respect thereto, and agree to indemnify and hold \r\nFreelancer Clone, its owners, members, managers, operators, directors, \r\nofficers, agents, affiliates, and/or licensors, harmless to the fullest \r\nextent allowed by law regarding all matters related to your use of the \r\nWebsite. <span class="annotation">Freelancer Clone will at times check to see \r\nif users come up in the DOJ Sex Offender registry. If you don''t want us \r\nto run a check using your name and zip code, don''t sign up.</span></li>\r\n<li>You are solely responsible for the photos, profiles \r\nand other content, including, without limitation, Submitted Content, \r\nthat you publish or display on or through the Website, or transmit to \r\nother Website users. You understand and agree that Freelancer Clone may, in its\r\n sole discretion and without incurring any liability, review and delete \r\nor remove any Submitted Content that violates this Agreement or which \r\nmight be offensive, illegal, or that might violate the rights, harm, or \r\nthreaten the safety of Website users or others.</li>\r\n</ol>\r\n        </li>\r\n</ol>\r\n<h3>G. Mandatory Third Party Verification Service</h3>\r\n<p>Freelancer Clone uses a variety of tools in an effort to make our \r\nwebsite as safe as possible for service professionals and Service Users.\r\n Among these tools are mandatory searches for all users in the \r\nDepartment of Justice''s "Dru Sjodin National Sex Offender Public \r\nWebsite" ("DOJ SMART Screen"). Do not register as a user on Freelancer Clone if\r\n you do not want Freelancer Clone to search for you in the DOJ Smart Screen. By\r\n requesting to use, registering to use, and/or using Freelancer Clone, you \r\nrepresent and warrant that you and each member of your household have \r\nnot been and are not currently required to register as a sex offender \r\nwith any government entity.</p>\r\n<p>By registering as a user on the Website, you do hereby consent to\r\n allow Freelancer Clone to perform the DOJ SMART Screen using information you \r\nprovide, and you understand that Freelancer Clone may review the information \r\nprovided by the third-party verification service. You hereby authorize \r\nFreelancer Clone to verify your representations and warranties herein, and you \r\nacknowledge that Freelancer Clone reserves the right, but not the obligation, \r\nto verify such representations and warranties and to take action it \r\ndeems appropriate in its sole discretion. You agree to indemnify and \r\nhold harmless Freelancer Clone from any\r\n loss or liability that may result from \r\nthe DOJ Smart Screen. In addition, you do hereby represent, understand \r\nand expressly agree that Freelancer Clone offers this third-party verification \r\nservice as a convenience and does not have control over or assume any \r\nresponsibility for the quality, accuracy, or reliability of the \r\nthird-party verification service and/or the information provided by the \r\nthird-party verification service. Freelancer Clone retains the right to \r\nterminate your Freelancer Clone membership based on the information provided by\r\n this third party verification service. <span class="annotation">If you \r\nwant, we can use a third-party verification service to verify your \r\nidentity, credentials, and other public records. We charge for this \r\nextra service. The service helps you because it shows other users that \r\nyou''re who you say you are. We can''t guarantee the accuracy of the \r\ninformation we collect from these third-party sources.</span></p>\r\n<h3>H. Optional Third Party Verifcation Services</h3>\r\n<p>Freelancer Clone uses a variety of tools in an effort to make our \r\nwebsite as safe as possible for service professionals and Service Users.\r\n Among these tools are optional name verification, address verification,\r\n social security number verification, and criminal background checks for\r\n service professionals. Freelancer Clone uses PayPal.com to perform name and \r\naddress verification and Acxiom Information Security Services to verify \r\nsocial security numbers and perform criminal background checks.</p>\r\n<p>Freelancer Clone also seeks to allow service professionals to showcase \r\ntheir professional license credentials. Freelancer Clone has created a \r\nproprietary database of licenses from all 50 states and many national \r\norganizations that facilitates the verification of the professional \r\nlicense credentials of service professionals. It is a violation of these\r\n Terms of Use to use the state and national licensure weblinks compiled \r\nby Freelancer Clone for any reason other than to verify the licensing \r\ninformation of service professionals listed on Freelancer Clone.</p>\r\n<p>Freelancer Clone may make these or other third-party verification \r\nservices available to service professionals and Service Users. service \r\nprofessionals and Service Users may use these services to verify \r\ninformation such as, but not limited to, name, address, social security \r\nnumber, criminal background, and professional license credentials. By \r\nrequesting to use, registering to use, and/or using the Site, you \r\nrepresent and warrant that you and each member of your household have \r\nnever been the subject of a complaint, restraining order or any other \r\nlegal action involving, arrested for, charged with, or convicted of any \r\nfelony, any criminal offense involving violence, abuse, neglect, fraud \r\nor larceny, or any offense that involves endangering the safety of \r\nothers. You hereby authorize Freelancer Clone to verify your representations \r\nand warranties herein, and you acknowledge that Freelancer Clone reserves the \r\nright, but not the obligation, to verify such representations and \r\nwarranties and to take action it deems appropriate in its sole \r\ndiscretion.</p>\r\n<p>Use of the optional third-party verification services is \r\nvoluntary. If you decide to use or access information provided by a \r\nthird-party verification service offered through the Website, you do \r\nhereby represent, understand and expressly agree that Freelancer Clone offers \r\nthis third-party verification service as a convenience and does not have\r\n control over or assume any responsibility for the quality, accuracy, or\r\n reliability of the third-party verification service and/or the \r\ninformation provided by the third-party verification service. In \r\naddition, you understand that Freelancer Clone may review the information \r\nprovided by the third-party verification service and that Freelancer Clone \r\nretains the right to terminate your Freelancer Clone membership based on the \r\ninformation. You affirm that all of the information you provide to \r\nFreelancer Clone as part of these third-party verification services is correct,\r\n complete, and applicable to you.</p>\r\n<p>service professionals may choose whether to make the information \r\nobtained from third-party verification services public on the Freelancer Clone.\r\n If you decide to share any information from a third-party verification \r\nservice publicly, you understand that the information in the report may \r\nfactor into other party''s decisions to engage you as a service \r\nprofessional. You agree to indemnify and hold harmless Freelancer Clone from \r\nany loss or liability that may result from your sharing this report \r\npublicly.</p>\r\n<h3>I. Fair Credit Reporting Act</h3>\r\n<p>Pursuant to the Fair Credit Reporting Act (the "FCRA"), by this \r\nnotice Freelancer Clone, Inc. notifies you that it may, as part of your use of a\r\n third-party verification service, obtain a consumer report about you \r\nfrom a consumer reporting agency. Consumer reports may contain \r\ninformation on your character, general reputation, personal \r\ncharacteristics, and mode of living, including but not limited to \r\nconsumer credit, criminal history, workers'' compensation, driving, \r\nemployment, military, civil, and educational data and reports. If you \r\ndecide to use or access information provided by a third-party \r\nverification service offered through the Site, you warrant that you will\r\n comply with the FCRA, which can be found at <a href="http://www.ftc.gov/os/statutes/fcrajump.shtm">http://www.ftc.gov/os/statutes/fcrajump.shtm</a>,\r\n and all other applicable consumer reporting laws. If you decide to \r\naccess, use, or share information provided by a third-party verification\r\n service offered through the Site with any other party (either through \r\nthis Site or otherwise), you agree to do so in accordance with \r\napplicable law and to indemnify and hold Freelancer Clone harmless from any \r\nloss, liability, damage, or costs that may result from such access, use,\r\n or sharing of this information regardless of the cause. Freelancer Clone does \r\nnot assume and expressly disclaims any liability that may result from \r\nthe use of information provided by a third-party verification service. <span class="annotation">You\r\n have a number of rights, and we have a number of obligations, regarding\r\n the handling of any personal information that you authorize us to \r\ncollect from third-party verification services. The Fair Credit \r\nReporting Act dictates these rights and obligations. We will comply with\r\n all of our obligations, and you are free to exercise your rights, under\r\n this law.</span></p>\r\n<h3>J. Copyright Infringement Take Down Procedure</h3>\r\n<p>Pursuant to the Digital Millennium Copyright Act of 1998 \r\n("DMCA"), Freelancer Clone has established policies for dealing with alleged \r\nand actual copyright and trademark infringement. If you believe that \r\nyour work has been copied and posted on the Website in a way that \r\nconstitutes copyright infringement and/or trademark infringement, please\r\n send the following information to our Copyright Agent (see 17 U.S.C. &szlig; \r\n512(c)(3) for further detail): (i) identification of the copyrighted \r\nand/or trademarked work claimed to have been infringed, or, if multiple \r\nworks at a single online site are covered by a single notification, a \r\nrepresentative list of such works at that site; (ii) identification of \r\nthe material that is claimed to be infringing or to be the subject of \r\ninfringing activity and that is to be removed or access to which is to \r\nbe disabled at the Website, and information reasonably sufficient to \r\npermit Freelancer Clone to locate the material.; (iii) a written statement that\r\n you have a good faith belief that the disputed use is not authorized by\r\n the copyright and/or trademark owner, its agent, or the law; (iv) \r\ninformation reasonably sufficient to permit Freelancer Clone to contact you as \r\nthe complaining party, such as an address, telephone number, and, if \r\navailable, an electronic mail address at which you may be contacted; (v)\r\n an electronic or physical signature of the person authorized to act on \r\nbehalf of the owner of an exclusive interest that is allegedly \r\ninfringed; and (vi) a statement by you, made under penalty of perjury, \r\nthat the information in your report is accurate and that you are the \r\nowner of the exclusive right or authorized to act on the behalf of the \r\nowner of the exclusive right. A statement by you comprised of the \r\nforegoing points is referred to herein as the "Notice." <span class="annotation">If\r\n you think your copyright or trademark is being infringed on Freelancer Clone, \r\nplease follow these procedures to notify us about it. We''ll try to help \r\nyou solve the problem.</span></p>\r\n<p>Freelancer Clone''s designated Copyright Agent to receive Notice of \r\nclaimed infringement is: Alexander Daniels, who can be contacted as \r\nfollows via: mail: 1001 Page Street, Suite #45, San Francisco, CA 94117;\r\n e-mail: <a href="mailto:dmca@Freelancer Clone.com">dmca@Freelancer Clone.com</a>; \r\ntelephone: 888-560-7962; fax: 415 738 8329. For clarity, only DMCA \r\nnotices should go to the Copyright Agent; any other feedback, comments, \r\nrequests for technical support, and other communications should be \r\ndirected to Freelancer Clone customer service via e-mail at <a href="mailto:support@Freelancer Clone.com">support@Freelancer Clone.com</a>.</p>\r\n<p>You acknowledge that if you fail to comply with all of the \r\nrequirements, your Notice may not be valid. Freelancer Clone will remove any \r\ninfringing material, subject to the procedures outlined in the DMCA. \r\nNotwithstanding Freelancer Clone''s instructions above, you are solely \r\nresponsible for ensuring that any Notice you provide to Freelancer Clone \r\ncomplies\r\n with the provisions of the DMCA.</p>\r\n<p>Please also note that for copyright infringements under Section \r\n512(f) of the Copyright Act, any person who knowingly materially \r\nmisrepresents that material or activity is infringing may be subject to \r\nliability.</p>\r\n<em>Only the intellectual property rights owner is permitted to \r\nreport potentially infringing items through Freelancer Clone''s reporting system\r\n set forth above.  If you are not the intellectual property rights \r\nowner, you should contact the intellectual property rights owner and \r\nthey can choose whether to use the procedures set forth in these Terms \r\nof Use.</em>\r\n<h3>K. Modifications to or Termination of Website</h3>\r\n<ol>\r\n<li>MODIFICATION OR CESSATION OF WEBSITE\r\n<p>Freelancer Clone reserves the right at any time and from time to\r\n time to modify or discontinue, temporarily or permanently, the Website \r\n(or any part thereof) with or without notice and in its sole discretion.\r\n You agree that Freelancer Clone shall not be liable to you or to any third \r\nparty for any modification, suspension or discontinuance of Freelancer Clone \r\nservices.</p>\r\n<span class="annotation">We will modify Freelancer Clone frequently in order to improve it.</span> </li>\r\n<li>TERMINATION BY Freelancer Clone\r\n<p>You hereby acknowledge and agree that Freelancer Clone, in its \r\nsole and absolute discretion, has the right (but not the obligation) to \r\ndelete, terminate, or deactivate your Account, block your email or IP \r\naddress, cancel the Website or otherwise terminate your access to or \r\nparticipation in the use of the Website (or any part thereof), or remove\r\n and discard any Submitted Content on the Website ("Termination of \r\nService"), immediately and without notice, for any reason, including \r\nwithout limitation, Account inactivity or if Freelancer Clone believes or has \r\nreason to believe that you have violated any provision of the Terms of \r\nUse.</p>\r\n<span class="annotation">You or we can cancel your account at any time, and we aren''t liable for any problems arising from your account''s cancellation.</span> </li>\r\n<li>TERMINATION BY YOU\r\n<p>You may cancel your use of the Website and/or terminate \r\nthe Terms of Use with or without cause at any time by following the link\r\n in your Account under "Account Preferences" to "Deactivate Account."</p>\r\n</li>\r\n<li>EFFECT OF TERMINATION\r\n<p>Upon termination of your Account, your right to \r\nparticipate in the Website, including, but not limited to, your right to\r\n offer or purchase Services and your right to receive any fees or \r\ncompensation, including, without limitation, referral discounts, \r\nincentive bonuses, or other special offer rewards, shall automatically \r\nterminate. You acknowledge and agree that your right to receive any fees\r\n or compensation hereunder is conditional upon your proper use of the \r\nWebsite, your adherence to the Terms of Use, the continuous activation \r\nof your Account, and your permitted participation in the Website. In the\r\n event of Termination of Service, your Account will be disabled and you \r\nmay not be granted access to your Account or any files or other data \r\ncontained in your Account. Notwithstanding the foregoing, residual data \r\nmay remain in the Freelancer Clone system. <span class="annotation">We own everything we have produced for Freelancer Clone.com, and nobody else can use it without our permission.</span></p>\r\n<p>Unless Freelancer Clone has previously canceled or terminated \r\nyour use of the Website (in which case subsequent notice by Freelancer Clone \r\nshall not be required), if you provided a valid email address during \r\nregistration, Freelancer Clone will notify you via email of any such \r\ntermination or cancellation, which shall be effective immediately upon \r\nFreelancer Clone''s delivery of such notice.</p>\r\n<p>Upon Termination of Service, the following shall occur: \r\nall licenses granted to you hereunder will immediately terminate; and \r\nyou shall promptly destroy all copies of Freelancer Clone Data (as defined \r\nbelow), Marks (as defined below) and other content in your possession or\r\n control. You further acknowledge and agree that Freelancer Clone shall not be \r\nliable to you or any third party for any termination of your access to \r\nthe Website. Upon Termination of Service, Freelancer Clone retains the right to\r\n use any data collected from your use of the Website for internal \r\nanalysis and archival purposes, and all related licenses you have \r\ngranted Freelancer Clone hereunder shall remain in effect for the foregoing \r\npurpose. In no event is Freelancer Clone obligated to return any Submitted \r\nContent to you. Sections H, K, L, O, P, Q, S, T, and U (including the \r\nsection regarding limitation of liability), shall survive expiration or \r\ntermination of the Website or your Account. </p>\r\n<p>You agree to indemnify and hold Freelancer Clone, and its \r\nofficers, managers, members, affiliates, successor, assigns, directors, \r\nagents, service professionals, suppliers, and employees harmless from \r\nany claim or demand, including reasonable attorneys'' fees and court \r\ncosts, made by any third party due to or arising out of the Termination \r\nof Service.</p>\r\n</li>\r\n</ol>\r\n<h3>L. Intellectual Property Rights</h3>\r\n<ol>\r\n<li>Freelancer Clone OWNS OR HOLDS THE LICENSES TO ALL DATA AND MARKS ON THE WEBSITE\r\n<p>The content on the Website (exclusive of all Submitted \r\nContent), including without limitation, the text, software, scripts, \r\ngraphics, photos, sounds, music, videos, interactive features and the \r\nlike ("Data") and the trademarks, service marks and logos contained \r\ntherein ("Marks"), are owned by Freelancer Clone, subject to copyright and \r\nother intellectual property rights under United States and foreign laws \r\nand international conventions. Other trademarks, names and logos on this\r\n Website are the property of their respective owners.</p>\r\n<p>Data on the Website is provided to you AS IS for your \r\ninformation and personal use only and may not be used, copied, \r\nreproduced, distributed, transmitted, broadcast, displayed, sold, \r\nlicensed, or otherwise exploited for any other purposes whatsoever \r\nwithout the prior written consent of the respective owners. Freelancer Clone \r\nreserves all rights not expressly granted in and to the Website and the \r\nData. You agree not to use, copy, or distribute, any of the Data other \r\nthan as expressly permitted herein, including any use, copying, or \r\ndistribution of Submitted Content obtained through the Website for any \r\ncommercial purposes. If you download or print a copy of the Data for \r\npersonal use, you must retain all copyright and other proprietary \r\nnotices contained thereon. You agree not to circumvent, disable or \r\notherwise interfere with security features of the Website or features \r\nthat prevent or restrict use or copying of any Data or enforce \r\nlimitations on use of the Website or the Data therein.</p>\r\n</li>\r\n<li>Freelancer Clone''S LICENSE TO YOU FOR THE USE OF DATA AND MARKS\r\n<p>The Website contains Freelancer Clone''s Data and Marks, which \r\nare, or may become, protected by copyright, trademark, patent, trade \r\nsecret and other laws, and Freelancer Clone owns and retains all rights in the \r\nFreelancer Clone Data and Marks. Subject to these Terms of Use, Freelancer Clone \r\nhereby grants you a limited, revocable, nontransferable, \r\nnonsublicensable license to reproduce and display the Freelancer Clone Data \r\n(excluding any software source code) solely for your personal use in \r\nconnection with accessing and participating in the Website.</p>\r\n<p>The Website may also contain Data of other users or \r\nlicensors, which you shall not copy, modify, translate, publish, \r\nbroadcast, transmit, distribute, perform, display, or sell.</p>\r\n<p>Freelancer Clone may authorize you to use an "Embeddable Player"\r\n feature, which you may incorporate into your own personal, \r\nnon-commercial websites for use in accessing the materials on the \r\nWebsite; provided, however, that you provide a link back to the Website \r\non any pages that contain the Embeddable Player. Freelancer Clone reserves the \r\nright to discontinue any aspect of the Website at any time.</p>\r\n</li>\r\n</ol>\r\n<h3>M.Freelancer Clone Fees</h3>\r\n<ol>\r\n<li>FEES INCURRED BY SERVICE PROFESSIONALS\r\n<p>Joining Freelancer Clone, posting Services and viewing posted \r\nServices is free. Freelancer Clone reserves the right at its sole discretion to\r\n charge fees to service professionals for other services that Freelancer Clone \r\nmay provide, including but not limited to fees for contacting Service \r\nUsers, responding to job leads generated by Freelancer Clone, or conducting \r\ntransactions with Service Users through Freelancer Clone.<span class="annotation" style="top: -50px;">Freelancer Clone\r\n offers service professionals leads for new clients on an opt-in basis. \r\nYou only pay for what you want! You can read more about the benefits of \r\nlisting on Freelancer Clone <a href="#">here</a> and more about the leads program <a href="#">here</a>.\r\n In the future, Freelancer Clone may also offer premium services, such as tax \r\npreparation and bookkeeping, and we reserve the right to charge for \r\nthese premium services.</span></p>\r\n<p>Freelancer Clone may in the future offer additional premium \r\nservices, like tax preparation and bookkeeping, that service \r\nprofessionals can also choose to purchase. Freelancer Clone reserves the right \r\nto charge fees for these services at its sole discretion.</p>\r\n</li>\r\n<li>FEES INCURRED BY SERVICE USERS\r\n<p>Joining Freelancer Clone, viewing posted Services, and bidding \r\non posted Services is free. Freelancer Clone currently charges Service Users no\r\n fees for transactions completed on the Website between Service Users \r\nand Services service professionals. However, Freelancer Clone reserves the\r\n \r\nright to charge a fee to Service Users in the future on a \r\nper-transaction basis, and reserves the right to do so in its sole \r\ndiscretion. Changes to this Fee Policy are effective after Freelancer Clone has\r\n provided you with fourteen (14) days'' notice by posting the changes on \r\nthe Website. <span class="annotation">Freelancer Clone currently charges no \r\nfees to consumers. Freelancer Clone may at some point charge a small fee to \r\nconsumers for using Freelancer Clone.</span></p>\r\n</li>\r\n<li>TAXES\r\n<p>You understand that we are acting solely as an \r\nintermediary for the collection of rents and fees between a Service User\r\n and a service professional who choose to enter into an Agreement for \r\nService. Because state and local tax laws vary significantly by \r\nlocality, you understand and agree that you are solely responsible for \r\ndetermining your own tax reporting requirements in consultation with tax\r\n advisors, and that we cannot and do not offer tax advice to either \r\nhosts or guests. <span class="annotation">You have to pay your taxes for\r\n any income you receive in transactions resulting from using Freelancer Clone. \r\nWe are not liable for your nonpayment of taxes.</span></p>\r\n</li>\r\n<li>REFUND POLICY\r\n<p>All sales on Freelancer Clone are final and non-refundable</p>\r\n</li>\r\n</ol>\r\n<h3>N. Negotiation of Terms of Service; Disputes Between Registered Users</h3>\r\n<ol>\r\n<li>NEGOTIATION WORKSHEET AND CONTRACT TEMPLATE\r\n<p>As a courtesy to Registered Users, to facilitate the \r\nnegotiation and confirmation of the Agreement for Service, Freelancer Clone \r\nprovides a general framework for negotiating the terms of Service (e.g.,\r\n rate) ("Negotiation Worksheet"). Registered Users acknowledge and agree\r\n that (i) they are solely responsible for addressing all issues that \r\nexist now or may arise in the future in connection with the applicable \r\nService; and (ii) it is solely up to such Registered Users, if they so \r\ndesire, to enter into a signed, written contract, that addresses all of \r\nthe relevant issues and memorializes the agreed upon Negotiation \r\nWorksheet. <span class="annotation">We try to facilitate transactions on\r\n Freelancer Clone by providing template agreements between buyers and sellers. \r\nThese templates, however, are only suggestions, and we are not liable \r\nfor any problems arising from using our templates.</span></p>\r\n<p>You should not rely on the any information or resources \r\ncontained on the Website, including, without limitation, the Negotiation\r\n Worksheet, as a replacement or substitute for any professional, \r\nfinancial, legal or other advice or counsel. Freelancer Clone makes no \r\nrepresentations and warranties, and expressly disclaims any and all \r\nliability, concerning actions taken by a user following the information \r\nor using the resources offered or provided on or through the Websites, \r\nincluding, without limitation, the Negotiation Worksheet. In no way will\r\n Freelancer Clone be responsible for any actions taken or not taken based on \r\nthe information or resources provided on this Website.  If you have a \r\nsituation that requires professional advice, you should consult a \r\nqualified specialist. Do not disregard, avoid or delay obtaining \r\nprofessional advice from a qualified specialist because of information \r\nor resources that are provided on this Website, however provided.</p>\r\n</li>\r\n<li>Freelancer Clone IS NOT A PARTY TO ANY SERVICE CONTRACT\r\n<p>Each Registered User hereby acknowledges and agrees that \r\nFreelancer Clone is NOT a party to any oral or written Agreement for Service, \r\nNegotiation Worksheet, or any contract entered into between Registered \r\nUsers in connection with any Service offered, directly or indirectly, \r\nthrough the Website.</p>\r\n<span class="annotation">Freelancer Clone is just an intermediary between buyers and sellers, and we are not a party to any contract between website users.</span> </li>\r\n<li>NO AGENCY OR PARTNERSHIP\r\n<p>No agency, partnership, joint venture, or employment is \r\ncreated as a result of the Terms of Use or your use of any part of the \r\nWebsite, including without limitation, the Negotiation Worksheet or \r\nAgreement for Service. You do not have any authority whatsoever to bind \r\nFreelancer Clone in any respect. All service professionals are independent \r\ncontractors. Neither Freelancer Clone nor any users of the Website may direct \r\nor control the day-to-day activities of the other, or create or assume \r\nany obligation on behalf of the other. <span class="annotation">Freelancer Clone is not employing you, or partnering with you in any kind of business venture.</span></p>\r\n</li>\r\n<li>DISPUTES BETWEEN REGISTERED USERS\r\n<p>Subject to the provisions regarding disputes between \r\nWebsite participants in connection with Feedback (referred to above in \r\nSection 5), your interactions with individuals and/or organizations \r\nfound on or through the Website, including payment of and performance of\r\n any Service, and any other terms, conditions, warranties or \r\nrepresentations associated with such transactions or dealings, are \r\nsolely between you and such individual or organization. You should take \r\nreasonable precautions and make whatever investigation or inquiries you \r\ndeem necessary or appropriate before proceeding with any online or \r\noffline transaction with any third party, including without limitation, \r\nservice professionals and Service Users. <span class="annotation">You \r\nshould try to investigate the trustworthiness of anyone with whom you \r\nplan to contract. If there''s a dispute between you and another Freelancer Clone\r\n user, we have no obligation to get involved. We aren''t liable for any \r\nproblems arising from these disputes.</span></p>\r\n<p>You understand that deciding whether to use the Services \r\nof a service professional or provide Services to a Service User or use \r\ninformation contained in any Submitted Content, including, without \r\nlimitation, Postings, Offers, Wants and/or Feedback, is your personal \r\ndecision for which alone are responsible. You understand that Freelancer Clone \r\ndoes not and cannot make representations as to the suitability of any \r\nindividual you may decide to interact with on or through the Website \r\nand/or the accuracy or suitability of any advice, information, or \r\nrecommendations made by any individual.</p>\r\n<p>NOTWITHSTANDING THE FOREGOING, YOU AGREE THAT Freelancer Clone \r\nSHALL NOT BE RESPONSIBLE OR LIABLE FOR ANY LOSS OR DAMAGE OF ANY SORT \r\nWHATSOEVER INC', '2012-12-30 13:35:11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `cmt_id` int(10) NOT NULL AUTO_INCREMENT,
  `cmt_prj_id` int(11) NOT NULL,
  `cmt_usr_id` int(10) NOT NULL,
  `cmt_text` text NOT NULL,
  `cmt_updated_date` date NOT NULL,
  PRIMARY KEY (`cmt_id`),
  UNIQUE KEY `comment_id` (`cmt_id`),
  UNIQUE KEY `comment_id_2` (`cmt_id`),
  UNIQUE KEY `comment_id_3` (`cmt_id`),
  UNIQUE KEY `comment_id_4` (`cmt_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`cmt_id`, `cmt_prj_id`, `cmt_usr_id`, `cmt_text`, `cmt_updated_date`) VALUES
(1, 2, 4, 'grt', date_add(NOW(),INTERVAL -25 DAY)),
(2, 2, 1, 'sample message for this eCommerce project', date_add(NOW(),INTERVAL -25 DAY)),
(3, 2, 4, 'grt', date_add(NOW(),INTERVAL -25 DAY)),
(4, 2, 1, 'sample message for this eCommerce project', date_add(NOW(),INTERVAL -25 DAY)),
(5, 2, 1, 'sample message for this eCommerce project', date_add(NOW(),INTERVAL -25 DAY)),
(6, 2, 4, 'sadasdsa', date_add(NOW(),INTERVAL -25 DAY)),
(7, 2, 1, 'sample message for this eCommerce project', date_add(NOW(),INTERVAL -25 DAY)),
(8, 2, 1, 'sample message for this eCommerce project', date_add(NOW(),INTERVAL -25 DAY)),
(9, 2, 1, 'sample message for this eCommerce project', date_add(NOW(),INTERVAL -25 DAY)),
(10, 2, 1, 'sample message for this eCommerce project', date_add(NOW(),INTERVAL -25 DAY)),
(11, 2, 1, 'sample message for this eCommerce project', date_add(NOW(),INTERVAL -25 DAY)),
(12, 2, 1, 'sample message for this eCommerce project', date_add(NOW(),INTERVAL -25 DAY)),
(13, 2, 1, 'sample message for this eCommerce project', date_add(NOW(),INTERVAL -25 DAY)),
(14, 2, 1, 'sample message for this eCommerce project', date_add(NOW(),INTERVAL -25 DAY)),
(15, 2, 1, 'sample message for this eCommerce project', date_add(NOW(),INTERVAL -25 DAY)),
(16, 2, 1, 'sample hfgidto oituyoit ruyotryot uyot uoytryotuyoityiotruyio', date_add(NOW(),INTERVAL -20 DAY)),
(17, 2, 1, 'wwwwwwwwwww', date_add(NOW(),INTERVAL -18 DAY)),
(18, 2, 1, 'new message', date_add(NOW(),INTERVAL -18 DAY)),
(19, 2, 1, 'new message 2', date_add(NOW(),INTERVAL -16 DAY)),
(20, 5, 1, 'sample description', date_add(NOW(),INTERVAL -15 DAY)),
(21, 5, 1, 'yiuyi', date_add(NOW(),INTERVAL -14 DAY)),
(22, 5, 1, 'test message', date_add(NOW(),INTERVAL -14 DAY)),
(23, 5, 1, 'sample message', date_add(NOW(),INTERVAL -12 DAY)),
(24, 5, 1, 'aaaaaaaaaaaaaaa', date_add(NOW(),INTERVAL -12 DAY)),
(25, 5, 1, 'bbbbbbbbbbbbbbbbb', date_add(NOW(),INTERVAL -10 DAY)),
(26, 5, 1, 'ccccccccccccc', date_add(NOW(),INTERVAL -10 DAY)),
(27, 5, 1, 'dddd', date_add(NOW(),INTERVAL -9 DAY)),
(28, 5, 1, 'eeee', date_add(NOW(),INTERVAL -9 DAY)),
(29, 5, 1, 'commentss', date_add(NOW(),INTERVAL -8 DAY)),
(30, 5, 3, 'uyuyu', date_add(NOW(),INTERVAL -7 DAY)),
(31, 5, 3, 'rtrtr', date_add(NOW(),INTERVAL -7 DAY)),
(32, 40, 13, 'gfhfghgfhgfhgfh', date_add(NOW(),INTERVAL -6 DAY)),
(33, 40, 13, '', date_add(NOW(),INTERVAL -6 DAY)),
(38, 54, 1, 'sdsdsr', date_add(NOW(),INTERVAL -6 DAY)),
(39, 43, 13, 'test', date_add(NOW(),INTERVAL -5 DAY)),
(40, 43, 13, 'sample review', date_add(NOW(),INTERVAL -4 DAY));

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
CREATE TABLE `contact_us` (
  `cu_id` int(11) NOT NULL AUTO_INCREMENT,
  `cu_fname` varchar(100) NOT NULL,
  `cu_lname` varchar(100) NOT NULL,
  `cu_email` varchar(100) NOT NULL,
  `cu_contactnumber` varchar(50) NOT NULL,
  `cu_comments` text NOT NULL,
  `cu_updated_date` datetime NOT NULL,
  `cu_status` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`cu_id`, `cu_fname`, `cu_lname`, `cu_email`, `cu_contactnumber`, `cu_comments`, `cu_updated_date`, `cu_status`) VALUES
(1, 'Abcd', 'Xyz', 'abcd@wwww.com', '8574856985', 'Sample comment', date_add(NOW(),INTERVAL -5 DAY), 1);

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `cn_id` int(11) NOT NULL AUTO_INCREMENT,
  `cn_name` varchar(100) NOT NULL,
  `cn_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cn_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=253 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`cn_id`, `cn_name`, `cn_status`) VALUES
(5, 'Andorra', 1),
(4, 'American Samoa', 1),
(3, 'Algeria', 1),
(2, 'Albania', 1),
(1, 'Afghanistan', 1),
(6, 'Angola', 1),
(7, 'Anguilla', 1),
(8, 'Antarctica', 1),
(9, 'Antigua and Barbuda', 1),
(10, 'Argentina', 1),
(11, 'Armenia', 1),
(12, 'Armenia', 1),
(13, 'Aruba', 1),
(14, 'Australia', 1),
(15, 'Austria', 1),
(16, 'Azerbaijan', 1),
(17, 'Azerbaijan', 1),
(18, 'Bahamas', 1),
(19, 'Bahrain', 1),
(20, 'Bangladesh', 1),
(21, 'Barbados', 1),
(22, 'Belarus', 1),
(23, 'Belgium', 1),
(24, 'Belize', 1),
(25, 'Benin', 1),
(26, 'Bermuda', 1),
(27, 'Bhutan', 1),
(28, 'Bolivia', 1),
(29, 'Bosnia and Herzegovina', 1),
(30, 'Botswana', 1),
(31, 'Bouvet Island', 1),
(32, 'Brazil', 1),
(33, 'British Indian Ocean Territory', 1),
(34, 'Brunei Darussalam', 1),
(35, 'Bulgaria', 1),
(36, 'Burkina Faso', 1),
(37, 'Burundi', 1),
(38, 'Cambodia', 1),
(39, 'Cameroon', 1),
(40, 'Canada', 1),
(41, 'Cape Verde', 1),
(42, 'Cayman Islands', 1),
(43, 'Central African Republic', 1),
(44, 'Chad', 1),
(45, 'Chile', 1),
(46, 'China', 1),
(47, 'Christmas Island', 1),
(48, 'Cocos (Keeling) Islands', 1),
(49, 'Colombia', 1),
(50, 'Comoros', 1),
(51, 'Congo', 1),
(52, 'Congo, The Democratic Republic of The', 1),
(53, 'Cook Islands', 1),
(54, 'Costa Rica', 1),
(55, 'Cote D''ivoire', 1),
(56, 'Croatia', 1),
(57, 'Cuba', 1),
(58, 'Cyprus', 1),
(59, 'Cyprus', 1),
(60, 'Czech Republic', 1),
(61, 'Denmark', 1),
(62, 'Djibouti', 1),
(63, 'Dominica', 1),
(64, 'Dominican Republic', 1),
(65, 'Easter Island', 1),
(66, 'Ecuador', 1),
(67, 'Egypt', 1),
(68, 'El Salvador', 1),
(69, 'Equatorial Guinea', 1),
(70, 'Eritrea', 1),
(71, 'Estonia', 1),
(72, 'Ethiopia', 1),
(73, 'Falkland Islands (Malvinas)', 1),
(74, 'Faroe Islands', 1),
(75, 'Fiji', 1),
(76, 'Finland', 1),
(77, 'France', 1),
(78, 'French Guiana', 1),
(79, 'French Polynesia', 1),
(80, 'French Southern Territories', 1),
(81, 'Gabon', 1),
(82, 'Gambia', 1),
(83, 'Georgia', 1),
(84, 'Georgia', 1),
(85, 'Germany', 1),
(86, 'Ghana', 1),
(87, 'Gibraltar', 1),
(88, 'Greece', 1),
(89, 'Greenland', 1),
(90, 'Greenland', 1),
(91, 'Grenada', 1),
(92, 'Guadeloupe', 1),
(93, 'Guam', 1),
(94, 'Guatemala', 1),
(95, 'Guinea', 1),
(96, 'Guinea-bissau', 1),
(97, 'Guyana', 1),
(98, 'Haiti', 1),
(99, 'Heard Island and Mcdonald Islands', 1),
(100, 'Honduras', 1),
(101, 'Hong Kong', 1),
(102, 'Hungary', 1),
(103, 'Iceland', 1),
(104, 'India', 1),
(105, 'Indonesia', 1),
(106, 'Indonesia', 1),
(107, 'Iran', 1),
(108, 'Iraq', 1),
(109, 'Ireland', 1),
(110, 'Israel', 1),
(111, 'Italy', 1),
(112, 'Jamaica', 1),
(113, 'Japan', 1),
(114, 'Jordan', 1),
(115, 'Kazakhstan', 1),
(116, 'Kazakhstan', 1),
(117, 'Kenya', 1),
(118, 'Kiribati', 1),
(119, 'Korea, North', 1),
(120, 'Korea, South', 1),
(121, 'Kosovo', 1),
(122, 'Kuwait', 1),
(123, 'Kyrgyzstan', 1),
(124, 'Laos', 1),
(125, 'Latvia', 1),
(126, 'Lebanon', 1),
(127, 'Lesotho', 1),
(128, 'Liberia', 1),
(129, 'Libyan Arab Jamahiriya', 1),
(130, 'Liechtenstein', 1),
(131, 'Lithuania', 1),
(132, 'Luxembourg', 1),
(133, 'Macau', 1),
(134, 'Macedonia', 1),
(135, 'Madagascar', 1),
(136, 'Malawi', 1),
(137, 'Malaysia', 1),
(138, 'Maldives', 1),
(139, 'Mali', 1),
(140, 'Malta', 1),
(141, 'Marshall Islands', 1),
(142, 'Martinique', 1),
(143, 'Mauritania', 1),
(144, 'Mauritius', 1),
(145, 'Mayotte', 1),
(146, 'Mexico', 1),
(147, 'Micronesia, Federated States of', 1),
(148, 'Moldova, Republic of', 1),
(149, 'Monaco', 1),
(150, 'Mongolia', 1),
(151, 'Montenegro', 1),
(152, 'Montserrat', 1),
(153, 'Morocco', 1),
(154, 'Mozambique', 1),
(155, 'Myanmar', 1),
(156, 'Namibia', 1),
(157, 'Nauru', 1),
(158, 'Nepal', 1),
(159, 'Netherlands', 1),
(160, 'Netherlands Antilles', 1),
(161, 'New Caledonia', 1),
(162, 'New Zealand', 1),
(163, 'Nicaragua', 1),
(164, 'Niger', 1),
(165, 'Nigeria', 1),
(166, 'Niue', 1),
(167, 'Norfolk Island', 1),
(168, 'Northern Mariana Islands', 1),
(169, 'Norway', 1),
(170, 'Oman', 1),
(171, 'Pakistan', 1),
(172, 'Palau', 1),
(173, 'Palestinian Territory', 1),
(174, 'Panama', 1),
(175, 'Papua New Guinea', 1),
(176, 'Paraguay', 1),
(177, 'Peru', 1),
(178, 'Philippines', 1),
(179, 'Pitcairn', 1),
(180, 'Poland', 1),
(181, 'Portugal', 1),
(182, 'Puerto Rico', 1),
(183, 'Qatar', 1),
(184, 'Reunion', 1),
(185, 'Romania', 1),
(186, 'Russia', 1),
(187, 'Russia', 1),
(188, 'Rwanda', 1),
(189, 'Saint Helena', 1),
(190, 'Saint Kitts and Nevis', 1),
(191, 'Saint Lucia', 1),
(192, 'Saint Pierre and Miquelon', 1),
(193, 'Saint Vincent and The Grenadines', 1),
(194, 'Samoa', 1),
(195, 'San Marino', 1),
(196, 'Sao Tome and Principe', 1),
(197, 'Saudi Arabia', 1),
(198, 'Senegal', 1),
(199, 'Serbia and Montenegro', 1),
(200, 'Seychelles', 1),
(201, 'Sierra Leone', 1),
(202, 'Singapore', 1),
(203, 'Slovakia', 1),
(204, 'Slovenia', 1),
(205, 'Solomon Islands', 1),
(206, 'Somalia', 1),
(207, 'South Africa', 1),
(209, 'Spain', 1),
(210, 'Sri Lanka', 1),
(211, 'Sudan', 1),
(212, 'Suriname', 1),
(213, 'Svalbard and Jan Mayen', 1),
(214, 'Swaziland', 1),
(215, 'Sweden', 1),
(216, 'Switzerland', 1),
(217, 'Syria', 1),
(218, 'Taiwan', 1),
(219, 'Tajikistan', 1),
(220, 'Tanzania, United Republic of', 1),
(221, 'Thailand', 1),
(222, 'Timor-leste', 1),
(223, 'Togo', 1),
(224, 'Tokelau', 1),
(225, 'Tonga', 1),
(226, 'Trinidad and Tobago', 1),
(227, 'Tunisia', 1),
(228, 'Turkey', 1),
(229, 'Turkey', 1),
(230, 'Turkmenistan', 1),
(231, 'Turks and Caicos Islands', 1),
(232, 'Tuvalu', 1),
(233, 'Uganda', 1),
(234, 'Ukraine', 1),
(235, 'United Arab Emirates', 1),
(236, 'United Kingdom', 1),
(237, 'United States', 1),
(238, 'United States Minor Outlying Islands', 1),
(239, 'Uruguay', 1),
(240, 'Uzbekistan', 1),
(241, 'Vanuatu', 1),
(242, 'Vatican City', 1),
(243, 'Venezuela', 1),
(244, 'Vietnam', 1),
(245, 'Virgin Islands, British', 1),
(246, 'Virgin Islands, U.S.', 1),
(247, 'Wallis and Futuna', 1),
(248, 'Western Sahara', 1),
(249, 'Yemen', 1),
(250, 'Yemen', 1),
(251, 'Zambia', 1),
(252, 'Zimbabwe', 1);

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
CREATE TABLE `currency` (
  `cr_id` int(10) NOT NULL AUTO_INCREMENT,
  `cr_name` varchar(255) NOT NULL,
  `cr_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`cr_id`, `cr_name`, `cr_status`) VALUES
(1, 'INR', 1),
(2, 'USD', 1),
(3, 'EUR', 1),
(4, 'CAD', 1);

-- --------------------------------------------------------

--
-- Table structure for table `custom_faq`
--

DROP TABLE IF EXISTS `custom_faq`;
CREATE TABLE `custom_faq` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `cat_id` int(50) NOT NULL,
  `heading` text NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `custom_faq`
--

INSERT INTO `custom_faq` (`id`, `cat_id`, `heading`, `content`) VALUES
(1, 1, 'How do I submit a bid?', 'Before placing your first bid, we recommend reading "10 Tips for Writing an Effective Bid". When you find a project you''d like to bid on, simply click on the "Bid on This Project" button at the top or bottom of the bid listing to access the bid form for the project. Enter your bid amount, the number of days for delivery, and any necessary details, then click the "Place Bid" button. Follow up with a Private Message to provide more information or upload samples.'),
(3, 1, 'Is there a fee for bidding?', 'No. You can bid for free regardless of your membership level. Instead, you get a specific number of bids each month (your bid limit), which you can use to bid for work on Freelancer.com. Your bid limit depends on the type of membership you have.'),
(5, 2, 'Which identity proofs are accepted?', 'If you are an Indian Citizen you can use your Voter ID card, Driving License, Ration card or Passport, and your Visa/Passport if you are a Non-Resident/Foreign National.'),
(6, 3, 'What are cancellation policies for Holiday Packages ?', 'Cancellation Period&nbsp; Percentage of Cancellation :<br /><br />&nbsp;&nbsp;&nbsp; From booking date till 15 days prior to departure - 30 % of Package Cost<br />&nbsp;&nbsp;&nbsp; 7 Days prior to departure&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - 50% of Package Cost<br />&nbsp;&nbsp;&nbsp; 3 to 7 Days prior to departure&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - 75 % of Package Cost<br />&nbsp;&nbsp;&nbsp; Less than 24 hrs to 3 Days prior to departure&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - 100% of Package Cost<br /><br />'),
(4, 1, 'How can I change the date of my flight booking?', 'Date Change may be permissible on your booking on payment of Airline Date Change Fee, Service Charges plus any fare difference that may exist between your original fare and the fare of the flight that you want to change to. The date change fees and Service Charges are printed on your E-Ticket. In several cases, the date change fees and the cancellation fees levied by the airline is the same and you could also cancel the ticket online and make a fresh booking at the same cost as that of doing a date change. Please note that date change may not be permitted on certain tickets. <br /><br />You would need to get in touch with our Customer Care helpline to do any change of flights in your booking.<br /><br />If you want to change your flight to a flight that is operated by another airline, you will need to cancel your existing booking and make a fresh booking. Please visit our Customer Support section to cancel your booking online. Our online cancellation service lets you cancel a part of your booking by selecting the passengers and sectors you wish to cancel or cancel your complete booking in quick time.'),
(7, 4, 'Can I use my card to make a booking in someone else''s name?', 'Yes, you can, but do make sure that under ''Traveller Name'' you mention the name of the person who will be traveling. You are required to enter your name and your billing address while on the Payment Page.'),
(8, 4, 'I want to book online but donâ€™t have any credit or debit cards. Can I still book online?', 'You can still book your hotel online through Cash Cards, available in various denominations at many merchant establishments all over the country.'),
(9, 5, 'What happens if I am not carrying a copy of my E-Ticket to the airport?', 'If you fail to carry a printout of your E-Ticket, you will need to go to the airline counter at the airport and request for an E-Ticket copy by providing the PNR number of your reservation. The PNR number ( You can find this unique number on the top&nbsp; of your E-ticket.).');

-- --------------------------------------------------------

--
-- Table structure for table `deposit_fund`
--

DROP TABLE IF EXISTS `deposit_fund`;
CREATE TABLE `deposit_fund` (
  `df_id` int(10) NOT NULL AUTO_INCREMENT,
  `df_method` varchar(255) NOT NULL,
  `df_usr_id` int(10) NOT NULL,
  `df_amount` double(10,2) NOT NULL,
  `df_paydate` date NOT NULL,
  `df_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`df_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `deposit_fund`
--

INSERT INTO `deposit_fund` (`df_id`, `df_method`, `df_usr_id`, `df_amount`, `df_paydate`, `df_status`) VALUES
(1, 'paypal', 1, 100.00, date_add(NOW(),INTERVAL -16 DAY), 1),
(2, 'paypal', 4, 98.05, date_add(NOW(),INTERVAL -15 DAY), 1),
(3, 'moneybookers', 4, 10006.00, date_add(NOW(),INTERVAL -10 DAY), 1),
(4, 'webmoney', 4, 515151.00, date_add(NOW(),INTERVAL -8 DAY), 1),
(5, 'paypal', 5, 8989.00, date_add(NOW(),INTERVAL -5 DAY), 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_setting`
--

DROP TABLE IF EXISTS `email_setting`;
CREATE TABLE `email_setting` (
  `es_id` int(10) NOT NULL AUTO_INCREMENT,
  `es_option` text NOT NULL,
  `es_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`es_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `email_setting`
--

INSERT INTO `email_setting` (`es_id`, `es_option`, `es_status`) VALUES
(1, 'Your bid for a project is successful and you are chosen by the buyer', 1),
(2, 'You receive a new private message.', 1),
(3, 'When employer disputes a project.', 1),
(4, 'You receive notifications from the Freelancer.in Marketplace.', 1),
(5, 'We notify you of the top bidder for your project(s)', 1),
(6, 'When a project gets posted that is relevant to me', 1),
(7, 'News and announcements from the Freelancer.in team are available', 1);

-- --------------------------------------------------------

--
-- Table structure for table `escrow`
--

DROP TABLE IF EXISTS `escrow`;
CREATE TABLE `escrow` (
  `es_id` int(10) NOT NULL AUTO_INCREMENT,
  `es_tr_id` int(10) NOT NULL,
  `es_to_id` int(10) NOT NULL,
  `es_from_id` int(10) NOT NULL,
  `es_prj_id` int(10) NOT NULL,
  `es_amount` double(10,2) NOT NULL,
  `es_updated_date` date NOT NULL,
  `es_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`es_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `escrow`
--

INSERT INTO `escrow` (`es_id`, `es_tr_id`, `es_to_id`, `es_from_id`, `es_prj_id`, `es_amount`, `es_updated_date`, `es_status`) VALUES
(1, 20, 9, 1, 35, 200.00, date_add(NOW(),INTERVAL -25 DAY), 0),
(2, 23, 9, 1, 36, 250.00, date_add(NOW(),INTERVAL -22 DAY), 0),
(3, 26, 9, 1, 37, 20.00, date_add(NOW(),INTERVAL -20 DAY), 0),
(4, 27, 9, 1, 37, 10.00, date_add(NOW(),INTERVAL -16 DAY), 0),
(5, 53, 13, 1, 43, 10.00, date_add(NOW(),INTERVAL -12 DAY), 0),
(9, 64, 13, 1, 43, 20.00, date_add(NOW(),INTERVAL -10 DAY), 0),
(8, 63, 13, 1, 43, 20.00, date_add(NOW(),INTERVAL -8 DAY), 0),
(10, 65, 13, 1, 43, 20.00, date_add(NOW(),INTERVAL -6 DAY), 0),
(11, 66, 13, 1, 43, 15.00, date_add(NOW(),INTERVAL -5 DAY), 0);

-- --------------------------------------------------------

--
-- Table structure for table `faq_categories`
--

DROP TABLE IF EXISTS `faq_categories`;
CREATE TABLE `faq_categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `faq_categories`
--

INSERT INTO `faq_categories` (`id`, `category`) VALUES
(1, 'Freelancers - Bidding'),
(2, 'Hotel Booking'),
(3, 'Holiday Booking'),
(4, 'Payments'),
(5, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `fb_id` int(10) NOT NULL AUTO_INCREMENT,
  `fb_sender_id` int(10) NOT NULL,
  `fb_recv_id` int(10) NOT NULL,
  `fb_rate` int(10) NOT NULL,
  `fb_prj_id` int(10) NOT NULL,
  `fb_message` text NOT NULL,
  `fb_updated_date` date NOT NULL,
  `fb_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`fb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `feedback`
--


-- --------------------------------------------------------

--
-- Table structure for table `following`
--

DROP TABLE IF EXISTS `following`;
CREATE TABLE `following` (
  `flw_id` int(10) NOT NULL AUTO_INCREMENT,
  `flw_followed` int(10) NOT NULL,
  `flw_followed_by` int(10) NOT NULL,
  `flw_updated_date` date NOT NULL,
  `flw_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`flw_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `following`
--

INSERT INTO `following` (`flw_id`, `flw_followed`, `flw_followed_by`, `flw_updated_date`, `flw_status`) VALUES
(1, 4, 1, date_add(NOW(),INTERVAL -10 DAY), 1);

-- --------------------------------------------------------

--
-- Table structure for table `invited_user`
--

DROP TABLE IF EXISTS `invited_user`;
CREATE TABLE `invited_user` (
  `iu_id` int(11) NOT NULL AUTO_INCREMENT,
  `iu_usr_id` int(11) NOT NULL,
  `iu_prj_id` int(11) NOT NULL,
  `iu_updated_date` date NOT NULL,
  `iu_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`iu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `invited_user`
--

INSERT INTO `invited_user` (`iu_id`, `iu_usr_id`, `iu_prj_id`, `iu_updated_date`, `iu_status`) VALUES
(1, 1, 14, date_add(NOW(),INTERVAL -30 DAY), 1),
(2, 10, 60, date_add(NOW(),INTERVAL -10 DAY), 1),
(3, 11, 60, date_add(NOW(),INTERVAL -5 DAY), 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice` (
  `inv_id` int(10) NOT NULL AUTO_INCREMENT,
  `inv_usr_id` int(10) NOT NULL,
  `inv_prj_id` int(10) NOT NULL,
  `inv_amount` double(10,2) NOT NULL,
  `inv_creation_date` date NOT NULL,
  `inv_payment_status` int(1) NOT NULL DEFAULT '0',
  `inv_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`inv_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`inv_id`, `inv_usr_id`, `inv_prj_id`, `inv_amount`, `inv_creation_date`, `inv_payment_status`, `inv_status`) VALUES
(1, 2, 13, 100.00, date_add(NOW(),INTERVAL -5 DAY), 1, 1),
(2, 2, 13, 150.00, date_add(NOW(),INTERVAL -2 DAY), 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `membership_plan`
--

DROP TABLE IF EXISTS `membership_plan`;
CREATE TABLE `membership_plan` (
  `mp_id` int(10) NOT NULL AUTO_INCREMENT,
  `mp_name` varchar(255) NOT NULL,
  `mp_rate` double(10,2) NOT NULL,
  `mp_freelancerfee` int(3) NOT NULL,
  `mp_employerfee` int(3) NOT NULL,
  `mp_bidspermonth` int(10) NOT NULL,
  `mp_skills` int(10) NOT NULL,
  `mp_portfoliosize` int(10) NOT NULL,
  `mp_image` varchar(255) NOT NULL,
  `mp_updated_date` date NOT NULL,
  `mp_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`mp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `membership_plan`
--

INSERT INTO `membership_plan` (`mp_id`, `mp_name`, `mp_rate`, `mp_freelancerfee`, `mp_employerfee`, `mp_bidspermonth`, `mp_skills`, `mp_portfoliosize`, `mp_image`, `mp_updated_date`, `mp_status`) VALUES
(1, 'Free', 0.00, 5, 4, 5, 5, 1, '', '2012-10-30', 1),
(2, 'Standard', 5.95, 4, 3, 10, 10, 2, '', '2012-10-30', 1),
(3, 'Premium', 10.95, 2, 2, 10, 15, 2, 'mp4140premium.png', '2012-11-07', 1),
(4, 'premium', 49.95, 3, 0, 250, 50, 10, '', '2012-12-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `msg_id` int(255) NOT NULL AUTO_INCREMENT,
  `msg_from` int(255) NOT NULL,
  `msg_to` int(10) DEFAULT NULL,
  `msg_prj_id` int(255) NOT NULL,
  `msg_message` text NOT NULL,
  `msg_file` varchar(255) DEFAULT NULL,
  `msg_read` int(1) NOT NULL DEFAULT '0',
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `msg_date` datetime NOT NULL,
  `msg_to_status` int(1) NOT NULL DEFAULT '1',
  `msg_from_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`msg_id`),
  UNIQUE KEY `id` (`msg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`msg_id`, `msg_from`, `msg_to`, `msg_prj_id`, `msg_message`, `msg_file`, `msg_read`, `email`, `phone`, `msg_date`, `msg_to_status`, `msg_from_status`) VALUES
(1, 1, 2, 2, 'Hello,\r\nThanks for your bid.', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -42 DAY), 1, 1),
(2, 2, 1, 2, 'you are most welcome', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -42 DAY), 1, 1),
(3, 1, 4, 2, 'hello, sample message', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -42 DAY), 1, 1),
(4, 1, 9, 37, 'hello, sample message', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -42 DAY), 1, 0),
(5, 9, 1, 37, 'hello, reply', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -42 DAY), 1, 1),
(6, 9, 1, 37, 'fdugoitu toiuytoiuoyti uptyouiytpouiytpoui', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -42 DAY), 1, 1),
(7, 1, 9, 37, 'tyujouiytiou', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -41 DAY), 1, 1),
(8, 9, 0, 39, 'test pvt message', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -41 DAY), 1, 1),
(9, 9, 1, 39, 'sample private message', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -41 DAY), 0, 1),
(10, 1, 9, 37, '', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -40 DAY), 1, 1),
(11, 1, 9, 37, '', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -40 DAY), 1, 1),
(12, 1, 9, 37, '', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -40 DAY), 1, 1),
(13, 1, 9, 37, '', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -40 DAY), 1, 1),
(14, 1, 9, 37, '', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -40 DAY), 1, 1),
(15, 1, 9, 37, 'reply message ', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -39 DAY), 1, 1),
(16, 1, 9, 37, 'aaa', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -39 DAY), 1, 1),
(17, 1, 9, 37, 'ret er ert', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -38 DAY), 1, 1),
(18, 1, 9, 37, 'ret er ert', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -38 DAY), 1, 1),
(19, 1, 9, 37, 'werwe wer wer', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -38 DAY), 1, 1),
(20, 1, 9, 37, 'werwe wer wer', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -38 DAY), 1, 1),
(21, 1, 9, 37, 'dfuoit yrty urtyourtoyu oy utrioyurt', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -37 DAY), 1, 1),
(22, 1, 9, 37, 'dfuoit yrty urtyourtoyu oy utrioyurt', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -37 DAY), 1, 1),
(23, 9, 1, 37, 'test.....', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -37 DAY), 1, 1),
(24, 1, 9, 37, 'qqqqqqqqqqqqqqq', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -36 DAY), 1, 1),
(25, 1, 9, 37, 'qqqqqqqqq..qqqqqqqqqq', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -36 DAY), 1, 1),
(26, 1, 9, 37, '....tttt', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -36 DAY), 1, 1),
(27, 1, 9, 37, 'qqqqqqqqqqqqqqqq', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -36 DAY), 1, 1),
(28, 1, 9, 37, 'wwwwwww', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -36 DAY), 1, 1),
(29, 1, 9, 37, 'wwwwwwwwwwwqqqqqqqqqqqqqq', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -36 DAY), 1, 1),
(30, 1, 9, 37, 'p9utyuuuuuuuuuuuuuuuuu', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -36 DAY), 1, 1),
(31, 1, 9, 37, 'fjgoidfuj  tiypt7utyu', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -35 DAY), 1, 1),
(32, 1, 9, 37, 'uyfdguir iurttuoytr7y67', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -35 DAY), 1, 1),
(33, 1, 9, 37, 'dshforu t9ruytrytry', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -35 DAY), 1, 1),
(34, 2, 1, 2, 'gdfgdfg dfg dfg', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -35 DAY), 0, 1),
(35, 9, 1, 37, 'tfry rtytry', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -35 DAY), 1, 1),
(36, 9, 1, 37, 'tfry rtytry', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -35 DAY), 1, 1),
(37, 9, 1, 37, 'tfry rtytry', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -32 DAY), 1, 1),
(38, 9, 1, 37, 'tfry rtytry', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -30 DAY), 1, 1),
(39, 9, 1, 37, 'tfry rtytry', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -28 DAY), 0, 1),
(40, 9, 1, 37, 'tfry rtytry', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -27 DAY), 1, 1),
(41, 9, 1, 37, '111111111111', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -26 DAY), 1, 1),
(42, 9, 1, 37, '22222222222', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -26 DAY), 1, 1),
(43, 13, 1, 45, 'sdasasadasd', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -25 DAY), 1, 0),
(44, 1, 14, 51, 'tr rty rt yrty', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -25 DAY), 1, 1),
(45, 1, 16, 54, 'fduigy iufdyguy orio jrtyutuy', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -24 DAY), 1, 1),
(46, 1, 16, 54, 'wwwwww wwwwwwwwwwwww', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -22 DAY), 1, 1),
(47, 1, 16, 54, 'test message', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -22 DAY), 1, 1),
(48, 1, 16, 54, 'ryrtyrt rty', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -20 DAY), 1, 1),
(49, 16, 1, 54, 'test message', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -20 DAY), 1, 1),
(50, 1, 16, 54, 'sample test message for edit bid', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -18 DAY), 1, 1),
(51, 1, 4, 2, 'sample message after new design', 'msg-9611application-5b8e71d097ed002077b0c64d718cb367.css', 0, NULL, NULL, date_add(NOW(),INTERVAL -18 DAY), 1, 1),
(52, 1, 13, 45, 'sample reply message from new design 1', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -16 DAY), 1, 1),
(53, 1, 16, 54, '', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -15 DAY), 1, 1),
(54, 1, 13, 43, 'sample message for attachment testing', 'msg-7664Lighthouse.jpg', 1, NULL, NULL, date_add(NOW(),INTERVAL -12 DAY), 0, 1),
(56, 1, 9, 37, 'abcdefgh', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -12 DAY), 1, 1),
(55, 13, 1, 43, 'sample reply message', NULL, 1, NULL, NULL, date_add(NOW(),INTERVAL -12 DAY), 1, 1),
(57, 1, 13, 45, 'wderiurui iojogihyjoit', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -10 DAY), 1, 1),
(58, 1, 9, 37, 'new testttt message', 'msg-3907Tulips.jpg', 0, NULL, NULL, date_add(NOW(),INTERVAL -10 DAY), 1, 1),
(59, 1, 13, 43, 'qqqq', 'msg-4044Hydrangeas.jpg', 0, NULL, NULL, date_add(NOW(),INTERVAL -8 DAY), 1, 1),
(60, 1, 13, 43, 'ee', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -6 DAY), 1, 1),
(61, 1, 9, 37, 'testttttttttttttttttttt', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -5 DAY), 1, 1),
(62, 1, 13, 43, 'hiukkl kkbjiuo', 'msg-8562Penguins.jpg', 0, NULL, NULL, date_add(NOW(),INTERVAL -4 DAY), 1, 1),
(63, 1, 13, 43, 'aa', 'msg-1442Hydrangeas.jpg', 0, NULL, NULL, date_add(NOW(),INTERVAL -4 DAY), 1, 1),
(64, 1, 13, 43, 'uty utyutyut yuty', 'msg-2290Chrysanthemum.jpg', 0, NULL, NULL, date_add(NOW(),INTERVAL -2 DAY), 1, 1),
(65, 2, 1, 2, 'hello', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -2 DAY), 1, 1),
(66, 2, 1, 2, 'sent message', NULL, 0, NULL, NULL, date_add(NOW(),INTERVAL -1 DAY), 1, 1),
(67, 2, 1, 2, 'ty uty utyu', 'msg-9636Hydrangeas.jpg', 1, NULL, NULL, date_add(NOW(),INTERVAL -1 DAY), 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice` (
  `ntc_id` int(10) NOT NULL AUTO_INCREMENT,
  `ntc_heading` text NOT NULL,
  `ntc_description` text NOT NULL,
  `ntc_updated_date` date NOT NULL,
  `ntc_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ntc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `notice`
--

INSERT INTO `notice` (`ntc_id`, `ntc_heading`, `ntc_description`, `ntc_updated_date`, `ntc_status`) VALUES
(1, 'Please vote for us!', 'Hi there, please take 10 seconds of your time to vote for us in the 2012 Small Business Influencer Awards.', date_add(NOW(),INTERVAL -19 DAY), 1),
(2, 'Attention former Scriptlance Users', 'All feedback has now been loaded in, also all messages between employers and winners of projects (only).', date_add(NOW(),INTERVAL -14 DAY), 1),
(3, 'Expose Our Logo Contest is back! $25,000 to be won!', 'Get a team, start exposing & submit a video for your chance to win', date_add(NOW(),INTERVAL -12 DAY), 1),
(4, 'Freelancer Rewards are now massively cheaper!', 'Go to the Credit Shop now to cash in your credits!', date_add(NOW(),INTERVAL -10 DAY), 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateway`
--

DROP TABLE IF EXISTS `payment_gateway`;
CREATE TABLE `payment_gateway` (
  `id` int(10) NOT NULL,
  `pg_id` varchar(255) NOT NULL,
  `pg_name` varchar(255) NOT NULL,
  `pg_logo` varchar(255) NOT NULL,
  `pg_updated_date` date NOT NULL,
  `pg_status` int(1) NOT NULL DEFAULT '1',
  `pg_deposit_fee` int(10) NOT NULL,
  `pg_deposit_fee_type` enum('fixed','percent') NOT NULL,
  `pg_withdraw_fee` int(10) NOT NULL,
  `pg_withdraw_fee_type` enum('fixed','percent') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_gateway`
--

INSERT INTO `payment_gateway` (`id`, `pg_id`, `pg_name`, `pg_logo`, `pg_updated_date`, `pg_status`, `pg_deposit_fee`, `pg_deposit_fee_type`, `pg_withdraw_fee`, `pg_withdraw_fee_type`) VALUES
(1, 'info@itechscripts.com', 'paypal', 'paypal.jpg', date_add(NOW(),INTERVAL -40 DAY), 1, 5, 'fixed', 5, 'percent');

-- --------------------------------------------------------

--
-- Table structure for table `profile_completeness`
--

DROP TABLE IF EXISTS `profile_completeness`;
CREATE TABLE `profile_completeness` (
  `pc_id` int(10) NOT NULL AUTO_INCREMENT,
  `pc_field` text NOT NULL,
  `pc_value` int(3) NOT NULL,
  `pc_updated_date` date NOT NULL,
  `pc_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `profile_completeness`
--

INSERT INTO `profile_completeness` (`pc_id`, `pc_field`, `pc_value`, `pc_updated_date`, `pc_status`) VALUES
(1, 'user-image', 20, '2014-03-26', 1),
(2, 'user-portfolio', 20, '2014-03-26', 1),
(3, 'user-experience', 20, '2014-03-26', 1),
(4, 'user-education', 10, '2014-03-26', 1),
(5, 'user-certification', 10, '2014-03-26', 1),
(6, 'user-skills', 20, '2014-03-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `prj_id` int(11) NOT NULL AUTO_INCREMENT,
  `prj_usr_id` int(10) NOT NULL,
  `prj_name` text NOT NULL,
  `prj_scat_id` int(10) NOT NULL,
  `prj_details` text NOT NULL,
  `prj_file` varchar(255) DEFAULT NULL,
  `prj_expiry` datetime NOT NULL,
  `prj_updated_date` date NOT NULL,
  `prj_status` varchar(50) NOT NULL,
  PRIMARY KEY (`prj_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`prj_id`, `prj_usr_id`, `prj_name`, `prj_scat_id`, `prj_details`, `prj_file`, `prj_expiry`, `prj_updated_date`, `prj_status`) VALUES
(1, 1, 'first project', 1, 'gfhfgytrytrdsfsdfdsfdfdfdd', NULL, date_add(NOW(),INTERVAL -36 DAY), date_add(NOW(),INTERVAL -46 DAY), '1'),
(2, 1, 'eCommerce website', 1, 'sample description for eCommerce Website', NULL, date_add(NOW(),INTERVAL -35 DAY), date_add(NOW(),INTERVAL -45 DAY), 'running'),
(3, 4, 'Banking Website', 1, 'Typical Banking Website', NULL, date_add(NOW(),INTERVAL -34 DAY), date_add(NOW(),INTERVAL -44 DAY), 'open'),
(4, 5, 'CBC', 0, 'asdadsadsadsadfgmj asdfwd das asd a\r\n asda\r\n das\r\n as\r\nd\r\nasdsadsadsadsad\r\nsa\r\nsadasd\r\nadasdasdasdsadsadasd', NULL, date_add(NOW(),INTERVAL -30 DAY), date_add(NOW(),INTERVAL -40 DAY), 'open'),
(5, 2, 'youtube clone', 1, 'sample description for youtube clone', NULL, date_add(NOW(),INTERVAL -32 DAY), date_add(NOW(),INTERVAL -42 DAY), 'open'),
(6, 4, 'flipkart clone', 1, 'jfdogiurt uyoirtu yoitruyotuyotryosdgfreyttrytry tuytuytuytudsgfrtyre', NULL, date_add(NOW(),INTERVAL -32 DAY), date_add(NOW(),INTERVAL -42 DAY), 'open'),
(56, 1, 'ghjghj', 2, 'jkljkljkkl  hjkhj', NULL, date_add(NOW(),INTERVAL -34 DAY), date_add(NOW(),INTERVAL -44 DAY), 'open'),
(8, 1, 'Online bidder', 1, 'sample description', NULL, date_add(NOW(),INTERVAL -32 DAY), date_add(NOW(),INTERVAL -42 DAY), 'open'),
(9, 1, 'fsdggdgfd', 1, 'fdsfdsfdsfsd', NULL, date_add(NOW(),INTERVAL -31 DAY), date_add(NOW(),INTERVAL -41 DAY), 'open'),
(10, 1, 'Data Entry Job', 0, 'sample description for date entry', NULL, date_add(NOW(),INTERVAL -31 DAY), date_add(NOW(),INTERVAL -41 DAY), 'open'),
(11, 1, 'Makemytrip clone website', 1, 'sample description for makemytrip clone', NULL, date_add(NOW(),INTERVAL -30 DAY), date_add(NOW(),INTERVAL -40 DAY), 'open'),
(12, 2, 'new sample project', 5, 'sample details', NULL, date_add(NOW(),INTERVAL -31 DAY), date_add(NOW(),INTERVAL -41 DAY), 'open'),
(13, 3, 'project of joy', 1, 'soriuwe ewruteioptu oreiu toireu toire utoiewrut', NULL, date_add(NOW(),INTERVAL -31 DAY), date_add(NOW(),INTERVAL -41 DAY), 'running'),
(14, 3, 'testttttt project', 1, 'tfypiotrypoi potiypotripotyiupoytiurpoextra', NULL, date_add(NOW(),INTERVAL -30 DAY), date_add(NOW(),INTERVAL -40 DAY), 'open'),
(24, 10, 'another new proj', 1, 'geriuyeiutyri iuertyeriuytiureytireu ieruytiurytiureyui iureytiureytiureytireuyt', NULL, date_add(NOW(),INTERVAL -29 DAY), date_add(NOW(),INTERVAL -39 DAY), 'open'),
(23, 10, 'sample new proj', 1, 'sdhfiusdutfo odirutt uiy tiyurtyutu yiyu tyitiyptiy poitiytiytr', NULL, date_add(NOW(),INTERVAL -28 DAY), date_add(NOW(),INTERVAL -38 DAY), 'open'),
(25, 11, 'prooooj', 1, 'dfiudsoifuo odiuotiuyoit oityutuytu yoit tyutoiuytio uy', NULL, date_add(NOW(),INTERVAL -28 DAY), date_add(NOW(),INTERVAL -38 DAY), 'open'),
(34, 343932, 'rtrypoi pou', 1, 'hjikuy uyiuoiuoiuoui', NULL, date_add(NOW(),INTERVAL -27 DAY), date_add(NOW(),INTERVAL -37 DAY), 'open'),
(33, 343932, 'ertretrey6try', 2, 'try rtuytuytuyt', NULL, date_add(NOW(),INTERVAL -26 DAY), date_add(NOW(),INTERVAL -36 DAY), 'open'),
(35, 1, 'project testing', 1, 'g4iuryi4uy  433iu5y43oi5uy54ou', NULL, date_add(NOW(),INTERVAL -25 DAY), date_add(NOW(),INTERVAL -35 DAY), 'running'),
(36, 1, 'project test for dispute', 1, 'sample project detail', NULL, date_add(NOW(),INTERVAL -24 DAY), date_add(NOW(),INTERVAL -34 DAY), 'running'),
(37, 1, 'test for dproj', 1, 'bgfjdi eriutyryt oiyuotuyio oirtuy iouyoitr uyoit oiyuioyu', NULL, date_add(NOW(),INTERVAL -24 DAY), date_add(NOW(),INTERVAL -34 DAY), 'running'),
(39, 1, 'test prroject for ed', 1, 'dsrj eoiptujreoip tuprtyi', NULL, date_add(NOW(),INTERVAL -22 DAY), date_add(NOW(),INTERVAL -32 DAY), 'open'),
(40, 1, 'abcdefgh', 1, 'shweoi oeriutorei tureoitorieutre', NULL, date_add(NOW(),INTERVAL -20 DAY), date_add(NOW(),INTERVAL -30 DAY), 'open'),
(41, 0, 'ggggggg', 1, 'u7yi 789870o89098', NULL, date_add(NOW(),INTERVAL -20 DAY), date_add(NOW(),INTERVAL -30 DAY), 'open'),
(42, 0, 'qqqqqqqwwwwwwwwww', 1, 'fdhiugh otiuyotiuytr', NULL, date_add(NOW(),INTERVAL -20 DAY), date_add(NOW(),INTERVAL -30 DAY), 'open'),
(43, 1, 'CRM Project', 1, 'sdujoirut 0etu0 50e95860 65097poyjtfpo ptuytpo ptyou typoui', NULL, date_add(NOW(),INTERVAL -18 DAY), date_add(NOW(),INTERVAL -28 DAY), 'running'),
(44, 0, 'project number 1', 2, 'extraa s,dl a kjdasd', NULL, date_add(NOW(),INTERVAL -16 DAY), date_add(NOW(),INTERVAL -28 DAY), 'open'),
(45, 1, 'project number 1', 1, 'sbf snf ja fja f;aI;F NAIF SDF SDIF', NULL, date_add(NOW(),INTERVAL -15 DAY), date_add(NOW(),INTERVAL -28 DAY), 'running'),
(46, 1, 'Test Project', 2, 'Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project Test Project ', NULL, date_add(NOW(),INTERVAL -15 DAY), date_add(NOW(),INTERVAL -28 DAY), 'open'),
(47, 1, 'Prvt Project', 1, 'Prvt Project', NULL, date_add(NOW(),INTERVAL -15 DAY), date_add(NOW(),INTERVAL -26 DAY), 'open'),
(48, 1, 'prj abcd', 2, 'aaaa j2ee', NULL, date_add(NOW(),INTERVAL -14 DAY), date_add(NOW(),INTERVAL -25 DAY), 'open'),
(49, 1, 'conf project', 2, 'sldjfl rpotirep jdflgjdflgjrt prtpotrpo yitrp', NULL, date_add(NOW(),INTERVAL -14 DAY), date_add(NOW(),INTERVAL -25 DAY), 'open'),
(50, 1, 'new conf proj', 1, 'sdhoiuoi rpoirtypoitrp ptoyitpoyi', NULL, date_add(NOW(),INTERVAL -12 DAY), date_add(NOW(),INTERVAL -22 DAY), 'open'),
(51, 14, 'test cccccc', 2, 'fgsdfk ewoihrtoerituoreiut oi oeriutoireutroei oierutreoi tuori', NULL, date_add(NOW(),INTERVAL -12 DAY), date_add(NOW(),INTERVAL -22 DAY), 'open'),
(52, 15, 'qqqqqqq', 1, 'sdfrtret', NULL, date_add(NOW(),INTERVAL -12 DAY), date_add(NOW(),INTERVAL -20 DAY), 'open'),
(53, 15, 'fdgfdg', 1, 'gdfg dfg dfgfd', NULL, date_add(NOW(),INTERVAL -9 DAY), date_add(NOW(),INTERVAL -20 DAY), 'open'),
(54, 16, 'qqqq agn', 1, 'fgjhpop [pgo[pouytou[ [uo[you[yt;fk;g luky;glu kyt;l', NULL, date_add(NOW(),INTERVAL -7 DAY), date_add(NOW(),INTERVAL -19 DAY), 'open'),
(55, 1, 'sdfsdf', 1, 'fghfgh', NULL, '2013-10-26 02:06:04', '2013-10-22', 'open'),
(57, 1, 'aaaa', 1, 'wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww wwwwwwwwwwwwwwwwwww', NULL, date_add(NOW(),INTERVAL -6 DAY), date_add(NOW(),INTERVAL -18 DAY), 'close'),
(58, 1, 'abcd project', 1, 'abcd', NULL, date_add(NOW(),INTERVAL -5 DAY), date_add(NOW(),INTERVAL -18 DAY), 'open'),
(59, 1, 'project design', 1, 'sample description for the new project', NULL, date_add(NOW(),INTERVAL -5 DAY), date_add(NOW(),INTERVAL -18 DAY), 'open'),
(60, 1, 'CRM site', 1, 'sample description for the CRM Project', NULL, date_add(NOW(),INTERVAL -2 DAY), date_add(NOW(),INTERVAL -16 DAY), 'open'),
(61, 1, 'test proj after new design 1', 1, 'test description', NULL, date_add(NOW(),INTERVAL -5 DAY), date_add(NOW(),INTERVAL -15 DAY), 'open'),
(62, 1, 'test proj after new design 2', 1, 'nsdof idg oitoitfjhkljh lghjlgk jhljhrtuy0p69iy', NULL, date_add(NOW(),INTERVAL -1 DAY), date_add(NOW(),INTERVAL -15 DAY), 'open'),
(63, 1, 'CRM site', 1, 'sample description for the CRM Project', NULL, date_add(NOW(),INTERVAL 4 DAY), date_add(NOW(),INTERVAL -8 DAY), 'open'),
(64, 1, 'proj design 4', 1, 'test description for the project', NULL, date_add(NOW(),INTERVAL 5 DAY), date_add(NOW(),INTERVAL -15 DAY), 'open'),
(65, 1, 'proj for new design 5', 1, 'cfmnjcbuiui joiupgfoij', NULL, date_add(NOW(),INTERVAL 1 DAY), date_add(NOW(),INTERVAL -10 DAY), 'open'),
(66, 1, 'sample project', 1, 'sample project', NULL, date_add(NOW(),INTERVAL +10 DAY), date_add(NOW(),INTERVAL -10 DAY), 'open');

-- --------------------------------------------------------

--
-- Table structure for table `project_budget`
--

DROP TABLE IF EXISTS `project_budget`;
CREATE TABLE `project_budget` (
  `pb_id` int(10) NOT NULL AUTO_INCREMENT,
  `pb_prj_id` int(10) NOT NULL,
  `pb_type` varchar(50) NOT NULL,
  `pb_minprice` double(10,2) DEFAULT NULL,
  `pb_maxprice` double(10,2) DEFAULT NULL,
  `pb_rate` double(10,2) DEFAULT NULL,
  `pb_duration` int(10) DEFAULT NULL,
  `pb_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `project_budget`
--

INSERT INTO `project_budget` (`pb_id`, `pb_prj_id`, `pb_type`, `pb_minprice`, `pb_maxprice`, `pb_rate`, `pb_duration`, `pb_status`) VALUES
(1, 1, 'fixed', 200.00, 500.00, 0.00, 0, 1),
(2, 2, 'fixed', 850.00, 900.00, 0.00, 0, 1),
(3, 3, 'fixed', 500.00, 900.00, 0.00, 0, 1),
(4, 4, 'fixed', 1000.00, 3000.00, 0.00, 0, 1),
(5, 5, 'fixed', 500.00, 800.00, 0.00, 0, 1),
(6, 6, 'fixed', 400.00, 500.00, 0.00, 0, 1),
(7, 7, 'fixed', 600.00, 800.00, 0.00, 0, 1),
(8, 10, 'hourly', 0.00, 0.00, 10.00, 2, 1),
(9, 11, 'fixed', 500.00, 600.00, 0.00, 0, 1),
(10, 13, 'fixed', 500.00, 1000.00, 0.00, 10, 1),
(11, 14, 'fixed', 500.00, 600.00, 0.00, 10, 1),
(12, 15, 'fixed', 100.00, 500.00, 0.00, 10, 1),
(13, 16, 'fixed', 1000.00, 2000.00, 0.00, 5, 1),
(14, 17, 'fixed', 1000.00, 2000.00, 0.00, 5, 1),
(15, 18, 'fixed', 100.00, 200.00, 0.00, 5, 1),
(16, 19, 'fixed', 100.00, 500.00, 0.00, 5, 1),
(17, 20, 'fixed', 200.00, 500.00, 0.00, 5, 1),
(18, 21, 'fixed', 1000.00, 1200.00, 0.00, 5, 1),
(19, 22, 'fixed', 1000.00, 1200.00, 0.00, 5, 1),
(20, 23, 'fixed', 1000.00, 2000.00, 0.00, 5, 1),
(21, 24, 'fixed', 500.00, 800.00, 0.00, 5, 1),
(22, 25, 'fixed', 1000.00, 2000.00, 0.00, 5, 1),
(23, 26, 'fixed', 1000.00, 1200.00, 0.00, 5, 1),
(24, 27, 'fixed', 0.00, 0.00, 0.00, 0, 1),
(25, 28, 'fixed', 0.00, 0.00, 0.00, 0, 1),
(26, 29, 'fixed', 0.00, 0.00, 0.00, 0, 1),
(27, 30, 'hourly', 0.00, 0.00, 0.00, 0, 1),
(28, 31, 'hourly', 0.00, 0.00, 0.00, 0, 1),
(29, 32, 'hourly', 0.00, 0.00, 88.00, 0, 1),
(30, 33, 'fixed', 1000.00, 2000.00, 0.00, 0, 1),
(31, 34, 'hourly', 0.00, 0.00, 20.00, 0, 1),
(32, 35, 'fixed', 1200.00, 2000.00, 0.00, 10, 1),
(33, 36, 'fixed', 1000.00, 2000.00, 0.00, 5, 1),
(34, 37, 'hourly', 0.00, 0.00, 20.00, 5, 1),
(35, 38, 'fixed', 1200.00, 1400.00, 0.00, 4, 1),
(36, 39, 'fixed', 500.00, 800.00, 0.00, 5, 1),
(37, 40, 'fixed', 100.00, 200.00, 0.00, 10, 1),
(38, 41, 'fixed', 500.00, 200.00, 0.00, 0, 1),
(39, 42, 'fixed', 500.00, 501.00, 0.00, 0, 1),
(40, 43, 'fixed', 200.00, 500.00, 0.00, 0, 1),
(41, 44, 'fixed', 1000.00, 1200.00, 0.00, 0, 1),
(42, 45, 'fixed', 1000.00, 1500.00, 0.00, 13, 1),
(43, 46, 'fixed', 100.00, 500.00, 0.00, 5, 1),
(44, 47, 'fixed', 200.00, 700.00, 0.00, 10, 1),
(45, 48, 'fixed', 2500.00, 2800.00, 0.00, 15, 1),
(46, 49, 'fixed', 2500.00, 2800.00, 0.00, 12, 1),
(47, 50, 'fixed', 1000.00, 2000.00, 0.00, 15, 1),
(48, 51, 'hourly', 0.00, 0.00, 250.00, 15, 1),
(49, 52, 'hourly', 0.00, 0.00, 250.00, 20, 1),
(50, 53, 'fixed', 10.00, 15.00, 0.00, 25, 1),
(51, 54, 'fixed', 1200.00, 1580.00, 0.00, 15, 1),
(52, 55, 'fixed', 44.00, 444.00, 0.00, 4, 1),
(53, 56, 'fixed', 11.00, 111.00, 0.00, 11, 1),
(54, 57, 'fixed', 200.00, 800.00, 0.00, 10, 1),
(55, 58, 'fixed', 100.00, 102.00, 0.00, 10, 1),
(56, 59, 'fixed', 500.00, 800.00, 0.00, 10, 1),
(57, 60, 'fixed', 1000.00, 1200.00, 0.00, 10, 1),
(58, 61, 'fixed', 1200.00, 1500.00, 0.00, 10, 1),
(59, 62, 'fixed', 1000.00, 1200.00, 0.00, 12, 1),
(60, 63, 'hourly', 0.00, 0.00, 1200.00, 10, 1),
(61, 64, 'fixed', 800.00, 950.00, 0.00, 10, 1),
(62, 65, 'fixed', 500.00, 900.00, 0.00, 12, 1),
(63, 66, 'fixed', 220.00, 250.00, 0.00, 80, 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_dispute`
--

DROP TABLE IF EXISTS `project_dispute`;
CREATE TABLE `project_dispute` (
  `pds_id` int(10) NOT NULL AUTO_INCREMENT,
  `pds_prj_id` int(10) NOT NULL,
  `pds_bd_id` int(10) NOT NULL,
  `pds_reason` text NOT NULL,
  `pds_releaseAmount` double(10,2) NOT NULL,
  `pds_disputeDate` date NOT NULL,
  `pds_closeDate` date DEFAULT NULL,
  `pds_claimReason` text NOT NULL,
  `pds_claimAmount` double(10,2) NOT NULL,
  `pds_claimDate` date NOT NULL,
  `pds_setteledAmount` double(10,2) NOT NULL,
  `pds_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pds_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `project_dispute`
--

INSERT INTO `project_dispute` (`pds_id`, `pds_prj_id`, `pds_bd_id`, `pds_reason`, `pds_releaseAmount`, `pds_disputeDate`, `pds_closeDate`, `pds_claimReason`, `pds_claimAmount`, `pds_claimDate`, `pds_setteledAmount`, `pds_status`) VALUES
(5, 35, 13, 'sample reason for dispute the project', 200.00, date_add(NOW(),INTERVAL -20 DAY), date_add(NOW(),INTERVAL -20 DAY), 'must pay full amount', 20.00, date_add(NOW(),INTERVAL -20 DAY), 0.00, 0),
(6, 36, 14, 'sample dispute for the project', 100.00, date_add(NOW(),INTERVAL -18 DAY), date_add(NOW(),INTERVAL -18 DAY), 'must pay full amount', 20.00, date_add(NOW(),INTERVAL -18 DAY), 120.00, 0),
(7, 37, 15, '89ert98e7 tu8yr9typtriypoti', 10.00, date_add(NOW(),INTERVAL -16 DAY), date_add(NOW(),INTERVAL -16 DAY), 'must pay full amount', 20.00, date_add(NOW(),INTERVAL -16 DAY), 10.00, 0),
(8, 43, 33, 'test reason', 8.00, date_add(NOW(),INTERVAL -15 DAY), NULL, 'must pay full amount', 20.00, date_add(NOW(),INTERVAL -15 DAY), 0.00, 1),
(9, 43, 33, 'dispute test 1', 8.00, date_add(NOW(),INTERVAL -14 DAY), date_add(NOW(),INTERVAL -14 DAY), 'must pay full amount', 20.00, date_add(NOW(),INTERVAL -14 DAY), 8.00, 0),
(10, 43, 33, 'sample dispute for test 2', 20.00, date_add(NOW(),INTERVAL -12 DAY), date_add(NOW(),INTERVAL -12 DAY), 'must pay full amount', 20.00, date_add(NOW(),INTERVAL -12 DAY), 20.00, 0),
(11, 43, 33, 'sample dispute for testing decline method', 15.00, date_add(NOW(),INTERVAL -10 DAY), date_add(NOW(),INTERVAL -10 DAY), 'must pay full amount', 20.00, date_add(NOW(),INTERVAL -10 DAY), 15.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `project_files`
--

DROP TABLE IF EXISTS `project_files`;
CREATE TABLE `project_files` (
  `pfl_id` int(100) NOT NULL AUTO_INCREMENT,
  `pfl_uid` int(100) NOT NULL,
  `pfl_pr_id` int(100) NOT NULL,
  `pfl_filename` varchar(255) NOT NULL,
  PRIMARY KEY (`pfl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `project_files`
--

INSERT INTO `project_files` (`pfl_id`, `pfl_uid`, `pfl_pr_id`, `pfl_filename`) VALUES
(1, 1, 1, '120130201163735.jpg'),
(2, 1, 1, '120130201164004.jpg'),
(3, 4, 3, '420130206172633.jpg'),
(4, 5, 4, '520130206175139.txt'),
(5, 0, 48, '120131010112454.png'),
(7, 0, 66, 'prj9205Chrysanthemum.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `project_promotion`
--

DROP TABLE IF EXISTS `project_promotion`;
CREATE TABLE `project_promotion` (
  `pp_id` int(11) NOT NULL AUTO_INCREMENT,
  `pp_name` varchar(255) NOT NULL,
  `pp_dispText` text NOT NULL,
  `pp_amount` decimal(5,2) NOT NULL,
  `pp_updated_date` date NOT NULL,
  `pp_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `project_promotion`
--

INSERT INTO `project_promotion` (`pp_id`, `pp_name`, `pp_dispText`, `pp_amount`, `pp_updated_date`, `pp_status`) VALUES
(1, 'featured', 'I want my project to be listed as a featured project. Featured projects attract more, higher quality bids. They appear prominently on the home page.', '18.00', '2013-08-09', 1),
(2, 'private', 'I want to hide project details from search engines and users that are not logged in This feature is recommended for projects where confidentiality is a must. ', '8.00', '2013-08-09', 1),
(3, 'sealed', 'I want all the bids to be sealed so that bidders cannot see what others are bidding Sealed Bidding may lead to lower bids for your project! ', '5.00', '2013-08-09', 1),
(4, 'urgent', 'I want my project to be marked as an urgent project Receive a faster response from Freelancers to get your project started within 24 hours! ', '5.00', '2013-08-09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_promotion_option`
--

DROP TABLE IF EXISTS `project_promotion_option`;
CREATE TABLE `project_promotion_option` (
  `ppo_id` int(11) NOT NULL AUTO_INCREMENT,
  `ppo_prj_id` int(11) NOT NULL,
  `ppo_pp_id` int(11) NOT NULL,
  `ppo_updated_date` date NOT NULL,
  `ppo_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ppo_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `project_promotion_option`
--

INSERT INTO `project_promotion_option` (`ppo_id`, `ppo_prj_id`, `ppo_pp_id`, `ppo_updated_date`, `ppo_status`) VALUES
(1, 6, 3, date_add(NOW(),INTERVAL -42 DAY), 1),
(2, 1, 3, date_add(NOW(),INTERVAL -46 DAY), 1),
(3, 6, 4, date_add(NOW(),INTERVAL -42 DAY), 1),
(4, 7, 1, date_add(NOW(),INTERVAL -40 DAY), 1),
(5, 45, 1, date_add(NOW(),INTERVAL -28 DAY), 1),
(6, 6, 2, date_add(NOW(),INTERVAL -42 DAY), 1),
(7, 6, 4, date_add(NOW(),INTERVAL -40 DAY), 1),
(8, 46, 1, date_add(NOW(),INTERVAL -28 DAY), 1),
(9, 46, 3, date_add(NOW(),INTERVAL -28 DAY), 1),
(10, 46, 4, date_add(NOW(),INTERVAL -28 DAY), 1),
(11, 47, 2, date_add(NOW(),INTERVAL -26 DAY), 1),
(12, 47, 3, date_add(NOW(),INTERVAL -26 DAY), 1),
(13, 48, 1, date_add(NOW(),INTERVAL -25 DAY), 1),
(14, 48, 2, date_add(NOW(),INTERVAL -25 DAY), 1),
(15, 49, 3, date_add(NOW(),INTERVAL -25 DAY), 1),
(16, 50, 1, date_add(NOW(),INTERVAL -22 DAY), 1),
(17, 60, 2, date_add(NOW(),INTERVAL -16 DAY), 1),
(18, 60, 3, date_add(NOW(),INTERVAL -16 DAY), 1),
(19, 61, 4, date_add(NOW(),INTERVAL -15 DAY), 1),
(20, 62, 4, date_add(NOW(),INTERVAL -15 DAY), 1),
(22, 63, 4, date_add(NOW(),INTERVAL -8 DAY), 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_skill`
--

DROP TABLE IF EXISTS `project_skill`;
CREATE TABLE `project_skill` (
  `ps_id` int(10) NOT NULL AUTO_INCREMENT,
  `ps_prj_id` int(10) NOT NULL,
  `ps_sk_id` int(10) NOT NULL,
  PRIMARY KEY (`ps_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=133 ;

--
-- Dumping data for table `project_skill`
--

INSERT INTO `project_skill` (`ps_id`, `ps_prj_id`, `ps_sk_id`) VALUES
(1, 1, 2),
(2, 2, 4),
(3, 3, 133),
(4, 4, 95),
(5, 5, 1),
(6, 6, 4),
(22, 7, 4),
(33, 8, 1),
(23, 7, 93),
(24, 10, 17),
(25, 10, 18),
(32, 8, 2),
(31, 8, 1),
(34, 8, 2),
(35, 8, 1),
(36, 8, 2),
(37, 11, 1),
(38, 11, 4),
(39, 13, 1),
(40, 14, 2),
(41, 14, 1),
(42, 14, 6),
(43, 15, 1),
(44, 15, 6),
(45, 16, 3),
(46, 17, 2),
(47, 17, 4),
(48, 18, 1),
(49, 18, 4),
(50, 19, 1),
(51, 19, 4),
(52, 20, 3),
(53, 21, 1),
(54, 21, 5),
(55, 22, 4),
(56, 23, 4),
(57, 24, 4),
(58, 25, 4),
(59, 26, 4),
(60, 27, 5),
(61, 28, 5),
(62, 29, 5),
(63, 30, 4),
(64, 31, 1),
(65, 32, 3),
(66, 33, 4),
(67, 34, 4),
(68, 35, 4),
(69, 36, 4),
(70, 37, 4),
(71, 38, 4),
(72, 38, 24),
(73, 38, 25),
(74, 38, 4),
(75, 39, 4),
(76, 40, 4),
(77, 41, 2),
(78, 42, 19),
(79, 43, 3),
(80, 44, 3),
(81, 44, 4),
(82, 44, 5),
(83, 45, 4),
(84, 45, 6),
(85, 45, 4),
(86, 46, 3),
(87, 46, 4),
(88, 46, 3),
(89, 46, 4),
(90, 47, 3),
(91, 47, 4),
(92, 48, 88),
(93, 49, 88),
(94, 49, 89),
(95, 50, 1),
(96, 50, 2),
(97, 51, 88),
(98, 51, 89),
(99, 52, 4),
(100, 53, 5),
(101, 54, 4),
(102, 55, 2),
(103, 55, 3),
(104, 56, 2),
(105, 57, 2),
(106, 58, 1),
(107, 58, 4),
(108, 58, 160),
(109, 59, 4),
(110, 59, 114),
(111, 59, 133),
(112, 60, 1),
(113, 60, 4),
(114, 60, 114),
(115, 60, 133),
(116, 61, 1),
(117, 61, 4),
(118, 61, 133),
(119, 62, 1),
(120, 62, 3),
(121, 62, 4),
(122, 62, 89),
(123, 63, 1),
(124, 63, 11),
(125, 64, 1),
(126, 64, 4),
(127, 65, 1),
(128, 65, 4),
(129, 66, 1),
(130, 66, 4),
(131, 66, 1),
(132, 66, 4);

-- --------------------------------------------------------

--
-- Table structure for table `review_rating`
--

DROP TABLE IF EXISTS `review_rating`;
CREATE TABLE `review_rating` (
  `rr_id` int(10) NOT NULL AUTO_INCREMENT,
  `rr_prj_id` int(10) NOT NULL,
  `rr_to_usr` int(10) NOT NULL,
  `rr_from_usr` int(10) NOT NULL,
  `rr_work_quality` int(2) NOT NULL DEFAULT '0',
  `rr_communication` int(2) NOT NULL DEFAULT '0',
  `rr_expertise` int(2) NOT NULL DEFAULT '0',
  `rr_work_hire_again` int(2) NOT NULL DEFAULT '0',
  `rr_professionalism` int(2) NOT NULL DEFAULT '0',
  `rr_completionrate` varchar(1) NOT NULL DEFAULT '1',
  `rr_review` text NOT NULL,
  `rr_updated_date` date NOT NULL,
  `rr_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`rr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `review_rating`
--

INSERT INTO `review_rating` (`rr_id`, `rr_prj_id`, `rr_to_usr`, `rr_from_usr`, `rr_work_quality`, `rr_communication`, `rr_expertise`, `rr_work_hire_again`, `rr_professionalism`, `rr_completionrate`, `rr_review`, `rr_updated_date`, `rr_status`) VALUES
(2, 13, 2, 3, 6, 8, 6, 5, 0, '1', 'hewou ytu roityo yutr', date_add(NOW(),INTERVAL -18 DAY), 1),
(3, 13, 2, 3, 0, 4, 0, 0, 0, '1', 'ytuyti8u7y', date_add(NOW(),INTERVAL -16 DAY), 1),
(5, 35, 9, 1, 1, 2, 4, 5, 10, '1', 'excellent', date_add(NOW(),INTERVAL -15 DAY), 1),
(8, 45, 13, 1, 0, 0, 0, 0, 0, '1', 'fgifduhiutyhtr', date_add(NOW(),INTERVAL -14 DAY), 1),
(9, 2, 4, 1, 2, 4, 8, 9, 10, '1', 'test review', date_add(NOW(),INTERVAL -12 DAY), 1),
(10, 37, 9, 1, 0, 0, 0, 0, 0, '1', '', date_add(NOW(),INTERVAL -10 DAY), 1);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `st_id` int(10) NOT NULL AUTO_INCREMENT,
  `st_field` varchar(100) NOT NULL,
  `st_value` longtext NOT NULL,
  `st_updated_date` date NOT NULL,
  `st_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`st_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`st_id`, `st_field`, `st_value`, `st_updated_date`, `st_status`) VALUES
(1, 'website-title', 'Freelancer Clone', '2013-08-19', 1),
(2, 'meta-keywords', 'Freelancer Clone', '2013-08-19', 1),
(3, 'meta-description', 'Freelancer Clone', '2013-08-19', 1),
(4, 'website-name', 'Freelancer Clone', '2013-08-19', 1),
(5, 'logo', 'logo.png', '2013-08-19', 1),
(6, 'Project-Validity', '10', '2012-08-10', 1),
(7, 'currency-code', 'USD', '2014-01-21', 1),
(8, 'currency-symbol', '$', '2012-09-20', 1),
(9, 'minimum-withdraw-amount', '100', '2012-12-05', 1),
(10, 'site-language', 'english', '2013-08-21', 1),
(13, 'minimum-deposit', '3', '2013-10-20', 1),
(14, 'notification-delete-after', '6', '2014-01-15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE `skills` (
  `sk_id` int(10) NOT NULL AUTO_INCREMENT,
  `sk_cat_id` int(10) NOT NULL,
  `sk_name` varchar(255) NOT NULL,
  `sk_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`sk_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=549 ;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`sk_id`, `sk_cat_id`, `sk_name`, `sk_status`) VALUES
(1, 1, '.NET', 1),
(2, 1, 'Active Directory', 1),
(3, 1, 'Agile Development', 1),
(4, 1, 'AJAX', 1),
(5, 1, 'Amazon Web Services', 1),
(6, 1, 'Analytics', 1),
(7, 1, 'Apache', 1),
(8, 1, 'Apache Solr', 1),
(9, 1, 'Apple Safari', 1),
(10, 1, 'AS400 & iSeries', 1),
(11, 1, 'ASP', 1),
(12, 1, 'Assembly', 1),
(13, 1, 'Asterisk PBX', 1),
(14, 1, 'AutoHotkey', 1),
(15, 1, 'Azure', 1),
(16, 1, 'Balsamiq', 1),
(17, 1, 'Big Data', 1),
(18, 1, 'BigCommerce', 1),
(19, 1, 'Blog Install', 1),
(20, 1, 'BMC Remedy', 1),
(21, 1, 'Boonex Dolphin', 1),
(22, 1, 'Business Catalyst', 1),
(23, 1, 'C Programming', 1),
(24, 1, 'C# Programming', 1),
(25, 1, 'C++ Programming', 1),
(26, 1, 'CakePHP', 1),
(27, 1, 'Chordiant', 1),
(28, 1, 'Chrome OS', 1),
(29, 1, 'Cisco', 1),
(30, 1, 'Cloud Computing', 1),
(31, 1, 'CMS', 1),
(32, 1, 'COBOL', 1),
(33, 1, 'Cocoa', 1),
(34, 1, 'Codeigniter', 1),
(35, 1, 'Cold Fusion', 1),
(36, 1, 'Computer Graphics', 1),
(37, 1, 'Computer Security', 1),
(38, 1, 'CRE Loaded', 1),
(39, 1, 'CS-Cart', 1),
(40, 1, 'CubeCart', 1),
(41, 1, 'CUDA', 1),
(42, 1, 'Dart', 1),
(43, 1, 'Database Administration', 1),
(44, 1, 'Debugging', 1),
(45, 1, 'Delphi', 1),
(46, 1, 'Django', 1),
(47, 1, 'DNS', 1),
(48, 1, 'DOS', 1),
(49, 1, 'DotNetNuke', 1),
(50, 1, 'Drupal', 1),
(51, 1, 'Dynamics AX', 1),
(52, 1, 'eCommerce', 1),
(53, 1, 'eLearning', 1),
(54, 1, 'Electronic Forms', 1),
(55, 1, 'Embedded Software', 1),
(56, 1, 'Erlang', 1),
(57, 1, 'Expression Engine', 1),
(58, 1, 'Face Recognition', 1),
(59, 1, 'Facebook', 1),
(60, 1, 'FileMaker', 1),
(61, 1, 'Firefox', 1),
(62, 1, 'Fortran', 1),
(63, 1, 'Forum Software', 1),
(64, 1, 'FreelancerAPI', 1),
(65, 1, 'Game Consoles', 1),
(66, 1, 'Game Design', 1),
(67, 1, 'Gamification', 1),
(68, 1, 'Google Analytics', 1),
(69, 1, 'Google App Engine', 1),
(70, 1, 'Google Buzz', 1),
(71, 1, 'Google Checkout', 1),
(72, 1, 'Google Chrome', 1),
(73, 1, 'Google Earth', 1),
(74, 1, 'Google Go', 1),
(75, 1, 'Google Plus', 1),
(76, 1, 'Google Wave', 1),
(77, 1, 'Google Web Toolkit', 1),
(78, 1, 'GPGPU', 1),
(79, 1, 'Grease Monkey', 1),
(80, 1, 'Hadoop', 1),
(81, 1, 'Haskell', 1),
(82, 1, 'HP Openview', 1),
(83, 1, 'HTML', 1),
(84, 1, 'HTML5', 1),
(85, 1, 'IBM Tivoli', 1),
(86, 1, 'IIS', 1),
(87, 1, 'Interspire', 1),
(88, 1, 'J2EE', 1),
(89, 1, 'Java', 1),
(90, 1, 'JavaFX', 1),
(91, 1, 'Javascript', 1),
(92, 1, 'Joomla', 1),
(93, 1, 'jQuery / Prototype', 1),
(94, 1, 'JSP', 1),
(95, 1, 'Kinect', 0),
(96, 1, 'LabVIEW', 1),
(97, 1, 'Link Building', 1),
(98, 1, 'Linkedin', 1),
(99, 1, 'Linux', 1),
(100, 1, 'Lotus Notes', 1),
(101, 1, 'Mac OS', 1),
(102, 1, 'Magento', 1),
(103, 1, 'Map Reduce', 1),
(104, 1, 'Metatrader', 1),
(105, 1, 'Microsoft', 1),
(106, 1, 'Microsoft Access', 1),
(107, 1, 'Microsoft Exchange', 1),
(108, 1, 'Microsoft Expression', 1),
(109, 1, 'MMORPG', 1),
(110, 1, 'MODx', 1),
(111, 1, 'Moodle', 1),
(112, 1, 'MVC', 1),
(113, 1, 'MySpace', 1),
(114, 1, 'MySQL', 1),
(115, 1, 'Nginx', 1),
(116, 1, 'Ning', 1),
(117, 1, 'node.js', 1),
(118, 1, 'NoSQL Couch & Mongo', 1),
(119, 1, 'Objective C', 1),
(120, 1, 'OCR', 1),
(121, 1, 'Open Cart', 1),
(122, 1, 'OpenCL', 1),
(123, 1, 'OpenGL', 1),
(124, 1, 'Oracle', 1),
(125, 1, 'OSCommerce', 1),
(126, 1, 'Parallels Automation', 1),
(127, 1, 'Parallels Desktop', 1),
(128, 1, 'Pattern Matching', 1),
(129, 1, 'Paypal API', 1),
(130, 1, 'Pentaho', 1),
(131, 1, 'Perl', 1),
(132, 1, 'Photoshop Coding', 1),
(133, 1, 'PHP', 1),
(134, 1, 'PICK Multivalue DB', 1),
(135, 1, 'Pinterest', 1),
(136, 1, 'Plesk', 1),
(137, 1, 'Prestashop', 1),
(138, 1, 'Prolog', 1),
(139, 1, 'Protoshare', 1),
(140, 1, 'Python', 1),
(141, 1, 'REALbasic', 1),
(142, 1, 'Rocket Engine', 1),
(143, 1, 'Ruby & Ruby on Rails', 1),
(144, 1, 'SAP', 1),
(145, 1, 'Script Install', 1),
(146, 1, 'Scrum Development', 1),
(147, 1, 'Sencha / YahooUI', 1),
(148, 1, 'SEO', 1),
(149, 1, 'Sharepoint', 1),
(150, 1, 'Shell Script', 1),
(151, 1, 'Shopify', 1),
(152, 1, 'Shopping Carts', 1),
(153, 1, 'Silverlight', 1),
(154, 1, 'Smarty PHP', 1),
(155, 1, 'Social Engine', 1),
(156, 1, 'Social Networking', 1),
(157, 1, 'Software Architecture', 1),
(158, 1, 'Software Testing', 1),
(159, 1, 'Solaris', 1),
(160, 1, 'SQL', 1),
(161, 1, 'SugarCRM', 1),
(162, 1, 'Symfony PHP', 1),
(163, 1, 'System Admin', 1),
(164, 1, 'TaoBao API', 1),
(165, 1, 'TestStand', 1),
(166, 1, 'Tumblr', 1),
(167, 1, 'Twitter', 1),
(168, 1, 'UML Design', 1),
(169, 1, 'Unity 3D', 1),
(170, 1, 'UNIX', 1),
(171, 1, 'Usability Testing', 1),
(172, 1, 'User Interface / IA', 1),
(173, 1, 'vBulletin', 1),
(174, 1, 'Virtual Worlds', 1),
(175, 1, 'Virtuemart', 1),
(176, 1, 'Virtuozzo', 1),
(177, 1, 'Visual Basic', 1),
(178, 1, 'Visual Basic for Applications', 1),
(179, 1, 'Visual Foxpro', 1),
(180, 1, 'VoIP', 1),
(181, 1, 'Volusion', 1),
(182, 1, 'vTiger', 1),
(183, 1, 'Web Hosting Issues', 1),
(184, 1, 'Web Scraping', 1),
(185, 1, 'Web Security', 1),
(186, 1, 'webMethods', 1),
(187, 1, 'Website Management', 1),
(188, 1, 'Website Testing', 1),
(189, 1, 'Windows API', 1),
(190, 1, 'Windows Desktop', 1),
(191, 1, 'Windows Server', 1),
(192, 1, 'Wordpress', 1),
(193, 1, 'WPF', 1),
(194, 1, 'x86/x64 Assembler', 1),
(195, 1, 'XML', 1),
(196, 1, 'XSLT', 1),
(197, 1, 'Yii', 1),
(198, 1, 'YouTube', 1),
(199, 1, 'Zen Cart', 1),
(200, 1, 'Zend', 1),
(201, 1, 'Zoho', 1),
(202, 2, 'Amazon Kindle', 1),
(203, 2, 'Android', 1),
(204, 2, 'Android Honeycomb', 1),
(205, 2, 'Appcelerator Titanium', 1),
(206, 2, 'Blackberry', 1),
(207, 2, 'Geolocation', 1),
(208, 2, 'iPad', 1),
(209, 2, 'iPhone', 1),
(210, 2, 'J2ME', 1),
(211, 2, 'Metro', 1),
(212, 2, 'Mobile Phone', 1),
(213, 2, 'Nokia', 1),
(214, 2, 'Palm', 1),
(215, 2, 'Samsung', 1),
(216, 2, 'Symbian', 1),
(217, 2, 'WebOS', 1),
(218, 2, 'Windows CE', 1),
(219, 2, 'Windows Mobile', 1),
(220, 2, 'Windows Phone', 1),
(221, 3, 'Academic Writing', 1),
(222, 3, 'Article Rewriting', 1),
(223, 3, 'Articles', 1),
(224, 3, 'Astroturfing', 1),
(225, 3, 'Blog', 1),
(226, 3, 'Book Writing', 1),
(227, 3, 'Cartography & Maps', 1),
(228, 3, 'Copy Typing', 1),
(229, 3, 'Copywriting', 1),
(230, 3, 'eBooks', 1),
(231, 3, 'Editing', 1),
(232, 3, 'Fiction', 1),
(233, 3, 'Financial Research', 1),
(234, 3, 'Forum Posting', 1),
(235, 3, 'Ghostwriting', 1),
(236, 3, 'Grant Writing', 1),
(237, 3, 'LaTeX', 1),
(238, 3, 'Medical Writing', 1),
(239, 3, 'Newsletters', 1),
(240, 3, 'PDF', 1),
(241, 3, 'Poetry', 1),
(242, 3, 'Powerpoint', 1),
(243, 3, 'Press Releases', 1),
(244, 3, 'Product Descriptions', 1),
(245, 3, 'Proofreading', 1),
(246, 3, 'Proposal/Bid Writing', 1),
(247, 3, 'Publishing', 1),
(248, 3, 'Report Writing', 1),
(249, 3, 'Research', 1),
(250, 3, 'Resumes', 1),
(251, 3, 'Reviews', 1),
(252, 3, 'Screenwriting', 1),
(253, 3, 'Short Stories', 1),
(254, 3, 'Speech Writing', 1),
(255, 3, 'Technical Writing', 1),
(256, 3, 'Translation', 1),
(257, 3, 'Travel Writing', 1),
(258, 3, 'WIKI', 1),
(259, 4, '3D Animation', 1),
(260, 4, '3D Modelling', 1),
(261, 4, '3D Printing', 1),
(262, 4, '3D Rendering', 1),
(263, 4, '3ds Max', 1),
(264, 4, 'ActionScript', 1),
(265, 4, 'Adobe LiveCycle Designer', 1),
(266, 4, 'Advertisement Design', 1),
(267, 4, 'After Effects', 1),
(268, 4, 'Animation', 1),
(269, 4, 'Arts & Crafts', 1),
(270, 4, 'Audio Services', 1),
(271, 4, 'Banner Design', 1),
(272, 4, 'Blog Design', 1),
(273, 4, 'Brochure Design', 1),
(274, 4, 'Building Architecture', 1),
(275, 4, 'Business Cards', 1),
(276, 4, 'Capture NX2', 1),
(277, 4, 'Caricature & Cartoons', 1),
(278, 4, 'CGI', 1),
(279, 4, 'Commercials', 1),
(280, 4, 'Concept Design', 1),
(281, 4, 'Corporate Identity', 1),
(282, 4, 'Covers & Packaging', 1),
(283, 4, 'CSS', 1),
(284, 4, 'Dreamweaver', 1),
(285, 4, 'Fashion Design', 1),
(286, 4, 'Fashion Modeling', 1),
(287, 4, 'Final Cut Pro', 1),
(288, 4, 'Finale / Sibelius', 1),
(289, 4, 'Flash', 1),
(290, 4, 'Flash 3D', 1),
(291, 4, 'Flex', 1),
(292, 4, 'Flyer Design', 1),
(293, 4, 'Format & Layout', 1),
(294, 4, 'Furniture Design', 1),
(295, 4, 'Google SketchUp', 1),
(296, 4, 'Graphic Design', 1),
(297, 4, 'Icon Design', 1),
(298, 4, 'Illustration', 1),
(299, 4, 'Illustrator', 1),
(300, 4, 'InDesign', 1),
(301, 4, 'Industrial Design', 1),
(302, 4, 'Infographics', 1),
(303, 4, 'Interior Design', 1),
(304, 4, 'Invitation Design', 1),
(305, 4, 'Landing Pages', 1),
(306, 4, 'Logo Design', 1),
(307, 4, 'Maya', 1),
(308, 4, 'Motion Graphics', 1),
(309, 4, 'Music', 1),
(310, 4, 'Photo Editing', 1),
(311, 4, 'Photography', 1),
(312, 4, 'Photoshop', 1),
(313, 4, 'Photoshop Design', 1),
(314, 4, 'Post-Production', 1),
(315, 4, 'Poster Design', 1),
(316, 4, 'Pre-production', 1),
(317, 4, 'Presentations', 1),
(318, 4, 'Prezi', 1),
(319, 4, 'Print', 1),
(320, 4, 'PSD to HTML', 1),
(321, 4, 'PSD2CMS', 1),
(322, 4, 'QuarkXPress', 1),
(323, 4, 'Shopify Templates', 1),
(324, 4, 'Stationery Design', 1),
(325, 4, 'Sticker Design', 1),
(326, 4, 'T-Shirts', 1),
(327, 4, 'Templates', 1),
(328, 4, 'Typography', 1),
(329, 4, 'Video Broadcasting', 1),
(330, 4, 'Video Services', 1),
(331, 4, 'Videography', 1),
(332, 4, 'Visual Arts', 1),
(333, 4, 'Voice Talent', 1),
(334, 4, 'Website Design', 1),
(335, 4, 'Word', 1),
(336, 4, 'Yahoo! Store Design', 1),
(337, 5, 'Article Submission', 1),
(338, 5, 'BPO', 1),
(339, 5, 'Customer Support', 1),
(340, 5, 'Data Entry', 1),
(341, 5, 'Data Processing', 1),
(342, 5, 'Desktop Support', 1),
(343, 5, 'Excel', 1),
(344, 5, 'Order Processing', 1),
(345, 5, 'Phone Support', 1),
(346, 5, 'Technical Support', 1),
(347, 5, 'Transcription', 1),
(348, 5, 'Video Upload', 1),
(349, 5, 'Virtual Assistant', 1),
(350, 5, 'Web Search', 1),
(351, 6, 'Aeronautical Engineering', 1),
(352, 6, 'Aerospace Engineering', 1),
(353, 6, 'Algorithm', 1),
(354, 6, 'Arduino', 1),
(355, 6, 'Astrophysics', 1),
(356, 6, 'AutoCAD', 1),
(357, 6, 'Biology', 1),
(358, 6, 'Biotechnology', 1),
(359, 6, 'Broadcast Engineering', 1),
(360, 6, 'CAD/CAM', 1),
(361, 6, 'Chemical Engineering', 1),
(362, 6, 'Civil Engineering', 1),
(363, 6, 'Clean Technology', 1),
(364, 6, 'Climate Sciences', 1),
(365, 6, 'Construction Monitoring', 1),
(366, 6, 'Cryptography', 1),
(367, 6, 'Data Mining', 1),
(368, 6, 'Electrical Engineering', 1),
(369, 6, 'Electronics', 1),
(370, 6, 'Engineering', 1),
(371, 6, 'Engineering Drawing', 1),
(372, 6, 'Finite Element Analysis', 1),
(373, 6, 'Genetic Engineering', 1),
(374, 6, 'Geology', 1),
(375, 6, 'Geospatial', 1),
(376, 6, 'GPS', 1),
(377, 6, 'Home Design', 1),
(378, 6, 'Human Sciences', 1),
(379, 6, 'Imaging', 1),
(380, 6, 'Industrial Engineering', 1),
(381, 6, 'Instrumentation', 1),
(382, 6, 'Linear Programming', 1),
(383, 6, 'Machine Learning', 1),
(384, 6, 'Manufacturing Design', 1),
(385, 6, 'Materials Engineering', 1),
(386, 6, 'Mathematics', 1),
(387, 6, 'Matlab & Mathematica', 1),
(388, 6, 'Mechanical Engineering', 1),
(389, 6, 'Mechatronics', 1),
(390, 6, 'Medical', 1),
(391, 6, 'Microcontroller', 1),
(392, 6, 'Microstation', 1),
(393, 6, 'Mining Engineering', 1),
(394, 6, 'Nanotechnology', 1),
(395, 6, 'Natural Language', 1),
(396, 6, 'PCB Layout', 1),
(397, 6, 'Petroleum Engineering', 1),
(398, 6, 'Physics', 1),
(399, 6, 'PLC & SCADA', 1),
(400, 6, 'Product Management', 1),
(401, 6, 'Project Scheduling', 1),
(402, 6, 'Quantum', 1),
(403, 6, 'Remote Sensing', 1),
(404, 6, 'Robotics', 1),
(405, 6, 'RTOS', 1),
(406, 6, 'Scientific Research', 1),
(407, 6, 'Solidworks', 1),
(408, 6, 'Statistics', 1),
(409, 6, 'Structural Engineering', 1),
(410, 6, 'Telecommunications Engineering', 1),
(411, 6, 'Textile Engineering', 1),
(412, 6, 'Verilog / VHDL', 1),
(413, 6, 'Wireless', 1),
(414, 7, 'Buyer Sourcing', 1),
(415, 7, 'Logistics & Shipping', 1),
(416, 7, 'Manufacturing', 1),
(417, 7, 'Product Design', 1),
(418, 7, 'Product Sourcing', 1),
(419, 7, 'Supplier Sourcing', 1),
(420, 8, 'Ad Planning & Buying', 1),
(421, 8, 'Advertising', 1),
(422, 8, 'Affiliate Marketing', 1),
(423, 8, 'Branding', 1),
(424, 8, 'Bulk Marketing', 1),
(425, 8, 'Classifieds Posting', 1),
(426, 8, 'CRM', 1),
(427, 8, 'eBay', 1),
(428, 8, 'Google Adsense', 1),
(429, 8, 'Internet Marketing', 1),
(430, 8, 'Leads', 1),
(431, 8, 'Market Research', 1),
(432, 8, 'Marketing', 1),
(433, 8, 'MLM', 1),
(434, 8, 'Sales', 1),
(435, 8, 'SEM / Adwords', 1),
(436, 8, 'Telemarketing', 1),
(437, 8, 'Viral Marketing', 1),
(438, 9, 'Accounting', 1),
(439, 9, 'Audit', 1),
(440, 9, 'Business Analysis', 1),
(441, 9, 'Business Plans', 1),
(442, 9, 'Contracts', 1),
(443, 9, 'Employment Law', 1),
(444, 9, 'ERP', 1),
(445, 9, 'Event Planning', 1),
(446, 9, 'Finance', 1),
(447, 9, 'Fundraising', 1),
(448, 9, 'Human Resources', 1),
(449, 9, 'Inventory Management', 1),
(450, 9, 'ISO9001', 1),
(451, 9, 'Legal', 1),
(452, 9, 'Legal Research', 1),
(453, 9, 'Management', 1),
(454, 9, 'MYOB', 1),
(455, 9, 'Patents', 1),
(456, 9, 'Payroll', 1),
(457, 9, 'PeopleSoft', 1),
(458, 9, 'Personal Development', 1),
(459, 9, 'Project Management', 1),
(460, 9, 'Property Development', 1),
(461, 9, 'Property Law', 1),
(462, 9, 'Property Management', 1),
(463, 9, 'Public Relations', 1),
(464, 9, 'Quickbooks & Quicken', 1),
(465, 9, 'Recruitment', 1),
(466, 9, 'Salesforce.com', 1),
(467, 9, 'SAS', 1),
(468, 9, 'Tax', 1),
(469, 9, 'Tax Law', 1),
(470, 9, 'Visa / Immigration', 1),
(471, 10, 'Afrikaans', 1),
(472, 10, 'Arabic', 1),
(473, 10, 'Basque', 1),
(474, 10, 'Bengali', 1),
(475, 10, 'Bulgarian', 1),
(476, 10, 'Catalan', 1),
(477, 10, 'Croatian', 1),
(478, 10, 'Czech', 1),
(479, 10, 'Danish', 1),
(480, 10, 'Dutch', 1),
(481, 10, 'English', 1),
(482, 10, 'English', 1),
(483, 10, 'Filipino', 1),
(484, 10, 'Finnish', 1),
(485, 10, 'French', 1),
(486, 10, 'French', 1),
(487, 10, 'German', 1),
(488, 10, 'Greek', 1),
(489, 10, 'Hebrew', 1),
(490, 10, 'Hindi', 1),
(491, 10, 'Hungarian', 1),
(492, 10, 'Indonesian', 1),
(493, 10, 'Italian', 1),
(494, 10, 'Japanese', 1),
(495, 10, 'Korean', 1),
(496, 10, 'Lithuanian', 1),
(497, 10, 'Malay', 1),
(498, 10, 'Malayalam', 1),
(499, 10, 'Norwegian', 1),
(500, 10, 'Polish', 1),
(501, 10, 'Portuguese', 1),
(502, 10, 'Portuguese', 1),
(503, 10, 'Punjabi', 1),
(504, 10, 'Romanian', 1),
(505, 10, 'Russian', 1),
(506, 10, 'Serbian', 1),
(507, 10, 'Simplified Chinese', 1),
(508, 10, 'Slovakian', 1),
(509, 10, 'Slovenian', 1),
(510, 10, 'Spanish', 1),
(511, 10, 'Spanish', 1),
(512, 10, 'Swedish', 1),
(513, 10, 'Tamil', 1),
(514, 10, 'Telugu', 1),
(515, 10, 'Thai', 1),
(516, 10, 'Traditional Chinese', 1),
(517, 10, 'Traditional Chinese', 1),
(518, 10, 'Turkish', 1),
(519, 10, 'Urdu', 1),
(520, 10, 'Vietnamese', 1),
(521, 10, 'Welsh', 1),
(522, 11, 'Anything Goes', 1),
(523, 11, 'Automotive', 1),
(524, 11, 'Brain Storming', 1),
(525, 11, 'Cooking & Recipes', 1),
(526, 11, 'Dating', 1),
(527, 11, 'Education & Tutoring', 1),
(528, 11, 'Energy', 1),
(529, 11, 'Financial Markets', 1),
(530, 11, 'Flashmob', 1),
(531, 11, 'Freelance', 1),
(532, 11, 'Genealogy', 1),
(533, 11, 'Health', 1),
(534, 11, 'History', 1),
(535, 11, 'Insurance', 1),
(536, 11, 'Nutrition', 1),
(537, 11, 'Pattern Making', 1),
(538, 11, 'Psychology', 1),
(539, 11, 'Real Estate', 1),
(540, 11, 'Sports', 1),
(541, 11, 'Test Automation', 1),
(542, 11, 'Testing / QA', 1),
(543, 11, 'Training', 1),
(544, 11, 'Troubleshooting', 1),
(545, 11, 'Valuation & Appraisal', 1),
(546, 11, 'Weddings', 1),
(547, 11, 'XXX', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

DROP TABLE IF EXISTS `subcategory`;
CREATE TABLE `subcategory` (
  `scat_id` int(10) NOT NULL AUTO_INCREMENT,
  `scat_cat_id` int(10) NOT NULL,
  `scat_name` varchar(255) NOT NULL,
  `scat_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`scat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`scat_id`, `scat_cat_id`, `scat_name`, `scat_status`) VALUES
(1, 1, 'PHP/MySQL', 1),
(2, 1, 'JSP', 1);

-- --------------------------------------------------------

--
-- Table structure for table `temp_file_post`
--

DROP TABLE IF EXISTS `temp_file_post`;
CREATE TABLE `temp_file_post` (
  `fl_id` int(11) NOT NULL AUTO_INCREMENT,
  `fl_uid` int(11) DEFAULT NULL,
  `fl_filename` varchar(255) NOT NULL,
  PRIMARY KEY (`fl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `temp_file_post`
--


-- --------------------------------------------------------

--
-- Table structure for table `temp_proj_award`
--

DROP TABLE IF EXISTS `temp_proj_award`;
CREATE TABLE `temp_proj_award` (
  `tpa_id` int(10) NOT NULL AUTO_INCREMENT,
  `tpa_bd_id` int(10) NOT NULL,
  `tpa_updated_date` date NOT NULL,
  PRIMARY KEY (`tpa_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `temp_proj_award`
--

INSERT INTO `temp_proj_award` (`tpa_id`, `tpa_bd_id`, `tpa_updated_date`) VALUES
(16, 5, date_add(NOW(),INTERVAL -18 DAY)),
(17, 6, date_add(NOW(),INTERVAL -15 DAY));

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction` (
  `tr_id` int(10) NOT NULL AUTO_INCREMENT,
  `tr_to_id` int(10) NOT NULL,
  `tr_from_id` int(10) NOT NULL,
  `tr_prj_id` int(10) NOT NULL,
  `tr_amount` double(10,2) NOT NULL,
  `tr_type` varchar(50) NOT NULL,
  `tr_inv_id` int(10) DEFAULT NULL,
  `tr_release` int(1) NOT NULL DEFAULT '0',
  `tr_updated_date` date NOT NULL,
  `tr_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`tr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`tr_id`, `tr_to_id`, `tr_from_id`, `tr_prj_id`, `tr_amount`, `tr_type`, `tr_inv_id`, `tr_release`, `tr_updated_date`, `tr_status`) VALUES
(1, 0, 1, 0, 5.95, 'upgrade membership', NULL, 0, date_add(NOW(),INTERVAL -48 DAY), 1),
(2, 0, 4, 2, 5.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -46 DAY), 1),
(3, 0, 4, 2, 5.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -46 DAY), 1),
(4, 0, 5, 0, 5.95, 'upgrade membership', NULL, 0, date_add(NOW(),INTERVAL -46 DAY), 1),
(5, 0, 5, 3, 5.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -45 DAY), 1),
(6, 0, 4, 4, 5.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -45 DAY), 1),
(7, 0, 4, 2, 5.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -45 DAY), 1),
(8, 0, 4, 2, 46.25, 'freelancer fee', NULL, 0, date_add(NOW(),INTERVAL -42 DAY), 1),
(9, 0, 1, 2, 27.75, 'employer fee', NULL, 0, date_add(NOW(),INTERVAL -41 DAY), 1),
(10, 0, 4, 6, 5.00, 'promotion', NULL, 0, date_add(NOW(),INTERVAL -41 DAY), 1),
(11, 0, 4, 6, 5.00, 'promotion', NULL, 0, date_add(NOW(),INTERVAL -40 DAY), 1),
(12, 0, 1, 7, 18.00, 'promotion', NULL, 0, date_add(NOW(),INTERVAL -40 DAY), 1),
(13, 0, 1, 0, 5.95, 'upgrade membership', NULL, 0, date_add(NOW(),INTERVAL -40 DAY), 1),
(14, 0, 2, 7, 35.00, 'freelancer fee', NULL, 0, date_add(NOW(),INTERVAL -40 DAY), 1),
(15, 0, 1, 7, 21.00, 'employer fee', NULL, 0, date_add(NOW(),INTERVAL -39 DAY), 1),
(16, 0, 2, 13, 40.00, 'freelancer fee', NULL, 0, date_add(NOW(),INTERVAL -39 DAY), 1),
(17, 0, 3, 13, 32.00, 'employer fee', NULL, 0, date_add(NOW(),INTERVAL -40 DAY), 1),
(18, 0, 9, 35, 75.00, 'freelancer fee', NULL, 0, date_add(NOW(),INTERVAL -39 DAY), 1),
(19, 0, 1, 35, 45.00, 'employer fee', NULL, 0, date_add(NOW(),INTERVAL -38 DAY), 1),
(20, 9, 1, 35, 200.00, 'escrow', NULL, 1, date_add(NOW(),INTERVAL -37 DAY), 1),
(21, 0, 9, 36, 60.00, 'freelancer fee', NULL, 0, date_add(NOW(),INTERVAL -37 DAY), 1),
(22, 0, 1, 36, 36.00, 'employer fee', NULL, 0, date_add(NOW(),INTERVAL -37 DAY), 1),
(23, 9, 1, 36, 250.00, 'escrow', NULL, 1, date_add(NOW(),INTERVAL -37 DAY), 1),
(24, 0, 9, 37, 1.10, 'freelancer fee', NULL, 0, date_add(NOW(),INTERVAL -36 DAY), 1),
(25, 0, 1, 37, 0.66, 'employer fee', NULL, 0, date_add(NOW(),INTERVAL -36 DAY), 1),
(26, 9, 1, 37, 20.00, 'escrow', NULL, 1, date_add(NOW(),INTERVAL -35 DAY), 1),
(27, 9, 1, 37, 10.00, 'escrow', NULL, 1, '2013-09-22', 1),
(28, 0, 9, 38, 10.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -35 DAY), 1),
(29, 0, 9, 39, 10.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -35 DAY), 1),
(30, 0, 9, 39, 10.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -35 DAY), 1),
(31, 0, 9, 39, 10.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -35 DAY), 1),
(32, 0, 9, 39, 5.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -35 DAY), 1),
(33, 0, 9, 39, 5.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -35 DAY), 1),
(34, 0, 13, 43, 25.50, 'freelancer fee', NULL, 0, date_add(NOW(),INTERVAL -34 DAY), 1),
(35, 0, 1, 43, 15.30, 'employer fee', NULL, 0, date_add(NOW(),INTERVAL -34 DAY), 1),
(36, 0, 1, 45, 18.00, 'promotion', NULL, 0, date_add(NOW(),INTERVAL -34 DAY), 1),
(37, 0, 1, 6, 13.00, 'promotion', NULL, 0, date_add(NOW(),INTERVAL -34 DAY), 1),
(38, 0, 13, 45, 5.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -32 DAY), 1),
(39, 0, 13, 45, 62.50, 'freelancer fee', NULL, 0, date_add(NOW(),INTERVAL -32 DAY), 1),
(40, 0, 1, 45, 37.50, 'employer fee', NULL, 0, date_add(NOW(),INTERVAL -31 DAY), 1),
(41, 0, 1, 46, 28.00, 'promotion', NULL, 0, date_add(NOW(),INTERVAL -30 DAY), 1),
(42, 0, 1, 47, 13.00, 'promotion', NULL, 0, date_add(NOW(),INTERVAL -30 DAY), 1),
(43, 0, 1, 48, 26.00, 'promotion', NULL, 0, date_add(NOW(),INTERVAL -30 DAY), 1),
(44, 0, 1, 49, 5.00, 'promotion', NULL, 0, date_add(NOW(),INTERVAL -30 DAY), 1),
(45, 0, 1, 50, 18.00, 'promotion', NULL, 0, date_add(NOW(),INTERVAL -30 DAY), 1),
(46, 0, 1, 54, 5.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -30 DAY), 1),
(47, 0, 1, 54, 5.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -30 DAY), 1),
(48, 0, 1, 54, 0.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -29 DAY), 1),
(49, 0, 1, 54, 5.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -29 DAY), 1),
(52, 0, 1, 0, 5.95, 'upgrade membership', NULL, 0, date_add(NOW(),INTERVAL -29 DAY), 1),
(53, 13, 1, 43, 10.00, 'escrow', NULL, 1, date_add(NOW(),INTERVAL -28 DAY), 1),
(55, 0, 13, 0, 10.95, 'upgrade membership', NULL, 0, date_add(NOW(),INTERVAL -28 DAY), 1),
(56, 0, 1, 60, 13.00, 'promotion', NULL, 0, date_add(NOW(),INTERVAL -27 DAY), 1),
(57, 0, 1, 61, 5.00, 'promotion', NULL, 0, date_add(NOW(),INTERVAL -26 DAY), 1),
(58, 0, 1, 62, 5.00, 'promotion', NULL, 0, date_add(NOW(),INTERVAL -25 DAY), 1),
(59, 0, 1, 62, 5.00, 'promotion', NULL, 0, date_add(NOW(),INTERVAL -24 DAY), 1),
(60, 0, 1, 63, 5.00, 'promotion', NULL, 0, date_add(NOW(),INTERVAL -22 DAY), 1),
(63, 13, 1, 43, 20.00, 'escrow', NULL, 1, date_add(NOW(),INTERVAL -20 DAY), 1),
(64, 13, 1, 43, 20.00, 'escrow', NULL, 1, date_add(NOW(),INTERVAL -18 DAY), 1),
(65, 13, 1, 43, 20.00, 'escrow', NULL, 1, date_add(NOW(),INTERVAL -16 DAY), 1),
(66, 13, 1, 43, 15.00, 'escrow', NULL, 1, date_add(NOW(),INTERVAL -15 DAY), 1),
(67, 0, 13, 61, 5.00, 'bid promotion', NULL, 0, date_add(NOW(),INTERVAL -14 DAY), 1),
(68, 2, 3, 13, 100.00, 'invoice', 1, 0, date_add(NOW(),INTERVAL -12 DAY), 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `usr_id` int(12) NOT NULL AUTO_INCREMENT,
  `usr_name` varchar(255) NOT NULL,
  `usr_password` varchar(255) NOT NULL,
  `usr_mp_id` int(10) NOT NULL DEFAULT '1',
  `usr_mem_expiry` date NOT NULL,
  `usr_summary` text,
  `oauth_id` varchar(255) NOT NULL,
  `oauth_provider` varchar(255) NOT NULL,
  `usr_type` varchar(50) NOT NULL,
  `usr_email` varchar(255) NOT NULL,
  `usr_fname` varchar(255) DEFAULT NULL,
  `usr_lname` varchar(255) DEFAULT NULL,
  `usr_hourlyrate` double(8,2) NOT NULL DEFAULT '0.00',
  `usr_ct_id` int(10) DEFAULT NULL,
  `usr_address` text,
  `usr_gender` varchar(1) DEFAULT NULL,
  `usr_image` varchar(255) DEFAULT NULL,
  `usr_state` text NOT NULL,
  `usr_postalcode` int(8) NOT NULL,
  `usr_phone` varchar(255) NOT NULL,
  `usr_interests` text,
  `usr_website` varchar(255) DEFAULT NULL,
  `usr_emailVerified` int(1) NOT NULL DEFAULT '0',
  `usr_updated_date` date NOT NULL,
  `receive_newsletter` enum('1','0') NOT NULL DEFAULT '0',
  `receive_advice` enum('1','0') NOT NULL DEFAULT '0',
  `users_comment` enum('1','0') NOT NULL DEFAULT '0',
  `notify_refresh` enum('1','0') NOT NULL DEFAULT '0',
  `usr_lastlogin` datetime NOT NULL,
  `usr_loginip` varchar(255) NOT NULL,
  `usr_balance` double(10,2) NOT NULL DEFAULT '0.00',
  `usr_total_bid` int(10) NOT NULL,
  `usr_left_bid` int(11) NOT NULL,
  `usr_creation_date` date NOT NULL,
  `usr_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`usr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`usr_id`, `usr_name`, `usr_password`, `usr_mp_id`, `usr_mem_expiry`, `usr_summary`, `oauth_id`, `oauth_provider`, `usr_type`, `usr_email`, `usr_fname`, `usr_lname`, `usr_hourlyrate`, `usr_ct_id`, `usr_address`, `usr_gender`, `usr_image`, `usr_state`, `usr_postalcode`, `usr_phone`, `usr_interests`, `usr_website`, `usr_emailVerified`, `usr_updated_date`, `receive_newsletter`, `receive_advice`, `users_comment`, `notify_refresh`, `usr_lastlogin`, `usr_loginip`, `usr_balance`, `usr_total_bid`, `usr_left_bid`, `usr_creation_date`, `usr_status`) VALUES
(1, 'userdemo', '598db565fc4a30b682cb31ab78fa4c4008', 2, date_add(NOW(),INTERVAL 2 DAY), 'sample summary', '', '', 'Both', 'userdemo1@itechscripts.com', 'Userdemo', 'Userdemo', 10.00, 1, 'sdkjfhodgio', NULL, 'usr-4577Tulips.jpg', 'West Bengal', 700001, '7896542587', NULL, NULL, 1, date_add(NOW(),INTERVAL -30 DAY), '0', '0', '0', '0', date_add(NOW(),INTERVAL -1 DAY), '', 264.15, 20, 15, date_add(NOW(),INTERVAL -60 DAY), 1),
(2, 'freelancer', '7159c66b2b087b9891423907d990652a25', 2, '2013-08-29', NULL, '', '', '', 'newfreelancer@test.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 1, '2013-02-01', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 175.00, 5, 5, '0000-00-00', 1),
(3, 'joy', '3259c66b2b087b9891423907d990652a25', 1, '2013-03-06', NULL, '', '', '', 'joy@freelancerclone.com', 'abc', 'xyz', 0.00, 2, 'uyut', NULL, NULL, 'Maharastra', 400001, '8855998789', NULL, NULL, 0, '2013-08-29', '0', '0', '0', '0', '0000-00-00 00:00:00', '', -132.00, 0, 0, '0000-00-00', 1),
(4, 'Rahul', '59e10adc3949ba59abbe56e057f20f883e', 1, '2013-03-06', NULL, '', '', '', 'rs@gmail.com', 'Rahul', 'Bose', 0.00, 1, 'sadsasd', NULL, 'usr-959128483.1.jpg', 'West Bengal', 700097, '98989898', NULL, NULL, 0, '2013-02-06', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 525188.80, 0, 0, '0000-00-00', 1),
(5, 'sayan', '22af15d5fdacd5fdfea300e88a8e253e82', 2, '2013-03-06', 'yo', '', '', '', 'sd@gmail.com', 'Sayan', 'Das', 52.00, 3, 'adsadsad', NULL, 'usr-3406Koala.jpg', 'west bengal', 700097, '9864321365', NULL, NULL, 0, '2013-02-06', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 8978.05, 0, 0, '0000-00-00', 1),
(6, 'abcdef', '37e80b5017098950fc58aad83c8c14978e', 1, '2013-05-29', NULL, '', '', '', 'abcde@test.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 0, '2013-04-29', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 0.00, 0, 0, '0000-00-00', 1),
(7, 'abcd', '5959c66b2b087b9891423907d990652a25', 1, '2013-09-19', NULL, '', '', '', 'abcd@www.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 0, '2013-08-19', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 0.00, 0, 0, '0000-00-00', 1),
(8, 'abc', '6459c66b2b087b9891423907d990652a25', 1, '2013-09-26', NULL, '', '', '', 'abc@xyz.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 0, '2013-08-26', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 0.00, 0, 0, '0000-00-00', 1),
(9, 'newuser', '5071b3b26aaa319e0cdf6fdb8429c112b0', 1, '2013-09-30', NULL, '', '', 'Freelancer', 'qqq@ww.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 1, '2013-08-31', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 148.90, 0, 0, '2013-08-31', 1),
(10, 'empl', '4659c66b2b087b9891423907d990652a25', 1, '2013-10-02', NULL, '', '', 'Employer', 'qq@tt.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 0, '2013-09-02', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 0.00, 0, 0, '2013-09-02', 1),
(11, 'lnew', '8059c66b2b087b9891423907d990652a25', 1, '2013-10-02', NULL, '', '', 'Employer', 'aaaaaa@wwwwwwww.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 0, '2013-09-02', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 0.00, 0, 0, '2013-09-02', 1),
(12, 'new_freelancer', '4359c66b2b087b9891423907d990652a25', 1, '2013-10-24', NULL, '', '', 'Freelancer', 'newfreelancer@freelancer.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 0, '2013-09-24', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 0.00, 0, 0, '2013-09-24', 1),
(13, 'emuser', '7559c66b2b087b9891423907d990652a25', 3, '2014-02-06', 'fdgfsdgdfgfdg', '', '', 'Freelancer', 'aaaa@wwww.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 0, '2013-09-24', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 993.60, 10, 9, '2013-09-24', 1),
(14, 'testsign', '4159c66b2b087b9891423907d990652a25', 1, '2013-11-10', NULL, '', '', 'Both', 'abcd@wwwwwwwwwwwwwww.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 0, '2013-10-10', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 0.00, 0, 0, '2013-10-10', 1),
(15, 'aguser', '8059c66b2b087b9891423907d990652a25', 1, '2013-11-10', NULL, '', '', 'Both', 'qqqqqqqq@qq.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 0, '2013-10-10', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 0.00, 0, 0, '2013-10-10', 1),
(16, 'abcduser', '3259c66b2b087b9891423907d990652a25', 1, '2013-11-10', NULL, '', '', 'Both', 'qqqqqqq@eeeeeeeeeee.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 0, '2013-10-10', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 0.00, 0, 0, '2013-10-10', 1),
(17, 'abcdefghij', '8559c66b2b087b9891423907d990652a25', 1, '2014-01-18', NULL, '', '', 'Both', 'abcdefgh@wwww.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 0, '2013-12-18', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 0.00, 0, 0, '2013-12-18', 1),
(18, 'ksdf', '1959c66b2b087b9891423907d990652a25', 1, '2014-01-18', NULL, '', '', 'Both', 'abcd@eroiture.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 0, '2013-12-18', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 0.00, 0, 0, '2013-12-18', 1),
(19, 'aaaa', '3459c66b2b087b9891423907d990652a25', 1, '2014-01-18', NULL, '', '', 'Both', 'abcdefgh@wweeww.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 0, '2013-12-18', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 0.00, 0, 0, '2013-12-18', 1),
(20, 'abcd_user', '4259c66b2b087b9891423907d990652a25', 1, '2014-02-16', NULL, '', '', 'Both', 'abcdef@abcdef.com', NULL, NULL, 0.00, NULL, NULL, NULL, NULL, '', 0, '', NULL, NULL, 0, '2014-01-16', '0', '0', '0', '0', '0000-00-00 00:00:00', '', 0.00, 5, 5, '2014-01-16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_certification`
--

DROP TABLE IF EXISTS `user_certification`;
CREATE TABLE `user_certification` (
  `ucr_id` int(10) NOT NULL AUTO_INCREMENT,
  `ucr_usr_id` int(10) NOT NULL,
  `ucr_certificate` text NOT NULL,
  `ucr_organization` text NOT NULL,
  `ucr_year` int(4) NOT NULL,
  `ucr_description` text NOT NULL,
  PRIMARY KEY (`ucr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_certification`
--

INSERT INTO `user_certification` (`ucr_id`, `ucr_usr_id`, `ucr_certificate`, `ucr_organization`, `ucr_year`, `ucr_description`) VALUES
(2, 1, 'MCSE', 'Microsoft', 2012, 'flkgj idfjpigph o'),
(3, 2, 'MCSE', 'CU', 2004, 'abcd');

-- --------------------------------------------------------

--
-- Table structure for table `user_education`
--

DROP TABLE IF EXISTS `user_education`;
CREATE TABLE `user_education` (
  `ued_id` int(10) NOT NULL AUTO_INCREMENT,
  `ued_usr_id` int(10) NOT NULL,
  `ued_cn_id` int(10) NOT NULL,
  `ued_institute` text NOT NULL,
  `ued_degree` text NOT NULL,
  `ued_from_year` int(4) NOT NULL,
  `ued_to_year` int(4) NOT NULL,
  `ued_status` int(1) NOT NULL,
  PRIMARY KEY (`ued_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_education`
--

INSERT INTO `user_education` (`ued_id`, `ued_usr_id`, `ued_cn_id`, `ued_institute`, `ued_degree`, `ued_from_year`, `ued_to_year`, `ued_status`) VALUES
(2, 1, 104, 'C. U.', 'M.Sc.', 1998, 2001, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_email_setting`
--

DROP TABLE IF EXISTS `user_email_setting`;
CREATE TABLE `user_email_setting` (
  `ues_id` int(10) NOT NULL AUTO_INCREMENT,
  `ues_usr_id` int(10) NOT NULL,
  `ues_es_id` int(10) NOT NULL,
  PRIMARY KEY (`ues_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

--
-- Dumping data for table `user_email_setting`
--

INSERT INTO `user_email_setting` (`ues_id`, `ues_usr_id`, `ues_es_id`) VALUES
(3, 12, 4),
(4, 12, 5),
(5, 13, 1),
(6, 13, 2),
(7, 13, 3),
(8, 13, 4),
(9, 13, 5),
(10, 13, 6),
(11, 13, 7),
(12, 14, 1),
(13, 14, 2),
(14, 14, 3),
(15, 14, 4),
(16, 14, 5),
(17, 14, 6),
(18, 14, 7),
(19, 15, 1),
(20, 15, 2),
(21, 15, 3),
(22, 15, 4),
(23, 15, 5),
(24, 15, 6),
(25, 15, 7),
(26, 16, 1),
(27, 16, 2),
(28, 16, 3),
(29, 16, 4),
(30, 16, 5),
(31, 16, 6),
(32, 16, 7),
(33, 1, 1),
(34, 1, 2),
(35, 1, 3),
(36, 1, 4),
(37, 1, 5),
(38, 17, 1),
(39, 17, 2),
(40, 17, 3),
(41, 17, 4),
(42, 17, 5),
(43, 17, 6),
(44, 17, 7),
(45, 18, 1),
(46, 18, 2),
(47, 18, 3),
(48, 18, 4),
(49, 18, 5),
(50, 18, 6),
(51, 18, 7),
(52, 19, 1),
(53, 19, 2),
(54, 19, 3),
(55, 19, 4),
(56, 19, 5),
(57, 19, 6),
(58, 19, 7),
(59, 20, 1),
(60, 20, 2),
(61, 20, 3),
(62, 20, 4),
(63, 20, 5),
(64, 20, 6),
(65, 20, 7);

-- --------------------------------------------------------

--
-- Table structure for table `user_experience`
--

DROP TABLE IF EXISTS `user_experience`;
CREATE TABLE `user_experience` (
  `ue_id` int(10) NOT NULL AUTO_INCREMENT,
  `ue_usr_id` int(10) NOT NULL,
  `ue_title` text NOT NULL,
  `ue_company` text NOT NULL,
  `ue_from_month` int(11) NOT NULL,
  `ue_from_year` int(4) NOT NULL,
  `ue_to_month` int(11) DEFAULT NULL,
  `ue_to_year` int(4) DEFAULT NULL,
  `ue_summary` text NOT NULL,
  `ue_current` int(1) NOT NULL,
  PRIMARY KEY (`ue_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_experience`
--

INSERT INTO `user_experience` (`ue_id`, `ue_usr_id`, `ue_title`, `ue_company`, `ue_from_month`, `ue_from_year`, `ue_to_month`, `ue_to_year`, `ue_summary`, `ue_current`) VALUES
(2, 1, 'abcd job', 'xyz comps', 1, 2010, 2, 2012, 'test summary', 0),
(3, 1, 'wwww', 'jgkhuy', 0, 2011, 1, 2012, 'dfytfr uytuyt', 0),
(4, 2, 'abcd', 'xyz', 0, 2010, NULL, NULL, 'fdgkljtgj  poitpoipoi', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_login_details`
--

DROP TABLE IF EXISTS `user_login_details`;
CREATE TABLE `user_login_details` (
  `uld_id` int(10) NOT NULL AUTO_INCREMENT,
  `uld_usr_id` int(10) NOT NULL,
  `uld_last_login` datetime NOT NULL,
  `uld_ip` varchar(255) NOT NULL,
  PRIMARY KEY (`uld_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=341 ;

--
-- Dumping data for table `user_login_details`
--

INSERT INTO `user_login_details` (`uld_id`, `uld_usr_id`, `uld_last_login`, `uld_ip`) VALUES
(1, 1, '2013-02-01 11:27:59', '::1'),
(2, 1, '2013-02-01 15:26:32', '::1'),
(10, 1, '2013-02-06 16:58:54', '::1'),
(27, 5, '2013-02-06 18:59:55', '192.168.1.102'),
(28, 4, '2013-02-07 10:16:15', '192.168.1.102'),
(29, 4, '2013-02-07 11:20:48', '192.168.1.102'),
(30, 2, '2013-02-07 11:20:54', '::1'),
(43, 1, '2013-08-20 02:57:32', '::1'),
(44, 1, '2013-08-20 04:04:11', '::1'),
(45, 1, '2013-08-20 06:34:31', '::1'),
(46, 1, '2013-08-21 00:30:11', '::1'),
(47, 1, '2013-08-22 02:02:21', '::1'),
(48, 2, '2013-08-22 22:53:43', '::1'),
(49, 1, '2013-08-26 05:01:53', '127.0.0.1'),
(50, 1, '2013-08-26 05:02:23', '127.0.0.1'),
(51, 7, '2013-08-26 06:16:33', '127.0.0.1'),
(52, 7, '2013-09-21 17:14:33', '127.0.0.1'),
(53, 1, '2013-08-26 09:48:36', '127.0.0.1'),
(54, 1, '2013-08-26 09:51:58', '127.0.0.1'),
(72, 3, '2013-09-22 17:14:33', '127.0.0.1'),
(73, 2, '2013-08-30 17:38:19', '127.0.0.1'),
(74, 2, '2013-08-31 13:28:25', '127.0.0.1'),
(75, 2, '2013-09-21 17:14:33', '127.0.0.1'),
(76, 9, '2013-08-31 18:14:13', '127.0.0.1'),
(77, 9, '2013-08-31 18:22:12', '127.0.0.1'),
(78, 9, '2013-09-02 10:56:07', '127.0.0.1'),
(79, 9, '2013-09-02 13:27:03', '127.0.0.1'),
(80, 9, '2013-09-02 13:54:59', '127.0.0.1'),
(81, 9, '2013-09-02 13:56:57', '127.0.0.1'),
(82, 9, '2013-09-02 14:38:11', '127.0.0.1'),
(83, 9, '2013-09-02 14:47:08', '127.0.0.1'),
(84, 9, '2013-09-02 15:02:53', '127.0.0.1'),
(85, 9, '2013-09-02 17:04:20', '127.0.0.1'),
(86, 9, '2013-09-02 17:06:55', '127.0.0.1'),
(87, 10, '2013-09-02 17:23:23', '127.0.0.1'),
(88, 10, '2013-09-02 17:28:58', '127.0.0.1'),
(89, 10, '2013-09-02 17:31:46', '127.0.0.1'),
(90, 10, '2013-09-02 17:34:05', '127.0.0.1'),
(91, 10, '2013-09-02 17:39:05', '127.0.0.1'),
(92, 10, '2013-09-02 17:40:58', '127.0.0.1'),
(93, 10, '2013-09-02 17:44:45', '127.0.0.1'),
(94, 10, '2013-09-22 17:14:33', '127.0.0.1'),
(95, 11, '2013-09-22 17:14:33', '127.0.0.1'),
(110, 1, '2013-09-06 14:06:17', '127.0.0.1'),
(111, 9, '2013-09-06 14:10:18', '127.0.0.1'),
(112, 1, '2013-09-06 14:18:06', '127.0.0.1'),
(113, 9, '2013-09-06 14:19:38', '127.0.0.1'),
(114, 9, '2013-09-06 15:04:12', '127.0.0.1'),
(115, 1, '2013-09-09 10:12:13', '127.0.0.1'),
(116, 9, '2013-09-09 10:14:11', '127.0.0.1'),
(117, 1, '2013-09-09 11:21:41', '127.0.0.1'),
(118, 9, '2013-09-09 11:23:52', '127.0.0.1'),
(119, 1, '2013-09-09 11:27:53', '127.0.0.1'),
(120, 1, '2013-09-09 11:34:45', '127.0.0.1'),
(121, 9, '2013-09-09 11:35:47', '127.0.0.1'),
(155, 1, '2013-09-18 15:38:19', '127.0.0.1'),
(156, 9, '2013-09-18 15:39:04', '127.0.0.1'),
(157, 1, '2013-09-18 18:37:59', '127.0.0.1'),
(158, 1, '2013-09-18 18:46:53', '127.0.0.1'),
(159, 9, '2013-09-22 17:14:33', '127.0.0.1'),
(160, 1, '2013-09-18 15:36:27', '59.93.198.164'),
(161, 1, '2013-09-18 15:37:44', '59.93.198.164'),
(162, 1, '2013-09-21 11:36:45', '59.93.196.227'),
(163, 1, '2013-09-21 11:37:05', '59.93.196.227'),
(164, 1, '2013-09-21 14:30:09', '174.103.166.21'),
(165, 1, '2013-09-22 11:42:29', '59.93.246.66'),
(166, 1, '2013-09-22 11:57:21', '95.35.56.28'),
(167, 1, '2013-09-22 11:57:21', '95.35.56.28'),
(168, 1, '2013-09-22 17:14:33', '95.35.56.28'),
(169, 12, '2013-09-24 11:42:04', '127.0.0.1'),
(170, 12, '2013-09-24 11:43:56', '127.0.0.1'),
(171, 13, '2013-09-24 12:08:30', '127.0.0.1'),
(172, 1, '2013-09-24 12:10:09', '127.0.0.1'),
(173, 1, '2013-09-24 13:27:55', '127.0.0.1'),
(174, 1, '2013-09-24 14:53:57', '127.0.0.1'),
(175, 1, '2013-09-24 14:54:42', '127.0.0.1'),
(176, 1, '2013-09-24 15:16:01', '127.0.0.1'),
(177, 1, '2013-09-30 12:42:37', '127.0.0.1'),
(178, 1, '2013-09-30 13:20:24', '127.0.0.1'),
(179, 1, '2013-09-30 21:16:38', '127.0.0.1'),
(200, 1, '2013-10-09 16:20:55', '127.0.0.1'),
(201, 1, '2013-10-09 16:57:39', '127.0.0.1'),
(202, 13, '2013-10-09 17:46:31', '127.0.0.1'),
(203, 1, '2013-10-09 17:48:17', '127.0.0.1'),
(204, 13, '2013-10-09 17:49:58', '127.0.0.1'),
(205, 13, '2013-10-09 18:45:59', '127.0.0.1'),
(206, 1, '2013-10-09 19:30:21', '127.0.0.1'),
(207, 13, '2013-10-09 19:36:59', '127.0.0.1'),
(208, 1, '2013-10-09 19:43:34', '127.0.0.1'),
(209, 13, '2013-10-09 19:44:08', '127.0.0.1'),
(210, 1, '2013-10-09 19:52:06', '127.0.0.1'),
(211, 1, '2013-10-10 09:59:00', '127.0.0.1'),
(212, 1, '2013-10-10 11:30:14', '127.0.0.1'),
(213, 1, '2013-10-10 11:32:11', '127.0.0.1'),
(214, 1, '2013-10-10 11:37:22', '127.0.0.1'),
(215, 13, '2013-10-10 12:11:03', '127.0.0.1'),
(216, 12, '2013-10-10 12:16:09', '127.0.0.1'),
(217, 1, '2013-10-10 12:16:53', '127.0.0.1'),
(218, 12, '2013-10-10 12:19:31', '127.0.0.1'),
(219, 1, '2013-10-10 14:37:23', '127.0.0.1'),
(220, 1, '2013-10-10 17:06:24', '127.0.0.1'),
(221, 1, '2013-10-10 17:09:57', '127.0.0.1'),
(222, 1, '2013-10-10 17:17:36', '127.0.0.1'),
(223, 14, '2013-10-10 17:35:22', '127.0.0.1'),
(224, 15, '2013-10-10 17:44:52', '127.0.0.1'),
(225, 16, '2013-10-10 18:17:33', '127.0.0.1'),
(226, 1, '2013-10-20 20:13:24', '::1'),
(227, 1, '2013-10-22 01:44:38', '::1'),
(228, 1, '2013-10-22 23:41:50', '::1'),
(229, 1, '2013-10-23 12:48:10', '127.0.0.1'),
(230, 1, '2013-10-23 15:20:44', '127.0.0.1'),
(231, 16, '2013-10-23 18:09:38', '127.0.0.1'),
(232, 1, '2013-10-23 19:02:32', '127.0.0.1'),
(233, 1, '2013-10-24 10:57:11', '127.0.0.1'),
(234, 1, '2013-10-24 13:37:39', '127.0.0.1'),
(235, 1, '2013-11-11 13:09:02', '::1'),
(236, 1, '2013-11-29 15:55:08', '::1'),
(261, 1, '2014-01-06 16:45:43', '::1'),
(262, 13, '2014-01-06 16:46:32', '::1'),
(263, 1, '2014-01-06 19:13:57', '::1'),
(264, 1, '2014-01-07 10:43:54', '::1'),
(265, 1, '2014-01-07 11:56:50', '::1'),
(266, 1, '2014-01-07 19:46:26', '::1'),
(267, 13, '2014-01-09 10:31:05', '::1'),
(268, 1, '2014-01-09 10:33:00', '::1'),
(269, 1, '2014-01-09 10:59:29', '::1'),
(270, 1, '2014-01-09 11:10:09', '::1'),
(271, 1, '2014-01-10 15:01:07', '::1'),
(272, 1, '2014-01-11 13:49:33', '::1'),
(273, 13, '2014-01-14 18:31:19', '::1'),
(274, 1, '2014-01-15 11:33:48', '::1'),
(275, 13, '2014-01-15 15:18:09', '::1'),
(276, 1, '2014-01-15 15:29:30', '::1'),
(277, 13, '2014-01-15 15:33:30', '::1'),
(278, 13, '2014-01-15 15:41:58', '::1'),
(279, 1, '2014-01-15 15:42:42', '::1'),
(280, 13, '2014-01-15 15:43:40', '::1'),
(281, 1, '2014-01-15 15:44:20', '::1'),
(282, 13, '2014-01-15 15:45:01', '::1'),
(283, 1, '2014-01-15 15:45:45', '::1'),
(284, 13, '2014-01-15 15:47:08', '::1'),
(285, 1, '2014-01-15 15:49:02', '::1'),
(286, 13, '2014-01-15 15:53:54', '::1'),
(287, 1, '2014-01-15 16:03:19', '::1'),
(288, 1, '2014-01-15 16:25:44', '::1'),
(289, 13, '2014-01-15 16:43:13', '::1'),
(290, 1, '2014-01-15 17:48:03', '::1'),
(291, 13, '2014-01-15 17:50:36', '::1'),
(292, 1, '2014-01-15 17:51:34', '::1'),
(293, 13, '2014-01-15 18:17:25', '::1'),
(294, 1, '2014-01-15 19:07:06', '::1'),
(295, 13, '2014-01-16 11:33:58', '::1'),
(296, 1, '2014-01-16 15:33:39', '::1'),
(297, 10, '2014-01-16 16:07:04', '::1'),
(298, 1, '2014-01-16 16:31:26', '::1'),
(299, 11, '2014-01-16 16:32:18', '::1'),
(300, 1, '2014-01-16 16:33:11', '::1'),
(301, 20, '2014-01-16 16:43:53', '::1'),
(302, 1, '2014-01-16 19:00:42', '::1'),
(303, 20, '2014-01-16 19:01:01', '::1'),
(304, 20, '2014-01-17 12:01:20', '::1'),
(305, 1, '2014-01-17 14:47:24', '::1'),
(306, 1, '2014-01-17 14:47:46', '::1'),
(307, 2, '2014-01-17 16:29:30', '::1'),
(308, 1, '2014-01-21 18:49:16', '::1'),
(309, 2, '2014-01-21 19:09:43', '::1'),
(310, 1, '2014-01-21 19:11:01', '::1'),
(311, 2, '2014-01-21 19:34:21', '::1'),
(312, 1, date_add(NOW(),INTERVAL -14 DAY), '::1'),
(313, 2, '2014-01-22 11:20:07', '::1'),
(314, 1, date_add(NOW(),INTERVAL -12 DAY), '::1'),
(315, 1, date_add(NOW(),INTERVAL -10 DAY), '::1'),
(316, 2, '2014-01-22 18:22:18', '::1'),
(317, 1, date_add(NOW(),INTERVAL -9 DAY), '::1'),
(318, 2, '2014-01-22 18:47:06', '::1'),
(319, 1, '2014-01-24 12:39:51', '::1'),
(320, 2, '2014-01-24 13:42:43', '::1'),
(321, 3, '2014-01-24 13:57:19', '::1'),
(322, 2, '2014-01-24 14:20:27', '::1'),
(323, 3, '2014-01-24 14:23:10', '::1'),
(324, 2, '2014-01-24 15:08:20', '::1'),
(325, 3, '2014-01-24 15:11:12', '::1'),
(326, 2, '2014-01-24 15:15:23', '::1'),
(327, 2, '2014-01-24 15:17:05', '::1'),
(328, 3, '2014-01-24 15:43:49', '::1'),
(329, 2, '2014-01-24 15:44:46', '::1'),
(330, 2, '2014-01-24 15:52:21', '::1'),
(331, 2, '2014-01-24 17:59:40', '::1'),
(332, 3, date_add(NOW(),INTERVAL -8 DAY), '::1'),
(333, 1, date_add(NOW(),INTERVAL -7 DAY), '::1'),
(334, 1, date_add(NOW(),INTERVAL -6 DAY), '::1'),
(335, 1, date_add(NOW(),INTERVAL -5 DAY), '::1'),
(336, 1, date_add(NOW(),INTERVAL -4 DAY), '::1'),
(337, 1, date_add(NOW(),INTERVAL -3 DAY), '::1'),
(338, 1, date_add(NOW(),INTERVAL -2 DAY), '::1'),
(339, 1, date_add(NOW(),INTERVAL -1 DAY), '::1'),
(340, 2, date_add(NOW(),INTERVAL -1 DAY), '::1');

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

DROP TABLE IF EXISTS `user_notification`;
CREATE TABLE `user_notification` (
  `un_id` int(11) NOT NULL AUTO_INCREMENT,
  `un_usr_id` int(11) NOT NULL,
  `un_from_usr_id` int(11) NOT NULL,
  `un_type` varchar(255) NOT NULL,
  `un_content` text NOT NULL,
  `un_prj_id` int(11) NOT NULL,
  `un_updated_date` datetime NOT NULL,
  `un_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`un_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `user_notification`
--

INSERT INTO `user_notification` (`un_id`, `un_usr_id`, `un_from_usr_id`, `un_type`, `un_content`, `un_prj_id`, `un_updated_date`, `un_status`) VALUES
(5, 5, 4, 'awardproject', 'Rahul has awarded you for winning bidder.', 3, date_add(NOW(),INTERVAL -41 DAY), 1),
(6, 4, 5, 'awardproject', 'sayan has awarded you for winning bidder.', 4, date_add(NOW(),INTERVAL -40 DAY), 1),
(7, 4, 1, 'awardproject', 'test has awarded you for winning bidder.', 2, date_add(NOW(),INTERVAL -39 DAY), 1),
(8, 1, 4, 'accept project', 'Rahul has accept your project.', 2, date_add(NOW(),INTERVAL -38 DAY), 0),
(10, 2, 1, 'awardproject', 'userdemo has awarded you for winning bidder.', 7, date_add(NOW(),INTERVAL -37 DAY), 1),
(11, 1, 2, 'accept project', 'freelancer has accept your project.', 7, date_add(NOW(),INTERVAL -36 DAY), 0),
(12, 2, 3, 'awardproject', 'joy has awarded you for winning bidder.', 13, date_add(NOW(),INTERVAL -35 DAY), 0),
(13, 3, 2, 'accept project', 'freelancer has accept your project.', 13, date_add(NOW(),INTERVAL -34 DAY), 0),
(14, 1, 3, 'invite', 'joy has invited you for the project <a href="project.php?p=14">testttttt project</a>.', 14, date_add(NOW(),INTERVAL -34 DAY), 0),
(15, 9, 1, 'awardproject', 'userdemo has awarded you for winning bidder.', 35, date_add(NOW(),INTERVAL -32 DAY), 1),
(16, 1, 9, 'accept project', 'newuser has accept your project.', 35, date_add(NOW(),INTERVAL -32 DAY), 0),
(17, 9, 1, 'escrow', 'userdemo has deposited $200 USD in ESCROW', 35, date_add(NOW(),INTERVAL -31 DAY), 1),
(23, 1, 9, 'accept project', 'newuser has accept your project.', 36, date_add(NOW(),INTERVAL -30 DAY), 0),
(21, 9, 1, 'dispute', 'userdemo has dispute the project with the amount of $200 USD|5', 35, date_add(NOW(),INTERVAL -29 DAY), 1),
(22, 9, 1, 'awardproject', 'userdemo has awarded you for winning bidder.', 36, date_add(NOW(),INTERVAL -28 DAY), 1),
(24, 9, 1, 'escrow', 'userdemo has deposited $250 USD in ESCROW', 36, date_add(NOW(),INTERVAL -27 DAY), 1),
(25, 9, 1, 'dispute', 'userdemo has dispute the project with the amount of $100 USD|6', 36, date_add(NOW(),INTERVAL -26 DAY), 1),
(26, 9, 1, 'awardproject', 'userdemo has awarded you for winning bidder.', 37, date_add(NOW(),INTERVAL -26 DAY), 1),
(27, 1, 9, 'accept project', 'newuser has accept your project.', 37, date_add(NOW(),INTERVAL -25 DAY), 0),
(28, 9, 1, 'escrow', 'userdemo has deposited $20 USD in ESCROW', 37, date_add(NOW(),INTERVAL -25 DAY), 1),
(29, 9, 1, 'dispute', 'userdemo has dispute the project with the amount of $10 USD|7', 37, date_add(NOW(),INTERVAL -25 DAY), 1),
(30, 9, 1, 'escrow', 'userdemo has deposited $10 USD in ESCROW', 37, date_add(NOW(),INTERVAL -24 DAY), 1),
(31, 9, 1, 'dispute', 'userdemo has dispute the project with the amount of $5 USD|8', 37, date_add(NOW(),INTERVAL -24 DAY), 1),
(32, 13, 1, 'awardproject', 'userdemo1 has awarded you for winning quote.', 43, date_add(NOW(),INTERVAL -22 DAY), 1),
(33, 1, 13, 'accept project', 'emuser has accept your job.', 43, date_add(NOW(),INTERVAL -21 DAY), 0),
(34, 13, 1, 'awardproject', 'userdemo1 has awarded you for winning quote.', 45, date_add(NOW(),INTERVAL -20 DAY), 0),
(35, 1, 13, 'accept project', 'emuser has accept your job.', 45, date_add(NOW(),INTERVAL -19 DAY), 0),
(36, 0, 1, 'escrow', 'userdemo has deposited $10 USD in ESCROW', 43, date_add(NOW(),INTERVAL -18 DAY), 1),
(37, 13, 1, 'dispute', 'userdemo has dispute the project with the amount of $8 USD|8', 43, date_add(NOW(),INTERVAL -18 DAY), 1),
(38, 0, 1, 'escrow', 'userdemo has deposited $12 USD in ESCROW', 43, date_add(NOW(),INTERVAL -17 DAY), 1),
(39, 0, 1, 'escrow', 'userdemo has deposited $10 USD in ESCROW', 43, date_add(NOW(),INTERVAL -16 DAY), 1),
(40, 13, 1, 'escrow', 'userdemo has deposited $20 USD in ESCROW', 43, date_add(NOW(),INTERVAL -15 DAY), 1),
(41, 13, 1, 'release', 'userdemo has release $20.00 USD from ESCROW', 43, date_add(NOW(),INTERVAL -14 DAY), 1),
(42, 13, 1, 'dispute', 'userdemo has dispute the project with the amount of $8 USD|9', 43, date_add(NOW(),INTERVAL -14 DAY), 1),
(43, 13, 1, 'escrow', 'userdemo has deposited $20 USD in ESCROW', 43, date_add(NOW(),INTERVAL -12 DAY), 1),
(44, 13, 1, 'release', 'userdemo has release $20.00 USD from ESCROW', 43, date_add(NOW(),INTERVAL -12 DAY), 1),
(45, 13, 1, 'escrow', 'userdemo has deposited $25 USD in ESCROW', 43, date_add(NOW(),INTERVAL -10 DAY), 1),
(46, 13, 1, 'dispute', 'userdemo has dispute the project with the amount of $20 USD|10', 43, date_add(NOW(),INTERVAL -9 DAY), 0),
(47, 13, 1, 'escrow', 'userdemo has deposited $20 USD in ESCROW', 43, date_add(NOW(),INTERVAL -8 DAY), 0),
(48, 13, 1, 'dispute', 'userdemo has dispute the project with the amount of $15 USD|11', 43, date_add(NOW(),INTERVAL -6 DAY), 0),
(49, 10, 1, 'invite', 'userdemo has invited you for the project <a href="project.php?p=60">CRM site</a>.', 60, date_add(NOW(),INTERVAL -5 DAY), 0),
(50, 11, 1, 'invite', 'userdemo has invited you for the project <span style="color:#309">CRM site</span>.', 60, date_add(NOW(),INTERVAL -4 DAY), 0),
(54, 3, 2, 'invoice', 'freelancer has sent you a invoice(No.2)', 13, date_add(NOW(),INTERVAL -3 DAY), 1),
(53, 3, 2, 'invoice', 'freelancer has sent you a invoice(No.1)', 13, date_add(NOW(),INTERVAL -2 DAY), 0),
(55, 2, 3, 'invoice', 'joy has paid your invoice(No.1)', 13, date_add(NOW(),INTERVAL -1 DAY), 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_portfolio`
--

DROP TABLE IF EXISTS `user_portfolio`;
CREATE TABLE `user_portfolio` (
  `up_id` int(10) NOT NULL AUTO_INCREMENT,
  `up_usr_id` int(10) NOT NULL,
  `up_title` text NOT NULL,
  `up_description` text NOT NULL,
  `up_file` varchar(255) NOT NULL,
  `up_skills` varchar(255) NOT NULL,
  PRIMARY KEY (`up_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `user_portfolio`
--

INSERT INTO `user_portfolio` (`up_id`, `up_usr_id`, `up_title`, `up_description`, `up_file`, `up_skills`) VALUES
(11, 1, 'zzzxxxwwwrrr', 'fd ojgoitr ptyi potyiptoppogjpghgolkg jhgkl hgkl', '', '1,4,'),
(13, 2, 'test profile', 'sample profile description', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_skills`
--

DROP TABLE IF EXISTS `user_skills`;
CREATE TABLE `user_skills` (
  `usk_id` int(10) NOT NULL AUTO_INCREMENT,
  `usk_usr_id` int(10) NOT NULL,
  `usk_sk_id` int(10) NOT NULL,
  PRIMARY KEY (`usk_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=430 ;

--
-- Dumping data for table `user_skills`
--

INSERT INTO `user_skills` (`usk_id`, `usk_usr_id`, `usk_sk_id`) VALUES
(429, 1, 543),
(428, 1, 83),
(53, 2, 6),
(52, 2, 1),
(427, 1, 11),
(426, 1, 4),
(61, 12, 1),
(62, 12, 14),
(63, 12, 29),
(64, 12, 34),
(425, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_funds`
--

DROP TABLE IF EXISTS `withdraw_funds`;
CREATE TABLE `withdraw_funds` (
  `wf_id` int(10) NOT NULL AUTO_INCREMENT,
  `wf_usr_id` int(10) NOT NULL,
  `wf_gatewayName` varchar(255) NOT NULL,
  `wf_gatewayId` varchar(255) NOT NULL,
  `wf_amount` double(10,2) NOT NULL,
  `wf_updated_date` date NOT NULL,
  `wf_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`wf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `withdraw_funds`
--