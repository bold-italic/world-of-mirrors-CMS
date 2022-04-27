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

	// Product Name Validation
	let textFieldName = document.getElementById("product_name");
	if(!formFieldHasInput(textFieldName)){
		document.getElementById("product_error").style.display = "block";
		if(!errorFlag){
			textFieldName.focus();
			textFieldName.select();
		}
		errorFlag = true;
	}
	
	// Width Validation
	let textFieldWidth = document.getElementById("product_width");
	if(!formFieldHasInput(textFieldWidth)){
		document.getElementById("width_error").style.display = "block";
		if(!errorFlag){
			textFieldWidth.focus();
			textFieldWidth.select();
		}
		errorFlag = true;
	}	else{
			let productWidthValue = document.getElementById("product_width").value;
			productWidthValue = parseFloat(productWidthValue);
			if(isNaN(productWidthValue)){
				let fieldText = document.getElementById("product_width");
				document.getElementById("widthformat_error").style.display = "block";
				if(!errorFlag){
					fieldText.focus();
					fieldText.select();
				}
				errorFlag = true;
			}		
	}

	// Hight Validation
	let textFieldHight = document.getElementById("product_hight");
	if(!formFieldHasInput(textFieldHight)){
		document.getElementById("hight_error").style.display = "block";
		if(!errorFlag){
			textFieldHight.focus();
			textFieldHight.select();
		}
		errorFlag = true;
	}	else{
			let productHightValue = document.getElementById("product_hight").value;
			productHightValue = parseFloat(productHightValue);
			if(isNaN(productHightValue)){
				let fieldText = document.getElementById("product_hight");
				document.getElementById("hightformat_error").style.display = "block";
				if(!errorFlag){
					fieldText.focus();
					fieldText.select();
				}
				errorFlag = true;
			}		
	}

	// Shape Name Validation
	let textFieldShape = document.getElementById("product_shape");
	if(!formFieldHasInput(textFieldShape)){
		document.getElementById("shape_error").style.display = "block";
		if(!errorFlag){
			textFieldShape.focus();
			textFieldShape.select();
		}
		errorFlag = true;
	}

	// Frame Name Validation
	let textFieldFrame = document.getElementById("product_frame");
	if(!formFieldHasInput(textFieldFrame)){
		document.getElementById("frame_error").style.display = "block";
		if(!errorFlag){
			textFieldFrame.focus();
			textFieldFrame.select();
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
	document.getElementById("create_edit_product").addEventListener("submit", validate);
}

// Add document load event listener
document.addEventListener("DOMContentLoaded", load);