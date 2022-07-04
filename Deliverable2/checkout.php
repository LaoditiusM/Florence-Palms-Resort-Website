<?php
session_start();
require_once "config.php";

//Variable Declarations
$fName = $lName = $email =$idNum = $phoneNum = "";
$cardNum = $cholderName = $expdate = $cvv = "";
$errMsg = "";
$receiptNum = "";
$incompleteErr ="";
$amount = 1200;

//email
$to = $subject = $message = $header = $retval ="";

//Individual Error messages for input fields
$errMsg1 = $errMsg2 = $errMsg3 = $errMsg4 = "";
$errMsg5 = $errMsg6 = $errMsg7 = $errMsg8 = $errMsg9 = "";

$unit = $_SESSION['unit'];
$dateIn = $_SESSION['dateIn'];
$dateOut = $_SESSION['dateOut'];

$errors = "";

//Process payment data
if(isset($_POST['Pay'])){
	if(isset($_POST['fname']))
		$fName = get_post($conn,'fname');
	if(isset($_POST['lname']))
		$lName = get_post($conn, 'lname');
	if(isset($_POST['email']))
		$email = get_post($conn, 'email');
    if(isset($_POST['phoneNum']))
		$phoneNum = get_post($conn, 'phoneNum');
    if(isset($_POST['idnum']))
		$idNum = get_post($conn, 'idnum');
	if(isset($_POST['cardNum']))
		$cardNum = get_post($conn, 'cardNum');
	if(isset($_POST['cholderName']))
		$cholderName = get_post($conn, 'cholderName');
	if(isset($_POST['expDate']))
		$expdate = get_post($conn, 'expDate');
	if(isset($_POST['cvv']))
		$cvv = get_post($conn, 'cvv');
	
	//Data validation
	$errMsg1 = validate_firstName($fName);
	$errMsg2 = validate_lastName($lName);
	$errMsg3 = validate_email($email);
	$errMsg4 = validate_phoneNum($phoneNum);
	$errMsg5 = validate_idNum($idNum);
	$errMsg6 = validate_cardNum($cardNum);
	$errMsg7 = validate_cholderName($cholderName);
	$errMsg8 = validate_expDate($expdate);
	$errMsg9 = validate_cvv($cvv);
	
    $errors = "$errMsg1$errMsg2$errMsg3$errMsg4".
	"$errMsg5$errMsg6$errMsg7$errMsg8$errMsg9";

 
echo "<!DOCTYPE html><html><head>";
if(empty($errors))//All data is valid
{
	$query = "Select * FROM customers where idNum = '$idNum' OR email='$email'";
	$result = $conn->query($query);
    if(!$result)die ("Database Access failed:".$conn->error);
	
	$rows = $result->num_rows;
	if($rows < 1){//Check if customer is new or already exists
    $SQLquery = "INSERT INTO customers(Name,Surname,email, phoneNum,idNum)
    VALUES ('$fName', '$lName','$email','$phoneNum','$idNum')";
    $result = $conn->query($SQLquery);
    if(!$result)die ("Database Access failed:".$conn->error);
	}
	
	$receiptNum = substr($fName,0,1).substr($lName,0,1).substr($dateIn,0,4).substr($dateIn,5,2).substr($dateIn,8,2);
	//Insert the reservation details into the appropriate table
    $SQLquery2 = "INSERT INTO reservations(checkIn,checkOut,unitNumber,idNum,receiptNum)
    VALUES ('$dateIn','$dateOut','$unit','$idNum','$receiptNum')";
    $result = $conn->query($SQLquery2);
    if(!$result)die ("Database Access failed:".$conn->error);
	else{
		$SQLquery3 = "INSERT INTO invoice(receiptNum,idNum,amount)
		VALUES ('$receiptNum','$idNum','$amount')";
		$result = $conn->query($SQLquery3);
		if(!$result)die("Database Access failed:".$conn->error);
		$to = $email;
		$subject = "Florence Palms Accomodation";
		$message = "Receipt for ".$fName." ".$lName;
		$message .= "Family Unit Number: $unit";
		$message .= "Receipt Number: $receiptNum";
		$message .= "Check In Date: $dateIn";
		$header = "MIME-Version: 1.0\r\n";
		$header = "Content-type:text/html;charset=UTF-8\r\n";
		$header .= "From:<laoditiusneymar@gmail.com> \r\n";
		
		$retval = mail($to,$subject,$message,$header);
		if($retval == true){
			echo "Message sent";
		}
		else{
			echo "Message Not Sent";
		}
echo <<<_END
    <title>Payment checkout Successful</title>
    <link rel="stylesheet" href="checkoutSucc.css">
 </head>
<body> 
   <div class="container">
     <img src="tick2.png" alt="">
     <div class="wrapper">
        <h2>PAYMENT SUCCESSFUL</h2>
        <h3>Billing Address:</h3>

        <div class="details">  
          <p>Full Name: $fName $lName</p> 
          <p>E-mail   : $email</p>
	      <p>Phone    : $phoneNum</p>
	      <p>ID       : $idNum</p>
	      <p>Purchase  : R1200.00</p>
		  <p>Receipt: $receiptNum</p>
        </div>
   </div>
   <a href="accomodation.php" class="btn">Continue</a>
   </div>
   
</body>
</html>
_END;
	exit;}
}

$conn->close();
}

