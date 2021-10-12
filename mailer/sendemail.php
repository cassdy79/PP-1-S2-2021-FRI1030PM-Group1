<?php 
function registeremail($email, $fullname ,$mail) {
$adminEmail = "noreplytsbcarshare@gmail.com";
$mail->IsHTML(true);
if (!isset($_SESSION['admin'])) {
  $mail->AddAddress($email, $fullname);
} else {
  $mail->AddAddress($adminEmail, $fullname);
}
$mail->SetFrom("noreplytsbcarshare@gmail.com", "TSB Car Share");
$mail->Subject = "You have registered successfully";
$content = '<b>Welcome, '. $fullname.' to TSB car share, we hope you enjoy your stay</b>';

$mail->MsgHTML($content); 

if(!$mail->Send()) {
  echo "Error while sending Email.";
  var_dump($mail);
}
}


function invoiceEmail($email, $invoice ,$mail) {
  $adminEmail = "noreplytsbcarshare@gmail.com";
  $mail->IsHTML(true);
  if (!isset($_SESSION['admin'])) {
    $mail->AddAddress($email, $invoice['user']['fullname']);
  } else {
    $mail->AddAddress($adminEmail, $invoice['user']['fullname']);
  }


  $mail->SetFrom("noreplytsbcarshare@gmail.com", "TSB Car Share");
  $mail->Subject = "Payment successful";
  $content = '<b>Hello!, '. $invoice['user']['fullname'].', you have paid '.$invoice['estimatedCost'].', for your pick up
  at '.$invoice['location']['name'].' at '.$invoice['startTime'].'.';
  
  $mail->MsgHTML($content); 
  
  if(!$mail->Send()) {
    echo "Error while sending Email.";
    var_dump($mail);
  }
  }