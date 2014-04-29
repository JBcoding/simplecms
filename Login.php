<?php require_once('Connection.php'); ?>
<?php require_once("Functions.php"); ?>

<?php include("Header.php"); ?>

<?php

$message = "";
$Login = false;

if (isset($_POST['submit'])) { // Form has been submitted.

	// form data
	$password = trim(mysql_prep($_POST['password']));
	$mail = trim(mysql_prep($_POST['mail']));
	$salt = "";
	
	if(!empty($mail)) {
		
		$mysql_query = "SELECT `password`, `salt`, `ConfirmLink` FROM `user` WHERE `mail`='" . $mail . "'";
		$result = mysql_query($mysql_query, $connection);

		if($result) {
			if(mysql_num_rows($result) == 1) {
				$found_user = mysql_fetch_array($result);
				$salt = $found_user['salt'];
				$hashed_password = hash('sha512', $password . $salt);
				$hashed_password_DB = $found_user['password'];
				$confirm_link = $found_user['ConfirmLink'];
				
				if ($confirm_link == "Confirmed") {
					if ($hashed_password == $hashed_password_DB) {
						// rigtigt kodeord du er inde
						echo "<h1>You succesfully logged in<h1>";
						$Login = true;
					} else {
						//Forket kodeord
						$message = "Wrong password";
					}
				} else {
					//Not confirmed
					$message = "The account has not been confirmed";
				echo "Hedj";
				}
			} else {
				//mail forkert
				$message = "Wrong e-mail";
			}
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
	echo ' <h1>JBiD by JBcoding</h1>
            <h3>Not a member? Create a user <a href="SignUp.php">here</a></h3>
            <form method="post">
            	<p id="error">' . $message . '</p>
                <p>Email</p>
                <input type="email" required autofocus name="mail">
                <p>Password</p>
                <input type="password" required name="password">
                <p id="forgottenPassword"><a href="PasswordReset.php">Forgot your password?</a></p>
                <input type="submit" value="Login" name="submit">
            </form>';
}
?>

<?php include("Footer.php"); ?>
