function load_state1(val)
{
	$.post("ajax-loadstate",
		   {country:val},
		   function(data)
		   {$('#lst_state').html(data)})}
function load_state2(val)
{
	$.post("ajax-loadstate",
		   {country:val},function(data){$('#lst_bsstate').html(data)})}function load_state3(country,state){$.post("ajax-loadstate-selected",{cnty:country,st:state},function(data){$('#lst_bsstate').html(data)})}$(function(){$('#txt_pass').pstrength()});$("#js-enabled").hide();

function load_sec_text(val)
{	
	if(val=='5')
	{
		$("#other").slideDown(1000);
		$("#al_name_new").val("");
		$('#al_name_new').focus()
	}
	else
	{
		$("#other").slideUp(1000)
	}
}

function load_othr_job(val){if(val=='1000'){$("#otherjob").slideDown(1000);$("#otherjobtxt").val("");$('#otherjobtxt').focus()}else{$("#otherjob").slideUp(1000)}}$(document).ready(function(){$("#captcha_image").click(function(){$("#imgCaptcha").attr('src','CaptchaSecurityImages.php?'+Math.random())})});function same_addr(){if($('#chk_samemail').is(':checked')){addrs=jQuery.trim($('#area_addrs').val());city=jQuery.trim($('#txt_city').val());country=jQuery.trim($('#lst_country').val());state=jQuery.trim($('#lst_state').val());zip=jQuery.trim($('#txt_zip').val());$('#area_addrs2').val(addrs);$('#txt_bscity').val(city);$('#lst_bscountry').val(country);load_state3(country,state);$('#txt_bszip').val(zip)}}$(document).ready(function(){$("#txt_repass").bind('paste',function(e){$("#txt_repass").val("");$('#errormsg3').text(msg['req-5-char']);$('#txt_repass').focus();return loader(3)})});$(document).ready(function(){var emailok=false;var myForm=$("#form1"),email=$("#txt_email"),emailInfo=$("#errormsg1");email.blur(function(){$.ajax({type:"POST",data:"email="+$(this).attr("value"),url:"emailexistcheck",beforeSend:function(){emailInfo.html(msg['check-email']);loader(1)},success:function(data){if(data=="blank"){emailok=false;$('#errormsg1').text(msg['req-6-char']);$('#txt_email').focus();return loader(1)}else if(data=="invalid"){emailok=false;$('#errormsg1').text(msg['valid-email']);$('#txt_email').focus();return loader(1)}else if(data!="0"){emailok=false;$('#errormsg1').text(msg['email-exist']);$('#txt_email').focus();return loader(1)}else{emailok=true;$('#errormsg1').html("<font color=\"green\">"+msg['email-ok']+"</font>");return loader(1)}}})})});function validate(){email=jQuery.trim($('#txt_email').val());pass=jQuery.trim($('#txt_pass').val());repass=jQuery.trim($('#txt_repass').val());seques=jQuery.trim($('#seques').val());new_ques=jQuery.trim($('#new_ques').val());ans_seques=jQuery.trim($('#area_seans').val());captcha=jQuery.trim($('#txt_capcha').val());fname=jQuery.trim($('#txt_fname').val());lname=jQuery.trim($('#txt_lname').val());addrs=jQuery.trim($('#area_addrs').val());city=jQuery.trim($('#txt_city').val());country=jQuery.trim($('#lst_country').val());state=jQuery.trim($('#lst_state').val());zip=jQuery.trim($('#txt_zip').val());company=jQuery.trim($('#txt_company').val());jobttl=jQuery.trim($('#lst_jobttl').val());otherjobtxt=jQuery.trim($('#otherjobtxt').val());ph=jQuery.trim($('#txt_ph').val());mob=jQuery.trim($('#txt_mob').val());addrs2=jQuery.trim($('#area_addrs2').val());bscity=jQuery.trim($('#txt_bscity').val());bscountry=jQuery.trim($('#lst_bscountry').val());bsstate=jQuery.trim($('#lst_bsstate').val());bszip=jQuery.trim($('#txt_bszip').val());chk_terms=jQuery.trim($('#chk_terms').val());if(email.length<=5){$('#errormsg1').text(msg['req-6-char']);$('#txt_email').focus();return loader(1)}else if(isEmail(email)==false){$('#errormsg1').text(msg['valid-email']);$('#txt_email').focus();return loader(1)}else if(email.length>50){$('#errormsg1').text(msg['req-50-char']);$('#txt_email').focus();return loader(1)}else if(pass.length<=5){$('#errormsg2').text(msg['req-6-char']);$('#txt_pass').focus();return loader(2)}else if(pass.length>50){$('#errormsg2').text(msg['req-50-char']);$('#txt_pass').focus();return loader(2)}else if(repass.length<=5){$('#errormsg3').text(msg['req-6-char']);$('#txt_repass').focus();return loader(3)}else if(repass.length>50){$('#errormsg3').text(msg['req-50-char']);$('#txt_repass').focus();return loader(3)}else if(repass!==pass){$('#errormsg3').text(msg['same-val']);$('#txt_repass').focus();return loader(3)}else if(seques==''){$('#errormsg4').text(msg['req-ques']);$('#seques').focus();return loader(4)}else if(seques=='15'&&new_ques==''){$('#errormsg5').text(msg['own-ques']);$('#new_ques').focus();return loader(5)}else if(ans_seques==''){$('#errormsg6').text(msg['req-ans']);$('#area_seans').focus();return loader(6)}else if(captcha==''){$('#errormsg7').text(msg['req-code']);$('#txt_capcha').focus();return loader(7)}else if(isWhole(captcha)==''){$('#errormsg7').text(msg['valid-code']);$('#txt_capcha').focus();return loader(7)}else if(captcha.length<5){$('#errormsg7').text(msg['valid-code']);$('#txt_capcha').focus();return loader(7)}else if(fname==''){$('#errormsg8').text(msg['req-fname']);$('#txt_fname').focus();return loader(8)}else if(fname.length<2){$('#errormsg8').text(msg['req-2-char']);$('#txt_fname').focus();return loader(8)}else if(fname.length>50){$('#errormsg8').text(msg['req-50-char']);$('#txt_fname').focus();return loader(8)}else if(lname==''){$('#errormsg9').text(msg['req-lname']);$('#txt_lname').focus();return loader(9)}else if(lname.length<2){$('#errormsg9').text(msg['req-2-char']);$('#txt_lname').focus();return loader(9)}else if(lname.length>50){$('#errormsg9').text(msg['req-50-char']);$('#txt_lname').focus();return loader(9)}else if(addrs==''){$('#errormsg10').text(msg['req-addr']);$('#area_addrs').focus();return loader(10)}else if(addrs.length<2){$('#errormsg10').text(msg['req-2-char']);$('#area_addrs').focus();return loader(10)}else if(addrs.length>500){$('#errormsg10').text(msg['req-500-char']);$('#area_addrs').focus();return loader(10)}else if(city==''){$('#errormsg11').text(msg['req-city']);$('#txt_city').focus();return loader(11)}else if(city.length<2){$('#errormsg11').text(msg['req-2-char']);$('#txt_city').focus();return loader(11)}else if(city.length>50){$('#errormsg11').text(msg['req-50-char']);$('#txt_city').focus();return loader(11)}else if(country==''){$('#errormsg12').text(msg['req-country']);$('#lst_country').focus();return loader(12)}else if(state==''){$('#errormsg13').text(msg['req-state']);$('#lst_state').focus();return loader(13)}else if(zip==''){$('#errormsg14').text(msg['req-zip']);$('#txt_zip').focus();return loader(14)}else if(zip.length<2){$('#errormsg14').text(msg['req-2-char']);$('#txt_zip').focus();return loader(14)}else if(zip.length>50){$('#errormsg14').text(msg['req-50-char']);$('#txt_zip').focus();return loader(14)}else if(company==''){$('#errormsg15').text(msg['req-company']);$('#txt_company').focus();return loader(15)}else if(company.length<2){$('#errormsg15').text(msg['req-2-char']);$('#txt_company').focus();return loader(15)}else if(company.length>50){$('#errormsg15').text(msg['req-50-char']);$('#txt_company').focus();return loader(15)}else if(jobttl==''){$('#errormsg16').text(msg['req-job-title']);$('#lst_jobttl').focus();return loader(16)}else if(jobttl=='100'&&otherjobtxt==''){$('#errormsg17').text(msg['req-other-job-title']);$('#otherjobtxt').focus();return loader(17)}else if(ph==''){$('#errormsg18').text(msg['req-ph']);$('#txt_ph').focus();return loader(18)}else if(mob==''){$('#errormsg19').text(msg['req-mobile']);$('#txt_mob').focus();return loader(19)}else if(addrs2==''){$('#errormsg20').text(msg['req-baddr']);$('#area_addrs2').focus();return loader(20)}else if(addrs2.length<2){$('#errormsg20').text(msg['req-2-char']);$('#area_addrs2').focus();return loader(20)}else if(addrs2.length>500){$('#errormsg20').text(msg['req-500-char']);$('#area_addrs2').focus();return loader(20)}else if(bscity==''){$('#errormsg21').text(msg['req-bcity']);$('#txt_bscity').focus();return loader(21)}else if(bscity.length<2){$('#errormsg21').text(msg['req-2-char']);$('#txt_bscity').focus();return loader(21)}else if(bscity.length>50){$('#errormsg21').text(msg['req-50-char']);$('#txt_bscity').focus();return loader(21)}else if(bscountry==''){$('#errormsg22').text(msg['req-bcountry']);$('#lst_bscountry').focus();return loader(22)}else if(bsstate==''){$('#errormsg23').text(msg['req-bstate']);$('#lst_bsstate').focus();return loader(23)}else if(bszip==''){$('#errormsg24').text(msg['req-bzip']);$('#txt_bszip').focus();return loader(24)}else if(bszip.length<2){$('#errormsg24').text(msg['req-2-char']);$('#txt_bszip').focus();return loader(24)}else if(bszip.length>50){$('#errormsg24').text(msg['req-50-char']);$('#txt_bszip').focus();return loader(24)}else if(!$('#chk_terms').is(':checked')){$('#errormsg25').text(msg['req-terms']);$('#chk_terms').focus();return loader(25)}else{$('#loader1').fadeOut(1000);$('#errormsg1').fadeOut(1000)}}