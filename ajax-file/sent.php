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
$first_btn = true;
$last_btn = true;
$start = $page * $per_page;

$sql_sent="select * from message,user,project where msg_from='".$_SESSION['uid']."' and msg_to=usr_id and msg_prj_id=prj_id and msg_from_status='1' order by msg_date desc LIMIT ".$start.", ".$per_page;
$recObj=mysql_query($sql_sent) or die('MySql Error' . mysql_error());

/* -----Total count--- */
$query_pag_num = "SELECT count(*) AS count from message,user,project where msg_from='".$_SESSION['uid']."' and msg_to=usr_id and msg_prj_id=prj_id and msg_from_status='1'"; // Total records

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

<div class="message-container">
	<div id="id-message-list-navbar-sent" class="message-navbar align-center clearfix">
        <div class="message-bar">
            <div class="message-infobar" id="id-message-infobar">
                <span class="blue bigger-150"><?php echo $lang[362]; ?></span>
                <!--<span class="grey bigger-110">(10 unread messages)</span>-->
            </div>
        </div>

        <div>
            <div class="messagebar-item-left">
                &nbsp;
            </div>

            <div class="messagebar-item-right">
                <div class="inline position-relative">
                    
                </div>
            </div>

            <div class="nav-search minimized">
                
            </div>
        </div>
    </div>

    <div class="message-list-container">
        <div class="sent-message-list" id="message-list" align="left">
        
            
		 <?php while($row=mysql_fetch_object($recObj)){ ?>
            <div class="message-item">
                

                <span class="sender" title="<?php echo $row->usr_name; ?>">
                   <a href="profile.php?u=<?php echo md5($row->usr_id); ?>" style="text-decoration:none" target="_blank"><?php echo $row->usr_name; ?></a>
                    <!--<span class="light-grey">(4)</span>-->
                </span>
                <span class="time" style="width:100px;">
                <?php 
					$diff=dateDifference($row->msg_date,date("Y-m-d h:i:s"));
					if($diff>0){	echo date("d-m-Y",strtotime($row->msg_date));	}
					else {	echo date("h:i A",strtotime($row->msg_date));	}
                ?>
                </span>

				<?php if($row->msg_file != ''){ ?>
                	<span class="attachment"><i class="icon-paper-clip"></i></span>
                <?php	}	?>

                <span class="summary">
                    <!--<span class="badge badge-pink mail-tag"></span>-->
                    <span class="text">
                        <?php echo $lang[752]; ?>
                    </span>
                    &nbsp;&nbsp;
                    <span class="sender">
						(<a href="project.php?p=<?php echo $row->prj_id; ?>" style="text-decoration:none" target="_blank"><?php echo $row->prj_name; ?></a>)
					</span>
                </span>
            </div>
            <?php	}	?>


            
        </div>
    </div><!-- /.message-list-container -->

    <div class="message-footer clearfix">
        <div class="pull-left"> <?php echo $count;	?><?php echo $lang[753]; ?> </div>

        <div class="pull-right">
            <div class="inline middle"> <?php echo $lang[758]; ?><?php	echo $page+1;	?><?php echo $lang[759]; ?><?php	echo $no_of_paginations; ?> </div>

            &nbsp; &nbsp;
            <ul class="pagination middle">
						<?php
                    // FOR ENABLING THE FIRST BUTTON
						if ($first_btn && $cur_page > 1) {	?>
                            <li>
							<a href="javascript:showSent('1')"><i class="fa fa-angle-double-left" aria-hidden="true"></i>
</a>
							</li>
					<?php	} else if ($first_btn) {	?>
						    <li class="disabled">
							<span><i class="fa fa-angle-double-left" aria-hidden="true"></i>
</span>
							</li>
					<?php	}	?>
                        
                        
                        <?php
             // FOR ENABLING THE PREVIOUS BUTTON
            if ($previous_btn && $cur_page > 1){
                 $pre = $cur_page - 1;
            ?>
                 <li><a href="javascript:showSent('<?php echo $pre; ?>')"><i class="fa fa-angle-left" aria-hidden="true"></i>
</a></li>
                 <?php	}else if($previous_btn){	?>
                 <li class="disabled"><span><i class="fa fa-angle-left" aria-hidden="true"></i>
</span></li>
                    
            <?php	}	?>
                        
						<li>
                        	<span><input value="<?php echo $page+1; ?>" maxlength="3" type="text" readonly="readonly" /></span>
						</li>
                        <?php
						// TO ENABLE THE NEXT BUTTON
	                    if($next_btn && $cur_page < $no_of_paginations)
    	                {
        	                $nex = $cur_page + 1;
            	        ?>
                	      <li><a href="javascript:showSent('<?php echo $nex; ?>')"><i class="fa fa-angle-right" aria-hidden="true"></i>
</a></li>
                    	<?php
	                    }else if ($next_btn){
    	                ?>
        	              <li class="disabled"><span><i class="fa fa-angle-right" aria-hidden="true"></i>
</span></li>
            	        <?php	}	?>
                        
						 <?php
                        // TO ENABLE THE END BUTTON
						if ($last_btn && $cur_page < $no_of_paginations) {	?>
				    	
                            <li>
							<a href="javascript:showSent('<?php echo $no_of_paginations; ?>')"><i class="fa fa-angle-double-right" aria-hidden="true"></i>
</a>
							</li>
						<?php	} else if ($last_btn) {	?>
							<li class="disabled">
							<span><i class="fa fa-angle-double-right" aria-hidden="true"></i>
</span>
							</li>
						<?php	}	?>
					</ul>
        </div>
    </div>

