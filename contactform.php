<?php

if(isset($_POST['submit'])) 
{
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $email = $_POST['mail'];
    $message = $_POST['message'];
    $mailFrom = "noreply@raissacaitlin.com";


    $mailTo = "raissacaitlinp@gmail.com";
    $header = "New Submission";
    $text = "You have received a message from ".$name.".\n\n".$subject."\n\n".$message;

    $private = '6Ld29akUAAAAAG2r3E1_5GQzEzsy7sx-SFqQYvdf';
    $responseKey = $_POST['g-recaptcha-response'];
    $userIP = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?private=$private&response=$responseKey&userip=$userIP";

    $responseKey = file_get_contents($url);
    $responseKey = json_decode($responseKey);

        if($responseKey -> success)
        {
            mail($mailTo, $subject, $text, $header);
            echo "Message sent successfully";
        } else {
            echo "Please go back and make sure you check the security CAPTCHA box";
        }
    }
?>