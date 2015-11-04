<?php 
    //set validation error flag as false
    $error = false;
    //check if form is submitted
    if (isset($_POST['submit']))
    {
        $name = trim($_POST['txt_name']);
        $fromemail = trim($_POST['txt_email']);
        $subject = trim($_POST['txt_subject']);
        $message = trim($_POST['txt_msg']);

        //name can contain only alpha characters and space
        if (!preg_match("/^[a-zA-Z ]+$/",$name))
        {
            $error = true;
            $name_error = "Please Enter Valid Name";
        }
        if(!filter_var($fromemail,FILTER_VALIDATE_EMAIL))
        {
            $error = true;
            $fromemail_error = "Please Enter Valid Email ID";
        }
        if(empty($subject))
        {
            $error = true;
            $subject_error = "Please Enter Your Subject";
        }
        if(empty($message))
        {
            $error = true;
            $message_error = "Please Enter Your Message";
        }
        if (!$error)
        {
            //send mail
            $toemail = "contact@antoninressault.fr";
            $subject = "Enquiry from Visitor " . $name;
            $body = "Here goes your Message Details: \n\n Name: $name \n From: $fromemail \n Message: \n $message";
            $headers = "From: $fromemail\n";
            $headers .= "Reply-To: $fromemail";

            if (mail ($toemail, $subject, $body, $headers))
                $alertmsg  = '<div class="alert alert-success text-center">Message sent successfully.  We will get back to you shortly!</div>';
            else
                $alertmsg = '<div class="alert alert-danger text-center">There is error in sending mail.  Please try again later.</div>';
        }
    }
    header('Location: index.html#CONTACT');

?>