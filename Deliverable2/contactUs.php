<?php
require_once "config.php";
global $incompleteErr;
$name = $email = $phoneNum = $myMessage = "";
$to = $subject = $message = $header = $retval ="";
$errMsg = array();
$errors = "";
$errMsg[0] = $errMsg[1] = $errMsg[2] = $errMsg[3] = "";
$succMsg ="";
	
if(isset($_POST['send']))
{
	if(isset($_POST['name']))
		$name = get_post($conn,'name');
	if(isset($_POST['email']))
		$email = get_post($conn, 'email');
    if(isset($_POST['phoneNum']))
		$phoneNum = get_post($conn, 'phoneNum');
    if(isset($_POST['message']))
		$myMessage = get_post($conn, 'message');
	
	//Data validation
	$errMsg[0] = validate_name($name);
	$errMsg[1] = validate_email($email);
	$errMsg[2] = validate_phoneNum($phoneNum);
	$errMsg[3] = validate_message($myMessage);

	foreach($errMsg as $msg){
		$errors .= $msg;
	}
	if(empty($errors))//All data is valid
    {
	  $to = $email;
	  $subject = "Florence Palms Guest Contact";
	  $message = $myMessage;
	  $header = "From:laoditiusneymar@gmail.com";
		
	  $retval = mail($to,$subject,$message,$header);
	  if($retval == true){
	  $succMsg = "Message sent Successfully";
	  $name = $email = $phoneNum = $myMessage = "";
	  }
	  else{
		$succMsg = "Message was not Sent";		
	  }
	}
}

