<?php
// The message
$message = "developer email : hatamiarash7@gmail.com\nApplication : HyperOnline - ir.hatamiarash.hyperonline";
echo $message;
// In case any of our lines are larger than 70 characters, we should use wordwrap()
$message = wordwrap($message, 70, "\r\n");
echo "sending";
// Send
mail('apps@cafebazaar.ir', 'Cafe Bazaar', $message);
echo "After";
?>

