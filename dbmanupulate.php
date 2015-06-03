<?php
session_start();
$_SESSION["pageName"] = "";
include('db.php');

/* 
Step1 : $_REQUEST is an associative array.
Step2 : $_REQUEST takes $_POST, $_GET and $_COOKIE variable togeather in singe associative array.
Step3 : Here actionfunction and page is variable which passed form javascript file to this file.
Step4 : Variable actionfunction = showData ( showData is value for variable actionfunction  and showData is also an function in this 		        case) 
        and 
		Variable page = 1 (1 is value for variable page which coming form javascript page)
Step5 : Now $_REQUEST is an array.
Step6 : When you print $_REQUEST in foreach loop, we will get output as showData1. This output of variable values from javascript. 
Step 6: we can fetch array like this $_REQUEST['actionfunction'] and  $_REQUEST['page'];

Step 7: call_user_func(). This will call function by passing in first parameter and rest of parameter will be variables.
		In our case, $actionfunction will call showData() function. 

For Function showData()

Step1 : $data is $_REQUEST array which holds $_REQUEST['actionfunction'] and  $_REQUEST['page']
Step2 : So we use to fetch variable page like $data['page']
        $page is comming from javascript page.
		
		
Note : We cann't pass parameter like this directly -> showData($_REQUEST,$con,$limit,$adjacent); Error accors.

       we have to pass like below 
	   showData($data,$con,$limit,$adjacent)
	
*/

if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
$actionfunction = $_REQUEST['actionfunction'];  // This will call function showData()


  call_user_func($actionfunction,$_REQUEST,$con,$limit,$adjacent);
}


function showData($data,$con,$limit,$adjacent){
	
   $page = $data['page'];
  
   
   if($page==1)
   {
   	  $start = 0;  
   }
   else
   {
  	  $start = ($page-1)*$limit;
   }
   
   
  $sql = "select * from ajaxpage order by id asc";
  $rows  = $con->query($sql);
  $rows  = $rows->num_rows;
  
  $sql = "select * from ajaxpage order by id asc limit $start,$limit";
  
  $data = $con->query($sql);
  $tableResult='<table><tr class="head"><td>Id</td><td>Firstname</td><td>Lastname</td></tr>';
  if($data->num_rows>0){
   while( $row = $data->fetch_array(MYSQLI_ASSOC)){
      $tableResult.="<tr><td>".$row['id']."</td><td>".$row['firstname']."</td><td>".$row['lastname']."</td></tr>";
	 // $tableResult.="<tr><tdcolspan='5'> <input type</td></tr>"
   }
   }else{
    $tableResult .= "<td colspan='5'>No Data Available</td>";
   }
   $tableResult.='</table>';
   
   echo $tableResult; 
   
pagination($limit,$adjacent,$rows,$page);  
}


function pagination($limit,$adjacents,$rows,$page){	
	$pagination='';
	$paginationDropDown = '';
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$prev_='';
	$first='';
	$lastpage = ceil($rows/$limit);	
	$next_='';
	$last='';
	if($lastpage > 1)
	{	
		
		//previous button
		if ($page > 1) 
			$prev_.= "<a class='page-numbers' href=\"?page=$prev\">previous</a>";
		else{
			//$pagination.= "<span class=\"disabled\">previous</span>";	
			}
			
			
			
		
		//pages	
		if ($lastpage < 5 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
		$first='';
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if($counter == $page){
				$_SESSION["pageName"] = $counter;
				}
				
				if ($counter == $page)
				    $pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";					
			}
		$last='';
		}
		elseif($lastpage > 3 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			$first='';
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if($counter == $page){
					$_SESSION["pageName"] = $counter;
					}
					
					
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";					
				}
			$last.= "<a class='page-numbers' href=\"?page=$lastpage\">Last</a>";			
			}
			
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
		       $first.= "<a class='page-numbers' href=\"?page=1\">First</a>";	
			for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if($counter == $page){
					$_SESSION["pageName"] = $counter;
					}
					
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";					
				}
				$last.= "<a class='page-numbers' href=\"?page=$lastpage\">Last</a>";			
			}
			//close to end; only hide early pages
			else
			{
			    $first.= "<a class='page-numbers' href=\"?page=1\">First</a>";	
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					
					if($counter == $page){
					$_SESSION["pageName"] = $counter;
					}
					
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";					
				}
				$last='';
			}
            
		}
		
		
		if ($page < $counter - 1) 
			$next_.= "<a class='page-numbers' href=\"?page=$next\">next</a>";
		else{
			//$pagination.= "<span class=\"disabled\">next</span>";
			}
			
		$pagination = "<div class=\"pagination\">".$first.$prev_.$pagination.$next_.$last."</div>\n";
		//$pagination.= "</div>\n";	
		
		
		
		
		
		
		/*  DropDown Pagination Starts */
		$paginationDropDown.= "<select id='dropDown' onchange='dropDownPagination()'>
								 <option> Pages </option>";
		$_SESSION["dropDownPageCount"] = '';						 
		for ($counter = 1; $counter <= $lastpage; $counter++)
		{
			 
			 $paginationDropDown.= "<option value='".$counter."' selected>".$counter."</option>";
			
		}
		
		$paginationDropDown.= "</select>";
    
			//$paginationDropDown ="<div id='dropDown'>". ."</div>";							}	
		}
   
        /*  DropDown Pagination Ends */

    
	echo $pagination.$paginationDropDown;  
}

?>