
<script language="javascript">
function toggleJobCat(panelId) 
{
	if ($("#plus-minus_"+panelId).hasClass('fa fa-plus-circle')) 
	{
		//$.noConflict();
		$('#det-'+panelId).css({"display":"block"});
	    $("#plus-minus_"+panelId).removeClass('fa fa-plus-circle').addClass('fa fa-minus-circle');
	}
	else
	{
		//$.noConflict();
		$('#det-'+panelId).css({"display":"none"});
	    $("#plus-minus_"+panelId).removeClass('fa fa-minus-circle').addClass('fa fa-plus-circle');
	}
}

function colChange(sk_id,avl_sk,uid)
{
	
	var n = $("input:checked").length;
	if(n>avl_sk)
	{
		$('input:checkbox[name=sk_'+sk_id+']').attr('checked',false);
		n--;
	}
	$("#jlc_info_sel").text(n);
	
	if (document.getElementById("sk_"+sk_id).checked) 
	{
		$("#span_job_name_"+sk_id).css("color","#0000FF");//499C00
	} else {
	    $("#span_job_name_"+sk_id).css("color","#000000");
    }
	
	$.get("ajax-file/remainSkills.php", {sel:n,uid:uid}, function(data){	$('#jl_info').html(data);	});
}

	//$(document).ready(
        function Mysave_change(){		
		//$('#save_changes').click(function(){		
		
		$('#update_skills_form').submit();   
		}
		
		//);


</script>
<script>
	
	var disabledcb=false;
	var toDel="";
	var delConto=0;
	

	function updateTotalNum(e) {
		var total = $(e).parent('li').parent('ul').children().children('input:checked').length;
		var id = $(e).parents('ul[id*="jobCat"]').attr('id');
        if ( total == 0) {
		    $('#'+id+'_count').parent().hide();
        } else {
		    $('#'+id+'_count').parent().show();
        }
		$('#'+id+'_count').html(total);
	}

    function synTotalNum(id) {
		var total = $('#'+id).children().children('input:checked').length;
        if ( total == 0) {
		    $('#'+id+'_count').parent().hide();
        } else {
		    $('#'+id+'_count').parent().show();
        }
		$('#'+id+'_count').html(total);
	}


//	$(document).ready(
 //       function(){            $('#save_changes').click(function(){       $('#update_skills_form').submit();            });
			
                //synTotalNum("jobCat1");
//                synTotalNum("jobCat2");
//                synTotalNum("jobCat3");
//                synTotalNum("jobCat4");
//                synTotalNum("jobCat5");
//                synTotalNum("jobCat6");
//                synTotalNum("jobCat7");
//                synTotalNum("jobCat8");
//                synTotalNum("jobCat9");
//                synTotalNum("jobCat10");
//                synTotalNum("jobCat11");
//        }
//    );

    function expandCat(that, panelId) {

        $('#'+panelId+'_heading [class*=ns_icon]').removeClass('ns_icon-plus').addClass('ns_icon-minus');
        $('#'+panelId).parent().show();
        $('#toggleKey').html('[ collapse all ]');
    }

</script>

<?php
	$sql_usk="select * from user_skills where usk_usr_id='".$row->usr_id."'";
	$res_cnt_skill=mysql_query($sql_usk);
	$cnt_skill=mysql_num_rows($res_cnt_skill);
?>


<?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?>
<div class="ns_edit-skills">
<h4>Edit Skills</h4>
<?php
	$sql_mem="select * from membership_plan where mp_id=(select usr_mp_id from user where usr_id='".$_SESSION['uid']."')";
	$res_mem=mysql_query($sql_mem);
	$row_mem=mysql_fetch_object($res_mem);
?>
<p class="ns_margin-30"><?php echo $lang[570]; ?><?php echo $row_mem->mp_skills; ?><?php echo $lang[571]; ?></p>

<div class="col-sm-4">
<table class="table  table-bordered" style="background-color:#E8F8FF">
<tbody>
	<tr>
    	<td style="text-align:center">
        <div class="ns_pad-r20">
        	<p class="ns_margin-top10 ns_bold"><?php echo $lang[572]; ?></p>
			<p class="ns_bold ns_larger"><span id="jl_info"><?php echo ($row_mem->mp_skills-$cnt_skill); ?></span></p>
            <p class="ns_margin-10 ns_small ns_grey-light">(<?php echo $lang[574]; ?>&nbsp;<?php echo $row_mem->mp_skills; ?>)</p>
    	</div>
	    </td>
        <td style="text-align:center">
        <div class="ns_pad-l20">
    <p class="ns_margin-top10 ns_bold"><?php echo $lang[573]; ?></p>
	<p class="ns_bold ns_larger"><span id="jlc_info_sel"><?php echo $cnt_skill; ?></span></p>
    </div>
        </td>
	</tr>
