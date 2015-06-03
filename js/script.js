
$(function(){
	
	
	
 $.ajax({
	 
	 	url:"dbmanupulate.php",
                  type:"POST",
                  data:"actionfunction=showData&page=1",
        cache: false,
        success: function(response){
		   
		  $('#pagination').html(response);
		 
		}
		
	   });
    $('#pagination').on('click','.page-numbers',function(){
       $page = $(this).attr('href');
	   
	   $pageind = $page.indexOf('page=');
	   $page = $page.substring(($pageind+5)); 
	  
	   
  
	  
	  // $page = $page.substring(6);   
	   
	   /*
	   
	   1. Step 1: We getting page name like ?page=2
	   2. Step 2: Now we have to send only page id to logic page so we have to cut the string of $page (which is ?page=2)
	   3. Step 3: substring is used to characters from a string and return new string. 
	   4. Step 4: javascript substring will take 2parameter like start and end parameter 
	   
	              Ex: string.substring(start,end)
				  
				  In Our case one parameter we have passed so substring will considred as only strat index will full string 
				  after it.
	   
	   */
	   
	   
	   $.ajax({
	     url:"dbmanupulate.php",
                  type:"POST",
                  data:"actionfunction=showData&page="+$page,
        cache: false,
        success: function(response){
		   
		  $('#pagination').html(response);
		 
		}
		
	   });
	return false;
	});
	
});




function dropDownPagination(page){
  
   var dropDownPage = document.getElementById("dropDown").value;
   //alert(dropDownPage);         
  
    $.ajax({
	     url:"dbmanupulate.php",
                  type:"POST",
                  data:"actionfunction=showData&page="+dropDownPage,
        cache: false,
        success: function(response){
		   
		  $('#pagination').html(response);
		 
		}
		
	});
	
}


function sessionPageLoad(){
	
	
	$page = document.getElementById("pageNumberId").value;
	
	$.ajax({
	     url:"dbmanupulate.php",
                  type:"POST",
                  data:"actionfunction=showData&page="+$page,
        cache: false,
        success: function(response){
		   
		  $('#pagination').html(response);
		 
		}
		
	   });
}



	   
