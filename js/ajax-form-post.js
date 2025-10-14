$(document).ready(function()
{
	$('#txtUsername').keyup(function() {
			$(".error-messages").empty().fadeOut();
	});
	$('#txtPassword').keyup(function() {
			$(".error-messages").empty().fadeOut();
	});


	$("#frmUserLogin").submit(function()
	{
		
		if($('#txtUsername').val()=='')
		{
			$(".error-messages").text("Please Enter Email address").fadeIn();
			$('#txtUsername').focus();
			return false;
		}

		if(!isValidEmailStrict($('#txtUsername').val()))
		{
			$(".error-messages").text("Please Enter Valid Email").fadeIn();
			$("#txtUsername").focus();
			return false;
		}
		
		if(isValidateLen($('#txtUsername').val(),60))
		{
			$(".error-messages").text("Email address Exceeded Character Limit of 60 Characters").fadeIn();
			$('#txtUsername').focus();
			return false;
		}
		
		if($('#txtPassword').val()=='')
		{
			$(".error-messages").text("Please Enter Password").fadeIn();
			$('#txtPassword').focus();
			return false;
		}
		
		if(isValidateLen($('#txtPassword').val(),60))
		{
			$(".error-messages").text("Password Exceeded Character Limit of 60 Characters").fadeIn();
			$('#txtPassword').focus();
			return false;
		}


 		 /*if(!grecaptcha.getResponse())
		 {
		  $(".error-messages").text('Please check the "I\'m not a robot" checkbox!').fadeIn();
		   $('#recaptcha_response_field').focus();
		   return false;
		 }*/
		//,captcha:$('#captchacode').val(),captchacode:$('#ccname').text()

		//remove all the class add the messagebox classes and start fading
		$("#errorMsgBox").removeClass().addClass('messagebox').text('Validating....').fadeIn(0);
		//check the username exists or not from ajax  
		$.post("login-submit.inc.php",{ user_name:$('#txtUsername').val(),password:$('#txtPassword').val(),password:$('#txtPassword').val(),rand:Math.random() } ,function(data)
        {
		  //alert(data);
		  if(data.trim()=='act') //if correct login detail
		  {
			$("#errorMsgBox").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Logging in.....').addClass('messageboxok').fadeTo(0,0,
              function()
			  { 
			  	 //redirect to secure page
				 document.location='home.php';
			  });
			});
		  }
		  else if(data.trim()=='yes') //if correct login detail
		  {
		  	$("#errorMsgBox").fadeTo(1,1,function()  //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Logging in.....').addClass('messageboxok').fadeTo(0,1,
              function()
			  { 
			  	 //redirect to secure page
				 document.location='fffffffffffffff.php';
			  });
			});
		  }
		  else if(data.trim()=='block') //if correct login detail
		  {
		  	
			$("#errorMsgBox").fadeTo(1,1,function()  //start fading the messagebox
			{ 
			  //$(this).html(data).removeClass().addClass('error-messages').text('Too many invalid login. Your account has been blocked, Please try again after some time.').fadeTo(900,1);
            
			});
		  }
		  else 
		  {
		  	$("#errorMsgBox").fadeTo(1,1,function() //start fading the messagebox
			{ 
			 //add message and change the class of the box and start fading
			  $(this).html(data).removeClass().addClass('error-messages').fadeTo(900,1);
			  
			  //$("#shk").effect("shake", { times:3 }, 100);
			});		
          }
				
        });
 		return false; //not to post the  form physically
	});
	
	

	
	$("#frmRegister").submit(function()
	{
		
		placeName=$("#txtPlaceName").val();
		OwnerName=$("#txtOwnerName").val();
		NursingHomeNo=$("#txtNursingHomeNo").val();
		ProviderName=$("#txtProviderName").val();
		ProviderQualification=$("#txtProviderQualification").val();
		clinicType=$("#txtClinicType").val();
		email=$("#txtEmail").val();
		confirmEmail=$("#txtConfirmEmail").val();
		address=$("#txtAddress").val();
		//address2=$("#txtAddress2").val();
		district=$("#txtDistrict").val();
		pincode=$("#txtPincode").val();
		phone=$("#txtMobile").val();
		approvedcategory = $("input[type='radio']#acategory:checked").val();
		//alert(approvedcategory);
		//return false;
		//sec_code=$("#sec_code").val();
		sec_code=$("#recaptcha_response_field").val();
		//alert(sec_code);
		
		if(approvedcategory=='' || approvedcategory === undefined)
		{
			//alert("Please select Category of approved place.");
			$(".error-messages").text("Please Select Category of Approved Place").fadeIn();
			$("#acategory").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		if(approvedcategory=='12')
		{
			if ($('input[name^=twelveweeks]:checked').length <= 4) 
			{
				//alert("Please check facilities available at the place");
				$(".error-messages").text("Please Check all Facilities to continue").fadeIn();
				$("#acategory").focus();
				$('body').scrollTop(0);
				return false;
			}
		}
		else if(approvedcategory=='20')
		{
			if ($('input[name^=twentyweeks]:checked').length <= 7) 
			{
				//alert("Please check facilities available at the place");
				$(".error-messages").text("Please Check all Facilities to continue").fadeIn();
				$("#acategory").focus();
				$('body').scrollTop(0);
				return false;
			}
		}
		
		
		if(placeName=='')
		{
			//alert("Please enter Name of the place");
			$(".error-messages").text("Please Enter Name of the Place").fadeIn();
			$("#txtPlaceName").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		var placeName= placeName.length;
		
		if(placeName<2)
		{
			//alert("Please enter complete Name of Clinic.");
			$(".error-messages").text("Please Enter Complete Name of the Place").fadeIn();
			$("#txtPlaceName").focus();
			$('body').scrollTop(0);
			return false;
		}
		if(OwnerName=='')
		{
			//alert("Please enter Name of the place");
			$(".error-messages").text("Please Enter Name of owner").fadeIn();
			$("#OwnerName").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		var OwnerName= OwnerName.length;
		
		if(OwnerName<2)
		{
			//alert("Please enter complete Name of Clinic.");
			$(".error-messages").text("Please Enter Complete Name of owner").fadeIn();
			$("#OwnerName").focus();
			$('body').scrollTop(0);
			return false;
		}

		







		
		if(address=='')
		{
			//alert("Please enter Address");
			$(".error-messages").text("Please Enter Address").fadeIn();
			$("#txtAddress").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		if(address.length<2)
		{
			//alert("Please enter complete Address.");
			$(".error-messages").text("Please Enter Complete Address").fadeIn();
			$("#txtAddress").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		if(clinicType=='')
		{
			//alert("Please select Clinic Type");
			$(".error-messages").text("Please Select Clinic Type").fadeIn();
			$("#txtClinicType").focus();
			$('body').scrollTop(0);
			return false;
		}
	
		if(district=='0')
		{
			//alert("Please select District");
			$(".error-messages").text("Please Select District").fadeIn();
			$("#txtDistrict").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		
		if(pincode=='')
		{
			//alert("Please enter Pincode.");
			$(".error-messages").text("Please Enter Pincode").fadeIn();
			$("#txtPincode").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		var pincode= pincode.length;
		if(pincode < 6)
		{
			//alert("Pincode cannot be less then 6 characters.");
			$(".error-messages").text("Pincode Cannot be Less Then 6 Characters").fadeIn();
			$("#txtPincode").focus();
			$('body').scrollTop(0);
			return false;				
		}
		
		/*if(pincode > 6)
		{
			alert("Please enter valid Pincode.");
			$("#txtPincode").focus();
			return false;				
		}
*/
		if(isValidateLen(pincode,10))
		{
			//alert("Please enter valid Pincode.");
			$(".error-messages").text("Please Enter Valid Pincode").fadeIn();
			$("#txtPincode").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		//if(isNaN(textMobile))
		
		if(phone=='')
		{
			//alert("Please enter Phone/Mobile number.");
			$(".error-messages").text("Please Enter Mobile").fadeIn();
			$("#txtMobile").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		if(phone.length < 10)
		{
			//alert("Mobile / Phone number cannot be less then 10 characters.");
			$(".error-messages").text("Mobile Number Cannot be Less Then 10 Characters").fadeIn();
			$("#txtMobile").focus();
			$('body').scrollTop(0);
			return false;				
		}
		
		/*if(phone.length > 12)
		{
			alert("Phon e/ Mobile number exceeded character limit! Can have 12 digits.");
			$("#txtMobile").focus();
			return false;				
		}

		if(isValidateLen(phone,12))
		{
			alert("Please enter valid Mobile number.");
			$("#txtPhone").focus();
			return false;
		}*/


		if(email=='')
		{
			//alert("Please enter valid Email");
			$(".error-messages").text("Please Enter Email").fadeIn();
			$("#txtEmail").focus();
			$('body').scrollTop(0);
			return false;
		} else if(!isValidEmailStrict(email))
		{
			//alert("Please enter valid Email");
			$(".error-messages").text("Please Enter Valid Email").fadeIn();
			$("#txtEmail").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		if(confirmEmail=='')
		{
			//alert("Please enter valid Confirm Email");
			$(".error-messages").text("Please Enter Confirm Email").fadeIn();
			$("#txtEmail").focus();
			$('body').scrollTop(0);
			return false;
		} else if(!isValidEmailStrict(confirmEmail))
		{
			//alert("Please enter valid Confirm Email");
			$(".error-messages").text("Please Enter Valid Confirm Email").fadeIn();
			$("#txtEmail").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		if(confirmEmail!=email)
		{
			//alert("Confirm Email do not match");
			$(".error-messages").text("Confirm Email do not Match").fadeIn();
			$("#txtConfirmEmail").focus();
			$('body').scrollTop(0);
			return false;
		}
		/*
		if(sec_code=='')
		{
			alert("Please Enter Security Code");
			$("#sec_code").focus();
			return false;
		}*/
		

 		return true; 
	});
	
	$("#frmlicenseapproval").submit(function()
	{
		
		placeName=$("#txtPlaceName").val();
		OwnerName=$("#txtOwnerName").val();
		NursingHomeNo=$("#txtNursingHomeNo").val();
		ProviderName=$("#txtProviderName").val();
		ProviderQualification=$("#txtProviderQualification").val();
		clinicType=$("#txtClinicType").val();
		email=$("#txtEmail").val();
		confirmEmail=$("#txtConfirmEmail").val();
		address=$("#txtAddress").val();
		//address2=$("#txtAddress2").val();
		district=$("#txtDistrict").val();
		pincode=$("#txtPincode").val();
		phone=$("#txtMobile").val();
		//alert(approvedcategory);
		//return false;
		//sec_code=$("#sec_code").val();
		sec_code=$("#recaptcha_response_field").val();
		//alert(sec_code);

		
		if(NursingHomeNo=='')
		{
			//alert("Please enter Name of the place");
			$(".error-messages").text("Please Enter Nursing Home licence no.").fadeIn();
			$("#txtNursingHomeNo").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		var NursingHomeNo= NursingHomeNo.length;
		
		if(NursingHomeNo<2)
		{
			//alert("Please enter complete Name of Clinic.");
			$(".error-messages").text("Please Enter Complete Nursing Home licence no.").fadeIn();
			$("#txtNursingHomeNo").focus();
			$('body').scrollTop(0);
			return false;
		}
		if(OwnerName=='')
		{
			//alert("Please enter Name of the place");
			$(".error-messages").text("Please Enter Name of owner").fadeIn();
			$("#OwnerName").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		var OwnerName= OwnerName.length;
		
		if(OwnerName<2)
		{
			//alert("Please enter complete Name of Clinic.");
			$(".error-messages").text("Please Enter Complete Name of owner").fadeIn();
			$("#OwnerName").focus();
			$('body').scrollTop(0);
			return false;
		}


		
		if(ProviderName=='')
		{
			//alert("Please enter Name of the place");
			$(".error-messages").text("Please enter Name of MTP certified provider").fadeIn();
			$("#ProviderName").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		var ProviderName= ProviderName.length;
		
		if(ProviderName<2)
		{
			//alert("Please enter complete Name of Clinic.");
			$(".error-messages").text("Please enter complete Name of MTP certified provider").fadeIn();
			$("#ProviderName").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		if(ProviderQualification=='')
		{
			//alert("Please enter Name of the place");
			$(".error-messages").text("Please enter Provider qualification").fadeIn();
			$("#ProviderQualification").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		var ProviderQualification= ProviderQualification.length;
		
		/*if(address2=='')
		{
			//alert("Please enter Name of the place");
			$(".error-messages").text("Please enter address 2").fadeIn();
			$("#address2").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		var address2= address2.length;
		
		if(address2<2)
		{
			//alert("Please enter complete Name of Clinic.");
			$(".error-messages").text("Please enter complete address 2").fadeIn();
			$("#address2").focus();
			$('body').scrollTop(0);
			return false;
		}
*/







		
		if(address=='')
		{
			//alert("Please enter Address");
			$(".error-messages").text("Please Enter Address").fadeIn();
			$("#txtAddress").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		if(address.length<2)
		{
			//alert("Please enter complete Address.");
			$(".error-messages").text("Please Enter Complete Address").fadeIn();
			$("#txtAddress").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		if(clinicType=='')
		{
			//alert("Please select Clinic Type");
			$(".error-messages").text("Please Select Clinic Type").fadeIn();
			$("#txtClinicType").focus();
			$('body').scrollTop(0);
			return false;
		}
	
		if(district=='0')
		{
			//alert("Please select District");
			$(".error-messages").text("Please Select District").fadeIn();
			$("#txtDistrict").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		
		if(pincode=='')
		{
			//alert("Please enter Pincode.");
			$(".error-messages").text("Please Enter Pincode").fadeIn();
			$("#txtPincode").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		var pincode= pincode.length;
		if(pincode < 6)
		{
			//alert("Pincode cannot be less then 6 characters.");
			$(".error-messages").text("Pincode Cannot be Less Then 6 Characters").fadeIn();
			$("#txtPincode").focus();
			$('body').scrollTop(0);
			return false;				
		}
		
		/*if(pincode > 6)
		{
			alert("Please enter valid Pincode.");
			$("#txtPincode").focus();
			return false;				
		}
*/
		if(isValidateLen(pincode,10))
		{
			//alert("Please enter valid Pincode.");
			$(".error-messages").text("Please Enter Valid Pincode").fadeIn();
			$("#txtPincode").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		//if(isNaN(textMobile))
		
		if(phone=='')
		{
			//alert("Please enter Phone/Mobile number.");
			$(".error-messages").text("Please Enter Mobile").fadeIn();
			$("#txtMobile").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		if(phone.length < 10)
		{
			//alert("Mobile / Phone number cannot be less then 10 characters.");
			$(".error-messages").text("Mobile Number Cannot be Less Then 10 Characters").fadeIn();
			$("#txtMobile").focus();
			$('body').scrollTop(0);
			return false;				
		}
		
		/*if(phone.length > 12)
		{
			alert("Phon e/ Mobile number exceeded character limit! Can have 12 digits.");
			$("#txtMobile").focus();
			return false;				
		}

		if(isValidateLen(phone,12))
		{
			alert("Please enter valid Mobile number.");
			$("#txtPhone").focus();
			return false;
		}*/


		if(email=='')
		{
			//alert("Please enter valid Email");
			$(".error-messages").text("Please Enter Email").fadeIn();
			$("#txtEmail").focus();
			$('body').scrollTop(0);
			return false;
		} else if(!isValidEmailStrict(email))
		{
			//alert("Please enter valid Email");
			$(".error-messages").text("Please Enter Valid Email").fadeIn();
			$("#txtEmail").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		if(confirmEmail=='')
		{
			//alert("Please enter valid Confirm Email");
			$(".error-messages").text("Please Enter Confirm Email").fadeIn();
			$("#txtEmail").focus();
			$('body').scrollTop(0);
			return false;
		} else if(!isValidEmailStrict(confirmEmail))
		{
			//alert("Please enter valid Confirm Email");
			$(".error-messages").text("Please Enter Valid Confirm Email").fadeIn();
			$("#txtEmail").focus();
			$('body').scrollTop(0);
			return false;
		}
		
		if(confirmEmail!=email)
		{
			//alert("Confirm Email do not match");
			$(".error-messages").text("Confirm Email do not Match").fadeIn();
			$("#txtConfirmEmail").focus();
			$('body').scrollTop(0);
			return false;
		}
		/*
		if(sec_code=='')
		{
			alert("Please Enter Security Code");
			$("#sec_code").focus();
			return false;
		}*/
		

 		return true; 
	});

	$("#frmEditRegister").submit(function()
	{
		
		address=$("#txtAddress").val();
		district=$("#txtDistrict").val();
		pincode=$("#txtPincode").val();
		phone=$("#txtMobile").val();
		OwnerName=$("#OwnerName").val();
		NursingHomeNo=$("#NursingHomeNo").val();
		ProviderName=$("#ProviderName").val();
		ProviderQualification=$("#ProviderQualification").val();
		address2=$("#address2").val();
		
		if(OwnerName=='')
		{
			alert("Please enter Name of owner");
			$(".error-messages").text("Please enter Name of owner").fadeIn();
			$("#OwnerName").focus();
			return false;
		}
		if(NursingHomeNo=='')
		{
			alert("Please enter Nursing Home licence no");
			$(".error-messages").text("Please enter Nursing Home licence no").fadeIn();
			$("#NursingHomeNo").focus();
			return false;
		}
		if(ProviderName=='')
		{
			alert("Please enter Name of MTP certified provider");
			$(".error-messages").text("Please enter Name of MTP certified provider").fadeIn();
			$("#ProviderName").focus();
			return false;
		}
		if(ProviderQualification=='')
		{
			alert("Please enter Name of Provider qualification");
			$(".error-messages").text("Please enter Name of Provider qualification").fadeIn();
			$("#ProviderQualification").focus();
			return false;
		}
		if(address2=='')
		{
			alert("Please enter Address 2");
			$(".error-messages").text("Please enter Address 2").fadeIn();
			$("#address2").focus();
			return false;
		}
		
		
		if(district=='')
		{
			alert("Please select District");
			$("#txtDistrict").focus();
			return false;
		}
		
		
		if(pincode=='')
		{
			alert("Please enter Pincode.");
			$("#txtPincode").focus();
			return false;
		}
		
		if(pincode.length < 6)
		{
			alert("Pincode cannot be less then 6 characters.");
			$("#txtPincode").focus();
			return false;				
		}

		/*if(isValidateLen(pincode,10))
		{
			alert("Please enter valid Pincode.");
			$("#txtPincode").focus();
			return false;
		}*/
		
		if(phone=='')
		{
			alert("Please enter Phone/Mobile number.");
			$("#txtMobile").focus();
			return false;
		}
		
		if(phone.length < 10)
		{
			alert("Mobile / Phone number cannot be less then 10 characters.");
			$("#txtMobile").focus();
			return false;				
		}

		/*if(isValidateLen(phone,10))
		{
			alert("Please enter valid Mobile number.");
			$("#txtPhone").focus();
			return false;
		}*/
 		return true; 
	});


	$("#frmContact").submit(function()
	{
		
		userName=$("#txtUserName").val();
		operatingSystem=$("#txtOperatingSystem").val();
		browserUsed=$("#txtBrowserUsed").val();
		issueSubject=$("#txtIssueSubject").val();
		issueDescription=$("#txtIssueDescription").val();
		
		
    	if(userName=='')
		{
			alert("Please enter your Name.");
			$("#txtUserName").focus();
			return false;
		}
		

		if(operatingSystem=='' || operatingSystem=='0')
		{
			alert("Please select Operating System used.");
			$("#txtOperatingSystem").focus();
			return false;
		}
		
		if(browserUsed=='' || browserUsed=='0')
		{
			alert("Please select Browser used.");
			$("#txtBrowserUsed").focus();
			return false;
		}
		
		if(issueSubject=='')
		{
			alert("Please enter Issue/Problem Subject.");
			$("#txtIssueSubject").focus();
			return false;
		}
		
		if(issueDescription=='')
		{
			alert("Please enter Description of Issue/Problem.");
			$("#txtIssueDescription").focus();
			return false;
		}
		
 		return true; //not to post the  form physically
	});


	$("#frmCreatePresentation").submit(function()
	{
		
		orderNumber=$("#txtOrderNumber").val();
		customerNumber=$("#txtCustomerNumber").val();
		defaultTemplate=$("#txtDefaultTemplate").val();
		var frstcharvalid=orderNumber.charAt(0);
		
    	if(orderNumber=='')
		{
			alert("Please enter Order Number.");
			$("#txtOrderNumber").focus();
			return false;
		}


    	if(orderNumber.length>10 || orderNumber.length<6)
		{
			alert("This does not appear to be valid order number. Please check the order number and try again.");
			$("#txtOrderNumber").focus();
			return false;
		}
		
		if(frstcharvalid=='S' || frstcharvalid=='s')
		{
			
		}
		else
		{
			alert("This does not appear to be valid order number. Please check the order number and try again.");
			$("#txtOrderNumber").focus();
			return false;
		}

		if(customerNumber=='')
		{
			alert("Please enter Customer Number.");
			$("#txtCustomerNumber").focus();
			return false;
		}
		

		if(defaultTemplate=='' || defaultTemplate=='0')
		{
			alert("Please select Template.");
			$("#txtDefaultTemplate").focus();
			return false;
		}
				
 		return true; //not to post the  form physically
	});


	$("#frmRegisterEdit").submit(function()
	{
		
		firstName=$("#txtFirstName").val();
		lastName=$("#txtLastName").val();
		email=$("#txtEmail").val();
		phone=$("#txtPhone").val();
		txtLocation=$("#txtLocation").val();
		fax=$("#txtFax").val();
		defaultTemplate=$("#txtDefaultTemplate").val();
		//return false;
		
		
		if(email=='' || !isValidEmailStrict(email))
		{
			alert("Please enter valid Email");
			$("#txtEmail").focus();
			return false;
		}

		if(isValidateLen(email,60))
		{
			alert("Email exceeded character limit! Can have 60 characters.");
			$("#txtEmail").focus();
			return false;
		}
		
		if(firstName=='')
		{
			alert("Please enter First Name");
			$("#txtFirstName").focus();
			return false;
		}
		
		if(isValidateLen(firstName,45))
		{
			alert("First Name exceeded character limit! Can have 45 characters.");
			$("#txtFirstName").focus();
			return false;
		}
		
		if(lastName=='')
		{
			alert("Please enter Last Name");
			$("#txtLastName").focus();
			return false;
		}
		
		if(isValidateLen(lastName,45))
		{
			alert("Last Name exceeded character limit! Can have 45 characters.");
			$("#txtFirstName").focus();
			return false;
		}


		if(isValidateLen(txtLocation,60))
		{
			alert("Location exceeded character limit! Can have 60 characters.");
			$("#txtLocation").focus();
			return false;
		}
		
		
		if(phone=='')
		{
			alert("Please enter phone number in (999)-999-9999 format.");
			$("#txtPhone").focus();
			return false;
		}
		
		if(phone.length > 14)
		{
			alert("Please enter phone number in (999)-999-9999 format.");
			$("#txtPhone").focus();
			return false;				
		}

		if(isValidateLen(phone,14))
		{
			alert("Please enter phone number in (999)-999-9999 format.");
			$("#txtPhone").focus();
			return false;
		}

		if(fax=='')
		{
			alert("Please enter fax number in (999)-999-9999 format.");
			$("#txtFax").focus();
			return false;
		}
		
		if(fax.length > 14)
		{
			alert("Please enter fax number in (999)-999-9999 format.");
			$("#txtFax").focus();
			return false;				
		}

		if(isValidateLen(fax,14))
		{
			alert("Please enter fax number in (999)-999-9999 format.");
			$("#txtFax").focus();
			return false;
		}
	
	return true; 
	});

	$("#frmPasswordEdit").submit(function()
	{
		
		password=$("#txtPassword").val();		
		
		if(password=='')
		{
			alert("Please enter Password");
			$("#txtPassword").focus();
			return false;
		}
		
		if(isValidateLen(password,45))
		{
			alert("Password exceeded character limit! Can have 45 characters.");
			$("#txtPassword").focus();
			return false;
		}

 		return true; 
	});


	$("#frmQuickEstimate").submit(function()
	{
		
		if($("#txtWindowType").val()=='' || $("#txtWindowType").val()=='0')
		{
			alert("Please select Window Type.");
			$("#txtWindowType").focus();
			return false;
		}
		
		if($("#txtWindowSeries").val()=='' || $("#txtWindowSeries").val()=='0')
		{
			alert("Please select Window Series.");
			$("#txtWindowSeries").focus();
			return false;
		}
		if($("#txtWindowColor").val()=='' || $("#txtWindowColor").val()=='0')
		{
			alert("Please select Color.");
			$("#txtWindowColor").focus();
			return false;
		}
		if($("#txtWindowWidth").val()=='' || parseInt($("#txtWindowWidth").val())<parseInt($("#windowMinw").val()) || parseInt($("#txtWindowWidth").val())>parseInt($("#windowMaxw").val()))
		{
			
			alert("Please enter a width between "+$("#windowMinw").val()+" and "+$("#windowMaxw").val()+".");
			$("#txtWindowWidth").val('');
			$("#txtWindowWidth").focus();
			return false;
		}
		if($("#txtWindowHeight").val()=='' || parseInt($("#txtWindowHeight").val())<parseInt($("#windowMinh").val()) || parseInt($("#txtWindowHeight").val())>parseInt($("#windowMaxh").val()))
		{
			alert("Please enter a height between "+$("#windowMinh").val()+" and "+$("#windowMaxh").val()+".");
			$("#txtWindowHeight").val('');
			$("#txtWindowHeight").focus();
			return false;
		}
		
 		return true; 
	});

	$("#customersPage").click(function()
	{
		//alert("1");
		$('#mainContentDiv').slideUp();
		//alert("1");
		$('#listCustomersPage').slideDown();
		$('#listCustomersPage').load('list-customers.inc.php');
		$('#customerNewScreen').slideDown();
		////$('#customerNewScreen').show("slow");
		//alert("1");

 		return false; //not to post the  form physically
	});

	$("#addCustomersPage").click(function()
	{
		$('#addCustomersPage').slideUp();
		$('#addCustomerScreen').slideDown();

 		return false; //not to post the  form physically
	});

	$(".customerLink").click(function()
	{
		alert("1");
		id=$(this).attr('href');
		alert("1 "+id);
		$('#addCustomerScreen').slideDown();
		$('#addCustomerScreen').load('get-customer.inc.php?id='+id);

 		return false; //not to post the  form physically
	});
	
	$("#frmNewCustomer").submit(function()
	{
		
		firstName=$("#txtFirstName").val();
		lastName=$("#txtLastName").val();
		email=$("#txtEmail").val();
		phone=$("#txtPhone").val();
		address1=$("#txtAddress1").val();
		address2=$("#txtAddress2").val();
		state=$("#txtState").val();
		city=$("#txtCity").val();
		postal=$("#txtPostal").val();
		action=$("#txtAction").val();
		existingId=$("#txtCustomerId").val();
		
		if(firstName=='')
		{
			alert("Please enter First Name");
			$("#txtFirstName").focus();
			return false;
		}
		
		if(isValidateLen(firstName,60))
		{
			alert("First Name exceeded character limit! Can have 60 characters.");
			$("#txtFirstName").focus();
			return false;
		}

		
		if(lastName=='')
		{
			alert("Please enter Last Name");
			$("#txtLastName").focus();
			return false;
		}
		
		if(isValidateLen(lastName,60))
		{
			alert("First Name exceeded character limit! Can have 60 characters.");
			$("#txtFirstName").focus();
			return false;
		}

		if(email=='' || !isValidEmailStrict(email))
		{
			alert("Please enter valid Email");
			$("#txtEmail").focus();
			return false;
		}
		
		if(phone=='')
		{
			alert("Please enter phone number in (999)-999-9999 format.");
			$("#txtPhone").focus();
			return false;
		}
		
		//if(!phonenumberusformat(phone))
//		{
//			alert("Phone format is not right.");
//			$("#txtPhone").focus();
//			return false;			
//		}
		
		if(phone.length > 14)
		{
			alert("Please enter phone number in (999)-999-9999 format.");
			$("#txtPhone").focus();
			return false;				
		}

		if(isValidateLen(phone,14))
		{
			alert("Please enter phone number in (999)-999-9999 format.");
			$("#txtPhone").focus();
			return false;
		}

		
		//remove all the class add the messagebox classes and start fading
		////$("#errorMsgBox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		//check the username exists or not from ajax
		$.post("customer-submit.inc.php",{ post_firstName:$('#txtFirstName').val(),post_lastName:$('#txtLastName').val(),post_email:$('#txtEmail').val(),post_phone:$('#txtPhone').val(),post_address1:$('#txtAddress1').val(),post_address2:$('#txtAddress2').val(),post_state:$('#txtState').val(),post_city:$('#txtCity').val(),post_postal:$('#txtPostal').val(),post_action:$('#txtAction').val(),post_customerId:$('#txtCustomerId').val(),rand:Math.random() } ,function(data)
        {
			var dataArray=data.split("|");
		  if(dataArray[0]=='yes') //if correct login detail
		  {
			  	 //redirect to secure page
				 /////document.location='index.php';
					////$('#addCustomerScreen').slideUp();
					////$('#addCustomersPage').slideDown();
					////$('#listCustomersPage').slideDown();
					////$('#listCustomersPage').load('list-customers.inc.php');
					
					if($("#txtLastUrl").val()=="save")
						document.location='save-order.php?txtCustomer='+dataArray[1];
					else
						document.location='list-customers.php';
						
					return false; //not to post the  form physically
				 
		  }
		  else 
		  {
				alert(dataArray[1]);
          }
				
        });
 		return false; //not to post the  form physically
	});
	
	$("#frmChangeAdminPassword").submit(function()
	{
		//remove all the class add the messagebox classes and start fading
		////$("#errorMsgBox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		$("#loader").css({ visibility: 'visible' });
		$('#updtPass').attr('disabled','disabled');
		//check the username exists or not from ajax
		$.post("change-password.inc.php",{ oldpassword:$('#txtAdminOldPassword').val(),newpassword:$('#txtAdminNewPassword').val(),renewpassword:$('#txtAdminReNewPassword').val(),rand:Math.random() } ,function(data)
        {
			////alert(data);
			dataArray=data.split('|');
		  if(data=='yes') //if correct login detail
		  {
		  	$("#errorMsgBox").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Password Updated Successfully').addClass('messageboxok').fadeTo(900,1);
			});
		  }
		  else 
		  {
		  	$("#changePassMsgBox").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html(dataArray[1]).removeClass().addClass('messageboxerror').fadeTo(900,1);
				$("#loader").css({ visibility: 'hidden' });
				$('#updtPass').removeAttr('disabled');
			});		
          }
				
        });
 		return false; //not to post the  form physically
	});
	
	$("#frmLogin").submit(function()
	{
		//remove all the class add the messagebox classes and start fading
		$("#msgbox").text('Validating....').fadeIn(1000);
		//check the username exists or not from ajax
		$.post("login-submit.inc.php",{ user_name:$('#txtLoginUsername').val(),password:$('#txtLoginPassword').val(),rand:Math.random() } ,function(data)
        {
		  if(data=='yes') //if correct login detail
		  {
		  	$("#msgbox").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Logging in.....').fadeTo(900,1,
              function()
			  { 
			  	 //redirect to secure page
				 document.location='my-maidan.php';
			  });
			  
			});
		  }
		  else 
		  {
		  	$("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html(data).fadeTo(900,1);
			});		
          }
				
        });
 		return false; //not to post the  form physically
	});
	
	$("#contact-form").submit(function()
	{
		//remove all the class add the messagebox classes and start fading
		$("#contact-form img.ajax-loader").css({ visibility: 'visible' });
		//check the username exists or not from ajax
		$.post("contact-form-submit.inc.php",{ your_name:$('#txtName').val(),your_email:$('#txtEmail').val(),subject:$('#txtSubject').val(),your_message:$('#txtMessage').val(),verfCode:$('#txtVerificationCode').val(),rand:Math.random() } ,function(data)
        {
			////alert("data ");
		  if(data=='yes') //if correct login detail
		  {
		  	$("#contact-form img.ajax-loader").css({ visibility: 'hidden' });
			alert("Thanks for filling up the contact form");
			$('#txtName').val('');
			$('#txtEmail').val('');
			$('#txtSubject').val('');
			$('#txtMessage').val('');
			$('#txtVerificationCode').val('');
			refreshCaptcha();
		  }
		  else 
		  {
		  	$("#contact-form img.ajax-loader").css({ visibility: 'hidden' });
			alert("Error : " + data);
          }
				
        });
 		return false; //not to post the  form physically
	});
	
	//FORGOT PASSWORD FORM SUBMIT
	$("#frmForgotPassword").submit(function()
	{
		if($('#txtForgotEmail').val()=='')
		{
			//alert("Please enter Email.");
			$(".error-messages-2").text("Please Enter Email").fadeIn();
			$('#txtForgotEmail').focus();
			return false;
		}
		//alert($('#txtEmail').val());
		if($('#txtForgotEmail').val()!='')
		{
			//alert("yy");
			//alert(isValidEmail($('#txtEmail').val()));
			if(!isValidEmailStrict($('#txtForgotEmail').val()))
			{
				//alert("Please enter Valid Email.");
				$(".error-messages-2").text("Please Enter Valid Email").fadeIn();
				$('#txtForgotEmail').focus();
				return false;
			}
		}

		//remove all the class add the messagebox classes and start fading
		$("#errorForgotMsgBox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		//check the username exists or not from ajax
		$.post("forgot-submit.inc.php",{email:$('#txtForgotEmail').val(),rand:Math.random() } ,function(data)
        {
			//alert(data);
		  if(data.trim()=='yes') //if correct login detail
		  {
		  	//alert(data);
			$("#errorForgotMsgBox").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Logging in.....').addClass('messageboxok').fadeTo(900,1,
              function()
			  { 
			  	 //redirect to secure page
				 $(this).html('Check your e-mail for the reset password details.').addClass('messageboxok').fadeTo(900,1);
				 $('#txtForgotEmail').val('');
			  });
			  
			});
		  }
		  else 
		  {
		  	$("#errorForgotMsgBox").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html(data).addClass('messageboxerror').fadeTo(900,1);
			});		
          }
				
        });
 		return false; //not to post the  form physically
	});
	
	$("#frmloginstapes1").submit(function()
	{
		
		if($('#employmentId').val()=='' || $('#employmentId').val()==0)
		{
			$(".error-messages").text("Please select current employment status.").fadeIn();
			$('#employmentId').focus();
			return false;
		}
		
		if($('#membershipId').val()=='' || $('#membershipId').val()==0)
		{
			$(".error-messages").text("Please select your konectt membership.").fadeIn();
			$('#membershipId').focus();
			return false;
		}
		//remove all the class add the messagebox classes and start fading
		$("#errorMsgBox").removeClass().addClass('messagebox').text('Validating....').fadeIn(0);
		//check the username exists or not from ajax  
		$.post("loginstapes.php",{ post_action:'actloginstapes1',employmentId:$('#employmentId').val(),membershipId:$('#membershipId').val(),rand:Math.random() } ,function(data)
        {
		  if(data.trim()=='s1') //if correct login detail
		  {
			$("#errorMsgBox").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			 //add message and change the class of the box and start fading
			  $(this).html('Updating.....').addClass('messageboxok').fadeTo(0,0,
              function()
			  { 
			  	 //redirect to secure page
 				$("#divloginstapes1").hide();
				$("#divloginstapes2").show();
				
				$('#stape1').removeClass('active');
				$('#stape2').addClass('active');
				$("#frmloginstapesbutton2").prop("disabled", true);
				 //document.location='startpage.php';
			  });
			});
		  }
		  else
		  {
		  	$("#errorMsgBox").fadeTo(1,1,function() //start fading the messagebox
			{ 
			 //add message and change the class of the box and start fading
			  $(this).html(data).removeClass().addClass('error-messages').fadeTo(900,1);
			  
			  //$("#shk").effect("shake", { times:3 }, 100);
			});		
          }
				
        });
 		return false; //not to post the  form physically
	});
	
	$("#frmloginstapes2").submit(function()
	{
		
		if($('#employmentId').val()=='' || $('#employmentId').val()==0)
		{
			$(".error-messages").text("Please select current employment status.").fadeIn();
			$('#employmentId').focus();
			return false;
		}
		
		if($('#membershipId').val()=='' || $('#membershipId').val()==0)
		{
			$(".error-messages").text("Please select your konectt membership.").fadeIn();
			$('#membershipId').focus();
			return false;
		}
		//remove all the class add the messagebox classes and start fading
		$("#errorMsgBox").removeClass().addClass('messagebox').text('Validating....').fadeIn(0);
		//check the username exists or not from ajax  
		$.post("loginstapes.php",{ post_action:'actloginstapes1',employmentId:$('#employmentId').val(),membershipId:$('#membershipId').val(),rand:Math.random() } ,function(data)
        {
		  if(data.trim()=='s1') //if correct login detail
		  {
			$("#errorMsgBox").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			 //add message and change the class of the box and start fading
			  $(this).html('Updating.....').addClass('messageboxok').fadeTo(0,0,
              function()
			  { 
			  	 //redirect to secure page
 				$("#divloginstapes1").hide();
				$("#divloginstapes2").show();
				
				$('#stape1').removeClass('active');
				$('#stape2').addClass('active');
				$("#frmloginstapesbutton2").prop("disabled", true);
				 //document.location='startpage.php';
			  });
			});
		  }
		  else
		  {
		  	$("#errorMsgBox").fadeTo(1,1,function() //start fading the messagebox
			{ 
			 //add message and change the class of the box and start fading
			  $(this).html(data).removeClass().addClass('error-messages').fadeTo(900,1);
			  
			  //$("#shk").effect("shake", { times:3 }, 100);
			});		
          }
				
        });
 		return false; //not to post the  form physically
	});

	

});

function isValidateLen(txtID,lnth)
{



	if(txtID.length > lnth)



	{



		return true;



	}



	else



	{



		return false;



	}



}


function usphonefirmatting(fldid)
{



	$('#'+fldid).keyup(function(ev) {



	  var key = ev.which;



	  if (key < 48 || key > 57 || key != 45) {



		ev.preventDefault();



	  }



		this.value=this.value.split("-").join("");



	  if (this.value.length > 12) {



		this.value = this.value.slice(0, -1);



		return;



	  }



	



	  this.value = this.value.replace(/^(\d{3})(\d)/, '$1-$2')



		.replace(/^(\d{3}-\d{3})(\d)/, '$1-$2');



	});



}

function usssnfirmatting(fldid)
{



	$('#'+fldid).keyup(function(ev) {



	  var key = ev.which;



	  if (key < 48 || key > 57 || key != 45) {



		ev.preventDefault();



	  }



		this.value=this.value.split("-").join("");



	  if (this.value.length > 12) {



		this.value = this.value.slice(0, -1);



		return;



	  }



	



	  this.value = this.value.replace(/^(\d{3})(\d)/, '$1-$2')



		.replace(/^(\d{3}-\d{2})(\d)/, '$1-$2');



	});



}

function validPassword(strpassword)
{

	var passError = false;



	var passwordReg = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8}$/;







	var passwordVal = strpassword;	



	



	if(!passwordReg.test(passwordVal))



	{



		passError = true;



	}







	if(passError == true)



	{



		return false;



	}



	else



		return true;



}



function isValidEmailStrict(address)
{



	var hasError = false;



	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;







	var emailaddressVal = address;	



	



	if(!emailReg.test(emailaddressVal))



	{



		hasError = true;



	}







	if(hasError == true)



	{



		return false;



	}



	else



		return true;



	



}

function extractNumber(obj, decimalPlaces, allowNegative)
{



	var temp = obj.value;



	// avoid changing things if already formatted correctly



	var reg0Str = '[0-9]*';



	if (decimalPlaces > 0) {



		reg0Str += '\\.?[0-9]{0,' + decimalPlaces + '}';



	} else if (decimalPlaces < 0) {



		reg0Str += '\\.?[0-9]*';



	}



	reg0Str = allowNegative ? '^-?' + reg0Str : '^' + reg0Str;



	reg0Str = reg0Str + '$';



	var reg0 = new RegExp(reg0Str);



	if (reg0.test(temp)) return true;







	// first replace all non numbers



	var reg1Str = '[^0-9' + (decimalPlaces != 0 ? '.' : '') + (allowNegative ? '-' : '') + ']';



	var reg1 = new RegExp(reg1Str, 'g');



	temp = temp.replace(reg1, '');







	if (allowNegative) {



		// replace extra negative



		var hasNegative = temp.length > 0 && temp.charAt(0) == '-';



		var reg2 = /-/g;



		temp = temp.replace(reg2, '');



		if (hasNegative) temp = '-' + temp;



	}



	



	if (decimalPlaces != 0) {



		var reg3 = /\./g;



		var reg3Array = reg3.exec(temp);



		if (reg3Array != null) {



			// keep only first occurrence of .



			//  and the number of places specified by decimalPlaces or the entire string if decimalPlaces < 0



			var reg3Right = temp.substring(reg3Array.index + reg3Array[0].length);



			reg3Right = reg3Right.replace(reg3, '');



			reg3Right = decimalPlaces > 0 ? reg3Right.substring(0, decimalPlaces) : reg3Right;



			temp = temp.substring(0,reg3Array.index) + '.' + reg3Right;



		}



	}



	



	obj.value = temp;



}

function blockNonNumbers(obj, e, allowDecimal, allowNegative)
{



	var key;



	var isCtrl = false;



	var keychar;



	var reg;



		



	if(window.event) {



		key = e.keyCode;



		isCtrl = window.event.ctrlKey



	}



	else if(e.which) {



		key = e.which;



		isCtrl = e.ctrlKey;



	}



	



	if (isNaN(key)) return true;



	



	keychar = String.fromCharCode(key);



	



	// check for backspace or delete, or if Ctrl was pressed




	if (key == 8 || isCtrl)



	{



		return true;



	}







	reg = /\d/;



	var isFirstN = allowNegative ? keychar == '-' && obj.value.indexOf('-') == -1 : false;



	var isFirstD = allowDecimal ? keychar == '.' && obj.value.indexOf('.') == -1 : false;



	



	return isFirstN || isFirstD || reg.test(keychar);



}

function allnumeric(inputtxt)  
{  
  //alert(inputtxt);
  var numbers = /^[0-9]+$/;  
  if(inputtxt.match(numbers))  
  {  
  return true;  
  }  
  else  
  {  
  return false;  
  }  
}

function phonenumberusformat(inputtxt)  
{  
  var phonenous = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;  
  	 if(inputtxt.match(phonenous))  
     {  
       return true;          
     }  
     else  
     {   
       return false;  
     }  
} 
