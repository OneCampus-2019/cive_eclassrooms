$(document).ready(function() {
	 $("#add_user_form,#edit_user_form,#upload_std").submit(function(e) {
	 removeFeedback();
	 var errors = validateForm();
	 if (errors == "") {
	 return true;
	 } else {
	 provideFeedback(errors);
	 e.preventDefault();
	 return false;
	 }
	 });

	 function validateForm() {
	 var errorFields = new Array();
	 // testing code	 
	 re =  /[!"#$%&'()*+,\-./:;<=>?@[\\\]^_`{|}~]/;
	 if(!re.test($('#inputPassword').val())) {	    
	    $('#inputPassword').addClass("errorClass");
	    $("#inputPassword"+"Error").removeClass("errFB");
	    $('#inputPassword'+"Error").html("password must contain at least one Special character!");
	    //return true;
	    errorFields.push('inputPassword');	
	  }

	 re = /[0-9]/;
	  if(!re.test($('#inputPassword').val())) {
	    
	    $('#inputPassword').addClass("errorClass");
	    $("#inputPassword"+"Error").removeClass("errFB");
	    $('#inputPassword'+"Error").html("password must contain at least one number (0-9)!");
	    errorFields.push('inputPassword');	
	  }
	  re = /[a-z]/;
	  if(!re.test($('#inputPassword').val())) {	    
	    $('#inputPassword').addClass("errorClass");
	    $("#inputPassword"+"Error").removeClass("errFB");
	    $('#inputPassword'+"Error").html("password must contain at least one lowercase letter (a-z)!");
	  	errorFields.push('inputPassword');	
	  }
	  re = /[A-Z]/;
	  if(!re.test($('#inputPassword').val())) {	  
	    $('#inputPassword').addClass("errorClass");
	    $("#inputPassword"+"Error").removeClass("errFB");
	    $('#inputPassword'+"Error").html("password must contain at least one uppercase letter (A-Z)!");
	    errorFields.push('inputPassword');	
	  }
	  if ($('#inputPassword').val().length  < 8){
	 	//errorFields.push('inputPassword');
	 	$('#inputPassword').addClass("errorClass");
	    $("#inputPassword"+"Error").removeClass("errFB");
	    $('#inputPassword'+"Error").html("Password must be astleast 8 characters!");
	    errorFields.push('inputPassword');	
	 }
	  if ($('#inputPassword').val() == ""){
	 	//errorFields.push('inputPassword');
	 	$('#inputPassword').addClass("errorClass");
	    $("#inputPassword"+"Error").removeClass("errFB");
	    $('#inputPassword'+"Error").html("password is required!");
	    errorFields.push('inputPassword');	
	 }
	 // ending of testing code

	 //Check required fields have something in them for users
	 if ($('#inputFirstName').val() == "") {
	 errorFields.push('inputFirstName');	 
	 }
	 if ($('#email').val() == "") {
	 errorFields.push('email');	 
	 }
	 if ($('#inputUsername').val() == "") {
	 errorFields.push('inputUsername');	 
	 }	 
	 if ($('#role').val() == "") {
	 errorFields.push('role');	 
	 }
	 if ($('#role').val() != 9) {
		 if ($('#dept').val() == "") {
		 errorFields.push('dept');	 
		 }	 
	 }

	 //check required fields for student uploads
	 if ($('#stdName').val() == "") {
	 	errorFields.push('stdName');
	 }
	 
	 	
	 

	 return errorFields;
	 } //end function validateForm


	 function provideFeedback(incomingErrors) {
	 for (var i = 0; i < incomingErrors.length; i++){
		 $("#" + incomingErrors[i]).addClass("errorClass");
		 $("#" + incomingErrors[i] + "Error").removeClass("errFB");
	 }

	 $("#errorDiv").html("Errors encountered");
	 }//end of the function



	 function removeFeedback() {
	 $("#errorDiv").html("");
		 $('input,select').each(function() {
		 $(this).removeClass("errorClass");
		 });
		 
		 $('.errorSpan').each(function() {
		 $(this).addClass("errFB");
		 });

		
	 }
});