//Close the Popup menu and return to accomodation page
if(isset($_POST['btnClose'])){
	header("location:accomodation.php");
	exit();
}

echo <<<_END
<title>Payment Checkout</title>
<link rel="stylesheet" href="checkOutStyle2.css">
<script src="checkout.js"></script>
    <script src="accomodation.js"></script>
</head>

<body>
    <div class="wrapper">
        <div class="checkout_wrapper">           
            <div class="product_info">
                <img class="product" src="rooms2.jpeg" alt="product">
                <div class="content">
                    <h3>Family unit 1</h3>
                    <p>R1200.00</p>
                    <img class="logo" src="logos-01.png">
                </div>
            </div>
            <div class="checkout_form">
                <div class="circle"></div>
                <p>Billing Address</p>
                <form method="post" action="checkout.php" autocomplete="off" onSubmit="return validate(this)">
                <div class="details">
                    <div class="section">
                        <input type="text" placeholder="First Name" name="fname" maxlength="32" value="$fName">
                    </div>
					<div class="errMsg">
		              <p id="errMsg">$errMsg1</p>
	                </div>
					<div class="section">
                        <input type="text" placeholder="Last Name" name="lname" maxlength="32" value="$lName" autocomplete='off'>
                    </div>
					<div class="errMsg">
		              <p id="errMsg">$errMsg2</p>
	                </div>
                    <div class="section">
                        <input type="text" placeholder="E-mail" name="email" maxlength="32" value="$email" autocomplete='off'>
                    </div>
					<div class="errMsg">
		              <p id="errMsg">$errMsg3</p>
	                </div>
                    <div class="section">
                            <input type="text" placeholder="phone Number" name="phoneNum" maxlength="10" value="$phoneNum" autocomplete='off'>
                    </div>
					<div class="errMsg">
		              <p id="errMsg">$errMsg4</p>
	                </div>
                    <div class="section">
                        <input type="text" placeholder="ID" name="idnum" maxlength="13" autocomplete='off'>
                    </div>   
                    <div class="errMsg">
		              <p id="errMsg">$errMsg5</p>
	                </div>					
                    <p>Payment Section</p>
                    <div class="section">
                        <input type="text" placeholder="Card Number" name="cardNum" autocomplete='off'>
                    </div>
					<div class="errMsg">
		              <p id="errMsg">$errMsg6</p>
	                </div>
                    <div class="section">
                        <input type="text" placeholder="Cardholder Name" name="cholderName" autocomplete='off'>
                    </div>
					<div class="errMsg">
		              <p id="errMsg">$errMsg7</p>
	                </div>
                    <div class="section last_section">
                        <div class="item">
                            <input type="text" placeholder="mm/yy" name="expDate" autocomplete='off'>
                            <p id="errMsg">$errMsg8</p>
						</div>					
                        <div class="item">
                            <input type="text" placeholder="CVV" name="cvv" maxlength="5" autocomplete='off'>
                            <p id="errMsg">$errMsg9</p>
						</div>
                    </div>
					
                    <input type="submit" value="Pay" name="Pay" class="btn">
                    <input type="submit" value="Cancel" name="btnClose" class="btn">

				</div>
                </form>
				
             </div>
         </div>
		
    </div>
    

