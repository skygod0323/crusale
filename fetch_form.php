<?php 
ob_start();
session_start();
include "common.php";
?>
	<div id="forgot-box">
                            		 <form class="submit-form customform loginform">
                                        <h4><i class="icon-key"></i>
												<?php echo $lang[739]; ?></h4>
                                        <div class="input-group">
                                            <span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="<?php echo $lang[741]; ?>" id="usr_email_FP" name="usr_email_FP"/>
															<i class="icon-envelope"></i>
														</span>
                                        </div>
                                        
                                        <button class="btn btn-custom"  onClick="sendPassword();"><i class="icon-lightbulb"></i>
															<?php echo $lang[742]; ?></button>
                                        
                                        
                                            
                                         <div>
                                         	<br/>
                                            <a href="javascript:void(0);" onClick="login_box();" class="forgot-password-link">
                                            <i class="icon-arrow-left"></i>
                                            <?php echo $lang[743]; ?>
                                            </a>
                                        </div>
                                    </form>
                            </div>