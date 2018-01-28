<?php
$to = "hatamiarash7@gmail.com";      
$subject = "Mail Test at ".strftime("%T", time());      
$message = "This is a test."; 
$from = "HyperOnline <info@hyper-online.ir>";
$headers = "From: {$from}\r\n";
$result = mail($to, $subject, $message, $headers); 
echo $result ? 'Sent' : 'Error';
?>