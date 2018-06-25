<?php
// This script facilitates sending an email from an HTML form.
// Written by Steven Castellucci, Copyright 2018.


// HTML form variables
#$email_to = $_POST['email_to'];
$email_to = 'recipient@server.com'; // Configure as needed
$email_from = $_POST['email_from'];
$email_subject = $_POST['subject'];
$email_message = $_POST['message'];
// This script will only work when called from the following pages:
$approved_pages = array(            // Configure as needed
	"https://www.eecs.yorku.ca/~stevenc/CGI_Email/contact.html",
	"https://www.eecs.yorku.ca/~stevenc/CGI_Email/emergency.html");


// Input validation
$error_message = "";
$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
if(!isset($email_to) || !preg_match($email_exp,$email_to)) {
	$error_message .= '<p><b>The To: field does not contain a valid email address.</b></p>';
}
if(!isset($email_from) || !preg_match($email_exp,$email_from)) {
	$error_message .= '<p><b>The From: field does not contain a valid email address.</b></p>';
}
if(!isset($email_subject) || strlen($email_subject) < 1) {
	$error_message .= '<p><b>The Subject field is empty.</b></p>';
}
if(!isset($email_message) || strlen($email_message) < 1) {
	$error_message .= '<p><b>The Message area is empty.</b></p>';
}
if(isset($_SERVER['HTTP_REFERER']) &&
	!in_array($_SERVER['HTTP_REFERER'], $approved_pages)) {
	$error_message .= '<p><b>Referring Page:</b> '.$_SERVER['HTTP_REFERER'].'</p>';
	$error_message .= '<p><b>Only the following pages can use this script:</b>';
	foreach ($approved_pages as $page) {
		$error_message .= '<br>'.$page;
	}
	$error_message .= '</p>';
}
if(strlen($error_message) > 0) {
	died($error_message);
}


// Email sending
$email_headers = 'From: '.$email_from."\r\n".
                 'Reply-To: '.$email_from."\r\n".
                 'X-Mailer: PHP/'.phpversion();
if(mail($email_to, $email_subject, $email_message, $email_headers)) {
	succeeded($email_from, $email_subject, $email_message);
} else {
	died("Can't send email to $email_to");
}


// Convert special characters to HTML escape characters
function spCharsToHTML($str) {
	$spChars = array('&', '<', '>', '‘', '’', '“', '”', '–', '—');
	$html  = array('&amp;', '&lt;', '&gt;', '&lsquo;', '&rsquo;', '&ldquo;',
		'&rdquo;', '&ndash;', '&mdash;');
	$str = str_replace($spChars, $html, $str);
	return $str;
}


// Success message output
function succeeded($from, $subject, $msg) {
	echo '<h3>The following message was sent on your behalf:</h3>';
	echo '<i>From: '.$from.'</i><br>';
	echo '<i>Date: '.date("F j, Y, g:i a T").'</i><br>';
	echo '<i>Subject: '.$subject.'</i><br><br>';
	echo spCharsToHTML($msg);
	die();
}


// Error message output
function died($error) {
	echo "<p>The following error(s) occurred:</p>";
	echo $error;
	echo "<p>Please go back and fix these errors.</p>";
	echo "<a href='javascript:history.back(1);'>Back</a>";
	die();
}
?>
