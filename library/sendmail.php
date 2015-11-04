<?php
  /**
   * Sets error header and json error message response.
   *
   * @param  String $messsage error message of response
   * @return void
   */
  function errorResponse ($messsage) {
    header('HTTP/1.1 500 Internal Server Error');
    die(json_encode(array('message' => $messsage)));
  }

  /**
   * Pulls posted values for all fields in $fields_req array.
   * If a required field does not have a value, an error response is given.
   */
  function constructMessageBody () {
    $fields_req =  array("name" => true, "email" => true, "message" => true);
    $message_body = "";
    foreach ($fields_req as $name => $required) {
      $postedValue = $_POST[$name];
      if ($required && empty($postedValue)) {
        errorResponse("$name is empty.");
      } else {
        $message_body .= ucfirst($name) . ":  " . $postedValue . "\n";
      }
    }
    return $message_body;
  }

  header('Content-type: application/json');

  //attempt to send email
  $messageBody = constructMessageBody();
  require './vender/php_mailer/PHPMailerAutoload.php';
  $mail = new PHPMailer;
  $mail->CharSet = 'UTF-8';
  $mail->isSMTP();
  $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "ressault.antonin@gmail.com";
    $mail->Password = "freK{vU<orr;E[oRm&";
  
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
  }

  $mail->setFrom($_POST['email'], $_POST['name']);
  $mail->addAddress("ressault.antonin@gmail.com");

  $mail->Subject = $_POST['reason'];
  $mail->Body  = $messageBody;


  //try to send the message
  if($mail->send()) {
    echo json_encode(array('message' => 'Your message was successfully submitted.'));
  } else {
    errorResponse('An expected error occured while attempting to send the email: ' . $mail->ErrorInfo);
  }
?>
