<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function post_captcha($user_response) {
        $fields_string = '';
        $fields = array(
            'secret' => '6Ld29akUAAAAAG2r3E1_5GQzEzsy7sx-SFqQYvdf',
            'response' => $user_response
        );
        foreach($fields as $key=>$value)
        $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    // Call the function post_captcha
    $res = post_captcha($_POST['g-recaptcha-response']);

    if (!$res['success']) {
        // What happens when the CAPTCHA wasn't checked
        echo '<p>Please go back and make sure you check the security CAPTCHA box.</p><br>';
    } else {
        // If CAPTCHA is successfully completed...
        $name = $_POST['name'];
        $subject = $_POST['subject'];
        $mailFrom = $_POST['mail'];
        $message = $_POST['message'];


        $mailTo = "raissacaitlinp@gmail.com";
        $header = "From my wesite: ".$mailFrom;
        $text = "You have received a message from ".$name.".\n\n".$message;


        mail($mailTo, $subject, $text, $header);

        // Paste mail function or whatever else you want to happen here!
        header("Location: index.html?sent");
        echo '<br><p>CAPTCHA was completed successfully!</p><br>';
    }
}
?>