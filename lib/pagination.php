 <?php 
//function to return the pagination string
class Pagination{
	function getPaginationString($page, $totalitems, $limit, $adjacents, $targetpage = "/", $pagestring = "?page=")
	{
			//defaults
			if(!$adjacents) $adjacents = 1;
			if(!$limit) $limit = 15;
			if(!$page) $page = 1;
			if(!$targetpage) $targetpage = "/";
			
			//other vars
			$prev = $page - 1;									//previous page is page - 1
			$next = $page + 1;									//next page is page + 1
			$lastpage = ceil($totalitems / $limit);				//lastpage is = total items / items per page, rounded up.
			$lpm1 = $lastpage - 1;								//last page minus 1
			
			/* 
				Now we apply our rules and draw the pagination object. 
				We're actually saving the code to a variable in case we want to draw it more than once.
			*/
			$pagination = "";
			if($lastpage > 1)
			{	
				$pagination .= "";
				if($margin || $padding)
				{
					$pagination .= " style=\"";
					if($margin)
						$pagination .= "margin: $margin;";
					if($padding)
						$pagination .= "padding: $padding;";
					$pagination .= "\"";
				}
				$pagination .= "";
		
				//previous button
				if ($page > 1) 
					$pagination .= "<li class=\"prev\"><a href=\"$targetpage$pagestring$prev\"><i class=\"icon-double-angle-left\"></i></a></li>";
				else
					$pagination .= "<li class=\"prev disabled\"><a><i class=\"icon-double-angle-left\"></i></a></li>";
				
				//pages	
				if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
				{	
					for ($counter = 1; $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination .= "<li class=\"active\"><a>$counter</a></li>";
						else
							$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a></li>";					
					}
				}
				elseif($lastpage >= 7 + ($adjacents * 2))	//enough pages to hide some
				{
					//close to beginning; only hide later pages
					if($page < 1 + ($adjacents * 3))		
					{
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
						{
							if ($counter == $page)
								$pagination .= "<li class=\"active\"><a>$counter</a></li>";
							else
								$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a></li>";
						}
						$pagination .= "...";
						$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $lpm1 . "\">$lpm1</a></li>";
						$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $lastpage . "\">$lastpage</a></li>";
					}
					//in middle; hide some front and some back
					elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
					{
						$pagination .= "<li><a href=\"" . $targetpage . $pagestring . "1\">1</a></li>";
						$pagination .= "<li><a href=\"" . $targetpage . $pagestring . "2\">2</a></li>";
						$pagination .= "...";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
						{
							if ($counter == $page)
								$pagination .= "<li class=\"active\"><a>$counter</a></li>";
							else
								$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a></li>";					
						}
						$pagination .= "...";
						$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $lpm1 . "\">$lpm1</a></li>";
						$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $lastpage . "\">$lastpage</a></li>";		
					}
					//close to end; only hide early pages
					else
					{
						$pagination .= "<li><a href=\"" . $targetpage . $pagestring . "1\">1</a></li>";
						$pagination .= "<li><a href=\"" . $targetpage . $pagestring . "2\">2</a></li>";
						$pagination .= "...";
						for ($counter = $lastpage - (1 + ($adjacents * 3)); $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination .= "<li class=\"active\"><a>$counter</a></li>";
							else
								$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a></li>";					
						}
					}
				}
				
				//next button
				if ($page < $counter - 1) 
					$pagination .= "<li class=\"next\"><a href=\"" . $targetpage . $pagestring . $next . "\"><i class=\"icon-double-angle-right\"></i></a></li>";
				else
					$pagination .= "<li class=\"next disabled\"><a><i class=\"icon-double-angle-right\"></i></a></li>";
				$pagination .= "\n";
			}
			
			return "<div class=\"dataTables_paginate paging_bootstrap\"><ul class=\"pagination pull-right no-margin\">".$pagination."</ul></div>";
		
		}
		
		function setpage(){
		
			if(!isset($_GET['page']) || $_GET['page']=="" ){
				$page=1;
			}else{
				$page=$_GET['page'];
			}
			return $page;
		}
		function setlimit($default){
				if(!isset($_GET['limit']) || $_GET['limit']=="" ){
				$limit=$default;
			}else{
				$limit=$_GET['limit'];
			}
			//echo $limit;
			return $limit;
		}
		function setstart($page,$limit){
			if($page==1){
				$start=0;
			}
			else{
					$start=(($page-1)*$limit);
			}
			return $start;
		}
}
?>