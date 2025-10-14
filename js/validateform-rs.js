function formValidation(frmid){
var returnflag='y';
$('#'+frmid+' .validate').each(function(i, obj) { 
var elem = $(this); 
var ID = elem.attr('id');
var ATTR = elem.attr('name'); 
var TYPE = elem.attr('type');
var DISPLAYNAME = elem.attr('displayname');
var FIELDMINLENGTH = elem.attr('field_min_length');
var FIELDVALUE = $("#"+ID).val(); 

$("#"+ID).removeClass('redborderfield');

//alert(ID);
//alert(ATTR);
//alert(TYPE);
//alert(DISPLAYNAME);
//alert(FIELDMINLENGTH);
//alert(FIELDVALUE);


//----------------Special Characters Validation----------------

 

if(TYPE!='email'){
/*if(/^[a-z@A-Z0-9- ]*$/.test(FIELDVALUE) == false) { 
var msg='Special characters not allowed in '+DISPLAYNAME;
var header='System Alert!';
alertbox(header,msg);
$("#"+ID).focus();
returnflag='n';
return false;
}*/ }
 
//----------------Email Validation----------------

if(TYPE=='email'){
if(this.value==''){ 
$("#"+ID).addClass('redborderfield');
$("#"+ID).focus();
returnflag='n';
return false;
}

if(this.value!=''){
var regEmail = /^([-a-zA-Z0-9._]+@[-a-zA-Z0-9.]+(\.[-a-zA-Z0-9]+)+)$/;
if(!this.value.match(regEmail)){ 
$("#"+ID).addClass('redborderfield');
$("#"+ID).focus();
returnflag='n';
return false; 
} } }


if(TYPE=='phone'){
if(this.value==''){ 
$("#"+ID).addClass('redborderfield');
$("#"+ID).focus();
returnflag='n';
return false;
} }

if(TYPE=='text'){
if(this.value==''){ 
$("#"+ID).addClass('redborderfield');
$("#"+ID).focus();
returnflag='n';
return false; 
} }


if(TYPE=='textarea'){
if(this.value==''){ 
$("#"+ID).addClass('redborderfield');
$("#"+ID).focus();
returnflag='n';
return false; 
} }

if(TYPE=='radio'){
if(this.value==''){ 
$("#"+ID).addClass('redborderfield');
$("#"+ID).focus();
returnflag='n';
return false; 
} }

if(TYPE=='password'){
if(this.value==''){ 
$("#"+ID).addClass('redborderfield');
$("#"+ID).focus();
returnflag='n';
return false; 
} }

 

//----------------Select Field Validation----------------

if(TYPE!='password' || TYPE!='text' || TYPE!='phone' || TYPE!='email' || TYPE!='radio'){
	
if(FIELDVALUE==0){ 
$("#"+ID).addClass('redborderfield');
$("#"+ID).focus();
returnflag='n';
return false;
}
}
 
 
 //----------------Length Validation----------------
 

if($(this).val().length<FIELDMINLENGTH){ 
$("#"+ID).addClass('redborderfield');
$("#"+ID).focus();
returnflag='n';
return false;
}

  
});

if(returnflag=='y'){ 
$("#"+frmid).submit();
}

}