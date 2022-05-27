<?php
ob_start();
session_start();
include "../common.php";

if($_POST['page'])
{
$page = $_POST['page'];
$cur_page = $page;
$page -= 1;
$per_page = 10; // Per page records
$previous_btn = true;
$next_btn = true;
//$first_btn = false;
//$last_btn = false;
$start = $page * $per_page;

$sql_inbox="select * from message,user,project where msg_to='".$_SESSION['uid']."' and msg_from=usr_id and msg_prj_id=prj_id and msg_to_status='1' order by msg_date desc LIMIT ".$start.", ".$per_page;
$recObj=mysql_query($sql_inbox) or die('MySql Error' . mysql_error());

/* -----Total count--- */
$query_pag_num = "SELECT count(*) AS count from message,user,project where msg_to='".$_SESSION['uid']."' and msg_from=usr_id and msg_prj_id=prj_id and msg_to_status='1'"; // Total records

$result_pag_num = mysql_query($query_pag_num);
$row = mysql_fetch_array($result_pag_num);
$count = $row['count'];
$no_of_paginations = ceil($count / $per_page);

/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
if($cur_page >= 7)
{
    $start_loop = $cur_page - 3;
    if($no_of_paginations > $cur_page + 3)
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
    if($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
?>
<div class="tab-pane in active">
													<div class="message-container">
														<div id="id-message-list-navbar" class="message-navbar align-center clearfix">
															<div class="message-bar">
																<div class="message-infobar" id="id-message-infobar">
																	<span class="blue bigger-150">Sentbox</span>
																	<span class="grey bigger-110">(2 unread messages)</span>
																</div>

																<div class="message-toolbar hide">
																	<div class="inline position-relative align-left">
																		<a href="#" class="btn-message btn btn-xs dropdown-toggle" data-toggle="dropdown">
																			<span class="bigger-110">Action</span>

																			<i class="icon-caret-down icon-on-right"></i>
																		</a>

																		<ul class="dropdown-menu dropdown-lighter dropdown-caret dropdown-125">
																			<li>
																				<a href="#">
																					<i class="icon-mail-reply blue"></i>
																					&nbsp; Reply
																				</a>
																			</li>

																			<li>
																				<a href="#">
																					<i class="icon-mail-forward green"></i>
																					&nbsp; Forward
																				</a>
																			</li>

																			<li>
																				<a href="#">
																					<i class="icon-folder-open orange"></i>
																					&nbsp; Archive
																				</a>
																			</li>

																			<li class="divider"></li>

																			<li>
																				<a href="#">
																					<i class="icon-eye-open blue"></i>
																					&nbsp; Mark as read
																				</a>
																			</li>

																			<li>
																				<a href="#">
																					<i class="icon-eye-close green"></i>
																					&nbsp; Mark unread
																				</a>
																			</li>

																			<li>
																				<a href="#">
																					<i class="icon-flag-alt red"></i>
																					&nbsp; Flag
																				</a>
																			</li>

																			<li class="divider"></li>

																			<li>
																				<a href="#">
																					<i class="icon-trash red bigger-110"></i>
																					&nbsp; Delete
																				</a>
																			</li>
																		</ul>
																	</div>

																	<div class="inline position-relative align-left">
																		<a href="#" class="btn-message btn btn-xs dropdown-toggle" data-toggle="dropdown">
																			<i class="icon-folder-close-alt bigger-110"></i>
																			<span class="bigger-110">Move to</span>

																			<i class="icon-caret-down icon-on-right"></i>
																		</a>

																		<ul class="dropdown-menu dropdown-lighter dropdown-caret dropdown-125">
																			<li>
																				<a href="#">
																					<i class="icon-stop pink2"></i>
																					&nbsp; Tag#1
																				</a>
																			</li>

																			<li>
																				<a href="#">
																					<i class="icon-stop blue"></i>
																					&nbsp; Family
																				</a>
																			</li>

																			<li>
																				<a href="#">
																					<i class="icon-stop green"></i>
																					&nbsp; Friends
																				</a>
																			</li>

																			<li>
																				<a href="#">
																					<i class="icon-stop grey"></i>
																					&nbsp; Work
																				</a>
																			</li>
																		</ul>
																	</div>

																	<a href="#" class="btn btn-xs btn-message">
																		<i class="icon-trash bigger-125"></i>
																		<span class="bigger-110">Delete</span>
																	</a>
																</div>
															</div>

															<div>
																<div class="messagebar-item-left">
																	<label class="inline middle">
																		<input type="checkbox" id="id-toggle-all" class="ace" />
																		<span class="lbl"></span>
																	</label>

																	&nbsp;
																	<div class="inline position-relative">
																		<a href="#" data-toggle="dropdown" class="dropdown-toggle">
																			<i class="icon-caret-down bigger-125 middle"></i>
																		</a>

																		<ul class="dropdown-menu dropdown-lighter dropdown-100">
																			<li>
																				<a id="id-select-message-all" href="#">All</a>
																			</li>

																			<li>
																				<a id="id-select-message-none" href="#">None</a>
																			</li>

																			<li class="divider"></li>

																			<li>
																				<a id="id-select-message-unread" href="#">Unread</a>
																			</li>

																			<li>
																				<a id="id-select-message-read" href="#">Read</a>
																			</li>
																		</ul>
																	</div>
																</div>

																<div class="messagebar-item-right">
																	<div class="inline position-relative">
																		<a href="#" data-toggle="dropdown" class="dropdown-toggle">
																			Sort &nbsp;
																			<i class="icon-caret-down bigger-125"></i>
																		</a>

																		<ul class="dropdown-menu dropdown-lighter pull-right dropdown-100">
																			<li>
																				<a href="#">
																					<i class="icon-ok green"></i>
																					Date
																				</a>
																			</li>

																			<li>
																				<a href="#">
																					<i class="icon-ok invisible"></i>
																					From
																				</a>
																			</li>

																			<li>
																				<a href="#">
																					<i class="icon-ok invisible"></i>
																					Subject
																				</a>
																			</li>
																		</ul>
																	</div>
																</div>

																<div class="nav-search minimized">
																	<form class="form-search">
																		<span class="input-icon">
																			<input type="text" autocomplete="off" class="input-small nav-search-input" placeholder="Search inbox ..." />
																			<i class="icon-search nav-search-icon"></i>
																		</span>
																	</form>
																</div>
															</div>
														</div>

														<div id="id-message-item-navbar" class="hide message-navbar align-center clearfix">
															<div class="message-bar">
																<div class="message-toolbar">
																	<div class="inline position-relative align-left">
																		<a href="#" class="btn-message btn btn-xs dropdown-toggle" data-toggle="dropdown">
																			<span class="bigger-110">Action</span>

																			<i class="icon-caret-down icon-on-right"></i>
																		</a>

																		<ul class="dropdown-menu dropdown-lighter dropdown-caret dropdown-125">
																			<li>
																				<a href="#">
																					<i class="icon-mail-reply blue"></i>
																					&nbsp; Reply
																				</a>
																			</li>

																			<li>
																				<a href="#">
																					<i class="icon-mail-forward green"></i>
																					&nbsp; Forward
																				</a>
																			</li>

																			<li>
																				<a href="#">
																					<i class="icon-folder-open orange"></i>
																					&nbsp; Archive
																				</a>
																			</li>

																			<li class="divider"></li>

																			<li>
																				<a href="#">
																					<i class="icon-eye-open blue"></i>
																					&nbsp; Mark as read
																				</a>
																			</li>

																			<li>
																				<a href="#">
																					<i class="icon-eye-close green"></i>
																					&nbsp; Mark unread
																				</a>
																			</li>

																			<li>
																				<a href="#">
																					<i class="icon-flag-alt red"></i>
																					&nbsp; Flag
																				</a>
																			</li>

																			<li class="divider"></li>

																			<li>
																				<a href="#">
																					<i class="icon-trash red bigger-110"></i>
																					&nbsp; Delete
																				</a>
																			</li>
																		</ul>
																	</div>

																	<div class="inline position-relative align-left">
																		<a href="#" class="btn-message btn btn-xs dropdown-toggle" data-toggle="dropdown">
																			<i class="icon-folder-close-alt bigger-110"></i>
																			<span class="bigger-110">Move to</span>

																			<i class="icon-caret-down icon-on-right"></i>
																		</a>

																		<ul class="dropdown-menu dropdown-lighter dropdown-caret dropdown-125">
																			<li>
																				<a href="#">
																					<i class="icon-stop pink2"></i>
																					&nbsp; Tag#1
																				</a>
																			</li>

																			<li>
																				<a href="#">
																					<i class="icon-stop blue"></i>
																					&nbsp; Family
																				</a>
																			</li>

																			<li>
																				<a href="#">
																					<i class="icon-stop green"></i>
																					&nbsp; Friends
																				</a>
								</li>

							<li>
								<a href="#">
									<i class="icon-stop grey"></i>
									&nbsp; Work
								</a>
							</li>
						</ul>
					</div>

					<a href="#" class="btn btn-xs btn-message">
						<i class="icon-trash bigger-125"></i>
						<span class="bigger-110">Delete</span>
					</a>
				</div>
			</div>

			<div>
				<div class="messagebar-item-left">
					<a href="#" class="btn-back-message-list">
						<i class="icon-arrow-left blue bigger-110 middle"></i>
						<b class="bigger-110 middle">Back</b>
					</a>
				</div>

				<div class="messagebar-item-right">
					<i class="icon-time bigger-110 orange middle"></i>
					<span class="time grey">Today, 7:15 pm</span>
				</div>
			</div>
		</div>

														
		<div class="message-list-container">
			<div class="message-list" id="message-list" align="left">
				<div class="message-item message-unread">
					<label class="inline">
						<input type="checkbox" class="ace" />
						<span class="lbl"></span>
					</label>

					<i class="message-star icon-star-empty light-grey"></i>

					<span class="sender" title="John Doe">
									John Doe
						<span class="light-grey">(4)</span>
					</span>
					<span class="time">7:15 pm</span>

					<span class="attachment">
						<i class="icon-paper-clip"></i>
					</span>

					<span class="summary">
						<span class="badge badge-pink mail-tag"></span>
						<span class="text">
							Clik to open this message right here
						</span>
					</span>
				</div>
        	</div>
		</div>
	</div>
</div>
<?php } ?>