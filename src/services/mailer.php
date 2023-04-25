<?php

function send_invitation($email, $token)
{
  mb_language("Japanese");
  mb_internal_encoding("UTF-8");

  define("MAIL_TO_ADDRESS", $email);
  define("MAIL_SUBJECT", "POSSEアプリに招待されています");
  define("MAIL_BODY", "こちらから登録してください。 http://localhost:8080/admin/auth/signup.php?token=$token&email=$email");
  define("MAIL_FROM_ADDRESS", "designare@example.jp");
  define("MAIL_HEADER", "Content-Type: text/plain; charset=UTF-8 \n".
                        "From: " . MAIL_FROM_ADDRESS . "\n".
                        "Sender: " . MAIL_FROM_ADDRESS ." \n".
                        "Return-Path: " . MAIL_FROM_ADDRESS . " \n".
                        "Reply-To: " . MAIL_FROM_ADDRESS . " \n".
                        "Content-Transfer-Encoding: BASE64\n");
  return mb_send_mail(MAIL_TO_ADDRESS , MAIL_SUBJECT , MAIL_BODY , MAIL_HEADER, "-f ".MAIL_FROM_ADDRESS);
}
