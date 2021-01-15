<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Include the reCaptcha library
require_once "recaptchalib.php";

$privatekey = "6LdqDAkTAAAAAFYSLTonishb1QWCHMraUA9UOP4w";

// reCaptcha looks for the POST to confirm
$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

// If the entered code is correct it returns true (or false)
if ($resp->is_valid) {
  echo "true";
} else {
  echo "false";
}

