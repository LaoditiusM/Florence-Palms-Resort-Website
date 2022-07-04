
 function validate(form)
 {
 fail = validate_firstName(form.fname.value)
 fail += validate_lastName(form.lname.value)
 fail += validate_email(form.email.value)
 fail += validate_phoneNum(form.phoneNum.value)
 fail += validate_idNum(form.idnum.value)
 fail += validate_cardNum(form.cardNum.value)
 fail += validate_cholderName(form.cholderName.value)
 fail += validate_expDate(form.expDate.value)
 fail += validate_cvv(form.cvv.value)
 if (fail == "") return true
 else { alert(fail); return false }
 }
 
 function validate_firstName(field)
{
 if(field == ""){
	 return "First Name Required";
 }
 else if(/[^a-zA-Z]/.test(field))
return "Only letters (a-z,A-Z) are allowed for first name.\\n";
 return "";
}

function validate_lastName(field)
{
 if(field == ""){
	return "Last Name required\\n";
 }
 else if(/[^a-zA-Z]/.test(field))
return "Only letters (a-z,A-Z) are allowed for surname.\\n";
 return "";
}

function validate_email(field)
 {
 if (field == "") return "Email required.\\n"
 else if (!((field.indexOf(".") > 0) &&
 (field.indexOf("@") > 0)) ||
 /[^a-zA-Z0-9.@_-]/.test(field))
 return "The Email address is invalid.\\n"
 return ""
 }

function validate_phoneNum(field)
{
 if(field == ""){
	return "Phone number required.";
 }
 else if(/[^0-9]{10}/.test(field))
 return "Invalid phone number\\n";
 return "";
}

function validate_idNum(field)
{
 if(field == ""){
	return "ID number required.\\n";
 }
 else if(/[^0-9]/".test(field) || (field.length != 13))
 return "Invalid ID number\\n";
   
 return "";
}

function validate_cardNum(field){
if(field == ""){
	return "Card number required.\\n";
}
 
   const cardType = [
    /^4[0-9]{12}(?:[0-9]{3})?$/,
    /^5[1-5][0-9]{14}$/,
    /^6(?:011|5[0-9]{2})[0-9]{12}$/);
	];
   
   if(cardType[0].test(field))
   {
	   return "";
   }
   else if(cardType[1].test(field))
   {
	   return "";
   }
   else if(cardType[2].test(field))
   {
	   return "";
   }
   else
	   return "Invalid Card number\\n";
   
}

function validate_cholderName(field)
{
 if(field == ""){
	return "Card Holder name required.\\n";
 }
 else if(/[^a-zA-Z ]/.test(field))
 return "Invalid Card Holder name.\\n";
 return "";
}

function validate_expDate(field){
	if(field == ""){
	return "Expiray Date required.";
	}
    if(/[^0-9\/]/.test(field) || (field.length <> 5))
    return "Invalid Exp Date<br>";

	var expMonth = substr($field,0,2);
	var expYear = substr($field,3,2) + 2000;
	
	var expires = Date(expYear,expMonth,1);
	var now = new Date();
	
	if(expires < now)
	 return "expired";
 
    return "";

}

function validate_cvv(field){
	if(field == ""){
	return "CVV number required.\\n";
	}
	else if(/[^0-9]/".test(field) || (field.length != 4))
    return "Invalid CVV\\n";
}