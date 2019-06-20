<?php

// ---------------- SEND MAIL FORM ----------------
// send e-mail to ...
$to="alaouiel1@gmail.com"; // could be any email address

// Subject
$subject="Testing emails from localhost";

// From
$header="from: your name <your email>";

// Your message
$message="Hirn";
$message.="This is test email from my localhostrn";
$message.="Thank you";

// send email
$sentmail = mail($to,$subject,$message,$header);

// if email succesfully sent
echo ($sentmail)?"Email Has Been Sent .":"Cannot Send Email ";

?>