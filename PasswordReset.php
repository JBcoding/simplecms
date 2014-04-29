<?php require_once('Connection.php'); ?>
<?php require_once("Functions.php"); ?>

<?php include("Header.php"); ?>

<?php

$message = "";
$Login = false;

if (isset($_POST['submit'])) { // Form has been submitted.

	// form data
	$mail = trim(mysql_prep($_POST['mail']));
	
	if(!empty($mail)) {
		
		$reset_link = generate_salt(64);
			
		$mysql_query = "UPDATE `user` SET `passwordResetLink`='" . $reset_link . "' WHERE `mail`='" . $mail . "'";
		$result = mysql_query($mysql_query, $connection);

		if($result) {
			// Reset link opdateret			
			send_mail($mail, "Password reset", "Reset link below \n http://www.319.dk/JBID/PasswordResetNew.php?mail=" . $mail . "&key=" . $reset_link);
			$Login = true;
			echo "<h1>E-mail sent</h1>";
		} else {
			// Fejl med databasen detaljer kan ses ved brug af "mysql_error()"
			$message = "Unknown error";
		}
		
	} else {
		// mail ikke god nok
		$message = "E-mail to short";
	}
	
} 
if (!$Login) {
	echo '<h1>Reset password for JBiD</h1>
            <h3>Password Reset - Got here by accident? Go to <a href="index.html">login</a></h3>
            <form method="post">
            	<p id="error">' . $message . '</p>
                <p>Please enter the email you used to sign up</p>
                <input id="mail" type="email" required autofocus name="mail">
                <input id="createButton" type="submit" value="Send reset email" name="submit">
            </form>';
}
?>

<?php include("Footer.php"); ?>