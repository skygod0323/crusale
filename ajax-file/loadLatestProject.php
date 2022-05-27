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


$sql_prj="select * from project,bid,user where prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$_SESSION['uid']."' and bd_status=0 and prj_status='open' and prj_expiry > now() order by bd_date desc LIMIT $start, $per_page";
$res_prj=mysql_query($sql_prj) or die('MySql Error' . mysql_error());

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="left" valign="top"><h1><?php echo $lang[170]; ?></h1></td>
	</tr>
	<tr>
		<td align="left" valign="top" class="recent-project-box-header-bg">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
            	<td width="24%" align="left" valign="top" class="project-header-name"><?php echo $lang[18]; ?></td>
                            <td width="10%" align="left" valign="top"><?php echo $lang[19]; ?></td>
                                <td width="8%" align="left" valign="top"><?php echo $lang[20]; ?></td>
                                <td width="12%" align="left" valign="top"><?php echo $lang[21]; ?> (<?php echo getCurrencyCode(); ?>)</td>
                                <td width="24%" align="left" valign="top"><?php echo $lang[22]; ?></td>
                                <td width="12%" align="left" valign="top"><?php echo $lang[23]; ?></td>
                                <td width="10%" align="left" valign="top"><?php echo $lang[24]; ?></td>
                              </tr>
                            </table></td>
						  </tr>
						  <tr>
							<td align="left" valign="top" class="recent-project-box-body-con">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                
                                <?php 
							$i=0;
							while($row=mysql_fetch_object($recObj)) { 
							$i++;
	?>
		<tr id="main_tr<?php echo $row->prj_id; ?>" onMouseOver="show_desc(<?php echo $row->prj_id; ?>)" onMouseOut="hide_desc(<?php echo $row->prj_id; ?>)">
            <td width="24%" align="left" valign="top" class="project-name">
                <?php
                $promo_now="select * from project_promotion_option where ppo_prj_id=".$row->prj_id;
$promo_now2=mysql_query($promo_now);
$total_promo=mysql_num_rows($promo_now2);
if($total_promo>0){
                
                while($promo_row=mysql_fetch_object($promo_now2)) { 
                    $promo_name="select pp_name from project_promotion where pp_id=".$promo_row->ppo_pp_id;
                    $promo_name2=mysql_query($promo_name);
                    $promo_name_row=mysql_fetch_object($promo_name2);
                    $pp_name=$promo_name_row->pp_name;
                ?>
                 <div class="ns_<?php echo $pp_name;?>-icon"></div>
      <?php  }} ?>
                
                <a href="project.php?p=<?php echo $row->prj_id; ?>"><?php echo $row->prj_name; ?></a></td>
            
            <?php
				$bid_now="select * from bid where bd_prj_id=".$row->prj_id;
				$bid_now2=mysql_query($bid_now);
				$total_bid=mysql_num_rows($bid_now2);
				if($total_bid==0){
					$total_bid=$lang[659];
				}

				$ave_now="select AVG(bd_amount) from bid where bd_prj_id=".$row->prj_id;
				$ave_now2=mysql_query($ave_now);
				$ave_bid_row=mysql_fetch_array($ave_now2);
				$ave_bid=round($ave_bid_row['AVG(bd_amount)'], 2);
				if($total_bid==0){
					$ave_bid="-";
				}
			?>
            
            <td width="10%" align="left" valign="top"><?php echo ucfirst($row->pb_type); ?></td>
			<td width="8%" align="left" valign="top"><?php echo $total_bid; ?></td>
   <td width="12%" align="left" valign="top"><?php echo $ave_bid; ?></td>
   <td width="24%" align="left" valign="top">
   <?php
			$sql_sk="select * from skills where sk_id in(select ps_sk_id from project_skill where ps_prj_id=".$row->prj_id.")";
			$res_sk=mysql_query($sql_sk);
			$c=0;
			while($row_sk=mysql_fetch_object($res_sk)){		?>
            <?php if($c>0){ ?>,&nbsp;<?php } ?>
		        <a class="hiddenlink" href="category.php?sk=<?php echo $row_sk->sk_id; ?>"><?php echo $row_sk->sk_name; ?></a>
		<?php	$c++;	}	?>
   </td>
    <td width="12%" align="left" valign="top"><?php echo date("M d,Y",strtotime($row->prj_updated_date)); ?></td>
    <td width="10%" align="left" valign="top">
    <?php if(dateDifference(date("Y-m-d"),$row->prj_expiry)>=0){	echo dateDifference(date("Y-m-d"),$row->prj_expiry)." ".$lang[168]; }else{ echo $lang[169];	}	?>
    </td>
    </tr>
    <tr style="display:none;" id="proj_desc<?php echo $row->prj_id; ?>" onmouseover="show_desc(<?php echo $row->prj_id; ?>)" onmouseout="hide_desc(<?php echo $row->prj_id; ?>)">
    <td colspan="7" align="left"><?php echo substr($row->prj_details, 0, 100); ?></td>
    </tr>                             
                            <?php } ?>     
                                 
								</table>

							</td>
						  </tr>
	<tr>
        <td align="left" valign="top" class="recent-project-box-footer"><?php echo $showitems; ?></td>
	</tr>
      <tr>
	<td align="right" valign="top" class="recent-project-box-footer">
          <div class="top-pagination-col">
              <?php echo $p->getPaginationString($page, $totalitems, $limit, $adjacents, $targetpage, $pagestring); ?>
          </div>
      </td>
    </tr>
					  </table>
<?php
}
?>