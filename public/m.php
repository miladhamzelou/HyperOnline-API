<?php
// The message
$message = "باسمه تعالی\nمدیریت محترم سایت آپارات\nاحتراما اینجانب امیر حاجی بابایی مدیر فروشگاه مجازی 'هایپر آنلاین' تقاضا دارم کانال ایجاد شده تحت عنوان هایپر آنلاین در سایت آپارات را به کانال رسمی تبدیل نمایید.
لازم به ذکر است هایپر آنلاین اولین فروشگاه مجازی در استان همدان می باشد دارای پروانه کسب از اتحادیه کشوری کسب و کار مجازی است.
تصویر جواز کسب و همچنین فرم درخواست کانال رسمی برای شما ارسال میگردد.
آدرس سایت:
www.hyper-online.ir
باتشکر فراوان";
echo $message;
// In case any of our lines are larger than 70 characters, we should use wordwrap()
$message = wordwrap($message, 70, "\r\n");
echo "sending";
// Send
//mail('apps@cafebazaar.ir', 'Cafe Bazaar', $message);
mail('hatamiarash7@gmail.com', 'Cafe Bazzar', $message);
echo "After";
?>