</tbody>
</table>
</div>

<div class="ns_clear"></div>
<p style="padding-top:5px;"></p>
<div class="ns_clear"></div>
</div>


<form id="update_skills_form" class="form-horizontal" method="post" action="" >
<br><br><br><br><br>
<ul class="ns_accordion">
     <?php
	 $sql_cat="select * from category where cat_status=1";
	 $res_cat=mysql_query($sql_cat);
	 while($row_cat=mysql_fetch_object($res_cat)) {
	 ?>
	<li class="ns_item" style="border-bottom:1px solid #eee;padding:5px;list-style-type: none;" onClick="toggleJobCat(<?php echo $row_cat->cat_id; ?>);" id="jobCat<?php echo $row_cat->cat_id; ?>_heading">
		<span class="ns_bold"><?php echo $row_cat->cat_name; ?></span>
		<span style="float:right;" class="fa fa-plus-circle" aria-hidden="true" id="plus-minus_<?php echo $row_cat->cat_id; ?>"></span>
<!--		<span class="ns_right ns_italic ns_margin-r15" style="display:none;">
            (<span id="jobCat1_count" class="subtotal">2</span> selected)
        </span>-->

	</li>
	<li id="det-<?php echo $row_cat->cat_id; ?>" style="display:none">
		<ul id="jobCat1">
		      <?php
			  	$sql_sk="select * from skills where sk_cat_id='".$row_cat->cat_id."'";
				$res_sk=mysql_query($sql_sk);
				while($row_sk=mysql_fetch_object($res_sk)){ 
					
					$c=0;
					$res_usk=mysql_query($sql_usk);
					while($row_usk=mysql_fetch_object($res_usk))
					{
						if($row_usk->usk_sk_id == $row_sk->sk_id)
						{
							$c=1;	
						}
					}
			  ?>
		       <li class="col-md-3 col-sm-12" style="list-style-type: none;">
               
               
               
    			<input type="checkbox" name="sk_<?php echo $row_sk->sk_id; ?>" id="sk_<?php echo $row_sk->sk_id; ?>" onChange="colChange(this.value,<?php echo $row_mem->mp_skills; ?>,<?php echo $_SESSION['uid']; ?>);" onClick="" value="<?php echo $row_sk->sk_id; ?>" <?php if($c==1){ ?> checked="checked" <?php } ?>class="" >
                
    	  		    <span id="span_job_name_<?php echo $row_sk->sk_id; ?>" <?php if($c==1){ ?> style="color:#00F"<?php } ?> class="lbl">&nbsp;<?php echo $row_sk->sk_name; ?></span>
		  	<!--<span id="span_job_15"></span>
            <span class="lbl"></span>-->
           
            
		       </li>
               <?php } ?>
                     
                <div class="ns_clear"></div>
		     </ul>
	      </li>
      <?php } ?>
	
</ul>
<br>
<div class="ns_right">
    <a class="btn btn-info btn-lg" href="javascript:void(0)" onClick="Mysave_change();" id="save_changes"><i class="icon-ok bigger-110"></i><?php echo $lang[575]; ?></a>
    <!--<a class="ns_btn ns_margin-none" href="javascript:void(0);" id="cancel_skill_changes"><?php /*echo $lang[398];*/ ?></a>-->
</div>
<input type="hidden" name="save_skill" value="1" />
</form>

<?php }else{ ?>

<div class="ns_edit-skills">
<h1><?php echo $lang[395]; ?></h1>
<ul class='ns_skills'>
	<div id="skills_div">
    <?php
	$sql_show_skill="select * from skills where sk_id in(select usk_sk_id from user_skills where usk_usr_id='".$row->usr_id."')";
	$res_show_skill=mysql_query($sql_show_skill);
	if(mysql_num_rows($res_show_skill)>0)
	{
		while($row_show_skill=mysql_fetch_object($res_show_skill)){
	?>
          <li><a class="exam_skills" job_id="<?php echo $row_show_skill->sk_id; ?>"><?php echo $row_show_skill->sk_name; ?></a></li>
    <?php
		}
	}
	?>
        
    </div>
</ul>

</div>

<?php } ?>