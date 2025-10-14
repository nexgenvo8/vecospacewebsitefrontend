 
 
 function toggle() {
	 
	 	alert();
	var ele = document.getElementById("setting");


	if(ele.style.display == "block") {
    		ele.style.display = "none";
  	}
	else {
		ele.style.display = "block";
	}
} 


<!--=========================================================-->


function cmd_del(){

var x= confirm("Do you want to delete this record?.");

if(x)

return true;

else 

return false;



}



function opensettingpop(){
	 
ele1='outerpop';
ele2='innerpop';

$("#"+ele1).slideDown( "fast" );
$("#"+ele2).slideDown( "slow" );


}



function closesettingpop(){
	 
ele1='outerpop';
ele2='innerpop';

ele3='wrongloginclick';
ele4='msgload';
ele5='successmsg';

$("#"+ele3).slideUp( "fast" );
$("#"+ele4).slideUp( "fast" );
$("#"+ele5).slideUp( "fast" );

$("#"+ele1).slideUp( "fast" );
$("#"+ele2).slideUp( "fast" );


}





function loginclick(){
	
 
ele2='wrongloginclick';
ele1='msgload';
$("#"+ele1).slideDown( "fast" );
$("#"+ele2).slideUp( "fast" );
}




function loginfaild(){
ele2='wrongloginclick';
ele1='msgload';
ele3='successmsg';

$("#"+ele1).slideUp( "fast" );
$("#"+ele2).slideDown( "fast" );
$("#"+ele3).slideUp( "fast" );
}




function successactoin(){
ele2='wrongloginclick';
ele1='msgload';
ele3='successmsg';

$("#"+ele1).slideUp( "fast" );
$("#"+ele2).slideUp( "fast" );
$("#"+ele3).slideDown( "fast" );
}


function globalloading(){ 
ele1='globalpageloding';  
$("#"+ele1).slideDown( "fast" ); 
}


function confirmdlt(){ 
ele1='confdlt';  
$("#"+ele1).slideDown( "fast" ); 
}

function closeconfirmdlt(){ 
ele1='confdlt';  
$("#"+ele1).slideUp( "fast" ); 
}



  $(document).ready(function(){
    $("#chkAll").click(function(){
 
        $(".chk").prop("checked",$("#chkAll").prop("checked"))
    }) 
});
  
  
  
  
function openpageimg(){
	 
ele1='outerpop';
ele2='pageimagebox';

$("#"+ele1).slideDown( "fast" );
$("#"+ele2).slideDown( "slow" );


}  


function closepageimg(){
	 
ele1='outerpop';
ele2='pageimagebox';

$("#"+ele1).slideUp( "fast" );
$("#"+ele2).slideUp( "fast" );


}  




function pageimageselect(pid){ 

  closepageimg();
 
  
$('#fimagech').load('featuredimage.php?pid='+pid);
 
 
  
  }

