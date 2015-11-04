 <?php
// NOTE: this page must be saved as a .php file.
// And your server must support PHP 5.3+ PHP Mail().
// Define variables and set to empty values
$result = $name = $email = $phone = $message = $human = "";
$errName = $errEmail = $errPhone = $errMessage = $errHuman = "";
    if (isset($_POST["submit"])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];
        
         //valid address on your web server
        $from = 'webmaster@yourdomain.com ';
        //your email address where you wish to receive mail
        $to = 'ressault.antonin@gmail.com'; 
        $subject = 'MESSAGE FROM YOUR WEB SITE';
        $headers = "From:$from\r\nReply-to:$email";
        $body = "From: $name\n E-Mail: $email\n Phone: $phone\n Message: $message";
// Check if name is entered
if (empty($_POST["name"])) {
$errName = "Please enter your name.";
} else {
    $name = test_input($_POST["name"]);
}
// Check if email is entered
if (empty($_POST["email"])) {
$errEmail = "Please enter your email address.";
} else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is valid format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errEmail = "Invalid email format.";
    }
}
// Check if phone is entered although it is not required so we don't need error message
if (empty($_POST["phone"])) {
$phone = "";
} else {
    $phone = test_input($_POST["phone"]);
}
//Check if message is entered
if (empty($_POST["message"])) {
$errMessage = "Please enter your message.";
} else {
    $message = test_input($_POST["message"]);
}

// If there are no errors, send the email & output results to the form
if (!$errName && !$errEmail && !$errPhone &&  !$errMessage && !$errHuman) {
    if (mail ($to, $subject, $body, $from)) {
        $result='<div class="alert alert-success"><h2><span class="glyphicon glyphicon-ok"></span> Message sent!</h2><h3>Thank you for contacting us. Someone will be in touch with you soon.</h3></div>';
    } else {
        $result='<div class="alert alert-danger"><h2><span class="glyphicon glyphicon-warning-sign"></span> Sorry there was a form processing error.</h2> <h3>Please try again later.</h3></div>';
       }
    }
}
//sanitize data inputs   
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   $data = (filter_var($data, FILTER_SANITIZE_STRING));
   return $data;
}
//end form processing script
?>