<?php require_once('Connection.php'); ?>
<?php require_once("Functions.php"); ?>

<?php include("Header.php"); ?>

<?php

$message = "";
$Login = false;

if (isset($_POST['submit'])) { // Form has been submitted.

	// form data
	$mail = trim(mysql_prep($_POST['mail']));
	$key = trim(mysql_prep($_POST['key']));
	$password = trim(mysql_prep($_POST['password']));
	$password_confirm = trim(mysql_prep($_POST['passwordConfirm']));
	$salt = generate_salt();
	$hashed_password = hash('sha512', $password . $salt);
	
	if(!empty($mail)) {
		
		if ($password == $password_confirm) {
		
			$mysql_query = "UPDATE `user` SET `password`='" . $hashed_password . "',`salt`='" . $salt . "',`passwordResetLink`='' WHERE `mail`='" . $mail . "' AND `passwordResetLink`='" . $key . "'";
			$result = mysql_query($mysql_query, $connection);

			if($result) {
				// Password updatet		
				$Login = true;
				echo "<h1>Your password is updated</h1>";
			} else {
				// Fejl med databasen detaljer kan ses ved brug af "mysql_error()"
				$message = "Unknown error";
			}
		
		} else {
			// Koder ikke ens
			$message = "The passwords do not match";
		}
		
	} else {
		// mail ikke god nok
		$message = "E-mail to short";
	}
	
} 
if (!$Login) {
	echo '<h1>Reset password for JBiD</h1>
            <h3>Password Reset - Got here by accident? Go to <a href="index.html">login</a></h3>
            <form id="createUser" method="post">
            	<p id="error">' . $message . '</p>
            	<input id="mail" type="hidden" name="mail" value="' . $_GET["mail"] . '">
            	<input type="hidden" name="key" value="' . $_GET["key"] . '">
                <p>Password</p>
                <input id="password1" type="password" required name="password">
                <p>Confirm password</p>
                <input id="password2" type="password" required name="passwordConfirm">
                <p id="matches"> </p>
                <input id="createButton" type="submit" value="Save new password" name="submit">
            </form>';
}
?>

<?php include("Footer.php"); ?>