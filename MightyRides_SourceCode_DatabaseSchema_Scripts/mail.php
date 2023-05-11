<?php
$to_email = $_POST['email'];
$subject = $_POST['subject'];
$body = $_POST['message'];
$from="akhtersohaib56@gmail.com";
// $headers = "From:$from ";

if (mail($to_email, $subject, $body)) {
    echo "Email successfully sent";
} 
else {
    echo "Email sending failed...";
}
?>

