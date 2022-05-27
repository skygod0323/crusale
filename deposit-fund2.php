<?php
ob_start();
session_start();
include "common.php";

$mp_id=$_POST['mp_id'];

$sql_mp="select * from membership_plan where mp_id='".$mp_id."'";
$res_mp=mysql_query($sql_mp);
$row_mp=mysql_fetch_object($res_mp);

class addPay{
	var $msg;	
	var $usr_id;
	var $usr_mp_id;

	
	function __construct($usr_id, $usr_mp_id)
	{		
		$this->usr_id=$usr_id;
		$this->usr_mp_id=$usr_mp_id;
	}
	
	function add()
	{															
		$sql="update user
			set			
				usr_mp_id ='".$this->usr_mp_id."',
				usr_mem_expiry =date_add(now(),INTERVAL 1 MONTH)
			where
				usr_id ='".$this->usr_id."'";
			
		mysql_query($sql) or die(mysql_error());

		$this->msg='<font color="#009900">Membership upgraded successfully</font>';
	}	
}

if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}

if(isset($_POST['deposit_money']))
{ 	
	
	$adn=new addPay(addslashes(trim($_POST['usr_id'])),addslashes(trim($_POST['usr_mp_id'])));

	$adn->add();
	
	$_SESSION['msg']=$adn->msg;

	header("location:deposit-fund.php");
}

?>
   	<?php include "includes/header.php"; ?>
<script language="javascript">
function methodSel(method)
{
	if(method == 'paypal')
	{
		//$.noConflict();
		$('#depositpaypalreferenceList').addClass("ns_selected");
		$('#depositmoneybookersList').removeClass("ns_selected");
	}
	else
	{
		//$.noConflict();
		$('#depositpaypalreferenceList').removeClass("ns_selected");
		$('#depositmoneybookersList').addClass("ns_selected");	
	}
}
</script>
	<div class="ns_clear"></div>
	<div class="grid">
	

