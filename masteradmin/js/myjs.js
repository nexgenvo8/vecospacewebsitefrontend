<!-------------------Shake effec------------------------->

$(document).ready(function() {
$("#shk").effect("shake", { times:3 }, 100);
});

<!--=========================================================-->


 
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

$("#"+ele1).show( "fast" );
$("#"+ele2).show( "fast" );


}



function closesettingpop(){
	 
ele1='outerpop';
ele2='innerpop';

$("#"+ele1).hide( "fast" );
$("#"+ele2).hide( "fast" );


}