</body>

</html>
_END;

//------ Data Validation ------------
function validate_firstName($field)
{
 if($field == ""){
	 return "First Name Required";
 }
 else if(preg_match("/[^a-zA-Z]/",$field))
return "Only letters (a-z,A-Z) are allowed for first name.<br>";
 return "";
}

function validate_lastName($field)
{
 if($field == ""){
	return "Last Name required";
 }
 else if(preg_match("/[^a-zA-Z]/",$field))
return "Only letters (a-z,A-Z) are allowed for surname.<br>";
 return "";
}

function validate_email($field)
{
 if ($field == ""){
	return "Email required";
 }
 else if (!((strpos($field, ".") > 0) &&
 (strpos($field, "@") > 0)) ||
 preg_match("/[^a-zA-Z0-9.@_-]/", $field))
 return "The Email address is invalid.<br>";
 return "";
}

function validate_phoneNum($field)
{
 if($field == ""){
	return "Phone number required.";
 }
 else if(preg_match("/[^0-9]{10}/",$field))
 return "Invalid phone number<br>";
 return "";
}

function validate_idNum($field)
{
 if($field == ""){
	return "ID number required.";
 }
 else if(preg_match("/[^0-9]/",$field) || (strlen($field) != 13))
 return "Invalid ID number<br>";
   
 return "";
}

function validate_cardNum($field){
if($field == ""){
	return "Card number required.";
}
 
   $cardType = array(
   "visa" => "/^4[0-9]{12}(?:[0-9]{3})?$/",
   "mastercard" => "/^5[1-5][0-9]{14}$/",
   "discover" => "/^6(?:011|5[0-9]{2})[0-9]{12}$/");
   
   if(preg_match($cardType['visa'],$field))
   {
	   return "";
   }
   else if(preg_match($cardType['mastercard'],$field))
   {
	   return "";
   }
   else if(preg_match($cardType['discover'],$field))
   {
	   return "";
   }
   else
	   return "Invalid Card number<br>";
   
}

function validate_cholderName($field)
{
 if($field == ""){
	return "Card Holder name required.";
 }
 else if(preg_match("/[^a-zA-Z ]/",$field))
 return "Invalid Card Holder name.<br>";
 return "";
}

function validate_expDate($field){
	if($field == ""){
	return "Expiray Date required.";
	}
    if(preg_match("/[^0-9\/]/",$field) || (strlen($field) <> 5))
    return "Invalid Exp Date<br>";

	$expMonth = substr($field,0,2);
	$expYear = substr($field,3,2);
	
	$expires = DateTime::createFromFormat('my',$expMonth.$expYear);
	$now = new DateTime();
	
	if($expires < $now)
	 return "expired";
 
    return "";

}

function validate_cvv($field){
	if($field == ""){
	return "CVV number required.";
	}
	else if(preg_match("/[^0-9]/",$field) || (strlen($field) != 4))
    return "Invalid CVV<br>";
}

function get_post($conn, $var)
{
	return $conn->real_escape_string($_POST[$var]);
}
//------ Data Validation ------------
?>