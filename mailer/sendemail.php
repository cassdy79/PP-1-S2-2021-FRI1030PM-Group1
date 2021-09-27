<?php 
function registeremail($email, $fullname ,$mail) {

$mail->IsHTML(true);
$mail->AddAddress($email, $fullname);
$mail->SetFrom("noreplytsbcarshare@gmail.com", "TSB Car Share");
$mail->Subject = "You have registered successfully";
$content = '<b>Welcome, '. $fullname.' to TSB car share, we hope you enjoy your stay</b>';

$mail->MsgHTML($content); 

if(!$mail->Send()) {
  echo "Error while sending Email.";
  var_dump($mail);
}
}