echo <<<_END
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Form</title>
    <link rel="stylesheet" href="styleC2.css" />
  </head>
  <body>
    <header class="header">
      <div class="nav-container">
        <nav class="navbar">
          <div class="sticky_logo logo">
            <a href="home2.html#home"><img class="logo1" src="logos-01.png" /></a>
            <h3 class='logo-heading'><a href="home2.html#home"><span>FLORENCE PALMS</span><br>RESORT</a></h3>
          </div>
          <ul class="nav-menu">
            <li><a href="home2.html#home">Home</a></li>
            <li><a href="home2.html#about">About</a></li>
            <li><a href="accomodation.php">Accomodation</a></li>
            <li><a href="gallery.html">Gallery</a></li>
            <li><a href="contactUs.php">Contact</a></li>
          </ul>
          <div class="hamburger">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
          </div>
        </nav>
      </div>
      </div>
    </header>
    <script>
      const hamburger = document.querySelector(".hamburger");
      const navMenu = document.querySelector(".nav-menu");
	
      hamburger.addEventListener("click", mobliemmenu);

      function mobliemmenu() {
        hamburger.classList.toggle("active");
        navMenu.classList.toggle("active");
      }

      window.addEventListener("scroll", function () {
        var header = document.querySelector("header");
        header.classList.toggle("sticky", window.scrollY > 0);
      });
    </script>
    <section>
      <div class="container-head top2">
          <div class="subheading-white">
            <h6>CONTACT</h6>
            <h5>Get In Touch</h5>
            <h4>Finding Us & Getting In Touch</h4>
            <div class="underline"></div>
            <p class="mTop"> We Look forward to hearing from you and welcoming you in person to 
              Florence Palms Resort in Mamaneng, Marble Hall. For a fun break or family 
              dayout in the natural spring of virgin land, there are few destinations that
              compare.
            </p>
          </div>
          
      </div>
    </section>

    <div class="container-contactUs">
      <span class="big-circle"></span>
      <img src="img/shape.png" class="square" alt="" />
      <div class="form">
        <div class="contact-info">
          <h3 class="title">Let's get in touch</h3>
          <p class="text">
            We would love to hear from you as our beloved guests. We inspire to ensure
			that our guests are happy, satisfied and love our services.
          </p>

          <div class="info">
            <div class="information">
              <img src="img/location.png" class="icon" alt="" />
              <p>Mamaneng, Marble Hall 0450,Limpopo</p>
            </div>
            <div class="information">
              <img src="img/email.png" class="icon" alt="" />
              <p>florencePalmsResort09@gmail.com</p>
            </div>
            <div class="information">
              <img src="img/phone.png" class="icon" alt="" />
              <p>0718837258</p>
            </div>
          </div>

          <div class="social-media">
            <p>Connect with us :</p>
            <div class="social-icons">
              <a href="https://m.facebook.com/FlorencePalmsResort/">
                <img src="fc2.png">
              </a>
              <a href="#">
                <img  src="tw2.png">
              </a>
              <a href="#">
                <img src="in2.png">
              </a>
              <a href="#">
                <img src="yt2.png">
              </a>
            </div>
          </div>
        </div>

        <div class="contact-form">
          <span class="circle one"></span>
          <span class="circle two"></span>

          <form action="contactUs.php" method="POST" autocomplete="off">
            <h3 class="title">Contact us</h3>
			<div class="successMsg">
		     <p>$succMsg</p>
	        </div>
            <div class="input-container">
              <input type="text" value="$name" name="name" class="input" />
              <label for="">Name</label>
              <span>Name</span>
            </div>
			<div class="errMsg">
		     <p>$errMsg[0]</p>
	        </div>
            <div class="input-container">
              <input type="email" value="$email" name="email" class="input" />
              <label for="">Email</label>
              <span>Email</span>
            </div>
			<div class="errMsg">
		     <p>$errMsg[1]</p>
	        </div>
            <div class="input-container">
              <input type="tel" value="$phoneNum" name="phoneNum" class="input" />
              <label for="">Phone</label>
              <span>Phone</span>
            </div>
			<div class="errMsg">
		     <p>$errMsg[2]</p>
	        </div>
            <div class="input-container textarea">
              <textarea name="message" class="input"></textarea>
              <label for="">Message</label>
              <span>Message</span>
            </div>
			<div class="errMsg">
		     <p>$errMsg[3]</p>
	        </div>
            <input type="submit" value="Send" name="send" class="btn" />
		 </form>
        </div>
      </div>
    </div>

		  
    <script src="app.js"></script>
    <footer>
      <div class="footer-content top">
        <img class="logo1 top"  src="Logos-02.png">
        <h3 class="flhead posTop">Florence Palms</h3>
        <p class="posTop">Mamaneng, Marble Hall 0450,Limpopo<br>South Africa</p>
        <h4>Accomodation Reservations</h4>
        <h3>0718837258</h3>
        <ul class="socials">
          <li><a href="https://m.facebook.com/FlorencePalmsResort/"><img src="fc2.png"></a></li>
          <li><a href=""><img src="tw2.png"></a></li>
          <li><a href=""><img src="in2.png"></a></li>
          <li><a href=""><img src="yt2.png"></a></li>
        </ul>
        <hr>
        <div class="quickLinks">
          <h4>QUICK LINKS</h4>
          <p><a href="home2.html#about">About</a></p>
          <p><a href="accomodation.php">Accomodation</a></p>
          <p><a href="gallery.html">Gallery</a></p>
          <p<a href="contactUs.php">Contact</a></p>
        </div>
        <hr class="mBottom">
      </div>
    
      <div class="footer-bottom">
        <p>copyright &copy;2022 Florence Palms Resort</p>
      </div>
    </footer>
  </body>
</html>
_END;
function validate_name($field)
{
 if($field == ""){
	 return "Name required.<br>";
 }
 else if(preg_match("/[^a-zA-Z ]/",$field))
return "Only letters (a-z,A-Z) are allowed for first name.<br>";
 return "";
}

function validate_email($field)
{
 if ($field == ""){
	return "Email required.<br>";
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
	return "Phone number required.<br>";
 }
 else if(preg_match("/[^0-9]{10}/",$field))
 return "Invalid phone number<br>";
 return "";
}

function validate_message($field)
{
 if($field == ""){
	return "Message required.<br>";
 }
 return "";
}
function get_post($conn, $var)
{
	return $conn->real_escape_string($_POST[$var]);
}
?>