</div><!-- /.message-container -->

<?php	
$i=0;
$rec_det=mysql_query($sql_sent);
while($row=mysql_fetch_object($rec_det)){	?>
<div class="hide message-content" id="<?php echo $i; ?>-message-content-sent">
    <div class="message-header clearfix">
        <div class="pull-left">
            <!--<span class="blue bigger-125"> Clik to close this message </span>-->

            <div class="space-4"></div>
            &nbsp;
            <?php if(($row->usr_image!="")&&($row->usr_image!="NULL")){?>
			<img class="middle" alt="<?php echo $row->usr_name; ?>" src="images/users/<?php echo $row->usr_image; ?>" width="32" />
            <?php	}else{	?>
			<img class="middle" alt="<?php echo $row->usr_name; ?>" src="images/users/unknown.png" width="32" />
            <?php	}	?>
            &nbsp;
            <a href="profile.php?u=<?php echo md5($row->usr_id); ?>" class="sender" target="_blank"><?php echo $row->usr_name; ?></a>

            &nbsp;
            <i class="icon-time bigger-110 orange middle"></i>
            <span class="time">
            <?php 
				$diff=dateDifference($row->msg_date,date("Y-m-d h:i:s"));
				if($diff>0){	echo date("d-m-Y",strtotime($row->msg_date));	}
				else {	echo "Today, ".date("h:i A",strtotime($row->msg_date));	}
            ?>
            </span>
        </div>

        <div class="action-buttons pull-right">
            <!--<a href="#"><i class="icon-reply green icon-only bigger-130"></i></a>
            <a href="#"><i class="icon-mail-forward blue icon-only bigger-130"></i></a>-->

            <a href="javascript:delMessage(<?php echo $row->msg_id;	?>,'from')"><i class="icon-trash red icon-only bigger-130"></i></a>
        </div>
    </div>

    <div class="hr hr-double"></div>

    <div class="message-body">
        <p><?php echo $row->msg_message;  ?></p>
    </div>

    <?php if($row->msg_file != ''){ ?>
    
	<div class="hr hr-double"></div>

    <div class="message-attachment clearfix">
        <div class="attachment-title">
            <span class="blue bolder bigger-110"><?php echo $lang[754]; ?></span>
            &nbsp;
            <!--<span class="grey">(2 files, 4.5 MB)</span>

            <div class="inline position-relative">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                    &nbsp;
                    <i class="icon-caret-down bigger-125 middle"></i>
                </a>

                <ul class="dropdown-menu dropdown-lighter">
                    <li><a href="#">Download all as zip</a></li>
                    <li><a href="#">Display in slideshow</a></li>
                </ul>
            </div>-->
        </div>

        &nbsp;
        <ul class="attachment-list pull-left list-unstyled">
            <li>
                <a href="upload/message/<?php echo $row->msg_file; ?>" target="_blank" class="attached-file inline">
                    <i class="icon-file-alt bigger-110 middle"></i>
                    <span class="attached-name middle"><?php echo $row->msg_file; ?></span>
                </a>

                <div class="action-buttons inline">
                    <a href="upload/message/<?php echo $row->msg_file; ?>" target="_blank">
                        <i class="icon-download-alt bigger-125 blue"></i>
                    </a>

                    <!--<a href="#"><i class="icon-trash bigger-125 red"></i></a>-->
                </div>
            </li>

        </ul>
    </div>
    <?php	}	?>
</div>
                                
<?php	$i++;
}	?>
<script type="text/javascript">
			window.jQuery || document.write("<script src='new_design/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='new_design/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="new_design/js/bootstrap.min.js"></script>
		<script src="new_design/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<script src="new_design/js/bootstrap-tag.min.js"></script>
		<script src="new_design/js/jquery.hotkeys.min.js"></script>
		<script src="new_design/js/bootstrap-wysiwyg.min.js"></script>
		<script src="new_design/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="new_design/js/jquery.ui.touch-punch.min.js"></script>
		<script src="new_design/js/jquery.slimscroll.min.js"></script>

		<!-- ace scripts -->

		<script src="new_design/js/ace-elements.min.js"></script>
		<script src="new_design/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			jQuery(function($){
				//handling tabs and loading/displaying relevant messages and forms
				//not needed if using the alternative view, as described in docs
				var prevTab = 'sent'
				$('#inbox-tabs a[data-toggle="tab"]').on('show.bs.tab', function (e) {
					var currentTab = $(e.target).data('target');
					if(currentTab == 'write') {
						Sent.show_form();
					}
					else {
						if(prevTab == 'write')
							Sent.show_list();
			
						//load and display the relevant messages 
					}
					prevTab = currentTab;
				})
			
			
				
				//basic initializations
				$('.sent-message-list .message-item input[type=checkbox]').removeAttr('checked');
				$('.sent-message-list').delegate('.message-item input[type=checkbox]' , 'click', function() {
					$(this).closest('.message-item').toggleClass('selected');
					if(this.checked) Sent.display_bar(1);//display action toolbar when a message is selected
					else {
						Sent.display_bar($('.sent-message-list input[type=checkbox]:checked').length);
						//determine number of selected messages and display/hide action toolbar accordingly
					}		
				});
			
			
				//check/uncheck all messages
				$('#id-toggle-all').removeAttr('checked').on('click', function(){
					if(this.checked) {
						Sent.select_all();
					} else Sent.select_none();
				});
				
				//select all
				$('#id-select-message-all').on('click', function(e) {
					e.preventDefault();
					Sent.select_all();
				});
				
				//select none
				$('#id-select-message-none').on('click', function(e) {
					e.preventDefault();
					Sent.select_none();
				});
				
				//select read
				$('#id-select-message-read').on('click', function(e) {
					e.preventDefault();
					Sent.select_read();
				});
			
				//select unread
				$('#id-select-message-unread').on('click', function(e) {
					e.preventDefault();
					Sent.select_unread();
				});
			
				/////////
			
				//display first message in a new area
				/*$('.sent-message-list .message-item:eq(0) .text').on('click', function() {
					//show the loading icon
					$('.message-container').append('<div class="message-loading-overlay"><i class="icon-spin icon-spinner orange2 bigger-160"></i></div>');
					
					$('.message-inline-open').removeClass('message-inline-open').find('.message-content').remove();
			
					var message_list = $(this).closest('.sent-message-list');
			
					//some waiting
					setTimeout(function() {
			
						//hide everything that is after .sent-message-list (which is either .message-content or .message-form)
						message_list.next().addClass('hide');
						$('.message-container').find('.message-loading-overlay').remove();
			
						//close and remove the inline opened message if any!
			
						//hide all navbars
						$('.message-navbar').addClass('hide');
						//now show the navbar for single message item
						$('#id-message-item-navbar').removeClass('hide');
			
						//hide all footers
						$('.message-footer').addClass('hide');
						//now show the alternative footer
						$('.message-footer-style2').removeClass('hide');
			
						
						//move .message-content next to .sent-message-list and hide .sent-message-list
						message_list.addClass('hide').after($('.message-content')).next().removeClass('hide');
			
						//add scrollbars to .message-body
						$('.message-content .message-body').slimScroll({
							height: 200,
							railVisible:true
						});
			
					}, 500 + parseInt(Math.random() * 500));
				});*/
				
				
			<?php	
			$j=0;
			$rec_js=mysql_query($sql_sent);
			while($row=mysql_fetch_object($rec_js)){	?>
			
				//display second message right inside the message list
				$('.sent-message-list .message-item:eq(<?php echo $j;	?>) .text').on('click', function(){
					var message = $(this).closest('.message-item');
			
					//if message is open, then close it
					if(message.hasClass('message-inline-open')) {
						message.removeClass('message-inline-open').find('.message-content').remove();
						return;
					}
			
					$('.message-container').append('<div class="message-loading-overlay"><i class="icon-spin icon-spinner orange2 bigger-160"></i></div>');
					setTimeout(function() {
						$('.message-container').find('.message-loading-overlay').remove();
						message
							.addClass('message-inline-open')
							.append('<div class="message-content" />')
						var content = message.find('.message-content:last').html( $('#<?php echo $j; ?>-message-content-sent').html() );
			
						content.find('.message-body').slimScroll({
							height: 200,
							railVisible:true
						});
				
					}, 500 + parseInt(Math.random() * 500));
					
				});
			
			<?php	$j++;	}	?>
			
				//back to message list
				$('.btn-back-message-list').on('click', function(e) {
					e.preventDefault();
					Sent.show_list();
					$('#inbox-tabs a[data-target="sent"]').tab('show'); 
				});
			
			
			
				//hide message list and display new message form
				/**
				$('.btn-new-mail').on('click', function(e){
					e.preventDefault();
					Sent.show_form();
				});
				*/
			
			
			
			
				var Sent = {
					//displays a toolbar according to the number of selected messages
					display_bar : function (count) {
						if(count == 0) {
							$('#id-toggle-all').removeAttr('checked');
							$('#id-message-list-navbar-sent .message-toolbar').addClass('hide');
							$('#id-message-list-navbar-sent .message-infobar').removeClass('hide');
						}
						else {
							$('#id-message-list-navbar-sent .message-infobar').addClass('hide');
							$('#id-message-list-navbar-sent .message-toolbar').removeClass('hide');
						}
					}
					,
					select_all : function() {
						var count = 0;
						$('.message-item input[type=checkbox]').each(function(){
							this.checked = true;
							$(this).closest('.message-item').addClass('selected');
							count++;
						});
						
						$('#id-toggle-all').get(0).checked = true;
						
						Sent.display_bar(count);
					}
					,
					select_none : function() {
						$('.message-item input[type=checkbox]').removeAttr('checked').closest('.message-item').removeClass('selected');
						$('#id-toggle-all').get(0).checked = false;
						
						Sent.display_bar(0);
					}
					,
					select_read : function() {
						$('.message-unread input[type=checkbox]').removeAttr('checked').closest('.message-item').removeClass('selected');
						
						var count = 0;
						$('.message-item:not(.message-unread) input[type=checkbox]').each(function(){
							this.checked = true;
							$(this).closest('.message-item').addClass('selected');
							count++;
						});
						Sent.display_bar(count);
					}
					,
					select_unread : function() {
						$('.message-item:not(.message-unread) input[type=checkbox]').removeAttr('checked').closest('.message-item').removeClass('selected');
						
						var count = 0;
						$('.message-unread input[type=checkbox]').each(function(){
							this.checked = true;
							$(this).closest('.message-item').addClass('selected');
							count++;
						});
						
						Sent.display_bar(count);
					}
				}
			
				//show message list (back from writing mail or reading a message)
				Sent.show_list = function() {
					$('.message-navbar').addClass('hide');
					$('#id-message-list-navbar-sent').removeClass('hide');
			
					$('.message-footer').addClass('hide');
					$('.message-footer:not(.message-footer-style2)').removeClass('hide');
			
					$('.sent-message-list').removeClass('hide').next().addClass('hide');
					//hide the message item / new message window and go back to list
				}
			
				//show write mail form
				Sent.show_form = function() {
					if($('.message-form').is(':visible')) return;
					if(!form_initialized) {
						initialize_form();
					}
					
					
					var message = $('.sent-message-list');
					$('.message-container').append('<div class="message-loading-overlay"><i class="icon-spin icon-spinner orange2 bigger-160"></i></div>');
					
					setTimeout(function() {
						message.next().addClass('hide');
						
						$('.message-container').find('.message-loading-overlay').remove();
						
						$('.sent-message-list').addClass('hide');
						$('.message-footer').addClass('hide');
						$('.message-form').removeClass('hide').insertAfter('.sent-message-list');
						
						$('.message-navbar').addClass('hide');
						$('#id-message-new-navbar').removeClass('hide');
						
						
						//reset form??
						$('.message-form .wysiwyg-editor').empty();
					
						$('.message-form .ace-file-input').closest('.file-input-container:not(:first-child)').remove();
						$('.message-form input[type=file]').ace_file_input('reset_input');
						
						$('.message-form').get(0).reset();
						
					}, 300 + parseInt(Math.random() * 300));
				}
			
			
			
			
				var form_initialized = false;
				function initialize_form() {
					if(form_initialized) return;
					form_initialized = true;
					
					//intialize wysiwyg editor
					$('.message-form .wysiwyg-editor').ace_wysiwyg({
						toolbar:
						[
							'bold',
							'italic',
							'strikethrough',
							'underline',
							null,
							'justifyleft',
							'justifycenter',
							'justifyright',
							null,
							'createLink',
							'unlink',
							null,
							'undo',
							'redo'
						]
					}).prev().addClass('wysiwyg-style1');
			
					//file input
					$('.message-form input[type=file]').ace_file_input()
					//and the wrap it inside .span7 for better display, perhaps
					.closest('.ace-file-input').addClass('width-90 inline').wrap('<div class="row file-input-container"><div class="col-sm-7"></div></div>');
			
					//the button to add a new file input
					$('#id-add-attachment').on('click', function(){
						var file = $('<input type="file" name="attachment[]" />').appendTo('#form-attachments');
						file.ace_file_input();
						file.closest('.ace-file-input').addClass('width-90 inline').wrap('<div class="row file-input-container"><div class="col-sm-7"></div></div>')
						.parent(/*.span7*/).append('<div class="action-buttons pull-right col-xs-1">\
							<a href="#" data-action="delete" class="middle">\
								<i class="icon-trash red bigger-130 middle"></i>\
							</a>\
						</div>').find('a[data-action=delete]').on('click', function(e){
							//the button that removes the newly inserted file input
							e.preventDefault();			
							$(this).closest('.row').hide(300, function(){
								$(this).remove();
							});
						});
					});
				}//initialize_form
			
			
				//turn the recipient field into a tag input field!
				/**	
				var tag_input = $('#form-field-recipient');
				if(! ( /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase())) ) 
					tag_input.tag({placeholder:tag_input.attr('placeholder')});
			
			
				//and add form reset functionality
				$('.message-form button[type=reset]').on('click', function(){
					$('.message-form .message-body').empty();
					
					$('.message-form .ace-file-input:not(:first-child)').remove();
					$('.message-form input[type=file]').ace_file_input('reset_input');
					
					
					var val = tag_input.data('value');
					tag_input.parent().find('.tag').remove();
					$(val.split(',')).each(function(k,v){
						tag_input.before('<span class="tag">'+v+'<button class="close" type="button">&times;</button></span>');
					});
				});
				*/
			
			});
		</script>
		<!-- <![endif]-->
        
<?php	}	?>