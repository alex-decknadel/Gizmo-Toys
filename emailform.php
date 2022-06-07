<!DOCTYPE HTML>

<html>

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Thanks!</title>
<style type="text/css">
<!--

body {
	background-color: #ccc;
	}

code {
	white-space: pre-wrap;
	}

body,td,th, td {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #333333;
}

div#wrapper {
	width: 40em;
	margin-left: auto;
	margin-right: auto;
	background-color: white;
	padding: 1.5em;
	border: 1px solid #666;
	}

h1,h2,h3,h4,h5,h6 {
	font-family: Georgia, Times New Roman, Times, serif;
	margin: 0;
	padding: 0;
}

tr.even td {
	border: 1px solid #ccc;
	border-width: 1px 0;
	}

-->
</style>
</head>
<body>


<?php
//This is a very simple PHP script that outputs the name of each bit of information (that corresponds to the <code>name</code> attribute for that field) along with the value that was sent with it right in the browser window, and then sends it all to an email address (once you've added it to the script).

$to_email = 'adeckna1@my.chemeketa.edu, peter.hoelter@chemeketa.edu';    // Change this to the address you want the e-mail sent to. Leave my address in for this exercise so that I get a copy.

if (empty($_POST)) {
	print "<p>No data was submitted.</p>";
	print "</body></html>";
	exit();
}

//Creates function that removes magic escaping, if it's been applied, from values and then removes extra newlines and returns to foil spammers. Thanks Larry Ullman!
function clear_user_input($value) {
	if (get_magic_quotes_gpc()) $value=stripslashes($value);
	$value= str_replace( "\n", '', trim($value));
	$value= str_replace( "\r", '', $value);
	return $value;
	}


if ($_POST['comments'] == 'Please share any comments you have here') $_POST['comments'] = '';	

//Create body of message by cleaning each field and then appending each name and value to it

$body ="Here is the data that was submitted:\n\n";

foreach ($_POST as $key => $value) {
	$key = clear_user_input($key);
	$value = clear_user_input($value);
	if ($key=='extras') {
		
	if (is_array($_POST['extras']) ){
		$body .= "$key: ";
		$counter =1;
		foreach ($_POST['extras'] as $value) {
				//Add comma and space until last element
				if (sizeof($_POST['extras']) == $counter) {
					$body .= "$value\n";
					break;}
				else {
					$body .= "$value, ";
					$counter += 1;
					}
				}
		} else {
		$body .= "$key: $value\n";
		}
	} else {

	$body .= "$key: $value\n";
	}
}

extract($_POST);
//removes newlines and returns from $email and $name so they can't smuggle extra email addresses for spammers
$email = clear_user_input($email);
$name = clear_user_input($first_name) . ' ' . clear_user_input($last_name);

//Create header that puts email in From box along with name in parentheses and sends bcc to alternate address
$from='From: '. $email . "(" . $name . ")" . "\r\n";


//Creates intelligible subject line that also shows me where it came from
$subject = $_POST['email_subject'];

//Sends mail to me, with elements created above
mail($to_email, $subject, $body, $from);


?>
<div id="wrapper">

<h1>Thank you!</h1>
<p>Thanks for submitting your information. We will process it shortly.</p>
<p><a href="/">Back to Home &raquo;</a></p>

<p>Your Submission:</p>
<p><code><?=$body; ?></code></p>

</div>

</body>
</html>
