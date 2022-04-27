/******************

    Description: This Javascript file allows to do client-side validation.

******************/

// Handles the submit event of the survey form
function validate(e){
	hideErrors();
	if(formHasErrors()){
		e.preventDefault();
		return false;
	}
	return true;
}

// Does all the error checking for the form
function formHasErrors(){

	let errorFlag = false;

	// Name Validation
	let textFieldName = document.getElementById("comment_user_name");
	if(!formFieldHasInput(textFieldName)){
		document.getElementById("name_error").style.display = "block";
		if(!errorFlag){
			textFieldName.focus();
			textFieldName.select();
		}
		errorFlag = true;
	}

	// Comment Validation
	let textFieldComment = document.getElementById("comment");
	if(!formFieldHasInput(textFieldComment)){
		document.getElementById("comment_error").style.display = "block";
		if(!errorFlag){
			textFieldComment.focus();
			textFieldComment.select();
		}
		errorFlag = true;
	}

	return errorFlag;
}

// Hides all of the error elements
function hideErrors(){
	let error = document.getElementsByClassName("error");
	for ( let i = 0; i < error.length; i++ ){
		error[i].style.display = "none";
	}
}

//Determines if a text field element has input 
function formFieldHasInput(fieldElement){
	if (fieldElement.value == null || trim(fieldElement.value) == ""){
		return false;
	}
	return true;
}

// Removes white space from a string value
function trim(str){
	return str.replace(/^\s+|\s+$/g,"");
}

// Handles the load event of the document
function load(){
	hideErrors();
	// Add event listener for the form submit
	document.getElementById("create_comment").addEventListener("submit", validate);
}

// Add document load event listener
document.addEventListener("DOMContentLoaded", load);