<div id="ns_content" class="container_12 ns_deposit-funds"> 
			
	<div class="grid_12"></div>
	<div id="ns_content-main" class="grid_8">				
				<div id="msg"><?php echo $msg; ?></div>
		<form class="ns_form deposit_form" method="post"> 
		<input type="hidden" name="usr_id" value="<?php echo $_SESSION['uid']; ?>"/>
        <input type="hidden" name="usr_mp_id" value="<?php echo $row_mp->mp_id; ?>"/>
        <input type="hidden" name="mp_id" value="<?php echo $mp_id; ?>"/>
	     <fieldset> 
			<div class="ns_field ns_pad-none"> 
				<label size="30" for="payment" class="ns_grey-dark" style="font-size: 25px; margin-bottom:10px; color:#222;">Please select payment method:</label> 
					<ul class="ns_option"> 
				          
				          		<!--<li id="deposit.gcList" class="ns_selected	ns_round-top ns_first" style=" ">
				          		</li>--> 
							
				         <li id="depositpaypalreferenceList" class="ns_selected ns_round-top ns_first" style=" display: list-item">
							<span class="ns_verified"></span>
								
								
				   		<input id="deposit.paypal.referenceRadio" name="df_method" methodname="deposit.paypal.reference" value="paypal" type="radio" checked="checked" onClick="methodSel(this.value)"/>
				          			 
					  		<span class="ns_icon-misc ns_paypal"></span> 
					          		

					          <div class="ns_desc"> 
						      	<label id="deposit.paypal.referenceLabel">Paypal Verified  
										<span class="ns_icon-16 ns_tip  hoverable"></span>
								</label>
										
						<p class="ns_small">Fee: <span id="deposit.paypal.reference_fee_descr" descrname="deposit.paypal.reference">₹15.00 fixed and 2.30% fee is taken.</span></p> 	
                                            
					    </div>
									
									<!--[if IE 6 | IE 7]>
									<div class='generic_hover contest-type' style='margin-left: 30px; margin-top: 15px; width: 180px; display:none;'> 
									<![endif]--> 
									
									
									<!--[if gt IE 7]>
									<div class='generic_hover contest-type' style='margin-left: 600px; width: 180px; display:none;'> 
									<![endif]--> 
									
									<!--[if !IE]><!-->
									<div class="generic_hover contest-type" style="margin-left: 600px; width: 180px; display:none;">
									<!--<![endif]-->
										<div class="generic_hover_arrow"></div> 
										<div class="clear"></div> 
										<div style="padding-top:5px"> 
											Authorize Website to use your Paypal Verified account to make one click payments.<br><br>Payment is instant, fast and secure! Pay via <b>VISA</b>, <b>Mastercard</b> or directly from your <b>bank account</b>. Read more about <a href="http://www.paypal.com/" target="_blank">PayPal</a>.
										</div> 
									</div>
									
					          		<div class="ns_clear"></div> 
				          		</li> 
							
				          		<li id="depositmoneybookersList" class="" style="display: list-item">
								
	         			<input id="deposit.moneybookersRadio" name="df_method" methodname="deposit.moneybookers" value="moneybookers" type="radio" onClick="methodSel(this.value)">
				          			 
					          		<span class="ns_icon-misc ns_moneybookers"></span> 
					          		

					          		<div class="ns_desc"> 
						          		<label id="deposit.moneybookersLabel">Moneybookers  
											<span class="ns_icon-16 ns_tip  hoverable"></span>
										</label>
										
										<p class="ns_small">Fee: <span id="deposit.moneybookers_fee_descr" descrname="deposit.moneybookers">₹15.00 fixed and 2.30% fee is taken.</span></p> 	
                                        
											
                                            
                                            
					          		</div>
									
									<!--[if IE 6 | IE 7]>
									<div class='generic_hover contest-type' style='margin-left: 30px; margin-top: 15px; width: 180px; display:none;'> 
									<![endif]--> 
									
									
									<!--[if gt IE 7]>
									<div class='generic_hover contest-type' style='margin-left: 600px; width: 180px; display:none;'> 
									<![endif]--> 
									
									<!--[if !IE]><!-->
									<div class="generic_hover contest-type" style="margin-left: 600px; width: 180px; display:none;">
									<!--<![endif]-->
												<div class="generic_hover_arrow"></div> 
												<div class="clear"></div> 
												<div style="padding-top:5px">
													Deposits by Moneybookers are secure and cost-effective. Moneybookers is authorised and regulated by the Financial Services Authority of the UK and is only of the largest payment gateways in the world, with over 15 billion euros processed. Read more about <a href="https://www.moneybookers.com/app/?rid=672430" target="_blank">Moneybookers</a>
                                                    
												</div> 
									</div>
									
					          		<div class="ns_clear"></div> 
				          		</li> 
							
				          		<li id="deposit.wireList" class="ns_more" style="display: none">
								
								
								
				          			<input id="deposit.wireRadio" name="method" methodname="deposit.wire" value="deposit.wire" type="radio">
				          			 
					          		<span class="ns_icon-misc ns_wired-transfer"></span> 
					          		

					          		<div class="ns_desc"> 
						          		<label id="deposit.wireLabel">Direct Deposit - <span class="ns_highlight">Non-instant payment</span> 
											<span class="ns_icon-16 ns_tip  hoverable"></span>
										</label>
										
										<p class="ns_small">Fee: <span id="deposit.wire_fee_descr" descrname="deposit.wire">No fee taken.</span></p> 	
                                        
											
												<p class="ns_left ns_from">Send from: </p>
												<select id="country_code" name="country_code" class="country_code ns_third-1 ns_left" onchange='onCountryCodeUpdate("deposit.wire");'>
													<option value="AF">Afghanistan</option><option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AS">American Samoa</option><option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AQ">Antarctica</option><option value="AG">Antigua and Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BA">Bosnia and Herzegovina</option><option value="BW">Botswana</option><option value="BV">Bouvet Island</option><option value="BR">Brazil</option><option value="IO">British Indian Ocean Territory</option><option value="BN">Brunei Darussalam</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="KY">Cayman Islands</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos (Keeling) Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CG">Congo</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="CI">Cote D'Ivoire (Ivory Coast)</option><option value="HR">Croatia (Hrvatska)</option><option value="CU">Cuba</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="CS">Czechoslovakia (former)</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="TP">East Timor</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FK">Falkland Islands (Malvinas)</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="FX">France, Metropolitan</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HM">Heard and McDonald Islands</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN" selected="selected">India</option><option value="ID">Indonesia</option><option value="IR">Iran</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="KP">Korea (North)</option><option value="KR">Korea (South)</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Laos</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macau</option><option value="MK">Macedonia</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia</option><option value="MD">Moldova</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="AN">Netherlands Antilles</option><option value="NT">Neutral Zone</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand (Aotearoa)</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="MP">Northern Mariana Islands</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PS">Palestine</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="RE">Reunion</option><option value="RO">Romania</option><option value="RU">Russian Federation</option><option value="RW">Rwanda</option><option value="GS">S. Georgia and S. Sandwich Isls.</option><option value="KN">Saint Kitts and Nevis</option><option value="LC">Saint Lucia</option><option value="VC">Saint Vincent and the Grenadines</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="ST">Sao Tome and Principe</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia and Montenegro</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SK">Slovak Republic</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SH">St. Helena</option><option value="PM">St. Pierre and Miquelon</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SJ">Svalbard and Jan Mayen Islands</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syria</option><option value="TW">Taiwan</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania</option><option value="TH">Thailand</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad and Tobago</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="TC">Turks and Caicos Islands</option><option value="TV">Tuvalu</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="UK">United Kingdom</option><option value="US">United States</option><option value="UY">Uruguay</option><option value="UM">US Minor Outlying Islands</option><option value="SU">USSR (former)</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VA">Vatican City State (Holy See)</option><option value="VE">Venezuela</option><option value="VN">Viet Nam</option><option value="VG">Virgin Islands (British)</option><option value="VI">Virgin Islands (U.S.)</option><option value="WF">Wallis and Futuna Islands</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZR">Zaire</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option>
												</select>
											
                                            
                                            
					          		</div>
									
									<!--[if IE 6 | IE 7]>
									<div class='generic_hover contest-type' style='margin-left: 30px; margin-top: 15px; width: 180px; display:none;'> 
									<![endif]--> 
									
									
									<!--[if gt IE 7]>
									<div class='generic_hover contest-type' style='margin-left: 600px; width: 180px; display:none;'> 
									<![endif]--> 
									
									<!--[if !IE]><!-->
									<div class="generic_hover contest-type" style="margin-left: 600px; width: 180px; display:none;">
									<!--<![endif]-->
												<div class="generic_hover_arrow"></div> 
												<div class="clear"></div> 
												<div style="padding-top:5px"> 
													Free for deposits in INR from India!
												</div> 
									</div>
									
					          		<div class="ns_clear"></div> 
				          		</li> 
							
				          		<li id="deposit.wmList" class="	ns_more	" style=" display: none">
								
				          			<input id="deposit.wmRadio" name="method" methodname="deposit.wm" value="deposit.wm" type="radio">
				          			 
					          		<span class="ns_icon-misc ns_wm"></span> 
					          		

					          		<div class="ns_desc"> 
						          		<label id="deposit.wmLabel">WebMoney  
											<span class="ns_icon-16 ns_tip  hoverable"></span>
										</label>
										
										<p class="ns_small">Fee: <span id="deposit.wm_fee_descr" descrname="deposit.wm">2.00% fee is taken.</span></p> 	
                                        
											
                                            
                                            
					          		</div>
									
									<!--[if IE 6 | IE 7]>
									<div class='generic_hover contest-type' style='margin-left: 30px; margin-top: 15px; width: 180px; display:none;'> 
									<![endif]--> 
									
									
									<!--[if gt IE 7]>
									<div class='generic_hover contest-type' style='margin-left: 600px; width: 180px; display:none;'> 
									<![endif]--> 
									
									<!--[if !IE]><!-->
									<div class="generic_hover contest-type" style="margin-left: 600px; width: 180px; display:none;">
									<!--<![endif]-->
												<div class="generic_hover_arrow"></div> 
												<div class="clear"></div> 
												<div style="padding-top:5px"> 
													Deposits by WebMoney are instant. Read more about <a href="http://www.wmtransfer.com/" target="_blank">Webmoney</a>
												</div> 
									</div>
									
					          		<div class="ns_clear"></div> 
				          		</li> 
							
  	      		   			<div class="ns_clear"></div> 
				        	</ul> 
			          		
						<a href="javascript:void(0)" id="ns_more-payments">
						More payment methods +
						</a> 
				      	<div class="ns_clear"></div> 
				      </div>	
					</fieldset>			      	
					
					      	
					      	
					<fieldset id="paymentInfo"> 
						<div class="ns_field grid_8 alpha omega ns_pay"> 
							<div class="grid_5 alpha"> 
					      	<div class="ns_pad"> 
						      		<label for="country" style="font-size:14px;">I'd like to deposit: </label> 
						    
						      		<div class="ns_col ns_last">
                                        <span id="sign_idfixed" class="ns_form-prefix"><?php echo getCurrencySymbol(); ?></span>
								        <input class="ns_quarter-1" id="depositAmount" name="amount" style="padding-left: 11px;" value="<?php echo $row_mp->mp_rate; ?>" maxlength="15" type="text" readonly="readonly"> 
									</div>
								</div> 
							</div> 
							
							<!--<div class="grid_3 omega ns_align-r"> 
								<div class="ns_pad"> 
									<div class="ns_bold" style="font-size:14px;"> 
							      	Amount to Send:<br><span id="amountToSendText" class="ns_larger">
									<span id="sign_id3" descr="sign">₹</span><span id="totalamount">0</span> <span id="code_id1">INR</span></span> 

									<div class="ns_normal" style="font-size:14px; ">(Balance after deposit: <span id="balance" class="ns_color-green ns_bold"><span id="sign_id4" descr="sign">₹</span><span id="balance_id">200.00</span></span>)</div> 							      	 
						      	</div> 
						     </div> 
						  </div>-->
						</div>
					</fieldset> 
					      	
			    <button type="submit" id="btn_next_id" class="ns_btn ns_blue" name="deposit_money">Deposit Money </button> 
			      	
				</form>			
				
			    </div>

    
			<div id="ns_sidebar" class="grid_4"> 
				 
			</div> 
			
		
		</div> 



<script type="text/javascript" src="js/deposit-gc.js"></script> 


	</div>
	<div class="ns_clear"></div>
<?php include "includes/footer.php"; ?>

	<div class="ns_clear"></div>

<!-- 0.5592 -->
</div>

<div id="xx33">
</div>
</body>
</html>